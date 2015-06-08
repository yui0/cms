<?php
$db_host		= '';
$db_user		= '';
$db_pass		= '';
$db_database	= 'db/plist.db';
$db_txt	= 'db/plist.txt';

if (!empty($_GET["list"])) {
	$db_txt = 'db/'.htmlspecialchars($_GET["list"]);
}

$db = new PDO("sqlite:".$db_database) or die('Unable to establish a DB connection');

$path = "data";

if (!empty($_GET["path"])) {
	$path = htmlspecialchars($_GET["path"]);
}

$url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"]. $_SERVER["REQUEST_URI"];

function encodeURI($url) {
	// http://php.net/manual/en/function.rawurlencode.php
	// https://developer.mozilla.org/en/JavaScript/Reference/Global_Objects/encodeURI
	$unescaped = array(
		'%2D'=>'-', '%5F'=>'_', '%2E'=>'.', /*'%21'=>'!',*/ '%7E'=>'~',
		'%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')'
	);
	$reserved = array(
		'%3B'=>';', '%2C'=>',', '%2F'=>'/', '%3F'=>'?', '%3A'=>':',
		'%40'=>'@', '%26'=>'&', '%3D'=>'=', '%2B'=>'+', '%24'=>'$'
	);
	/*$score = array(
		'%23'=>'#'	// no need for chrome
	);*/
	return strtr(rawurlencode($url), array_merge($reserved,$unescaped/*,$score*/));
}

function getFileList($dir) {
	$files = glob(rtrim($dir, '/') . '/*');
	$list = array();
	foreach ($files as $file) {
		if (is_file($file)) {
			$list[] = $file;
		}
		if (is_dir($file)) {
			$list = array_merge($list, getFileList($file));
		}
	}

	return $list;
}

$array = getFileList($path);
//var_dump($array);

unset($list);
$p = "poster:\"http://www.jplayer.org/audio/poster/The_Stark_Palace_640x360.png\"\n";
foreach ($array as $name) {
	$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

	$flag = 1;
	switch ($ext) {
	case "mp3":
		$s = "mp3:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "m4a":
		$s = "m4a:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "flac":
		$s = "flac:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "oga":
		$s = "oga:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "aac":
		$s = "aac:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "wav":
		$s = "wav:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "mpeg":
		$s = "mp3:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "wma":	// x!
		$s = "m4a:\""./*$url.*/encodeURI($name)."\",\n";
		break;

	case "flv":
		$s = "flv:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "mp4":
		$s = "m4v:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "m4v":
		$s = "m4v:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "mpg":
		$s = "m4v:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "mkv":
		$s = "m4v:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "wmv":
		$s = "m4v:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "avi":
		$s = "m4v:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "ogm":
		$s = "m4v:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "ogv":
		$s = "ogv:\""./*$url.*/encodeURI($name)."\",\n";
		break;
	case "webmv":
		$s = "webmv:\""./*$url.*/encodeURI($name)."\",\n";
		break;

	case "jpg":
	case "png":
		$p = "poster:\""./*$url.*/encodeURI($name)."\"\n";
		$pp = encodeURI($name);
	case "zip":
	case "rar":
	case "m3u":
	case "cue":
	case "txt":
	case "ini":
	case "rtf":
	case "md5":
	case "sfv":
	case "log":

//	case "tta":
		$flag = 0;
	}

	if ($flag) {
		$list .= "{\ntitle:\"".basename($name)."\",\nartist:\"".basename(dirname($name))."\",\n".$s.$p."},\n";

//		$db->query('INSERT INTO plist (title, artist, url, poster) VALUES ("'.basename($name).'","'.basename(dirname($name)).'","'.$url.encodeURI($name).'","'.$pp.'")');
		$db->query('INSERT INTO plist (title, artist, url, poster) SELECT "'.basename($name).'","'.basename(dirname($name)).'","'.$url.encodeURI($name).'","'.$pp.'" WHERE NOT EXISTS (SELECT id FROM plist WHERE url="'.$url.encodeURI($name).'")');
	}
}

file_put_contents($db_txt, $list);
echo "OK!";
?>

