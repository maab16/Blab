<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define("VIEWS_PATH", ROOT.DS."App".DS."Views");

require_once ROOT.DS.'vendor'.DS.'autoload.php';

new Blab\Libs\defaultSettings();
use App\Database\Models;
use Blab\Mvc\Models\Blab_Model;

$db = Blab_Model::getDBInstance();

$path = dirname(ROOT.DS."App".DS.'Database'.DS.'Models');

// $objects = new RecursiveIteratorIterator(
//     new RecursiveDirectoryIterator($path),
//     RecursiveIteratorIterator::SELF_FIRST
// );
// foreach ($objects as $file => $object) {
//     $basename = $object->getBasename();
//     if ($basename == '.' or $basename == '..') {
//         continue;
//     }
//     if ($object->isDir()) {
//         continue;
//     }
//     $files[] = $basename;
// }


$files = array_filter(scandir(ROOT.DS."App".DS.'Database'.DS.'Models'));

foreach ($files as $file) {
	if ($file == '.' || $file == '..')
		continue;
	$info = new SplFileInfo($file);
	$model = "App\Database\Models\\".ucfirst($info->getBasename('.'.$info->getExtension()));
	$db->createTable(new $model());
}

// Logged In User
(new Blab\Libs\Blab_User())->loggedInUser();

Blab\Mvc\Bootstrap::run($_SERVER['REQUEST_URI']);