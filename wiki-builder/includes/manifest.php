<?php
define('BUNGIE_URL', 'https://www.bungie.net');
define('LN', "\n");

function getUrl($url, $options=array()) {
	$user_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1";

	$http_header = array(
		'x-api-key: '.API_KEY
	);

	$ch = curl_init();
	curl_setopt_array($ch, $ch_options = array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTPHEADER => $http_header,
		CURLOPT_SSL_VERIFYHOST => 2,
		CURLOPT_USERAGENT => $user_agent
	));
	if (isset($options[CURLOPT_HTTPHEADER])) $options[CURLOPT_HTTPHEADER] = array_merge($http_header, $options[CURLOPT_HTTPHEADER]);
	curl_setopt_array($ch, $options);

	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function getJson($url) {
	$result = json_decode(getUrl($url));
	if (!isset($result->ErrorCode) || $result->ErrorCode != 1) exit();
	return $result->Response;
}

$manifest_url = BUNGIE_URL.'/platform/destiny/manifest/';

$cachePath = BUILDERPATH.'/cache/cache.json';
$cache = false;
$update = true;
$manifest = false;

if (!file_exists(BUILDERPATH.'/cache')) mkdir(BUILDERPATH.'/cache');

if (file_exists($cachePath)) {
	$cache = json_decode(file_get_contents($cachePath), true);
	$update = false;
}
if ($cache && time()-$cache['updated'] > 5*60) {
	echo 'Checking for changes.'.LN;
	$manifest = getJson($manifest_url);

	$update = pathinfo($manifest->mobileWorldContentPaths->en, PATHINFO_BASENAME) != pathinfo($cache['world'], PATHINFO_BASENAME);
	$cache['updated'] = time();
}
if (isset($_GET['update'])) $update = true;
if ($update) {
	if (!$manifest) $manifest = getJson($manifest_url);

	$version = $manifest->version;
	$assetPath = BUNGIE_URL.$manifest->mobileAssetContentPath;
	$gearPath = BUNGIE_URL.end($manifest->mobileGearAssetDataBases)->path;
	$worldPath = BUNGIE_URL.$manifest->mobileWorldContentPaths->en;

	echo 'Version: '.$version.LN;
	echo 'Asset Content Path: '.$assetPath.LN;
	echo 'Gear Asset Path: '.$gearPath.LN;
	echo 'World Content Path: '.$worldPath.LN;

	foreach(array($assetPath, $gearPath, $worldPath) as $path) {
		$cacheFilePath = BUILDERPATH.'/cache/'.pathinfo($path, PATHINFO_BASENAME);
		file_put_contents($cacheFilePath.'.zip', getUrl($path));

		$zip = new ZipArchive();
		if ($zip->open($cacheFilePath.'.zip') === TRUE) {
			$zip->extractTo(BUILDERPATH.'/cache');
			$zip->close();
		}
	}
	$cache = array(
		'version' => $version,
		'updated' => time(),
		'asset' => BUILDERPATH.'/cache/'.pathinfo($assetPath, PATHINFO_BASENAME),
		'gear' => BUILDERPATH.'/cache/'.pathinfo($gearPath, PATHINFO_BASENAME),
		'world' => BUILDERPATH.'/cache/'.pathinfo($worldPath, PATHINFO_BASENAME),
	);

	$structure = array();

	$dbtypes = array(
		'asset' => $cache['asset'],
		'gear' => $cache['gear'],
		'world' => $cache['world']
	);

	foreach($dbtypes as $dbtype => $dbfile) {
		if ($db = new SQLite3($dbfile)) {
			echo 'SQLite: '.str_replace(BUILDERPATH.'/', '', $dbfile).LN;
			$result = $db->query("SELECT name FROM sqlite_master WHERE type='table'");

			$structure[$dbtype] = array(
				'type' => $dbtype,
				'definitions' => array()
			);

			while($row = $result->fetchArray()) {
				$result2 = $db->query('SELECT COUNT(*) FROM '.$row['name']);
				$total = current($result2->fetchArray(true));

				$result2 = $db->query('SELECT COUNT(*) FROM '.$row['name'].' WHERE json LIKE \'%Name":"Classified"%\'');
				$classified = current($result2->fetchArray(true));

				$result2 = $db->query('SELECT * FROM '.$row['name'].' LIMIT 1');
				$entry = $result2->fetchArray(true);

				$structure[$dbtype]['definitions'][] = array(
					'name' => $row['name'],
					'entries' => $total,
					'classified' => $classified
				);
				file_put_contents(BUILDERPATH.'/cache/'.$dbtype.'-'.$row['name'].'.json', json_encode(json_decode($entry['json']), JSON_PRETTY_PRINT));
			}
			usort($structure[$dbtype]['definitions'], function($a, $b) {
				return strcmp($a['name'], $b['name']);
			});
		}
	}

	file_put_contents(BUILDERPATH.'/data/manifest.json', json_encode($structure, JSON_PRETTY_PRINT));
}
file_put_contents($cachePath, json_encode($cache, JSON_PRETTY_PRINT));

echo 'Version: '.$cache['version'].' | Updated: '.date('Y-m-d G:ia', $cache['updated']).LN;

echo '<textarea readonly>';
echo file_get_contents(BUILDERPATH.'/data/manifest.json').LN;
echo '</textarea>';