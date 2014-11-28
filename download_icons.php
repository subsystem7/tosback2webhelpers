<?php
/* 
 * This script attempts to download all of the .ico files for the crawled sites and places
 * them in an icon folder in the web_front_end
 *
 *  
 */
$AUDIT_BASE = "/Library/WebServer/Documents/isoc_tosback2/audit/";
$WEB_FRONT_END = "/Library/WebServer/Documents/isoc_tosback2/web_front_end/";

$script_folder = getcwd();

chdir($AUDIT_BASE);
$xml_files = explode("\n", shell_exec('find domains/* -name index.xml'));

chdir($WEB_FRONT_END);
foreach ($xml_files as &$xml_file) {
	// domains/[domain_name]/index.xml
	$name = substr($xml_file,8,strlen($xml_file)-18);
	
	// download ico files, removing those that do not properly match the first 4 bytes 
	// that identifies an ico
	if(!file_exists('rez/img/ico/' . $name . '.ico')) {
		shell_exec('curl -L http://' . $name . '/favicon.ico -s -o rez/img/ico/' . $name . '.ico');
		if(file_exists('rez/img/ico/' . $name . '.ico')){
			$cmp = shell_exec('cmp -n 4 ' . $script_folder . '/ico_header.bin rez/img/ico/' . $name . '.ico');
			if($cmp) {
				unlink('rez/img/ico/' . $name . '.ico');		
				copy('rez/img/ico/default.ico', 'rez/img/ico/' . $name . '.ico');
			}
		} else {
				copy('rez/img/ico/default.ico', 'rez/img/ico/' . $name . '.ico');		
		}
	}
}

?>
