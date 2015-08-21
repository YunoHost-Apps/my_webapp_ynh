<?php

/**
 * Cheryl 3.0
 *
 * 2003 - 2013 Devin Smith
 * https://github.com/arzynik/cheryl
 *
 * Cheryl is a web based file manager for the modern web. Built
 * on top of PHP5 and AngularJS with lots of love from HTML5 and
 * CSS3 animations.
 *
 * In intall, just copy this script to where you want to share files.
 * See the config below for options.
 *
 */
 

ignore_user_abort(false);
set_time_limit(10);
date_default_timezone_set('Europe/Paris');

ini_set('zlib.output_compression','On');
ini_set('zlib.output_compression_level', 9);


if (!defined('CHERYL_SALT')) {
	// password salt. make something random
	define('CHERYL_SALT', 'SALTTOCHANGE');
}

class Cheryl {
	private static $_cheryl;

	private $defaultConfig = array(
		// the admin username nad password to access all features. if set to blank, all users will have access to all enabled features
		// array of users. this can be overwridden by custom user clases
		'users' => array(
			array(
				'username' => 'admin',
				'password' => '',
				'permissions' => 'all' // if set to all, all permissions are enabled. even new features addedd in the future
			)
		),
		'authentication' => array(
			'type' => 'simple'  // simple: users are stored in the users array. mysql: uses a mysqli interface. pdo: uses pdo interface. see examples
		),
		'useSha1' => true, // if true, passwords will be hashed client side for security.
		'root' => 'files', // the folder you want users to browse
		'includes' => 'Cheryl', // path to look for additional libraries. leave blank if you dont know
		'templateName' => 'cheryl', // name of the template to look for. leave alone if you dont know
		'readonly' => false, // if true, disables all write features, and doesnt require authentication
		'features' => array(
			'snooping' => false, // if true, a user can browse filters behind the root directory, posibly exposing secure files. not reccomended
			'recursiveBrowsing' => true, // if true, allows a simplified view that shows all files recursivly in a directory. with lots of files this can slow it down
		),
		// files to hide from view
		'hiddenFiles' => array(
			'.DS_Store',
			'desktop.ini',
			'.git',
			'.svn',
			'.hg',
			'.trash',
			'.thumb',
			'.cherylconfig'
		),
		'trash' => true, // if true, deleting files will send to trash first
		'libraries' => array(
			'type' => 'remote'
		),
		'recursiveDelete' => true // if true, will allow deleting of unempty folders
	);

	public $features = array(
		'rewrite' => false,
		'userewrite' => null,
		'json' => false,
		'gd' => false,
		'exif' => false,
		'imlib' => false,
		'imcli' => false
	);

	public $authed = false;
	

	public static function init($config = null) {
		if (!self::$_cheryl) {
			new Cheryl($config);
		}
		return self::$_cheryl;
	}
	
	public function __construct($config = null) {
		if (!self::$_cheryl) {
			self::$_cheryl = $this;
		}

		if (is_object($config)) {
			$config = (array)$config;
		} elseif(is_array($config)) {
			$config = $config;
		} else {
			$config = array();
		}
		
		$config = array_merge($this->defaultConfig, $config);
		$config = Cheryl_Model::toModel($config);
		
		$this->config = $config;

		$this->_setup();
		$this->_digestRequest();
		$this->_authenticate();
	}
	
	public static function script() {
		return preg_replace('@'.DIRECTORY_SEPARATOR.'((index|default)\.(php|htm|html))$@','',$_SERVER['SCRIPT_NAME']);
	}

	public static function password($password) {
		// just a pinch
		return sha1($password.CHERYL_SALT);
	}
	
	public static function me() {
		return self::$_cheryl;
	}
	
	public static function go() {
		self::me()->_request();
		echo self::template();
	}
	
	public static function template() {
		return Cheryl_Template::show();
	}

	private function _request() {
		// process authentication requests
		switch ($this->requestPath[0]) {
			case 'logout':
				$this->_logout();
				echo json_encode(array('status' => true, 'message' => 'logged out'));
				exit;

			case 'login':
				$res = $this->_login();
				if ($res) {
					echo json_encode(array('status' => true, 'message' => 'logged in'));
				} else {
					echo json_encode(array('status' => false, 'message' => 'failed to log in'));
				}
				exit;
				
			// get the config and authentication status
			case 'config':
				$this->_getConfig();
				exit;
				break;

			// list the contents of a directory
			case 'ls':
				$this->_requestList();
				exit;
				break;
			
			// download a file
			case 'dl':
				$this->_getFile(true);
				exit;
				break;
				
			// upload a file
			case 'ul':
				$this->_takeFile();
				exit;
				break;
				
			// view a file
			case 'vw':
				$this->_getFile(false);
				exit;
				break;
				
			// delete a file
			case 'rm':
				$this->_deleteFile();
				exit;
				break;
				
			// rename a file
			case 'rn':
				$this->_renameFile();
				exit;
				break;
				
			// make a directory
			case 'mk':
				$this->_makeFile();
				exit;
				break;

			// save a file
			case 'sv':
				$this->_saveFile();
				exit;
				break;
				
			// display icon
			case 'icon':
				header('Content-Type: image/png');
				echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAJgAAACYCAYAAAAYwiAhAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA3NpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDphYWFjYWRhNi1lYjI0LTQ2NTMtYWNmYi1jYzY2NDZhNDk0MzMiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NDYyNUIwMDQ1NkY4MTFFM0FFODVCQ0FBODlEMUY3OTkiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NDYyNUIwMDM1NkY4MTFFM0FFODVCQ0FBODlEMUY3OTkiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChNYWNpbnRvc2gpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6YWFhY2FkYTYtZWIyNC00NjUzLWFjZmItY2M2NjQ2YTQ5NDMzIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOmFhYWNhZGE2LWViMjQtNDY1My1hY2ZiLWNjNjY0NmE0OTQzMyIvPiA8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');
				exit;
				break;
				

			default:
				// display the main html document by letting it pass through php
				break;
		}
	}

	private function _setup() {

		$this->features = (object)$this->features;

		if (file_exists($this->config->includes)) {
			// use include root at script level
			$this->config->includes = realpath($this->config->includes).DIRECTORY_SEPARATOR;

		} elseif (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.$this->config->includes)) {
			// use include root at lib level
			$this->config->includes = dirname(__FILE__).DIRECTORY_SEPARATOR.$this->config->includes.DIRECTORY_SEPARATOR;

		} else {
			// use current path
			$this->config->includes = realpath(__FILE__).DIRECTORY_SEPARATOR;
		}

		if (!$this->config->root) {
			$this->config->root = dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR;
		} else {
			$this->config->root = dirname($_SERVER['SCRIPT_FILENAME']).DIRECTORY_SEPARATOR.$this->config->root.DIRECTORY_SEPARATOR;
			
			if (!file_exists($this->config->root)) {
				@mkdir($this->config->root);
				@chmod($this->config->root, 0777);
			}
		}

		if ((function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules())) || getenv('HTTP_MOD_REWRITE') == 'On') {
			$this->features->rewrite = true;
		}
		
		if (!function_exists('json_decode')) {
			if (file_exists($this->config->includes.'Cheryl/Library/JSON.php')) {
				require_once($this->config->includes.'Cheryl/Library/JSON.php');
			}
		}

		if (function_exists('json_decode')) {
			$this->features->json = true;
		}
		
		if (function_exists('exif_read_data')) {
			$this->features->exif = true;
		}
		if (function_exists('getimagesize')) {
			$this->features->gd = true;
		}
		if (function_exists('Imagick::identifyImage')) {
			$this->features->imlib = true;
		}
		if (!$this->features->imlib) {
			$o = shell_exec('identify -version 2>&1');
			if (!strpos($o, 'not found')) {
				$this->features->imcli = 'identify';
			} elseif (file_exists('/usr/local/bin/identify')) {
				$this->features->imcli = '/usr/local/bin/identify';
			} elseif(file_exists('/usr/bin/identify')) {
				$this->features->imcli = '/usr/bin/identify';
			} elseif(file_exists('/opt/local/bin/identify')) {
				$this->features->imcli = '/opt/local/bin/identify';
			} elseif(file_exists('/bin/identify')) {
				$this->features->imcli = '/bin/identify';
			} elseif(file_exists('/usr/bin/identify')) {
				$this->features->imcli = '/usr/bin/identify';
			}
		}

		$stat = intval(trim(shell_exec('stat -f %B '.escapeshellarg(__FILE__))));
		if ($stat && intval(filemtime(__FILE__)) != $stat) {
			$this->features->ctime = true;
		}
	}

	private function _authenticate() {

                // Patch: Authenticate automaticaly
                $this->user = new Cheryl_User('admin');
                return $this->authed = true;

		if (!Cheryl_User::users()) {
			// allow anonymouse access. ur crazy!
			return $this->authed = true;
		}

		session_start();

		if ($_SESSION['cheryl-authed']) {
			$this->user = new Cheryl_User($_SESSION['cheryl-username']);
			return $this->authed = true;
		}
	}
	
	private function _login() {
		$user = Cheryl_User::login();
		if ($user) {
			$this->user = $user;
			$this->authed = $_SESSION['cheryl-authed'] = true;
			$_SESSION['cheryl-username'] = $this->user->username;
			return true;

		} else {
			return false;
		}
	}
	
	private function _logout() {
		@session_destroy();
		@session_regenerate_id();
		@session_start();
	}

	private function _digestRequest() {
		if (strtolower($_SERVER['REQUEST_METHOD']) == 'post' && !$_REQUEST['__p']) {
			if (!$this->features->json) {
				header('Status: 400 Bad Request');
				header('HTTP/1.0 400 Bad Request');
				echo json_encode(array('status' => false, 'JSON is not installed on this server. requests must use query strings'));
			} else {
				$this->request = json_decode(file_get_contents('php://input'),true);
			}
		} else {
			$this->request = $_REQUEST;
		}

		if ($this->request['__p']) {
			// we have a page param result
			$url = explode('/',$this->request['__p']);
			$this->features->userewrite = false;

		} else {
			$url = false;
		}

		$this->requestPath = $url;
		
		// sanatize file/directory requests
		if ($this->request['_d']) {
			$this->request['_d'] = str_replace('/',DIRECTORY_SEPARATOR, $this->request['_d']);
			if ($this->config->features->snooping) {
				// just allow them to enter any old damn thing
				$this->requestDir = $this->config->root.$this->request['_d'];
			} else {
				$this->requestDir = preg_replace('/\.\.\/|\.\//i','',$this->request['_d']);
				//$this->requestDir = preg_replace('@^'.DIRECTORY_SEPARATOR.basename(__FILE__).'@','',$this->requestDir);
				$this->requestDir = $this->config->root.$this->requestDir;
			}
			
			if (file_exists($this->requestDir)) {
				$this->requestDir = dirname($this->requestDir).DIRECTORY_SEPARATOR.basename($this->requestDir);
			} else {
				$this->requestDir = null;
			}
		}
		
		// sanatize filename
		if ($this->request['_n']) {
			$this->requestName = preg_replace('@'.DIRECTORY_SEPARATOR.'@','',$this->request['_n']);	
		}
	}
	
	private function _getFiles($dir, $filters = array()) {
		
		if ($filters['recursive']) {
			$iter = new RecursiveDirectoryIterator($dir);
			$iterator = new RecursiveIteratorIterator(
				$iter,
				RecursiveIteratorIterator::SELF_FIRST,
				RecursiveIteratorIterator::CATCH_GET_CHILD
			);
			
			$filtered = new CherylFilterIterator($iterator);
			
			$paths = array($dir);
			foreach ($filtered as $path => $file) {
				if ($file->getFilename() == '.' || $file->getFilename() == '..') {
					continue;
				}
				if ($file->isDir()) {
					$dirs[] = $this->_getFileInfo($file);
				} elseif (!$file->isDir()) {
					$files[] = $this->_getFileInfo($file);
				}
			}

		} else {
			$iter = new CherylDirectoryIterator($dir);
			$filter = new CherylFilterIterator($iter);
			$iterator = new IteratorIterator($filter);

			$paths = array($dir);
			foreach ($iterator as $path => $file) {
				if ($file->isDot()) {
					continue;
				}
				if ($file->isDir()) {
					$dirs[] = $this->_getFileInfo($file);
				} elseif (!$file->isDir()) {
					$files[] = $this->_getFileInfo($file);
				}
			}
		}
		
		return array('dirs' => $dirs, 'files' => $files);
	}

	private function _cTime($file) {
		return trim(shell_exec('stat -f %B '.escapeshellarg($file->getPathname())));
	}

	// do our own type detection
	private function _type($file, $extended = false) {

		$mime = mime_content_type($file->getPathname());

		$mimes = explode('/',$mime);
		$type = strtolower($mimes[0]);
		$ext = $file->getExtension();

		if ($ext == 'pdf') {
			$type = 'image';
		}
		
		$ret = array(
			'type' => $type,
			'mime' => $mime
		);
		
		if (!$extended) {
			return $ret['type'];
		} else {
			return $ret;
		}
	}
	
	private function _getFileInfo($file, $extended = false) {
		$path = str_replace(realpath($this->config->root),'',realpath($file->getPath()));

		if ($file->isDir()) {
			$info = array(
				'path' => $path,
				'name' => $file->getFilename(),
				'writeable' => $file->isWritable(),
				'type' => $this->_type($file, false)
			);

		} elseif (!$file->isDir()) {
			$info = array(
				'path' => $path,
				'name' => $file->getFilename(),
				'size' => $file->getSize(),
				'mtime' => $file->getMTime(),
				'ext' => $file->getExtension(),
				'writeable' => $file->isWritable()
			);

			if ($this->features->ctime) {
				$info['ctime'] = $this->_cTime($file);
			}

			if ($extended) {
				$type = $this->_type($file, true);
				
				$info['type'] = $type['type'];

				$info['meta'] = array(
					'mime' => $type['mime']
				);

				if ($type['type'] == 'text') {
					$info['contents'] = file_get_contents($file->getPathname());
				}

				if (strpos($mime, 'image') > -1) {
					if ($this->features->exif) {
						$exif = @exif_read_data($file->getPathname());

						if ($exif) {
							$keys = array('Make','Model','ExposureTime','FNumber','ISOSpeedRatings','FocalLength','Flash');
							foreach ($keys as $key) {
								if (!$exif[$key]) {
									continue;
								}
								$exifInfo[$key] = $exif[$key];
							}
							if ($exif['DateTime']) {
								$d = new DateTime($exif['DateTime']);
								$exifInfo['Created'] = $d->getTimestamp();
							} elseif ($exif['FileDateTime']) {
								$exifInfo['Created'] = $exif['FileDateTime'];
							}
							if ($exif['COMPUTED']['CCDWidth']) {
								$exifInfo['CCDWidth'] = $exif['COMPUTED']['CCDWidth'];
							}
							if ($exif['COMPUTED']['ApertureFNumber']) {
								$exifInfo['ApertureFNumber'] = $exif['COMPUTED']['ApertureFNumber'];
							}
							if ($exif['COMPUTED']['Height']) {
								$height = $exif['COMPUTED']['Height'];
							}
							if ($exif['COMPUTED']['Width']) {
								$width = $exif['COMPUTED']['Width'];
							}
						}
					}
					$info['meta']['exif'] = $exifInfo;
				}
				if (!$height || !$width) {
					if ($this->features->gd) {
						$is = @getimagesize($file->getPathname());
						if ($is[0]) {
							$width = $is[0];
							$height = $is[1];
						}
					}
				}
				if ($height && $width) {
					$info['meta']['height'] = $height;
					$info['meta']['width'] = $width;
				}
			}
			
			$info['meta']['mime'] = $mime;
			$info['perms'] = $file->getPerms();

		}
		return $info;
	}
	
	private function _getFile($download = false) {
		if (!$this->authed && !$this->config->readonly) {
			echo json_encode(array('status' => false, 'message' => 'not authenticated'));
			exit;
		}
		
		if (!$this->requestDir || !is_file($this->requestDir)) {
			header('Status: 404 Not Found');
			header('HTTP/1.0 404 Not Found');
			exit;
		}
		
		$file = new SplFileObject($this->requestDir);
		
		// not really sure if this range shit works. stole it from an old script i wrote
		if (isset($_SERVER['HTTP_RANGE'])) {
			list($size_unit, $range_orig) = explode('=', $_SERVER['HTTP_RANGE'], 2);
			if ($size_unit == 'bytes') {
				list($range, $extra_ranges) = explode(',', $range_orig, 2);
			} else {
				$range = '';
			}
			
			if ($range) {
				list ($seek_start, $seek_end) = explode('-', $range, 2);
			}
			
			$seek_end = (empty($seek_end)) ? ($size - 1) : min(abs(intval($seek_end)),($size - 1));
			$seek_start = (empty($seek_start) || $seek_end < abs(intval($seek_start))) ? 0 : max(abs(intval($seek_start)),0);
			
			if ($seek_start > 0 || $seek_end < ($size - 1)) {
				header('HTTP/1.1 206 Partial Content');
			} else {
				header('HTTP/1.1 200 OK');
			}
			header('Accept-Ranges: bytes');
			header('Content-Range: bytes '.$seek_start.'-'.$seek_end.'/'.$size);
			$contentLength = ($seek_end - $seek_start + 1);

		} else {
			header('HTTP/1.1 200 OK');
			header('Accept-Ranges: bytes');
			$contentLength = $file->getSize();
		}

		header('Pragma: public');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Date: '.date('r'));
		header('Last-Modified: '.date('r',$file->getMTime()));
		header('Content-Length: '.$contentLength);
		header('Content-Transfer-Encoding: binary');
		
		if ($download) {
			header('Content-Disposition: attachment; filename="'.$file->getFilename().'"');
			header('Content-Type: application/force-download');
		} else {
			header('Content-Type: '. mime_content_type($file->getPathname()));
		}

		// i wrote this freading a really long time ago but it seems to be more robust than SPL. someone correct me if im wrong
		$fp = fopen($file->getPathname(), 'rb');
		fseek($fp, $seek_start);
		while(!feof($fp)) {
			set_time_limit(0);
			print(fread($fp, 1024*8));
			flush();
			ob_flush();
		}
		fclose($fp);
		exit;
	}

	private function _requestList() {
		if (!$this->authed && !$this->config->readonly) {
			echo json_encode(array('status' => false, 'message' => 'not authenticated'));
			exit;
		}

		if (!$this->requestDir) {
			header('Status: 404 Not Found');
			header('HTTP/1.0 404 Not Found');
			exit;
		}

		if (is_file($this->requestDir)) {
			$file = new SplFileObject($this->requestDir);
			$info = $this->_getFileInfo($file, true);
			echo json_encode(array('type' => 'file', 'file' => $info));

		} else {

			if (realpath($this->requestDir) == realpath($this->config->root)) {
				$path = '';
				$name = '';
			} else {
				$dir = pathinfo($this->requestDir);
				$path = str_replace(realpath($this->config->root),'',realpath($dir['dirname']));
				$name = basename($this->requestDir);
				$path = $path{0} == '/' ? $path : '/'.$path;
			}
			$info = array(
				'path' => $path,
				'writeable' => is_writable($this->requestDir),
				'name' => $name
			);

			$files = $this->_getFiles($this->requestDir, array(
				'recursive' => $this->request['filters']['recursive']
			));
			echo json_encode(array('type' => 'dir', 'list' => $files, 'file' => $info));
		}
	}
	
	private function _takeFile() {
		if (!$this->authed) {
			echo json_encode(array('status' => false, 'message' => 'not authenticated'));
			exit;
		}
		if ($this->config->readonly || !$this->user->permission('upload', $this->requestDir)) {
			echo json_encode(array('status' => false, 'message' => 'no permission'));
			exit;			
		}

		foreach ($_FILES as $file) {
			move_uploaded_file($file['tmp_name'],$this->requestDir.DIRECTORY_SEPARATOR.$file['name']);
		}

		echo json_encode(array('status' => true));
	}
	
	private function _deleteFile() {
		if (!$this->authed) {
			echo json_encode(array('status' => false, 'message' => 'not authenticated'));
			exit;
		}
		if ($this->config->readonly || !$this->user->permission('delete', $this->requestDir)) {
			echo json_encode(array('status' => false, 'message' => 'no permission'));
			exit;			
		}
		
		$status = false;

		if (is_dir($this->requestDir)) {
			if ($this->config->recursiveDelete) {
				foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->requestDir), RecursiveIteratorIterator::CHILD_FIRST) as $path) {
					if ($path->getFilename() == '.' || $path->getFilename() == '..') {
						continue;
					}
					$path->isFile() ? unlink($path->getPathname()) : rmdir($path->getPathname());
				}
			}

			if (rmdir($this->requestDir)) {
				$status = true;
			}

		} else {
			if (unlink($this->requestDir)) {
				$status = true;
			}
		}
		
		echo json_encode(array('status' => $status));
	}
	
	private function _renameFile() {
		if (!$this->authed) {
			echo json_encode(array('status' => false, 'message' => 'not authenticated'));
			exit;
		}
		if ($this->config->readonly || !$this->user->permission('rename', $this->requestDir)) {
			echo json_encode(array('status' => false, 'message' => 'no permission'));
			exit;			
		}

		if (@rename($this->requestDir, dirname($this->requestDir).DIRECTORY_SEPARATOR.$this->requestName)) {
			$status = true;
		} else {
			$status = false;
		}
		
		echo json_encode(array('status' => $status, 'name' => $this->requestName));
	}
	
	private function _makeFile() {
		if (!$this->authed) {
			echo json_encode(array('status' => false, 'message' => 'not authenticated'));
			exit;
		}
		if ($this->config->readonly || !$this->user->permission('create', $this->requestDir)) {
			echo json_encode(array('status' => false, 'message' => 'no permission'));
			exit;			
		}

		if (@mkdir($this->requestDir.DIRECTORY_SEPARATOR.$this->requestName,0777)) {
			$status = true;
		} else {
			$status = false;
		}
		
		echo json_encode(array('status' => $status, 'name' => $this->requestName));
	}
	
	private function _saveFile() {
		if (!$this->authed) {
			echo json_encode(array('status' => false, 'message' => 'not authenticated'));
			exit;
		}
		if ($this->config->readonly || !$this->user->permission('save', $this->requestDir)) {
			echo json_encode(array('status' => false, 'message' => 'no permission'));
			exit;			
		}

		if (@file_put_contents($this->requestDir,$this->request['c'])) {
			$status = true;
		} else {
			$status = false;
		}

		echo json_encode(array('status' => $status));
	}
	
	private function _getConfig() {
		echo json_encode(array('status' => true, 'authed' => $this->authed));
	}

	public static function iteratorFilter($current) {
        return !in_array(
            $current->getFileName(),
            self::me()->config->hiddenFiles,
            true
        );
	}
}


class CherylFilterIterator extends FilterIterator {
    public function accept() {
        return Cheryl::iteratorFilter($this->current());
    }
}

class CherylDirectoryIterator extends DirectoryIterator {
	public function getExtension() {
		if (method_exists(get_parent_class($this), 'getExtension')) {
			$ext = parent::getExtension();
		} else {
			$ext = pathinfo($this->getPathName(), PATHINFO_EXTENSION);
		}
		return strtolower($ext);
	}
}


class Cheryl_Model {
	public static function toModel($array) {

		$object = new Cheryl_Model();
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $name => $value) {
				if ($name === 0) {
					$isArray = true;
				}

				if (!empty($name) || $name === 0) {

					if (is_array($value)) {
						if (!count($value)) {
                    		$value = null;
						} else {
							$value = self::toModel($value);
						}
                    }
					if ($isArray) {
						switch ($value) {
							case 'false':
								$array[$name] = false;
								break;
							case 'true':
								$array[$name] = true;
								break;
							case 'null':
								$array[$name] = null;
								break;
							default:
								$array[$name] = $value;
								break;
						}
					} else {
						$name = trim($name);
						switch ($value) {
							case 'false':
								$object->$name = false;
								break;
							case 'true':
								$object->$name = true;
								break;
							case 'null':
								$object->$name = null;
								break;
							default:
								$object->$name = $value;
								break;
						}					
					}
				}
			}
		}

		return $isArray ? $array : $object;
	}
}

// we need to at least be able to encode data
if (!function_exists('json_encode')) {
	function json_encode($data) {
		switch ($type = gettype($data)) {
			case 'NULL':
				return 'null';
			case 'boolean':
				return ($data ? 'true' : 'false');
			case 'integer':
			case 'double':
			case 'float':
				return $data;
			case 'string':
				return '"' . addslashes($data) . '"';
			case 'object':
				$data = get_object_vars($data);
			case 'array':
				$output_index_count = 0;
				$output_indexed = array();
				$output_associative = array();
				foreach ($data as $key => $value) {
					$output_indexed[] = json_encode($value);
					$output_associative[] = json_encode($key) . ':' . json_encode($value);
					if ($output_index_count !== NULL && $output_index_count++ !== $key) {
						$output_index_count = NULL;
					}
				}
				if ($output_index_count !== NULL) {
					return '[' . implode(',', $output_indexed) . ']';
				} else {
					return '{' . implode(',', $output_associative) . '}';
				}
			default:
				return '';
		}
	}
}



if (!class_exists('Cheryl_Template')) {
	class Cheryl_Template {
		public static function build($dir, $template, $show = false) {
			if ($show) {
				ob_start();
			}

			$path = $dir.DIRECTORY_SEPARATOR.'Template'.DIRECTORY_SEPARATOR.$template;

			if (file_exists($path.'.phtml')) {
				// use the template
				$template = file_get_contents($path.'.phtml');
				if (file_exists($path.'.css')) {
					$template = str_replace('<style></style>','<style>'.file_get_contents($path.'.css').'</style>', $template);
				}
				if (file_exists($path.'.js')) {
					$template = str_replace('<script></script>','<script>'.file_get_contents($path.'.js').'</script>', $template);
				}

				if ($show) {
					$temp = tempnam(null,'cheryl-template');
					file_put_contents($temp, $template);
					include($temp);

				} else {
					$res = $template;
				}
			}

			if ($show) {
				$res = ob_get_contents();
				ob_end_clean();
			}
			return $res;
		}

		public static function show() {
			$res = self::build(Cheryl::me()->config->includes, Cheryl::me()->config->templateName, true);
			if (!$res) {
				ob_start();
				?> <!DOCTYPE HTML>
<html ng-app="Cheryl">
<head>
<title>Cheryl</title>
<link rel="shortcut icon" href="http://cheryl.io/icon.png">
<link rel="apple-touch-icon-precomposed" href="http://cheryl.io/icon.png">
	
<style>html, body, margin, form, a, h1, h2, h3, h4, h5, h6, select, input, tr, td, table, ul, ol, li, textarea, p, button {
	margin: 0;
	padding: 0;
}
body {
	background: #eceff1;
	color: #404040;
	background: #eceff1 -webkit-gradient(linear, left top, left bottom, color-stop(0%,#48aed9), color-stop(1000%,#48aed9));
	background-size: 100% 142px;
	background-repeat:no-repeat;
}
body, input, button {
	font: 10px "Open Sans", "Helvetica", "Arial", sans-serif;
}
:focus {
	outline: none;
}
::selection {
	background: rgba(255,39,151,.75);
	color: #fff;
}
::-moz-selection {
	background: rgba(255,39,151,.75);
	color: #fff;
}
a, a:visited, a:active {
	text-decoration: none;
	color: #404040;
}
.wrapper {
	width: 870px;
	margin: 0 auto;
	margin-bottom: 25px;
}
.clearfix:after {
	content: '';
	display: block;
	clear: both;
	visibility: hidden;
	line-height: 0;
	height: 0;
}

.logo svg {
	height: 90px;
	width: 90px;
}
.panel {
	float: left;
	width: 170px;
	margin: 0 20px 0 0;
}
.logo {
	margin: 30px 0 40px 40px;
}
.toggles {
	float: left;
	width: 680px;
	margin: 20px 0 0 0;
}
.content {
	float: left;
	width: 630px;
	min-height: 500px;
	background: #fff;
	box-shadow: 0px 1px 4px rgba(0,0,0,.3);
	padding: 25px;
	margin: 25px 0 20px 0;
}
h1 {
	color: #555963;
	font-weight: 100;
	font-size: 2em;
}
h2 {
	color: #404040;
	font-weight: 100;
	font-size: 1.5em;
	margin-bottom: .5em;
}
h1 input, h2 input {
	margin: 0;
	padding: 0;
	border: 1px dashed #f6f6f6;
	width: 20em;
	color: #555963;
	font-weight: 100;
	font-size: 1em;
	-webkit-transition: .2s border;
}
h2 input {
	border: 1px dashed #d0d0d0;
	padding: .3em;
}
.file-name-top, h1 input {
	padding-left: .2em;
}
h1 input:hover {
	border: 1px dashed #d0d0d0;
}
h1 input:focus, h2 input:focus {
	border: 1px dashed #b0b0b0;
}
.file-name-top {
	border: 1px solid transparent;
}
.toggles button {
	border: 0;
	background: rgba(0,0,0,.2);
	border-radius: 5px;
	color: #fff;
	font-size: 1.1em;
	padding: .5em 1.2em .6em 1.2em;
	cursor: pointer;
	opacity: .5;
	-webkit-transition: .2s opacity;
	width: 12em;
}
.toggles button.enabled {
	opacity: .8;
}
.toggles button:hover {
	opacity: .7;	
}
.toggles button.enabled:hover {
	opacity: 1;	
}
.toggles .search {
	border: 0;
	background: rgba(0,0,0,.2);
	border-radius: 5px;
	color: #fff;
	font-size: 1.1em;
	padding: .2em .4em .2em .8em;
	opacity: .5;
	-webkit-transition: .2s opacity;
	float: right;
}
.toggles .search .fa {
	vertical-align: middle;
}
.toggles .search .search-box {
	background: 0;
	padding: .35em .4em .45em .4em;
	border: 0;
	color: #fff;
	width: 8em;
	font-size: 1em;
	margin: 0;
	vertical-align: middle;
	-webkit-transition: .2s width;
}
.toggles .search.active {
	opacity: .8;
}
.toggles .search.active .search-box {
	width: 15em;
}

.toggles .search .search-box::-webkit-input-placeholder {
	color: #fff;
	-webkit-transition: .2s opacity;
}
.toggles .search .search-box::-moz-placeholder {
	color: #fff;
	-moz-transition: .2s opacity;
}
.toggles .search .search-box::-ms-input-placeholder {
	color: #fff;
	-ms-transition: .2s opacity;
}
.toggles .search .search-box::-o-input-placeholder {
	color: #fff;
	-o-transition: .2s opacity;
}
.toggles .search .search-box::input-placeholder {
	color: #fff;
	transition: .2s opacity;
}

.toggles .search.active .search-box::-webkit-input-placeholder {
	opacity: 0;
}
.toggles .search.active .search-box::-moz-placeholder {
	opacity: 0;
}
.toggles .search.active .search-box::-ms-placeholder {
	opacity: 0;
}
.toggles .search.active .search-box::-o-input-placeholder {
	opacity: 0;
}
.toggles .search.active .search-box::input-placeholder {
	opacity: 0;
}

.copyright {
	clear: both;
	float: right;
	cursor: pointer;
}
.copyright a {
	text-decoration: none;
	color: #cacccd;
	font-size: 2em;
}
.powered, .cheryl {
	-webkit-transition: .4s all;
}
.powered {
	opacity: .3;
}
.copyright:hover .powered {
	opacity: .7;
}
.copyright:hover .cheryl {
	color: #f83ca2;
}
.details .info {
	color: #767676;
	border-radius: 4px;
	padding: .2em 0 .2em 0;
	font-size: 1.2em;
	list-style: none;
}
.filter {
	background: #e0e2e4;
	color: #767676;
	display: block;
	border-radius: 4px;
	padding: .4em .8em .4em .8em;
	margin-bottom: .2em;
	font-size: 1.2em;
	cursor: pointer;
}
.filter.enabled {
	background: #a4d4e9;
	color: #fff;
}
.file .icon {
	font-size: 4em;
	color: #c0c0c0;
	width: 1em;
	height: 1em;
	display: inline-block;
	vertical-align: top;
}
.file .icon .fa {
	-webkit-transition: .2s all;
	position: absolute;
	display: block;
}
.file .icon .fa-cloud-upload {
	font-size: .85em;
	padding-top: .2em;
}
.file .icon .fa-download {
	opacity: 0;
	font-size: .9em;
	padding-top: .2em;
}
.file {
	background: #f0f0f0;
	padding: .8em 1.4em .8em 1.4em;
	cursor: pointer;
	-webkit-transition: .2s all;
	margin-bottom: .8em;
	display: block;
	border: 1px solid #f0f0f0;
}
.files .file:hover {
	background: #ecf3f9;
}
.files .file .icon:hover .fa-file-text-o {
	opacity: 0;
}
.files .file .icon:hover .fa-download {
	opacity: 1;
}
.files .file:focus {
	background: #ecf3f9;
	border: 1px solid #e0e6ec;
}
.files .file:hover .icon {
	color: #b5b5b5;
}
.uploads {
	margin-top: 1.4em;
}
.files {
	margin-top: 1.4em;
}
.file .attrs {
	display: inline-block;
	color: #9ea0a4;
	font-size: 1.1em;
	text-align: right;
	line-height: 1.7em;
	margin-top: .3em;
	float: right;
}
.file .filename {
	color: #303238;
	font-size: 17px;
	font-weight: 600;
}
.file .path {
	color: #9ea0a4;
	font-size: 1.1em;
	line-height: 1.6em;
}
.file .fileinfo {
	display: inline-block;
	margin-left: 1.5em;
}
.item-count {
	float: right;
	opacity: .7;
}
button, .filter {
	-webkit-touch-callout: none;
	  -webkit-user-select: none;
	   -khtml-user-select: none;
	     -moz-user-select: none;
	      -ms-user-select: none;
	       -o-user-select: none;
	          user-select: none;
}
.file-image {
	background-size: contain !important;
	background-repeat: no-repeat !important;
	width: 500px;
	height: 500px;
}
#downloader {
	display: none;
}

.upload {
	visibility: hidden;
	width: 0;
	height: 0;
}
.actions {
	float: right;
	text-align: right;
	margin-top: -4.3em;
}
.actions button {
	background: #555963;
	border: 1px solid #555963;
	border-radius: 4px;
	color: #fff;
	font-size: 1.4em;
	padding: .2em .4em .2em .4em;
	width: 2.7em;
	cursor: pointer;
	-webkit-transition: .15s all;
	margin-right: .3em;
}
.actions button:hover {
	background: #f0f0f0;
	color: #555963;
	border: 1px solid #9ea1a7;
}
.location .path {
	display: inline-block;
	margin-left: 4.1em;
}


@-webkit-keyframes progress-bar-stripes {
	from {
		background-position: 40px 0;
	}
	to {
		background-position: 0 0;
	}
}

@-moz-keyframes progress-bar-stripes {
	from {
		background-position: 40px 0;
	}
	to {
		background-position: 0 0;
	}
}

@-o-keyframes progress-bar-stripes {
	from {
		background-position: 40px 0;
	}
	to {
		background-position: 0 0;
	}
}

@keyframes progress-bar-stripes {
	from {
		background-position: 40px 0;
	}
	to {
		background-position: 0 0;
	}
}

.progress {
	height: 5.8em;
	overflow: hidden;
	background-color: #555963;
	float: left;
	width: 100%; 
}
.progress-bar {
	overflow: hidden;
	height: 100%;
	width: 100%;
	background-color: #428bca;
	-webkit-transition: width 0.6s ease;
	   -moz-transition: width 0.6s ease;
	    -ms-transition: width 0.6s ease;
	     -o-transition: width 0.6s ease;
	        transition: width 0.6s ease;
}
.progress-striped .progress-bar {
	background-image: -webkit-gradient(linear, 0 100%, 100% 0, color-stop(0.25, rgba(255, 255, 255, 0.15)), color-stop(0.25, transparent), color-stop(0.5, transparent), color-stop(0.5, rgba(255, 255, 255, 0.15)), color-stop(0.75, rgba(255, 255, 255, 0.15)), color-stop(0.75, transparent), to(transparent));
	background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
	background-image: -moz-linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
	background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
	background-size: 40px 40px;
}
.progress.active .progress-bar {
	-webkit-animation: progress-bar-stripes 2s linear infinite;
	   -moz-animation: progress-bar-stripes 2s linear infinite;
	    -ms-animation: progress-bar-stripes 2s linear infinite;
		 -o-animation: progress-bar-stripes 2s linear infinite;
		    animation: progress-bar-stripes 2s linear infinite;
}
.progress-bar-success {
	background-color: #5cb85c;
}
.progress-bar-info {
	background-color: #5bc0de;
}
.progress-bar-danger {
	background-color: #d9534f;
}


.upload-item {
	padding: 0;
}
.upload-content {
	padding: .8em 1.4em .8em 1.4em;
	float: left;
	margin-top: -5.8em;
	width: 95%;
}
.upload-content .filename, .upload-content .icon, .upload-content .attrs, .upload-content .path {
	color: #fff;
}

.modal-wrap {
	opacity: 0;
	pointer-events: none;
	-webkit-transition: .2s opacity;
	position: fixed;
	bottom: 0;
	height: 0;
	width: 0;
	z-index: 1000;
}

.modal-enabled {
	overflow: hidden;
}

.login-wrap, .modal-enabled .modal-wrap {
	position: fixed;
	width: 100%;
	height: 100%;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	overflow: hidden;
}

.login-wrap {
	background: #46aad5;
}

.modal-wrap {
	background: rgba(34,53,62,.7);
}

.modal-enabled .modal-wrap {
	opacity: 1;
	pointer-events: auto;
}

.login .welcome {
	color: #fff;
	font-size: 4.5em;
	font-weight: 100;
	text-align: center;
	margin-bottom: .8em;
}

.login .input-wrap {
	color: #fff;
	border-radius: 5px;
	background: rgba(0,0,0,.26);
	font-size: 2em;
	padding: .4em .6em .4em .6em;
	width: 100%;
	box-sizing: border-box;
	font-weight: 100;
	margin-bottom: .27em;
}

.login input {
	width: 100%;
	font-size: 1em;
	font-weight: 100;
	border: 0;
	background: none;
	color: #fff;
}
.login .field, .login .label {
	display: table-cell;
}
.login .field {
	width: 100%;
}
.login .label {
	min-width: 5.5em;
	opacity: .7;
}

.login {
	width: 35em;
	margin: 0 auto;
	margin-top: 10em;
}

.login-button {
	border-radius: 5px;
	background: rgba(0,0,0,.76);
	padding: .4em .6em .4em .6em;
	width: 100%;
	box-sizing: border-box;
	border: none;
	font-size: 2em;
	color: #fff;
	cursor: pointer;
	-webkit-transition: .2s all;
}

.copyright-login {
	opacity: .2;
	font-size: 2em;
	margin-top: 2em;
	text-align: right;
	-webkit-transition: .4s all;
}
.copyright-login:hover {
	opacity: .7;
}
.copyright-login:hover .cheryl {
	color: #f83ca2;
}

.filter-name {
	max-width: 2em;
	text-overflow:ellipsis;
	display: inline-block;
	overflow: hidden;
	max-width: 10em;
	height: 1.3em;
	vertical-align: top;
}
.modal {
	background: #fff;
	width: 36em;
	margin: 0 auto;
	margin-top: 20em;
	padding: 2em;
	min-height: 11em;
	text-align: center;
	box-shadow: 0px 0px 0px 4px rgba(0,0,0,.14);
}

.modal-dropupload {
	background: none;
	border-radius: 10px;
	border: 2px dashed #fff;
	box-shadow: none;
	width: 28em;
	color: #fff;
}

.modal-dropupload h1 {
	color: #fff;
	font-size: 9em;
	margin-top: .4em;
	line-height: 1em;
}
.modal-dropupload h2 {
	color: #fff;
	font-size: 2em;
	margin-bottom: 1.6em;
}

.modal button {
	border: none;
	padding: .45em 2em .45em 2em;
	font-size: 1.4em;
	margin: 0 .5em 0 .5em;
	cursor: pointer;
	border-radius: 3px;
	background: #f0f0f0;
	color: #555963;
	border: 1px solid #9ea1a7;
	-webkit-transition: .15s all;
}

.modal button:focus, .modal button:hover {
	background: #555963;
	color: #fff;
	border: 1px solid #555963;
}

@-webkit-keyframes shake {
	0%   { -webkit-transform: translate(2px, 1px)   rotate(0deg); }
	10%  { -webkit-transform: translate(-1px, -2px) rotate(-1deg); }
	20%  { -webkit-transform: translate(-3px, 0px)  rotate(1deg); }
	30%  { -webkit-transform: translate(0px, 2px)   rotate(0deg); }
	40%  { -webkit-transform: translate(1px, -1px)  rotate(1deg); }
	50%  { -webkit-transform: translate(-1px, 1px)  rotate(-1deg); }
	60%  { -webkit-transform: translate(-3px, -2px)  rotate(0deg); }
	70%  { -webkit-transform: translate(2px, 1px)   rotate(-1deg); }
	80%  { -webkit-transform: translate(-1px, -2px) rotate(1deg); }
	90%  { -webkit-transform: translate(2px, -1px)   rotate(0deg); }
	100% { -webkit-transform: translate(1px, -2px)  rotate(-1deg); }
}

.global-error .logo svg {
	-webkit-animation-name: 'shake';
	-webkit-animation-duration: 0.3s;
	-webkit-transform-origin:50% 50%;
	-webkit-animation-iteration-count: 3;
	-webkit-animation-timing-function: linear;
}
#editor {
	height: 100%;
	min-height: 500px;
	font-size: 11px;
	
}
.file-contents {
	margin-top: 1em;
}

                
.fullscreen-editor #editor { 
	height: auto !important;
	width: auto !important;
	border: 0;
	margin: 0;
	position: fixed !important;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
	z-index: 10000
}
.fullscreen-editor {
	overflow: hidden
}










.animated {
	-webkit-animation-fill-mode: both;
	   -moz-animation-fill-mode: both;
	    -ms-animation-fill-mode: both;
	     -o-animation-fill-mode: both;
	        animation-fill-mode: both;

	-webkit-animation-duration: 1s;
	   -moz-animation-duration: 1s;
	    -ms-animation-duration: 1s;
	     -o-animation-duration: 1s;
	        animation-duration: 1s;
}
.welcome {
	-webkit-animation-delay: .4s;
	   -moz-animation-delay: .4s;
	    -ms-animation-delay: .4s;
	     -o-animation-delay: .4s;
	        animation-delay: .4s;
}
.login-form {
	-webkit-animation-delay: 1.1s;
	   -moz-animation-delay: 1.1s;
	    -ms-animation-delay: 1.1s;
	     -o-animation-delay: 1.1s;
	        animation-delay: 1.1s;
}
@-webkit-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}
@-moz-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}
@-ms-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}
@-o-keyframes fadeIn {
	0% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}
@keyframes fadeIn {
	0% {
		opacity: 0;
	}
	100% {
		opacity: 1;
	}
}
@-webkit-keyframes fadeInDown {
	0% {
		opacity: 0;
		-webkit-transform: translateY(-20px);
	}
	100% {
		opacity: 1;
		-webkit-transform: translateY(0);
	}
}

@-moz-keyframes fadeInDown {
	0% {
		opacity: 0;
		-moz-transform: translateY(-20px);
	}
	100% {
		opacity: 1;
		-moz-transform: translateY(0);
	}
}

@-ms-keyframes fadeInDown {
	0% {
		opacity: 0;
		-ms-transform: translateY(-20px);
	}
	100% {
		opacity: 1;
		-ms-transform: translateY(0);
	}
}

@-o-keyframes fadeInDown {
	0% {
		opacity: 0;
		-o-transform: translateY(-20px);
	}
	100% {
		opacity: 1;
		-o-transform: translateY(0);
	}
}

@keyframes fadeInDown {
	0% {
		opacity: 0;
		transform: translateY(-20px);
	}
	100% {
		opacity: 1;
		transform: translateY(0);
	}
}

.fadeInDown {
	-webkit-animation-name: fadeInDown;
	   -moz-animation-name: fadeInDown;
	    -ms-animation-name: fadeInDown;
	     -o-animation-name: fadeInDown;
	        animation-name: fadeInDown;
}
.fadeIn {
	-webkit-animation-name: fadeIn;
	   -moz-animation-name: fadeIn;
	    -ms-animation-name: fadeIn;
	     -o-animation-name: fadeIn;
	        animation-name: fadeIn;
}
</style>

<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800" rel="stylesheet">

</head>
<body ng-controller="RootCtrl" ng-class="{'modal-enabled': dialog, 'global-error': (dialog && dialog.type == 'error'), 'fullscreen-editor': fullscreenEdit}" ng-body ng-drop-upload>
	<div class="wrapper clearfix" ng-show="authed">
		<div class="panel">
			<a href="<?php echo Cheryl::script() ? Cheryl::script() : '/' ?>"><div class="logo">
		
				<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
					 width="689.318px" height="642.217px" viewBox="0 0 689.318 642.217" enable-background="new 0 0 689.318 642.217"
					 xml:space="preserve">
				<g>
					<g>
						<g>
							<g>
								
									<ellipse transform="matrix(-0.6304 -0.7763 0.7763 -0.6304 829.5235 668.4048)" fill="#3B1410" cx="573.881" cy="136.727" rx="112.318" ry="117.438"/>
								<g>
									<g>
										
											<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="-402.9502" y1="939.6608" x2="-331.6008" y2="939.6608" gradientTransform="matrix(-0.0414 -0.999 0.999 -0.0414 -313.7207 -151.8308)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_1_)" d="M610.424,213.071c0,0,63.683,1.451,59.549-73.829
											C669.974,139.242,663.009,200.72,610.424,213.071z"/>
										
											<linearGradient id="SVGID_2_" gradientUnits="userSpaceOnUse" x1="335.5046" y1="363.5505" x2="410.826" y2="363.5505" gradientTransform="matrix(0.7423 0.67 0.67 -0.7423 67.1035 77.1552)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_2_)" d="M538.389,55.726c0,0,40.268-47.276,98.591,3.174C636.98,58.901,582.618,25.227,538.389,55.726z
											"/>
										
											<linearGradient id="SVGID_3_" gradientUnits="userSpaceOnUse" x1="-2232.4961" y1="-587.3471" x2="-2176.293" y2="-587.3471" gradientTransform="matrix(-0.5277 0.8493 -0.8493 -0.5277 -1062.6609 1651.484)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_3_)" d="M645.642,86.604c0,0-56.077-31.247-93.199,6.516C552.443,93.12,587.056,35.894,645.642,86.604z
											"/>
										
											<linearGradient id="SVGID_4_" gradientUnits="userSpaceOnUse" x1="-2228.9397" y1="-295.3342" x2="-2155.5984" y2="-295.3342" gradientTransform="matrix(-0.6438 0.7652 -0.7652 -0.6438 -1035.2269 1601.1501)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_4_)" d="M645.847,102.606c0,0-50.104-21.263-87.027,22.627
											C558.819,125.233,592.348,71.114,645.847,102.606z"/>
										
											<linearGradient id="SVGID_5_" gradientUnits="userSpaceOnUse" x1="-2289.9167" y1="-302.4471" x2="-2206.2373" y2="-302.4471" gradientTransform="matrix(-0.8224 0.569 -0.569 -0.8224 -1393.106 1197.1461)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_5_)" d="M657.495,136.096c0,0-17.959,53.366-70.557,45.1
											C586.939,181.197,644.183,201.136,657.495,136.096z"/>
										
											<linearGradient id="SVGID_6_" gradientUnits="userSpaceOnUse" x1="-2219.0256" y1="-316.291" x2="-2147.5671" y2="-316.291" gradientTransform="matrix(-0.6438 0.7652 -0.7652 -0.6438 -1035.2269 1601.1501)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_6_)" d="M646.085,115.763c0,0-21.869,30.751-68.64,35.636
											C577.445,151.399,620.6,161.903,646.085,115.763z"/>
									</g>
								</g>
							</g>
							<g>
								<path fill="#3B1410" d="M186.242,46.116c50.348,40.887,59.462,113.069,20.359,161.221
									c-39.108,48.152-111.623,54.042-161.972,13.156c-50.345-40.89-59.462-113.072-20.355-161.226
									C63.379,11.115,135.893,5.225,186.242,46.116z"/>
								<g>
									<g>
										
											<linearGradient id="SVGID_7_" gradientUnits="userSpaceOnUse" x1="-434.0402" y1="1772.5775" x2="-362.6902" y2="1772.5775" gradientTransform="matrix(0.0414 -0.999 -0.999 -0.0414 1836.4091 -151.8308)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_7_)" d="M78.892,209.647c0,0-63.684,1.452-59.548-73.83C19.345,135.817,26.309,197.297,78.892,209.647z
											"/>
										
											<linearGradient id="SVGID_8_" gradientUnits="userSpaceOnUse" x1="951.8776" y1="924.5019" x2="1027.199" y2="924.5019" gradientTransform="matrix(-0.7423 0.67 -0.67 -0.7423 1455.5847 77.1552)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_8_)" d="M150.929,52.302c0,0-40.269-47.275-98.591,3.174C52.337,55.476,106.7,21.805,150.929,52.302z"
											/>
										
											<linearGradient id="SVGID_9_" gradientUnits="userSpaceOnUse" x1="-2675.2734" y1="-1293.4803" x2="-2619.0691" y2="-1293.4803" gradientTransform="matrix(0.5277 0.8493 0.8493 -0.5277 2585.3501 1651.484)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_9_)" d="M43.675,83.179c0,0,56.078-31.247,93.198,6.518C136.873,89.697,102.262,32.471,43.675,83.179z"
											/>
										
											<linearGradient id="SVGID_10_" gradientUnits="userSpaceOnUse" x1="-2768.0786" y1="-930.8193" x2="-2694.7368" y2="-930.8193" gradientTransform="matrix(0.6438 0.7652 0.7652 -0.6438 2557.9155 1601.1501)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_10_)" d="M43.471,99.183c0,0,50.104-21.261,87.028,22.626C130.499,121.809,96.969,67.691,43.471,99.183
											z"/>
										
											<linearGradient id="SVGID_11_" gradientUnits="userSpaceOnUse" x1="-2977.1575" y1="-773.7715" x2="-2893.4783" y2="-773.7715" gradientTransform="matrix(0.8224 0.569 0.569 -0.8224 2915.7942 1197.1461)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_11_)" d="M31.822,132.674c0,0,17.958,53.365,70.557,45.1
											C102.379,177.774,45.134,197.711,31.822,132.674z"/>
										
											<linearGradient id="SVGID_12_" gradientUnits="userSpaceOnUse" x1="-2758.1646" y1="-951.7772" x2="-2686.707" y2="-951.7772" gradientTransform="matrix(0.6438 0.7652 0.7652 -0.6438 2557.9155 1601.1501)">
											<stop  offset="0" style="stop-color:#3B1410"/>
											<stop  offset="0.1834" style="stop-color:#502919"/>
											<stop  offset="0.533" style="stop-color:#835321"/>
											<stop  offset="1" style="stop-color:#3B1410"/>
										</linearGradient>
										<path fill="url(#SVGID_12_)" d="M43.232,112.34c0,0,21.869,30.75,68.64,35.635C111.872,147.975,68.717,158.48,43.232,112.34z"
											/>
									</g>
								</g>
							</g>
							<g>
								<linearGradient id="SVGID_13_" gradientUnits="userSpaceOnUse" x1="311.1925" y1="63.994" x2="360.3353" y2="424.3733">
									<stop  offset="0.0056" style="stop-color:#E3B087"/>
									<stop  offset="0.0291" style="stop-color:#E5B38B"/>
									<stop  offset="0.1391" style="stop-color:#ECC09A"/>
									<stop  offset="0.2753" style="stop-color:#F1C9A5"/>
									<stop  offset="0.4672" style="stop-color:#F4CEAB"/>
									<stop  offset="1" style="stop-color:#F5D0AD"/>
								</linearGradient>
								<path fill="url(#SVGID_13_)" d="M349.073,57.331c-151.457,0-274.236,127.366-274.236,284.479
									c0,22.437,2.513,44.266,7.247,65.204C110.5,532.7,220.382,642.217,350.21,642.217c127.014,0,232.705-105.509,263.884-227.083
									c6.001-23.396,9.217-47.971,9.217-73.324C623.311,184.697,500.529,57.331,349.073,57.331z"/>
								<g>
									<radialGradient id="SVGID_14_" cx="214.0404" cy="537.9091" r="39.4764" gradientUnits="userSpaceOnUse">
										<stop  offset="0" style="stop-color:#F8AEAB"/>
										<stop  offset="0.2779" style="stop-color:#F7B3AB"/>
										<stop  offset="0.721" style="stop-color:#F5C4AD"/>
										<stop  offset="1" style="stop-color:#F5D0AD"/>
									</radialGradient>
									<ellipse fill="url(#SVGID_14_)" cx="214.04" cy="537.907" rx="40.964" ry="37.933"/>
									<radialGradient id="SVGID_15_" cx="484.1053" cy="537.9091" r="39.4767" gradientUnits="userSpaceOnUse">
										<stop  offset="0" style="stop-color:#F8AEAB"/>
										<stop  offset="0.2779" style="stop-color:#F7B3AB"/>
										<stop  offset="0.721" style="stop-color:#F5C4AD"/>
										<stop  offset="1" style="stop-color:#F5D0AD"/>
									</radialGradient>
									<ellipse fill="url(#SVGID_15_)" cx="484.105" cy="537.907" rx="40.964" ry="37.933"/>
								</g>
								<g>
									<g>
										<g>
											<path fill="#3B1410" d="M492.486,387.328c-10.565-0.004-21.142,5.141-28.662,15.414l0,0v-0.003
												c-0.359,0.493-0.309,1.233,0.11,1.651l0,0c0.424,0.421,1.056,0.36,1.417-0.129l0,0c7.126-9.733,17.123-14.593,27.135-14.594
												l0,0c10.01,0.001,20.01,4.861,27.136,14.594l0,0c0.358,0.489,0.992,0.551,1.415,0.129l0,0
												c0.419-0.418,0.47-1.157,0.108-1.648l0,0c-7.515-10.27-18.091-15.414-28.653-15.414l0,0
												C492.489,387.328,492.488,387.328,492.486,387.328L492.486,387.328z"/>
											<path fill="#3B1410" d="M520.384,406.376c-0.845,0.004-1.66-0.436-2.141-1.11l0,0c-6.843-9.329-16.304-13.885-25.759-13.893
												l0,0c-9.455,0.008-18.914,4.564-25.766,13.906l0,0c-0.482,0.658-1.28,1.102-2.134,1.098l0,0
												c-0.685,0.004-1.374-0.29-1.855-0.777l0,0c-0.598-0.603-0.852-1.365-0.855-2.101l0,0c0.003-0.605,0.178-1.225,0.574-1.768
												l0,0c0.01-0.016,0.02-0.029,0.032-0.041l0,0c7.799-10.645,18.892-16.077,29.998-16.07l0,0c0.005,0,0.011,0,0.014,0l0,0h0.003
												c11.119-0.007,22.229,5.44,30.031,16.115l0,0c0.396,0.546,0.564,1.165,0.567,1.766l0,0c-0.003,0.731-0.251,1.493-0.856,2.103
												l0,0c-0.478,0.479-1.151,0.773-1.837,0.773l0,0C520.394,406.376,520.387,406.376,520.384,406.376L520.384,406.376z
												 M492.484,387.957v-0.63l0.336-1.675l-0.336,1.675V387.957L492.484,387.957L492.484,387.957z"/>
										</g>
									</g>
									<g>
										<g>
											<path fill="#3B1410" d="M227.415,387.328c-10.562-0.004-21.144,5.141-28.661,15.414l0,0v-0.003
												c-0.361,0.493-0.311,1.233,0.112,1.651l0,0c0.419,0.421,1.054,0.36,1.414-0.129l0,0c7.126-9.733,17.124-14.593,27.135-14.594
												l0,0c10.011,0.001,20.01,4.861,27.137,14.594l0,0c0.36,0.489,0.993,0.551,1.413,0.129l0,0
												c0.423-0.418,0.471-1.157,0.11-1.648l0,0c-7.517-10.27-18.091-15.414-28.652-15.414l0,0
												C227.42,387.328,227.415,387.328,227.415,387.328L227.415,387.328z"/>
											<path fill="#3B1410" d="M255.313,406.376c-0.845,0.004-1.658-0.436-2.14-1.11l0,0c-6.843-9.329-16.303-13.885-25.758-13.893
												l0,0c-9.454,0.008-18.915,4.564-25.766,13.906l0,0c-0.481,0.658-1.282,1.102-2.132,1.098l0,0
												c-0.69,0.004-1.377-0.29-1.857-0.777l0,0c-0.597-0.603-0.854-1.365-0.855-2.101l0,0c0.001-0.605,0.176-1.225,0.574-1.768l0,0
												c0.011-0.016,0.02-0.029,0.029-0.041l0,0c7.799-10.645,18.895-16.077,30.001-16.07l0,0c0.003,0,0.006,0,0.012,0l0,0h0.002
												c11.121-0.007,22.231,5.44,30.03,16.115l0,0c0.397,0.546,0.567,1.165,0.57,1.766l0,0c-0.003,0.731-0.254,1.493-0.857,2.103
												l0,0c-0.479,0.479-1.151,0.773-1.836,0.773l0,0C255.323,406.376,255.316,406.376,255.313,406.376L255.313,406.376z
												 M227.415,387.957v-0.63l0.335-1.675l-0.335,1.675V387.957L227.415,387.957L227.415,387.957z"/>
										</g>
									</g>
								</g>
								<g>
									<path fill="#010101" d="M550.875,438.219c0,0-20.954,15.173-54.19,5.058c0,0-11.385-5.42-24.246-1.27
										c-14.925,3.748-25.904,16.404-25.904,31.447c0,17.998,15.711,32.589,35.094,32.589c17.583,0,32.146-12.007,34.695-27.675
										C526.478,476.524,544.696,465.739,550.875,438.219z"/>
									<g>
										<path fill="#FFFFFF" d="M507.899,468.263c0,5.813-5.136,10.527-11.465,10.527c-6.338,0-11.469-4.714-11.469-10.527
											c0-5.815,5.131-10.533,11.469-10.533C502.764,457.729,507.899,462.447,507.899,468.263z"/>
										<path fill="#FFFFFF" d="M481.926,485.341c0,2.727-2.41,4.939-5.378,4.939c-2.976,0-5.385-2.213-5.385-4.939
											c0-2.73,2.409-4.945,5.385-4.945C479.516,480.395,481.926,482.61,481.926,485.341z"/>
									</g>
									<g>
										<path fill="#1B181C" d="M259.35,466.94c-3.782-0.455-7.734,3.301-10.425,7.143c-12.191,18.109-45.449,18.109-57.64,0
											c-2.689-3.842-6.639-7.598-10.422-7.143l0,0c-3.764,0.411-5.53,7.023-1.549,12.898c17.254,25.639,64.33,25.639,81.582,0.004
											C264.882,473.964,263.113,467.351,259.35,466.94L259.35,466.94z"/>
									</g>
								</g>
								<g>
									<path fill="#FFFFFF" d="M416.744,544.266c-0.859-1.077-2.08-1.004-2.927,0h-0.332h-56.791h-2.917h-65.42
										c-0.833-1.426-2.29-1.211-3.262,0c-0.973,1.221-1.084,3.361-0.253,4.785v-0.006c17.332,29.784,41.724,44.691,66.077,44.691
										c0.003,0,0.012,0,0.016,0c24.351,0,48.733-14.914,66.064-44.691C417.83,547.62,417.713,545.487,416.744,544.266z"/>
								</g>
							</g>
							<g>
								<path fill="#3B1410" d="M645.703,353.759C645.703,143.246,513.84-0.268,341.232,0C171.073,0.262,56.233,143.246,56.233,353.762
									c0.002,25.142,15.687,89.017,20.993,101.091c8.953,20.378,48.74,52.87,75.597,91.852
									c-31.331-71.765-30.074-146.556-30.074-146.556s159.164,42.443,363.427-161.817c6.581,8.1,94.723,185.055,94.723,185.055
									s14.964,48.898-26.22,111.805c0,0,58.79-48.696,71.791-82.74C629.64,444.155,645.703,378.784,645.703,353.759z"/>
								<g>
									
										<linearGradient id="SVGID_16_" gradientUnits="userSpaceOnUse" x1="772.6558" y1="102.7029" x2="985.3578" y2="102.7029" gradientTransform="matrix(-0.9886 0.1505 0.1505 0.9886 1120.4738 -172.6003)">
										<stop  offset="0" style="stop-color:#3B1410"/>
										<stop  offset="0.1834" style="stop-color:#502919"/>
										<stop  offset="0.533" style="stop-color:#835321"/>
										<stop  offset="1" style="stop-color:#3B1410"/>
									</linearGradient>
									<path fill="url(#SVGID_16_)" d="M370.612,35.554c0,0-104.022-17.74-205.353,64.355
										C165.259,99.909,226.619,14.091,370.612,35.554z"/>
									
										<linearGradient id="SVGID_17_" gradientUnits="userSpaceOnUse" x1="512.2903" y1="252.9687" x2="620.1285" y2="252.9687" gradientTransform="matrix(-0.966 0.2584 0.2584 0.966 1027.7928 -85.7945)">
										<stop  offset="0" style="stop-color:#3B1410"/>
										<stop  offset="0.1834" style="stop-color:#502919"/>
										<stop  offset="0.533" style="stop-color:#835321"/>
										<stop  offset="1" style="stop-color:#3B1410"/>
									</linearGradient>
									<path fill="url(#SVGID_17_)" d="M444.598,133.698c0,0,199.351,60.682,159.957,353.938
										C604.555,487.635,664.541,190.835,444.598,133.698z"/>
									
										<linearGradient id="SVGID_18_" gradientUnits="userSpaceOnUse" x1="515.6821" y1="87.2381" x2="607.4606" y2="87.2381" gradientTransform="matrix(-1.0087 0.3502 0.3689 1.0625 1087.8507 -44.2152)">
										<stop  offset="0" style="stop-color:#3B1410"/>
										<stop  offset="0.1834" style="stop-color:#502919"/>
										<stop  offset="0.533" style="stop-color:#835321"/>
										<stop  offset="1" style="stop-color:#3B1410"/>
									</linearGradient>
									<path fill="url(#SVGID_18_)" d="M450.007,96.23c0,0,148.743-5.351,178.487,307.761
										C628.494,403.992,628.494,93.555,450.007,96.23z"/>
									
										<linearGradient id="SVGID_19_" gradientUnits="userSpaceOnUse" x1="536.4581" y1="146.1406" x2="817.6895" y2="146.1406" gradientTransform="matrix(-0.9989 -0.0467 -0.0467 0.9989 946.2015 19.9831)">
										<stop  offset="0" style="stop-color:#3B1410"/>
										<stop  offset="0.1834" style="stop-color:#502919"/>
										<stop  offset="0.533" style="stop-color:#835321"/>
										<stop  offset="1" style="stop-color:#3B1410"/>
									</linearGradient>
									<path fill="url(#SVGID_19_)" d="M406.495,77.037c0,0-172.367-42.429-287.129,119.639
										C119.366,196.676,201.697,31.43,406.495,77.037z"/>
									
										<linearGradient id="SVGID_20_" gradientUnits="userSpaceOnUse" x1="591.3597" y1="-28.2471" x2="861.3224" y2="-28.2471" gradientTransform="matrix(-1.1164 0.6519 0.5042 0.8635 1091.2041 -164.2081)">
										<stop  offset="0" style="stop-color:#3B1410"/>
										<stop  offset="0.1834" style="stop-color:#502919"/>
										<stop  offset="0.533" style="stop-color:#835321"/>
										<stop  offset="1" style="stop-color:#3B1410"/>
									</linearGradient>
									<path fill="url(#SVGID_20_)" d="M411.38,187.68c0,0-161.863,41.268-281.583,209.904
										C129.797,397.584,181.288,256.429,411.38,187.68z"/>
									
										<linearGradient id="SVGID_21_" gradientUnits="userSpaceOnUse" x1="349.0724" y1="137.6138" x2="680.7399" y2="137.6138" gradientTransform="matrix(-0.9695 0.0633 0.0406 0.9072 744.6884 137.8341)">
										<stop  offset="0" style="stop-color:#3B1410"/>
										<stop  offset="0.1834" style="stop-color:#502919"/>
										<stop  offset="0.533" style="stop-color:#835321"/>
										<stop  offset="1" style="stop-color:#3B1410"/>
									</linearGradient>
									<path fill="url(#SVGID_21_)" d="M403.851,106.052c0,0-354.125-2.575-299.329,378.656
										C104.523,484.708,10.224,113.738,403.851,106.052z"/>
									
										<linearGradient id="SVGID_22_" gradientUnits="userSpaceOnUse" x1="263.0153" y1="43.7536" x2="650.2787" y2="43.7536" gradientTransform="matrix(-0.8219 0.1065 0.1225 0.945 627.7811 182.8543)">
										<stop  offset="0" style="stop-color:#3B1410"/>
										<stop  offset="0.1834" style="stop-color:#502919"/>
										<stop  offset="0.533" style="stop-color:#835321"/>
										<stop  offset="1" style="stop-color:#3B1410"/>
									</linearGradient>
									<path fill="url(#SVGID_22_)" d="M404.034,152.432c0,0-221.758,21.408-292.069,243.532
										C111.965,395.964,166.053,152.432,404.034,152.432z"/>
									
										<linearGradient id="SVGID_23_" gradientUnits="userSpaceOnUse" x1="493.9396" y1="49.7161" x2="599.5733" y2="49.7161" gradientTransform="matrix(-1.0087 0.3502 0.3689 1.0625 1087.8507 -44.2152)">
										<stop  offset="0" style="stop-color:#3B1410"/>
										<stop  offset="0.1834" style="stop-color:#502919"/>
										<stop  offset="0.533" style="stop-color:#835321"/>
										<stop  offset="1" style="stop-color:#3B1410"/>
									</linearGradient>
									<path fill="url(#SVGID_23_)" d="M445.947,58.859c0,0,177.139,21.317,198.777,288.934
										C644.724,347.793,636.608,69.47,445.947,58.859z"/>
									<linearGradient id="SVGID_24_" gradientUnits="userSpaceOnUse" x1="152.8603" y1="376.5605" x2="427.4074" y2="232.4359">
										<stop  offset="0" style="stop-color:#3B1410"/>
										<stop  offset="0.1834" style="stop-color:#502919"/>
										<stop  offset="0.533" style="stop-color:#835321"/>
										<stop  offset="1" style="stop-color:#3B1410"/>
									</linearGradient>
									<path fill="url(#SVGID_24_)" d="M421.858,221.865c0,0-221.559,70.727-254.911,181.531
										C166.948,403.396,214.597,264.301,421.858,221.865z"/>
									<linearGradient id="SVGID_25_" gradientUnits="userSpaceOnUse" x1="202.8852" y1="394.3258" x2="457.3486" y2="260.7443">
										<stop  offset="0" style="stop-color:#3B1410"/>
										<stop  offset="0.1834" style="stop-color:#502919"/>
										<stop  offset="0.533" style="stop-color:#835321"/>
										<stop  offset="1" style="stop-color:#3B1410"/>
									</linearGradient>
									<path fill="url(#SVGID_25_)" d="M448.387,243.673c0,0-121.501,124.95-245.381,150.882
										C203.006,394.556,341.183,382.768,448.387,243.673z"/>
								</g>
							</g>
						</g>
					</g>
				</g>
				</svg>
			</div></a>
	
			<div class="filters" ng-show="type=='dir'">
				<h2>Filter by date</h2>
				<ul>
					<li class="filter" ng-class="{enabled: filterCheck('dates',key)}" ng-click="filter('dates',key)" ng-repeat="(key, val) in dateFilterNames"><span class="filter-name">{{val}}</span><span class="item-count">({{dates[key] || '0'}})</span></li>
				</ul>
				<br><br>
				<h2>Filter by type</h2>
				<ul>
					<li class="filter" ng-class="{enabled: filterCheck('types',key)}" ng-click="filter('types',key)" ng-repeat="(key, val) in types"><span class="filter-name">{{key}}</span><span class="item-count">({{val}})</span></li>
				</ul>
				<br><br>
				<h2>Sort by</h2>
				<ul>
					<li class="filter">Name</li>
					<li class="filter">Date</li>
					<li class="filter">Type</li>
				</ul>
				
			</div>
			<div class="details" ng-show="type!='dir'">
				<h2>File info</h2>
				<ul>
					<li class="info">Created: {{file.ctime*1000 | date:'medium'}}</li>
					<li class="info">Modified: {{file.mtime*1000 | date:'medium'}}</li>
					<li class="info">Size: {{file.sizeReadable}}</li>
					<li class="info" ng-repeat="(key, val) in file.meta">{{key}}: <b>{{val}}</b></li>
				</ul>
			</div>
		</div>

		<div class="toggles">
			<button ng-class="{enabled: filters.recursive == 0}" ng-click="filter('recursive',0)">Browse</button>
			<button ng-class="{enabled: filters.recursive == 1}" ng-click="filter('recursive',1)">Recent</button>
			<div class="search" ng-class="{active: searchActive}">
				<i class="fa fa-search"></i>
				<input type="text" class="search-box" ng-model="filters.search" ng-focus="searchActive=true" ng-blur="searchActive=false" placeholder="Search">
			</div>
		</div>
		<div class="content">
			<div class="location">
				<h1>
					<i class="fa fa-folder-open"></i>&nbsp;&nbsp;
					<input ng-model="file.name" ng-show="file.writeable && file.name" ng-file-name><span class="file-name-top" ng-show="!file.name || !file.writeable">{{file.name || 'Home'}}</span>
				</h1>
				<a href="{{path()}}{{file.path}}" class="path">{{file.path ? 'Home' + (file.path == '/' ? '' : file.path) : ''}}</a>
			</div>
			<div class="actions">
				<button title="Fullscreen editor" class="fullscreen-button" ng-show="file.writeable && file.name && type!='dir' && file.type == 'text'" ng-fullscreen-editor><i class="fa fa-expand"></i></button><?php
				?><button title="Save this file" class="save-button" ng-save ng-show="file.writeable && file.name && type!='dir' && file.type == 'text'"><i class="fa fa-floppy-o"></i></button><?php
				?><button title="Delete this {{type=='dir' ? 'folder' : 'file'}}" class="delete-button" ng-delete ng-show="file.writeable && file.name"><i class="fa fa-trash-o"></i></button><?php
				?><a href="#NewFile"><button title="Create a new file" class="create-file-button" ng-make-file ng-show="file.writeable && type=='dir'"><i class="fa fa-file-text"></i></button></a><?php
				?><button title="Create a new folder" class="create-folder-button" ng-make-dir ng-show="file.writeable && type=='dir'"><i class="fa fa-folder"></i></button><?php
				?><button title="Upload a file" class="upload-button" ng-upload ng-show="file.writeable && type=='dir'"><i class="fa fa-cloud-upload"></i></button>
			</div>
			<div class="uploads" ng-show="type=='dir'">
				<a class="file upload-item clearfix" ng-repeat="upload in uploads">
					<div class="progress progress-striped active ">
						<div class="progress-bar" ng-class="{'progress-bar-info': upload.status == 'uploading', 'progress-bar-danger': upload.status == 'error', 'progress-bar-success': upload.status == 'success'}" style="width: {{upload.progress}}%"></div>
					</div>
					<div class="upload-content">
						<div class="icon">
							<i class="fa fa-cloud-upload"></i>
						</div>
						<div class="fileinfo">
							<span class="filename">{{upload.name}}</span>
							<span class="path"><br>Home{{upload.path}}</span>
						</div>
						<span class="attrs">
							{{upload.sizeReadable}}<br>
							<b ng-show="upload.status == 'success'">Complete!</b>
							<b ng-show="upload.status == 'error'">Failed to upload</b>
						</span>
					</div>
				</a>
			</div>

			<div class="files" ng-show="type=='dir'">
				<a href="{{path()}}{{file.path}}/{{file.name}}" class="file" ng-repeat="file in dirs | filter:filterFolders" tabindex="1" ng-show="!filters.recursive">
					<i class="icon fa fa-folder-o"></i>
					<div class="fileinfo">
						<span class="filename">{{file.name}}</span>
						<span class="path"><br>Home{{file.path}}</span>
					</div>
				</a>

				<a href="{{path()}}{{file.path}}/{{file.name}}" class="file" ng-repeat="file in files | filter:filterFiles" tabindex="1" >
					<div class="icon" ng-click="downloadFile($event, file)">
						<i class="fa fa-file-text-o"></i>
						<i class="fa fa-download"></i>
					</div>
					<div class="fileinfo">
						<span class="filename">{{file.name}}</span>
						<span class="path"><br>Home{{file.path}}</span>
					</div>
					<span class="attrs">
						{{file.dateReadable}}<br>
						{{file.sizeReadable}}
					</span>
				</a>
			</div>
			<div class="file-contents" ng-show="type!='dir'">
				<div id="editor" ng-show="file.contents"></div>
				<?php /*<div class="file-image" style="background: url(/Files/{{file.path}}/{{file.name}})"></div> */ ?>
			</div>
		</div>
		<div class="copyright">
			<a href="http://cheryl.io" target="_blank"><span class="powered">powered by</span> <span class="cheryl">cheryl.io</span></a>
		</div>
	</div>
	<div class="login-wrap" ng-show="!authed">
		<div class="login">
			<form ng-submit="login()">
				<div class="welcome fadeInDown animated" ng-bind="welcome">Welcome!</div>
				<div class="login-form fadeIn animated">
					<div class="input-wrap">
						<span class="label">Username:</span>
						<span class="field"><input type="text" ng-model="user.username" autofocus></span>
					</div>
					<div class="input-wrap">
						<span class="label">Password:</span>
						<span class="field"><input type="password" ng-model="user.password"></span>
					</div>
					<button class="login-button" type="submit"><i class="fa fa-heart"></i>&nbsp;&nbsp;&nbsp;Login</button>
				</div>
			</form>
			
			<div class="copyright-login">
				<a href="http://cheryl.io" target="_blank"><span class="powered">powered by</span> <span class="cheryl">cheryl.io</span></a>
			</div>
		</div>
	</div>
	<div class="modal-wrap" ng-modal>
		<div class="modal modal-{{dialog.type}}">
			<div ng-show="dialog.type == 'makeDir'">
				<form ng-submit="dialog.yes()">
					<h2>Create a folder in <b>Home{{file.path ? (file.path == '/' ? '' : file.path) : ''}}{{file.path ? '/' : ''}}{{file.name}}</b>
						<br><br>
						<input type="text" ng-model="dialog.file" ng-autofocus="dialog.type == 'makeDir'">
					</h2>
	
					<br><br><br>
					<button type="submit">Make</button>
					<button ng-click="dialog.no()">Cancel</button>
				</form>
			</div>
			<div ng-show="dialog.type == 'confirmDelete'">
				<h2>Are you sure you want to delete <b>{{dialog.file.name}}</b>?</h2>
				<br><br><br>
				<form ng-submit="dialog.yes()">
					<button ng-autofocus="dialog.type == 'confirmDelete'" tabindex="20">Yes</button>
					<button ng-click="dialog.no()" tabindex="21">No</button>
				</form>
			</div>
			<div ng-show="dialog.type == 'error'">
				<h2>{{dialog.message}}</h2>
				<br><br><br>
				<form ng-submit="dialog=false">
					<button ng-autofocus="dialog.type == 'error'">Close</button>
				</form>
			</div>
			<div ng-show="dialog.type == 'dropupload'">
				<h1><i class="fa fa-cloud-upload"></i></h1>
				<h2>Drop it!</h2>
			</div>
		</div>
	</div>
	<iframe id="downloader"></iframe>
	<input type="file" class="upload" ng-uploader multiple>
</body>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.3/angular.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.1/angular-route.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/ace/1.1.01/ace.js"></script>

<script>
/* http://caligatio.github.com/jsSHA/ */
(function(module) {function k(d){throw d;}function s(d,f){var a=[],b,c=[],e=0,g;if("UTF8"==f)for(g=0;g<d.length;g+=1){b=d.charCodeAt(g);c=[];2048<b?(c[0]=224|(b&61440)>>>12,c[1]=128|(b&4032)>>>6,c[2]=128|b&63):128<b?(c[0]=192|(b&1984)>>>6,c[1]=128|b&63):c[0]=b;for(b=0;b<c.length;b+=1)a[e>>>2]|=c[b]<<24-8*(e%4),e+=1}else if("UTF16"==f)for(g=0;g<d.length;g+=1)a[e>>>2]|=d.charCodeAt(g)<<16-8*(e%4),e+=2;return{value:a,binLen:8*e}}
function u(d){var f=[],a=d.length,b,c;0!==a%2&&k("String of HEX type must be in byte increments");for(b=0;b<a;b+=2)c=parseInt(d.substr(b,2),16),isNaN(c)&&k("String of HEX type contains invalid characters"),f[b>>>3]|=c<<24-4*(b%8);return{value:f,binLen:4*a}}
function v(d){var f=[],a=0,b,c,e,g,h;-1===d.search(/^[a-zA-Z0-9=+\/]+$/)&&k("Invalid character in base-64 string");b=d.indexOf("=");d=d.replace(/\=/g,"");-1!==b&&b<d.length&&k("Invalid '=' found in base-64 string");for(c=0;c<d.length;c+=4){h=d.substr(c,4);for(e=g=0;e<h.length;e+=1)b="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".indexOf(h[e]),g|=b<<18-6*e;for(e=0;e<h.length-1;e+=1)f[a>>2]|=(g>>>16-8*e&255)<<24-8*(a%4),a+=1}return{value:f,binLen:8*a}}
function w(d,f){var a="",b=4*d.length,c,e;for(c=0;c<b;c+=1)e=d[c>>>2]>>>8*(3-c%4),a+="0123456789abcdef".charAt(e>>>4&15)+"0123456789abcdef".charAt(e&15);return f.outputUpper?a.toUpperCase():a}
function x(d,f){var a="",b=4*d.length,c,e,g;for(c=0;c<b;c+=3){g=(d[c>>>2]>>>8*(3-c%4)&255)<<16|(d[c+1>>>2]>>>8*(3-(c+1)%4)&255)<<8|d[c+2>>>2]>>>8*(3-(c+2)%4)&255;for(e=0;4>e;e+=1)a=8*c+6*e<=32*d.length?a+"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".charAt(g>>>6*(3-e)&63):a+f.b64Pad}return a}
function y(d){var f={outputUpper:!1,b64Pad:"="};try{d.hasOwnProperty("outputUpper")&&(f.outputUpper=d.outputUpper),d.hasOwnProperty("b64Pad")&&(f.b64Pad=d.b64Pad)}catch(a){}"boolean"!==typeof f.outputUpper&&k("Invalid outputUpper formatting option");"string"!==typeof f.b64Pad&&k("Invalid b64Pad formatting option");return f}function z(d,f){var a=(d&65535)+(f&65535);return((d>>>16)+(f>>>16)+(a>>>16)&65535)<<16|a&65535}
function A(d,f,a,b,c){var e=(d&65535)+(f&65535)+(a&65535)+(b&65535)+(c&65535);return((d>>>16)+(f>>>16)+(a>>>16)+(b>>>16)+(c>>>16)+(e>>>16)&65535)<<16|e&65535}
function B(d,f){var a=[],b,c,e,g,h,C,t,j,D,l=[1732584193,4023233417,2562383102,271733878,3285377520],n=[1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1518500249,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,1859775393,
1859775393,1859775393,1859775393,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,2400959708,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782,3395469782];d[f>>>5]|=128<<24-f%32;d[(f+
65>>>9<<4)+15]=f;D=d.length;for(t=0;t<D;t+=16){b=l[0];c=l[1];e=l[2];g=l[3];h=l[4];for(j=0;80>j;j+=1)a[j]=16>j?d[j+t]:(a[j-3]^a[j-8]^a[j-14]^a[j-16])<<1|(a[j-3]^a[j-8]^a[j-14]^a[j-16])>>>31,C=20>j?A(b<<5|b>>>27,c&e^~c&g,h,n[j],a[j]):40>j?A(b<<5|b>>>27,c^e^g,h,n[j],a[j]):60>j?A(b<<5|b>>>27,c&e^c&g^e&g,h,n[j],a[j]):A(b<<5|b>>>27,c^e^g,h,n[j],a[j]),h=g,g=e,e=c<<30|c>>>2,c=b,b=C;l[0]=z(b,l[0]);l[1]=z(c,l[1]);l[2]=z(e,l[2]);l[3]=z(g,l[3]);l[4]=z(h,l[4])}return l}
module.jsSHA=function(d,f,a){var b=null,c=0,e=[0],g="",h=null,g="undefined"!==typeof a?a:"UTF8";"UTF8"===g||"UTF16"===g||k("encoding must be UTF8 or UTF16");"HEX"===f?(0!==d.length%2&&k("srcString of HEX type must be in byte increments"),h=u(d),c=h.binLen,e=h.value):"ASCII"===f||"TEXT"===f?(h=s(d,g),c=h.binLen,e=h.value):"B64"===f?(h=v(d),c=h.binLen,e=h.value):k("inputFormat must be HEX, TEXT, ASCII, or B64");this.getHash=function(a,d,f){var g=null,h=e.slice(),n="";switch(d){case "HEX":g=w;break;case "B64":g=
x;break;default:k("format must be HEX or B64")}"SHA-1"===a?(null===b&&(b=B(h,c)),n=g(b,y(f))):k("Chosen SHA variant is not supported");return n};this.getHMAC=function(b,a,d,f,h){var n,p,m,E,r,F,G=[],H=[],q=null;switch(f){case "HEX":n=w;break;case "B64":n=x;break;default:k("outputFormat must be HEX or B64")}"SHA-1"===d?(m=64,F=160):k("Chosen SHA variant is not supported");"HEX"===a?(q=u(b),r=q.binLen,p=q.value):"ASCII"===a||"TEXT"===a?(q=s(b,g),r=q.binLen,p=q.value):"B64"===a?(q=v(b),r=q.binLen,p=
q.value):k("inputFormat must be HEX, TEXT, ASCII, or B64");b=8*m;a=m/4-1;m<r/8?("SHA-1"===d?p=B(p,r):k("Unexpected error in HMAC implementation"),p[a]&=4294967040):m>r/8&&(p[a]&=4294967040);for(m=0;m<=a;m+=1)G[m]=p[m]^909522486,H[m]=p[m]^1549556828;"SHA-1"===d?E=B(H.concat(B(G.concat(e),b+c)),b+F):k("Unexpected error in HMAC implementation");return n(E,y(h))}};})(this);
</script>

<script>var editor;

var Cheryl =
	angular.module('Cheryl', ['ngRoute'])
	.config(function($routeProvider){
		$routeProvider
			.when('/logout', {
				action: 'logout',
				controller: 'LogoutCtrl',
			})
			.when('/login', {
				action: 'login',
				controller: 'LoginCtrl',
			})
			.otherwise({
				action: 'home',
				controller: 'RootCtrl'
			});
	})
	// Convert angulars json payload to the querystring standard so old versions of apache/php can understand
	.config(function($httpProvider) {
		$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
		$httpProvider.defaults.transformRequest = [function(data) {

		    var param = function(obj) {
				var query = '';
				var name, value, fullSubName, subValue, innerObj, i;
		      
				for (name in obj) {
					value = obj[name];
					if (value instanceof Array || value instanceof Object) {
						for (var subName in value) {
							innerObj = {};
							innerObj[name + '[' + subName + ']'] = value[subName];
							query += param(innerObj) + '&';
						}
					} else if(value !== undefined && value !== null) {
						query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
					}
				}
				return query.length ? query.substr(0, query.length - 1) : query;
			};

			return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
		}];
	})
	.config(function($locationProvider){
		$locationProvider.html5Mode(true).hashPrefix('!');
	})
	.controller('RootCtrl', function ($scope, $http, $location, $anchorScroll, $route) {
		$scope.now = new Date;
		$scope.yesterday = new Date;
		$scope.yesterday.setDate($scope.yesterday.getDate() - 1);
		
		$scope.user = [];
		$scope.welcomeDefault = $scope.welcome = 'Welcome!';
		
		$scope.types = [];
		$scope.dates = [];
		$scope.type = 'dir';
		$scope.dialog = false;
		$scope.config = false;
		
		$scope.dateFormat = 'm/d/Y H:i:s';
		
		$scope.path = function() {
			return $scope.script;
		};

		$scope.dirPath = function() {
			return $location.path().replace($scope.script,'') || '/';
		};
		
		var password = function() {
			return encodeURIComponent(new jsSHA($scope.user.password + '<?php echo CHERYL_SALT; ?>', 'TEXT').getHash('SHA-1', 'HEX'));
		};
		
		$scope.getConfig = function() {
			$http({method: 'GET', url: $scope.path() + '?__p=config'}).
				success(function(data) {
					if (data.status) {
						$scope.authed = data.authed;
						$scope.config = true;
					}
				});
		};
		
		$scope.login = function() {
			$http.post($scope.path() + '/', {'__p': 'login', '__username': $scope.user.username, '__hash': password()}).
				success(function(data) {
					if (data.status) {
						$scope.welcome = $scope.welcomeDefault;
						$scope.authed = true;
						$scope.user.password = '';
					} else {
						$scope.welcome = 'Try again!';
					}
				}).
				error(function(data) {
					$scope.welcome = 'Try again!';
				});	
		};
		
		$scope.authed = false;
		$scope.script = '<?php echo Cheryl::script() ?>';
		
		$scope.dateFilterNames = {
			0: 'Today',
			1: 'Last week',
			2: 'Last month',
			3: 'Archive'
		};

		$scope.filters = {
			recursive: 0,
			types: [],
			dates: [],
			search: ''
		};
		
		$scope.uploads = [];
		
		$scope.filter = function(filter, value) {
			switch (filter) {
				case 'recursive':
					$scope.filters[filter] = value;
					break;
				case 'types':
				case 'dates':
					$scope.filters[filter][value] = !$scope.filters[filter][value];
					var hasValue = false;
					for (var x in $scope.filters[filter]) {
						if ($scope.filters[filter][x]) {
							hasValue = true;
							break;
						}
					}
					if (!hasValue) {
						$scope.filters[filter] = [];
					}
					
					break;
				}
		};
		
		$scope.filterFiles = function(file) {
			if (Object.size($scope.filters.types)) {
				if (!$scope.filters.types[file.ext.toUpperCase()]) {
					return false;
				}
			}
			if (Object.size($scope.filters.dates)) {
				if (!$scope.filters.dates[file.dateFilter]) {
					return false;
				}
			}
			if ($scope.filters.search && file.name.indexOf($scope.filters.search) === -1) {
				return false;
			}
			return true;
		};
		
		$scope.filterFolders = function(file) {
			if ($scope.filters.search && file.name.indexOf($scope.filters.search) === -1) {
				return false;
			}
			return true;
		};
		
		$scope.filterCheck = function(filter, value) {
			return $scope.filters[filter][value];
		};
		
		var formatDate = function(file) {
			var time = new Date(file.mtime * 1000);
			var timeOfDay = (time.getHours() > 12 ? time.getHours() - 12 : time.getHours()) + ':' + time.getMinutes() + (time.getHours() > 12 ? ' PM' : ' AM');
			var daysAgo = Math.ceil(($scope.now.getTime() / 1000 / 60 / 60 / 24) - (time.getTime() / 1000 / 60 / 60 / 24));

			if ('' + time.getFullYear() + time.getMonth() + time.getDate() == '' + $scope.now.getFullYear() + $scope.now.getMonth() + $scope.now.getDate()) {
				file.dateReadable = 'Today @ ' + timeOfDay;
				file.dateFilter = 0;
				
			} else if ('' + time.getFullYear() + time.getMonth() + time.getDate() == '' + $scope.yesterday.getFullYear() + $scope.yesterday.getMonth() + $scope.yesterday.getDate()) {
				file.dateReadable = 'Yesterday @ ' + timeOfDay;
				file.dateFilter = 1;

			} else if (daysAgo < 7) {
				file.dateReadable = daysAgo + ' day' + (daysAgo == 1 ? '' : 's') + ' ago';
				file.dateFilter = 1;

			} else if (daysAgo < 28) {
				var weeks = Math.floor(daysAgo / 7);
				file.dateReadable = weeks + ' week' + (weeks == 1 ? '' : 's') + ' ago';
				file.dateFilter = 2;

			} else if (daysAgo < 363) {
				var months = Math.floor(daysAgo / 30);
				file.dateReadable = months + ' month' + (months == 1 ? '' : 's') + ' ago';
				file.dateFilter = 3;

			} else {
				var years = Math.floor(daysAgo / 365);
				file.dateReadable = years + ' year' + (years == 1 ? '' : 's') + ' ago';
				file.dateFilter = 3;
			}
			
			$scope.dates[file.dateFilter] = $scope.dates[file.dateFilter] ? $scope.dates[file.dateFilter] + 1 : 1;
		};
		
		$scope.formatSize = function(file) {
			var size = file.size;
			var i = -1;
			var byteUnits = [' KB', ' MB', ' GB', ' TB', 'PB', 'EB', 'ZB', 'YB'];
			do {
				size = size / 1024;
				i++;
			} while (size > 1024);
			file.sizeReadable = Math.max(size, 0.1).toFixed(1) + byteUnits[i];
		};
		
		$scope.loadFiles = function() {
			if (!$scope.config) {
				$scope.getConfig();
				return;
			}
			if (!$scope.authed) {
				return;
			}
			$scope.fullscreenEdit = false;
			$scope.filters.search = '';

			var url = $scope.path() + '?__p=ls&_d=' + $scope.dirPath();
			for (var x in $scope.filters) {
				url += '&filters[' + x + ']=' + $scope.filters[x];
			}
			
			$http({method: 'GET', url: url}).
				success(function(data) {
					$scope.type = data.type;
					$scope.file = data.file;
					$scope.file.nameUser = $scope.file.name;

					if (data.type == 'dir') {
						$scope.files = data.list.files;
						$scope.dirs = data.list.dirs;
						
						$scope.types = {};
						$scope.dates = {};

						for (var x in $scope.files) {
							var type = $scope.files[x].ext.toUpperCase();
							$scope.types[type] = $scope.types[type] ? $scope.types[type]+1 : 1;
							formatDate($scope.files[x]);
							$scope.formatSize($scope.files[x]);
						}
					} else {
						formatDate($scope.file);
						$scope.formatSize($scope.file);

					}
				}).
				error(function() {
					$scope.files = null;
				});	
		};

		$scope.$watch('filters.recursive', $scope.loadFiles);
		$scope.$watch('authed', $scope.loadFiles);
		$scope.$on('$locationChangeSuccess', function() {
			$anchorScroll();
			
			switch ($location.$$hash) {
				case 'NewFile':
					break;

				default:
					$scope.loadFiles();
					break;
			}
		});
		
		$scope.modes = {
			php: 'php',
			js: 'javascript',
			css: 'css',
			md: 'markdown',
			svg: 'svg',
			xml: 'xml',
			asp: 'asp',
			c: 'c',
			sql: 'mysql'
		};
		
		$scope.$watch('file.contents', function() {
			if (!$scope.file || !$scope.file.contents) {
				return;
			}

			if (!$scope.editor) {
				$scope.editor = ace.edit('editor');
				$scope.editor.renderer.setShowPrintMargin(false);
				$scope.editor.session.setWrapLimitRange(null, null);

				$scope.editor.commands.addCommand({
					name: 'saveFile',
					bindKey: {
						win: 'Ctrl-S',
						mac: 'Command-S',
						sender: 'editor|cli'
					},
					exec: function(env, args, request) {
						$scope.saveFile();
					}
				});
			}
			
			var mode = 'text';
			for (var x in $scope.modes) {
				if (x == $scope.file.ext) {
					mode = $scope.modes[x];
					break;
				}
			}

			$scope.editor.getSession().setMode('ace/mode/' + mode);

			$scope.editor.getSession().setValue($scope.file.contents);
			$scope.editor.setReadOnly(!$scope.file.writeable);

			fullscreenToggle();
		});
		
		var fullscreenToggle = function() {
			if (!$scope.editor) {
				return;
			}
			if ($scope.fullscreenEdit) {
				$scope.editor.renderer.setShowGutter(true);
				$scope.editor.setHighlightActiveLine(true);
				$scope.editor.session.setUseWrapMode(false);
				$scope.editor.setTheme('ace/theme/ambiance');
			} else {
				$scope.editor.renderer.setShowGutter(false);
				$scope.editor.setHighlightActiveLine(false);
				$scope.editor.session.setUseWrapMode(true);
				$scope.editor.setTheme('ace/theme/clouds');
			}
			setTimeout(function(){
				$scope.editor.resize();
			});
		};

		$scope.$watch('fullscreenEdit', fullscreenToggle);

		$scope.$watch('file.nameUser', function() {
			if (!$scope.file || $scope.file.name == $scope.file.nameUser) {
				return;
			}
			console.log('CHANGED');
		});

		$scope.downloadFile = function(event, file) {
			event.preventDefault();
			event.stopPropagation();
			var iframe = document.getElementById('downloader');
			iframe.src = $scope.path() + '?__p=dl&_d=' + file.path + '/' + file.name;
		};
		
		$scope.saveFile = function() {
			$scope.$apply(function() {
				var error = function() {
					$scope.dialog = {type: 'error', message: 'There was an error saving the file.'};
				};
				$http.post($scope.path() + '/', {
					'__p': 'sv',
					'_d': $scope.dirPath(),
					'c': $scope.editor.getSession().getValue()
				}).
				success(function(data) {
					if (data.status) {
						$scope.dialog = false;
					} else {
						error();
					}
				}).
				error(error);
			});
		};
		
		$scope.upload = function(event, scope) {
			var files = event.target.files || event.dataTransfer.files;

			for (var i = 0, f; f = files[i]; i++) {
				var xhr = new XMLHttpRequest();
				var file = files[i];

				if (xhr.upload && file.size <= 9000000000) {
					var fd = new FormData();
					fd.append(file.name, file);
					
					scope.$apply(function() {
					
						var upload = {
							name: file.name,
							path: $location.path(),
							size: file.size,
							uploaded: 0,
							progress: 0,
							status: 'uploading'
						};
						scope.formatSize(upload);
						scope.uploads.push(upload);


						xhr.upload.addEventListener('progress', function(e) {
							scope.$apply(function() {
								upload.uploaded = e.loaded;
								upload.progress = parseInt(e.loaded / e.total * 100);
							});
						}, false);

						xhr.onload = function() {
							var status = this.status;
							scope.$apply(function() {
								upload.status = (status == 200 ? 'success' : 'error');
								scope.loadFiles();
							});
							setTimeout(function() {
								scope.$apply(function() {
									scope.uploads.splice(scope.uploads.indexOf(upload), 1);
								});
							},5000);
						};

						xhr.open('POST', scope.path() + '/?__p=ul&_d=' + scope.dirPath(), true);
						xhr.setRequestHeader('X-File-Name', file.name);
						xhr.send(fd);
					});
				}
			}
		};
	})
	.directive('ngEnter', function() {
		return function(scope, element, attrs) {
			if (attrs.ngEnter) {
				element.bind('keydown keypress', function(event) {
					if (event.which === 13) {
						event.preventDefault();
						scope.$eval(attrs.ngEnter);
					}
				});
			}
		};
	})
	.directive('ngDropUpload', function () {
		return function (scope, element) {
	
			var dragEnd = function() {
				scope.$apply(function() {
					scope.dialog = false;
				});
			};
			
			var autoEndClean;

			angular.element(document).bind('dragover', function(event) {
				clearTimeout(autoEndClean);
				for (var x in event.dataTransfer.files) {
					console.log(event.dataTransfer.files[x]);
				}
				event.preventDefault();
				scope.$apply(function() {
					scope.dialog = {
						type: 'dropupload'
					}
				});
				autoEndClean = setTimeout(dragEnd,1000);
			});

			element
				.bind('drop', function(event) {
					event.preventDefault();
					scope.upload(event, scope);
				});
		}
	})
	.directive('ngUploader', function($location) {
		return function(scope, element) {
			element.bind('change', function(event) {
				scope.upload(event, scope);
			});
		};
	})
	.directive('ngUpload', function() {
		return function(scope, element) {
			element.bind('click', function(event) {
				document.querySelector('.upload').click();
			});
		};
	})
	.directive('ngMakeDir', function($http, $location) {
		return function(scope, element) {
			element.bind('click', function(event) {
				scope.$apply(function() {
					scope.dialog = {
						type: 'makeDir',
						path: scope.file,
						file: '',
						no: function() {
							scope.dialog = false;
						},
						yes: function() {
							if (!scope.dialog.file) {
								return;
							}
							var error = function() {
								scope.dialog = {type: 'error', message: 'There was an error creating the folder.'};
							};
							$http({method: 'GET', url: scope.path() + '?__p=mk&_d=' + scope.dirPath() + '&_n=' + scope.dialog.file}).
								success(function(data) {
									if (data.status) {
										scope.dialog = false;
										scope.loadFiles();
									} else {
										error();
									}
								}).
								error(error);	
						}
					};					
				});
			});
		};
	})
	.directive('ngDelete', function($http, $location) {
		return function(scope, element) {
			element.bind('click', function(event) {
				scope.$apply(function() {
					scope.dialog = {
						type: 'confirmDelete',
						file: scope.file,
						no: function() {
							scope.dialog = false;
						},
						yes: function() {
							var error = function() {
								scope.dialog = {type: 'error', message: 'There was an error deleting the ' + (scope.type == 'dir' ? 'folder' : 'file') + '.'};
							};
							$http({method: 'GET', url: scope.path() + '?__p=rm&_d=' + scope.dirPath()}).
								success(function(data) {
									if (data.status) {
										scope.dialog = false;
										$location.path(scope.script + scope.file.path);
									} else {
										error();
									}
								}).
								error(error);	
						}
					};					
				});
			});
		};
	})
	.directive('ngSave', function($http, $location) {
		return function(scope, element) {
			element.bind('click', function(event) {
				scope.saveFile();
			});
		};
	})
	.directive('ngFullscreenEditor', function($http, $location) {
		return function(scope, element) {
			element.bind('click', function(event) {
				scope.$apply(function() {
					scope.fullscreenEdit = true;
				});
			});
		};
	})
	.directive('ngModal', function() {
		return function(scope, element) {
			element.bind('click', function(event) {
				if (event.target == element[0]) {
					scope.$apply(function() {
						scope.dialog = false;					
					});
				}
			});
		};
	})
	.directive('ngBody', function() {
		return function(scope, element) {
			element.bind('keydown keypress', function(event) {
				if (event.which == 27) {
					scope.$apply(function() {
						scope.dialog = false;
						scope.fullscreenEdit = false;			
					});
				}
			});
		};
	})
	.directive('ngAutofocus', function() {
		return function(scope, element, attrs) {
			if (attrs.ngAutofocus) {
				scope.$watch(attrs.ngAutofocus, function(value) {
					setTimeout(function() {
						element[0].focus();
					},10);
				});
			}
		};
	})
	.directive('ngFileName', function($http) {
		return function(scope, element) {
			var save = function() {
				var error = function() {
					scope.dialog = {type: 'error', message: 'There was an error renaming the file.'};
				};
				$http({method: 'GET', url: scope.path() + '?__p=rn&_d=' + scope.dirPath() + '&_n=' + scope.file.name}).
					success(function(data) {
					console.log(data);
						if (data.status) {

						} else {
							error();
						}
					}).
					error(error);	
			};
			element
				.bind('change', function(event) {
					clearTimeout(scope.nameChange);
					scope.nameChange = setTimeout(save, 1000);
				})
				.bind('blur', function(event) {
					save();
				});
		};
	});

Object.size = function(obj) {
	var size = 0, key;
	for (key in obj) {
		if (obj.hasOwnProperty(key)) size++;
	}
	return size;
};

</script>

</html>
<?php 
				$res = ob_get_contents();
				ob_end_clean();
			}
			return $res;
		}
	}
}


if (!class_exists('Cheryl_User')) {
	class Cheryl_User extends Cheryl_User_Base {

		public static function users() {
			return Cheryl::me()->config->users;
		}
		
		public function __construct($u) {
			if (is_string($u)) {
				$type = strtolower(Cheryl::me()->config->authentication->type);

				if ($type == 'simple') {
					foreach (self::users() as $user) {
						if ($user->username == $u) {
							$u = $user;
							break;
						}
					}
				} elseif ($type == 'pdo' && class_exists('PDO')) {
					
					$q = Cheryl::me()->config->authentication->pdo->prepare('SELECT * FROM '.Cheryl::me()->config->authentication->permission_table.' WHERE user=:username');
					$q->bindValue(':username', $u, PDO::PARAM_STR);
					$q->execute();
					$rows = $q->fetchAll(PDO::FETCH_ASSOC);
					
					$u = array(
						'user' => $u,
						'permissions' => $rows
					);
				} elseif ($type == 'mysql' && function_exists('mysql_connect')) {
					// @todo #18
				}
			}

			parent::__construct($u);
		}

		public static function login() {
			if (Cheryl::me()->request['__username']) {
				// log in attempt
				if (Cheryl::me()->request['__hash']) {
					$pass = Cheryl::me()->request['__hash'];
				} else {
					$pass = self::password(Cheryl::me()->request['__password']);
				}
			} else {
				return false;
			}
			
			$type = strtolower(Cheryl::me()->config->authentication->type);

			// simple authentication. store users in an array
			if ($type == 'simple') {
				foreach (self::users() as $user) {
					if ($user->username == Cheryl::me()->request['__username']) {
						$u = $user;
						break;
					}
				}
	
				if ($u && (!$u->password || $pass == $u->password)) {
					// successfuly send username and password
					return new Cheryl_User($u);
				}
	
				return false;

			// use php data objects only if we have the libs
			} elseif ($type == 'pdo' && class_exists('PDO')) {

				$q = Cheryl::me()->config->authentication->pdo->prepare('SELECT * FROM '.Cheryl::me()->config->authentication->user_table.' WHERE user=:username AND hash=:hash LIMIT 1');
				$q->bindValue(':username', Cheryl::me()->request['__username'], PDO::PARAM_STR);
				$q->bindValue(':hash', $pass, PDO::PARAM_STR);
				$q->execute();
				$rows = $q->fetchAll(PDO::FETCH_ASSOC);

				if (count($rows)) {
					return new Cheryl_User($rows[0]);
				}

			// use php data objects only if we have the libs				
			} elseif ($type == 'mysql' && function_exists('mysql_connect')) {
				// @todo #18
			} else {
				return false;
			}
		}
	}
}


class Cheryl_User_Base {
	public function __construct($u = null) {
		if (is_array($u)) {
			foreach ($u as $key => $value) {
				$this->{$key} = $value;
			}
		} elseif(is_object($u)) {
			foreach (get_object_vars($u) as $key => $value) {
				$this->{$key} = $value;
			}			
		} elseif (is_string($u)) {
			
		}
	}

	public static function users() {
		return array();
	}
	
	public static function login() {
		return false;
	}

	public function permission($permission) {
		if ($this->permissions == 'all' || is_array($this->permissions) && $this->permissions[$perimssions] || is_object($this->permissions) && $this->permissions->{$perimssions}) {
			return true;
		} else {
			return false;
		}
	}
}



// if this wasnt defined, then automaticly run the script asuming this is standalone
if (!defined('CHERYL_CONTROL')) {
	$cheryl = new Cheryl();
	$cheryl->go();
}
