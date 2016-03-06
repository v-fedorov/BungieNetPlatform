<html>
<head>
	<meta charset='utf-8'>
	<title>Wiki Builder</title>
	<style>
		body {
			padding: 20px
		}
		textarea {
			display: block;
			width: 100%;
			margin-top: 10px;
			min-height: 150px;
		}
	</style>
</head>
<body>

<h2>Options</h2>
<ul>
	<li><a href="?platform-lib">Check for Updates</a></li>
	<li><a href="?wiki">Build Wiki</a></li>
	<li><a href="?pages">Build Pages</a></li>
</ul>
<h2>Log</h2>
<?php
define('BUILDERPATH', __DIR__);
define('BASEPATH', dirname(dirname(__DIR__)));

if (file_exists(BUILDERPATH.'/api-key.php')) include(BUILDERPATH.'/api-key.php');
if (!defined('API_KEY')) define('API_KEY', '{insert-api-key}');

if (isset($_GET['pages'])) {
	echo '<pre>';
	include('includes/pages.php');
	echo '</pre>';
}
else if (isset($_GET['wiki'])) {
	echo '<pre>';
	include('includes/wiki.php');
	echo '</pre>';
}
else {
	echo '<h3>Manifest</h3>';
	echo '<pre>';
	include('includes/manifest.php');
	echo '</pre>';
	include('includes/platform-lib.php');
}
?>

</body>
</html>