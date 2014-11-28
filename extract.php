<?php
/* 
 * This script extracts each XML index file created from the audit process, converts them
 * to JSON, and then writes out a javascript JSON variable named "sites" that is included
 * in the JavaScript based TOSBack2 front-end.
 *
 *  
 */
$AUDIT_BASE = "/Library/WebServer/Documents/isoc_tosback2/audit/";
$WEB_FRONT_END = "/Library/WebServer/Documents/isoc_tosback2/web_front_end/";

chdir($AUDIT_BASE);

//find domains/* -name index.xml
$xml_files = explode("\n", shell_exec('find domains/* -name index.xml'));

$sites_file_name = tempnam("/tmp", "sites");
$sites_file = fopen($sites_file_name, 'w+');

fwrite($sites_file, "var sites = {\nsitename:[\n");

foreach ($xml_files as &$xml_file) {
	if(!empty($xml_file)) {
		
		$json = "{\ndata: ";
		$xml_string = file_get_contents($xml_file);
		$xml = simplexml_load_string($xml_string);
		$json .= json_encode($xml);
		$json .= ",\n";
		$name = substr($xml_file,8,strlen($xml_file)-18);
		$json .= "name: \"" . $name . "\"\n},\n";
		
		fwrite($sites_file, $json);
	}
}
fwrite($sites_file, "]\n};");
fclose($sites_file);

copy($sites_file_name, $WEB_FRONT_END . 'rez/js/sites.js');
unlink($sites_file_name);

?>
