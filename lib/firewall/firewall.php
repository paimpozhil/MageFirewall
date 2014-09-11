<?php
/*
 +------------------------------------------------------------------+
 | Firewall   (c)2012-2013 NinTechNet                          |
 |                 <contact@ninjafirewall.com>                      |
 |                                                                  |
 | EDITION :       Free Edition                                     |
 +------------------------------------------------------------------+
 | REVISION:       2013-12-28 18:21:33                              |
 +------------------------------------------------------------------+
 | This program is free software: you can redistribute it and/or    |
 | modify it under the terms of the GNU General Public License as   |
 | published by the Free Software Foundation, either version 3 of   |
 | the License, or (at your option) any later version.              |
 |                                                                  |
 | This program is distributed in the hope that it will be useful,  |
 | but WITHOUT ANY WARRANTY; without even the implied warranty of   |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the    |
 | GNU General Public License for more details.                     |
 +------------------------------------------------------------------+
*/ 
	$mageFilename = 'app/Mage.php';
	require_once $mageFilename;
	Mage::setIsDeveloperMode(true);
	ini_set('display_errors', 1);
	umask(0);
	Mage::app();
	if(!Mage::helper('core')->isModuleEnabled('MageFire_Wall')) return;
    $resource = Mage::getSingleton('core/resource');
    $readConnection = $resource->getConnection('core_read'); 
    $mageOptions = Mage::getModel('wall/options');
    $wallHelper = Mage::helper('wall');
	if($wallHelper->getOptionsData('firewall_enable')==0) return;
    $ip_address = $wallHelper->getClientIp();
    $WhiteListQuery = "SELECT * FROM  ".$resource->getTableName('firewall_whitelist')."  WHERE status=1 && is_delete!=1 && ip='$ip_address'";
    $WhiteListResults = $readConnection->fetchAll($WhiteListQuery);
	$MagenfCheckDebug = '';
	//checking debug mode is enabled or not
	if($wallHelper->getOptionsData('debug_mode')==1) $MagenfCheckDebug = 2;
	$getIpOptionValue = $wallHelper->getOptionsData('banning_ip');
	$CheckipOption = ($getIpOptionValue==0) ? 'off' : 'on';
	define('NF_STARTTIME', microtime(true));

	$MagenfCheckEnabled = 1; // $results['0']['enabled'];
	$MagenfoptionApplication = 'generic|option|magento'; //$results['0']['application'];

if ($MagenfCheckDebug) {
   register_shutdown_function('nf_debugfirewall', $MagenfCheckDebug);
   define('STAG', '- ');
   define('ETAG', "\n");
   $nfdebug = STAG ."starting Firewall". ETAG ;// STAG ."hooked PHP script\t\t[----]   ". $_SERVER['SCRIPT_FILENAME'] . ETAG;
}

if (! $MagenfCheckEnabled) {
   if ($MagenfCheckDebug) { define('NFDEBUG', $nfdebug.= STAG ."protection is disabled\t[STOP]". ETAG . '::' . nf_benchmarks() ); }
  //return;
}
	if(empty($WhiteListResults)){
		$blackListQuery = "SELECT * FROM  ".$resource->getTableName('firewall_blacklist')."  WHERE status=1 && is_delete!=1 && ip='$ip_address'";
		$blackListResults = $readConnection->fetchAll($blackListQuery);
		if(!empty($blackListResults)){
			nf_write2log('Blacklist Ip trying to get site.', null, 2, 0);
			echo "You are in blacklist.";
			//die();	
		}
	}
if ($MagenfCheckDebug) { $nfdebug.= STAG ."checking user IP\t\t";}
if ( (preg_match('/^(?:::ffff:)?127\.0\.0\.1$/', $ip_address)) || ($ip_address == $_SERVER['SERVER_ADDR']) ) {
   if ($MagenfCheckDebug) { define('NFDEBUG', $nfdebug.= '[STOP]   '. $ip_address .' is whitelisted'. ETAG . '::' . nf_benchmarks() ); }
   return;
}

if ($MagenfCheckDebug) { $nfdebug.= "[----]   banning IP option is $CheckipOption". ETAG; }
if ( ($_SERVER['SCRIPT_FILENAME'] == dirname(__FILE__) .'/index.php') || ($_SERVER['SCRIPT_FILENAME'] == dirname(__FILE__) .'/login.php') ) {
   if ($MagenfCheckDebug) { define('NFDEBUG', $nfdebug.= STAG ."script is whitelisted\t\t[STOP]   ".$_SERVER['SCRIPT_NAME']. ETAG . '::' . nf_benchmarks() ); }
   return;
}
if (preg_match('/^[\d.:]+$/', $_SERVER['HTTP_HOST'])) {
	if ($MagenfCheckDebug) { $nfdebug.= STAG ."HTTP_HOST\t\t\t[FAIL]   HTTP_HOST is an IP (".$_SERVER['HTTP_HOST']  .')'. ETAG; }
	nf_write2log('HTTP_HOST is an IP', $_SERVER['HTTP_HOST'], 1, 0);
	if($getIpOptionValue==1){
		nf_block();
	}
}

if ( strpos('GET|POST|HEAD', $_SERVER['REQUEST_METHOD']) === false ) {
   if ($MagenfCheckDebug) { $nfdebug.= STAG ."REQUEST_METHOD\t\t[FAIL]   ". nf_bin2hex_string($_SERVER['REQUEST_METHOD']) .' not allowed'. ETAG; }
   nf_write2log('request method not allowed', $_SERVER['REQUEST_METHOD'], 2, 0);
   nf_block();
}
nf_check_request();

if ($MagenfCheckDebug) { $nfdebug.= STAG ."checking uploads\t\t"; }
if (! empty($_FILES)) {
   nf_check_upload();
} else {
   if ($MagenfCheckDebug) { $nfdebug.= "[----]   no upload detected". ETAG; }
}
$_GET = nf_sanitise( $_GET, 1, 'GET');
$_COOKIE = nf_sanitise( $_COOKIE, 1, 'COOKIE');
if (! empty($_SERVER['HTTP_USER_AGENT'])) {
	$_SERVER['HTTP_USER_AGENT'] = nf_sanitise( $_SERVER['HTTP_USER_AGENT'], 1, 'HTTP_USER_AGENT');
}
if (! empty($_SERVER['HTTP_REFERER'])) {
	$_SERVER['HTTP_REFERER'] = nf_sanitise( $_SERVER['HTTP_REFERER'], 1, 'HTTP_REFERER');
}
if (! empty($_SERVER['PATH_INFO'])) {
	$_SERVER['PATH_INFO'] = nf_sanitise( $_SERVER['PATH_INFO'], 2, 'PATH_INFO');
}
if (! empty($_SERVER['PATH_TRANSLATED'])) {
	$_SERVER['PATH_TRANSLATED'] = nf_sanitise( $_SERVER['PATH_TRANSLATED'], 2, 'PATH_TRANSLATED');
}
if (! empty($_SERVER['PHP_SELF'])) {
	$_SERVER['PHP_SELF'] = nf_sanitise( $_SERVER['PHP_SELF'], 2, 'PHP_SELF');
}

if ( (! defined('NFDEBUG')) && ($nfdebug) ) { define('NFDEBUG',$nfdebug . '::' . nf_benchmarks() ); }
return;

/* ================================================================ */
function nf_debugfirewall($debug) {

	if ( (defined('NF_NODBG')) || (! defined('NFDEBUG')) || (NFDEBUG == '') ) {
		return;
	}
	list($nfdebug, $bench) = explode('::', NFDEBUG . '::');

   if ($debug == 1) {
      echo "\n<!--\n". htmlentities( $nfdebug ) ."- stopping Firewall\n- processing time:\t\t$bench s\n-->"  ;
   } else {
		echo '<br><script>function onoff(){if(document.getElementById("tex").style.display=="none"){document.getElementById("tex").style.display="";document.getElementById("fie").style.background="#000000";document.cookie="tex=0; expires=Thu, 01-Jan-70 00:00:01 GMT;";}else{document.getElementById("tex").style.display="none";document.getElementById("fie").style.background="none";document.cookie="tex=1;";}}</script>'. "\n". '<center><fieldset id=fie style="width:85%;font-family:Verdana,Arial,sans-serif,Ubuntu;font-size:10px;background:';
		if ( (isset($_COOKIE['tex'])) && ($_COOKIE['tex'])==1) {echo 'none';} else {echo '#000000';}
		echo ';border:0px solid #000000;padding:0px;"><legend id=leg style="border:1px solid #ffd821;background:#ffd821;font-family:Verdana,Arial,sans-serif,Ubuntu;font-size:10px;"><a title=\'Click to mask/show the console\' href="javascript:onoff();" style="text-decoration: none;color:#000000;background:#ffd821;"><b>&nbsp;Firewall debug console&nbsp;</b></a></legend><textarea id=tex rows='. count(explode("\n", $nfdebug)) .' style="font-family:\'Courier New\',Courier,monospace,Verdana, Arial, sans-serif;font-size:12px;width:100%;border:none;padding:0px;background:#000000;color:#ffffff;line-height:14px;';
		if ( (isset($_COOKIE['tex'])) && ($_COOKIE['tex'])==1) {echo 'display:none;'; }
		echo '" wrap="off">'. htmlentities( $nfdebug ) ."- stopping Firewall\n- processing time\t\t$bench s</textarea></fieldset></center><br>";
   }
}
/* ================================================================ */
function nf_check_request() {
   global $resource;
   global $readConnection;
   global $MagenfCheckDebug;
   global $MagenfoptionApplication;
   global $nfdebug;

	$rules_count = 0;	
    $query = 'SELECT * FROM ' . $resource->getTableName('firewall_rules'). ' WHERE `who` REGEXP "^('. $MagenfoptionApplication .')$" && `enabled` = "1"';
    $results = $readConnection->fetchAll($query);
    foreach($results as $rulesData){
		$wherelist = explode('|', $rulesData['request']);	
		foreach ($wherelist as $where) {
			if ( ($where == 'POST') || ($where == 'GET') ) {
				foreach ($GLOBALS['_' . $where] as $reqkey => $reqvalue) {
               if ( is_array($reqvalue) ) {
                  $res = nf_flatten( "\n", $reqvalue );
                  $reqvalue = $res;
                 
                  $rulesData['what'] = '(?m:'. $rulesData['what'] .')';
               } else {
						if ( ($where == 'POST') && ($reqvalue) && (! isset( $b64_post[$reqkey])) ) {
							$b64_post[$reqkey] = 1;
							nf_check_b64($reqkey, $reqvalue);
						}
					}
					// print_r("reqvalue." .$reqvalue ."=" );
               if (! $reqvalue) {continue;}
               $rules_count++;
               
              // print_r($rulesData['what'] . "<br />");
               if ( preg_match('`'.$rulesData['what'].'`', $reqvalue) ) {
				   
                  if ($MagenfCheckDebug) { $nfdebug.= STAG ."checking request\t\t". '[FAIL]   '. $where .' : ' . $rulesData['why'] . ' (#'. $rulesData['rules_id'] . ')' . ETAG; }
                 
                  nf_write2log($rulesData['why'], $where . ':' . $reqkey . ' = ' . $reqvalue, $rulesData['level'], $rulesData['rules_id']);
                  nf_block();
               }
               
			   
            }
				continue;
			}

			$sub_value = explode(':', $where);
			if ( (! empty($sub_value[1]) ) && ( @isset($GLOBALS['_' . $sub_value[0]] [$sub_value[1]]) ) ) {
				$rules_count++;
				if ( is_array($GLOBALS['_' . $sub_value[0]] [$sub_value[1]]) ) {
               $res = nf_flatten( "\n", $GLOBALS['_' . $sub_value[0]] [$sub_value[1]] );
               $GLOBALS['_' . $sub_value[0]] [$sub_value[1]] = $res;
               $rulesData['what'] = '(?m:'. $rulesData['what'] .')';
            }
            if (! $GLOBALS['_' . $sub_value[0]] [$sub_value[1]]) {continue;}
				if ( preg_match('`'. $rulesData['what'] .'`', $GLOBALS['_' . $sub_value[0]] [$sub_value[1]]) ) {
					if ($MagenfCheckDebug) { $nfdebug.= STAG ."checking request\t\t". '[FAIL]   '.$sub_value[0].':'.$sub_value[1].' : ' . $rulesData['why'] . ' (#'. $rulesData['rules_id'] . ')' . ETAG; }
					nf_write2log($rulesData['why'], $sub_value[0].':'.$sub_value[1].' = ' . $GLOBALS['_' . $sub_value[0]] [$sub_value[1]], $rulesData['level'], $rulesData['rules_id']);
					nf_block();
				}

         } elseif ( isset($_SERVER[$where]) ) {
            $rules_count++;
				if ( preg_match('`'. $rulesData['what'] .'`', $_SERVER[$where]) ) {
               if ($MagenfCheckDebug) { $nfdebug.= STAG ."checking request\t\t". '[FAIL]   ' . $where.' : ' . $rulesData['why'] . ' (#'. $rulesData['rules_id'] . ')' . ETAG; }
               nf_write2log($rulesData['why'], $where . ':' . $_SERVER[$where], $rulesData['level'], $rulesData['rules_id']);
               nf_block();
            }
         }
      }
	}    
   

   if ($MagenfCheckDebug) { $nfdebug.= STAG ."checking request\t\t". '[PASS]   '. $rules_count . ' occurences checked' . ETAG; }

}
/* ================================================================ */
function nf_flatten($glue, $pieces) {

   foreach ($pieces as $r_pieces) {
      if ( is_array($r_pieces)) {
         $ret[] = nf_flatten($glue, $r_pieces);
      } else {
         $ret[] = $r_pieces;
      }
   }
   return implode($glue, $ret);
}
/* ================================================================ */
function nf_bin2hex_string($data) {

	$res = '';
	$string = str_split($data);
	foreach ( $string as $char ) {
		if ( ( ord($char) < 32 ) || ( ord($char) > 127 ) ) {
			$res .= '%' . bin2hex($char);
		} else {
			$res .= $char;
		}
	}
	return $res;
}
/* ================================================================== */
function nf_check_b64( $reqkey, $string ) {

	global $MagenfCheckDebug;
	global $nfdebug;

	$string = preg_replace( '`[^A-Za-z0-9+/=]`', '', $string);
	if ( (! $string) || (strlen($string) % 4 != 0) ) { return; }
	if ( base64_encode( $decoded = base64_decode($string) ) === $string ) {
		if ( preg_match( '`\b(?:\$?_(COOKIE|ENV|FILES|(?:GE|POS|REQUES)T|SE(RVER|SSION))|HTTP_(?:(?:POST|GET)_VARS|RAW_POST_DATA)|GLOBALS)\s*[=\[)]|\b(?i:array_map|assert|base64_(?:de|en)code|chmod|curl_exec|(?:ex|im)plode|error_reporting|eval|file(?:_get_contents)?|f(?:open|write|close)|fsockopen|function_exists|gzinflate|md5|move_uploaded_file|ob_start|passthru|preg_replace|phpinfo|stripslashes|strrev|(?:shell_)?exec|system|unlink)\s*\(|\becho\s*[\'"]|<\s*(?i:applet|div|embed|i?frame(?:set)?|img|meta|marquee|object|script|textarea)\b|\b(?i:(?:ht|f)tps?|php)://|\W\$\{\s*[\'"]\w+[\'"]|<\?(?i:php)`', $decoded) ) {
			if ($MagenfCheckDebug) { $nfdebug.= STAG ."checking request\t\t". '[FAIL]   POST[' . $reqkey . '] : BASE64-encoded injection' . ETAG; }
			nf_write2log('BASE64-encoded injection', 'POST:' . $reqkey . ' = ' . $string, 3, 0);
			nf_block();
		}
	}
}
/* ================================================================ */
function nf_sanitise($str, $how, $msg ) {

//	global $dbh;
	global $MagenfCheckDebug;
	global $nfdebug;
	if (! isset($str) ) {
		return null;
	} else if (is_string($str) ) {
		if (get_magic_quotes_gpc() ) {$str = stripslashes($str);}

		if ($how == 1) {
			//$str2 = $dbh->real_escape_string($str);
			$str2 = str_replace('`', '\`', $str);
		} else {
			$str2 = str_replace(	array('\\', "'", '"', "\x0d", "\x0a", "\x00", "\x1a", '`', '<', '>'),
				array('\\\\', "\\'", '\\"', 'X', 'X', 'X', 'X', '\\`', '\\<', '\\>'),	$str);
		}
		if ($str2 != $str) {
			nf_write2log('Sanitising user input', $msg . ': ' . $str, 6, 0);
			if ($MagenfCheckDebug) { $nfdebug.= STAG . "sanitising $msg\t\t[WARN]   string: " . nf_bin2hex_string($str) . ETAG; }
		}
		return $str2;

	} else if (is_array($str) ) {
		foreach($str as $key => $value) {
			if (get_magic_quotes_gpc() ) {$key = stripslashes($key);}

			$key2 = str_replace(	array('\\', "'", '"', "\x0d", "\x0a", "\x00", "\x1a", '`', '<', '>'),
				array('\\\\', "\\'", '\\"', 'X', 'X', 'X', 'X', '&#96;', '&lt;', '&gt;'),	$key, $occ);
			if ($occ) {
				unset($str[$key]);
				nf_write2log('Sanitising user input', $msg . ': ' . $key, 6, 0);
				if ($MagenfCheckDebug) { $nfdebug.= STAG . "sanitising $msg\t\t[WARN]   string: " . nf_bin2hex_string($key) . ETAG; }
			}
			$str[$key2] = nf_sanitise($value, $how, $msg);
		}
		return $str;
	}
}
/* ================================================================ */
function nf_check_upload() {

   global $nfdebug;
   global $MagenfCheckDebug;
   $tmp = '';
	foreach ($_FILES as $file) {
		if ( is_array($file['name']) ) {
			foreach($file['name'] as $key => $value) {
				if (! $file['name'][$key]) { continue; }
				$tmp .= $file['name'][$key] . ', ' . number_format($file['size'][$key]) . ' bytes ';
			}
		} else {
			if (! $file['name']) { continue; }
			$tmp .= $file['name'] . ', ' . number_format($file['size']) . ' bytes ';
		}
	}
   if ($tmp) {
		if ($MagenfCheckDebug) { $nfdebug.= '[FAIL]   file upload attempt : '. nf_bin2hex_string($tmp) . ETAG; }
		nf_write2log('File upload attempt', rtrim($tmp, ' '), 2, 0);
		nf_block();
	}

   if ($MagenfCheckDebug) { $nfdebug.= '[----]   upload field is empty' . ETAG; }
}
/* ================================================================ */
function nf_block() {

   global $nfdebug;
   global $rand_value;
   global $ip_address;

   header('HTTP/1.1 403 Forbidden');
	header('Status: 403 Forbidden');
	echo '<html><head><title>403 Forbidden</title><style>.smallblack{font-family:Verdana,Arial,Helvetica,Ubuntu,"Bitstream Vera Sans",sans-serif;font-size:12px;line-height:16px;color:#000000;}.tinygrey{font-family:Verdana,Arial,Helvetica,Ubuntu, "Bitstream Vera Sans",sans-serif;font-size:10px;line-height:12px;color:#999999;}</style></head><body><br><br><br><br><br><table align=center style="border:1px solid #FDCD25;" cellspacing=0 cellpadding=6 class=smallblack><tr><td align=center><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA3XAAAN1wFCKJt4AAAAB3RJTUUH1goFFS4tIeiJwwAAAqNJREFUOMttk9trXFUUxn97nz0zZ+ZEEnNFwSAhVQoKEcFCqaJ9CQhBnxRC639QCvqgkJdQGoo3fBbxQmlLzIPoQ0SKEAQlITEEL6mkScUmJ2MymclJzlzOTM6cs3w4U3OhH+yXtdb3fWvtxVKcwPI4g20Z3nW6H30509HvgCLcc2tVr/hT4PPRU1f5i4dhZhzjfpz+Mpx/25fdJZE4kkPEIt7vEi68429+kr3x66ekjpFlCqvwef+8FH6OJPRFQl+q+9vy9eQtuXnjupQK6/IgLsW5aOeLJxeXx0kDGIC8y2ePvzb+HCanKa8BsHLnH+YXFjHG0NUmDL/0bOKm07r7/MRQ+O1bX0E0au59wKmegadHMI6hsgoa0FD11snn81iWxc52BglslAAxoIzuHjg9vPbhn88Yx+G9VC7dTbCW9KMTo9r+Jq7rorVmr2ghQRqlFQgQQiqb7mxvY8zkOjgHGxCuQgSoRCQob+O6LkopdosCByrJCUkd97HbecGYHDZ6D6qzYPf8L1ArF9nY2Eg62G0iYQRKJSM0SqBLGIeMUVkUFnBwF9QWpOxkM3GdZrMJQHhQBGkk5LAOB34yrg1GFA1SgCWg90Htg4InHjtcc19PDaVqrS0AKaAJommYsMFstpNBaCVM8l48C79MgbsFr5wBbbdm161/MhB5LOlmhfdjGx/TEkgBaVhx4c3LcOkK/PF3EjtqIFnKUcA13TXKcrDDD7QRYx2KfHMb3H+hUITJaYj0EQGHuF7gx443WNQATpGLjT2WeIQIKyl6fQT6eqGrE0ZeBcsGrITc8FjOVrhw/B6+J1OfYyr28MRHxEfiKhIHiFQQKSOxh1ef5zuZwX7AUyevsjLNUKqXMauL51WOtIAioB6V+K1ZYsIZZvFo/X+fTjL6xSvBJAAAAABJRU5ErkJggg==" border=0 width=16 height=16><p>Sorry <b>'. $ip_address .'</b>, your request cannot be proceeded.<br>For security reason it was blocked and logged.<p>If you think that this was a mistake, please contact<br>the webmaster and enclose the following incident ID&nbsp;:<p>[<b>#' . $rand_value . '</b>]<br>&nbsp;</td></tr></table><br><br><br><br></body></html>';

   if ($nfdebug) {define('NFDEBUG', $nfdebug . '::' . nf_benchmarks() );}

	@$dbh->close();
   exit;
}
/* ================================================================ */
function nf_write2log( $loginfo, $logdata, $loglevel, $ruleid ) {

   global $MagenfCheckDebug;
   global $rand_value;
   global $nfdebug;
   global $ip_address;

	if ( ($loglevel == 6) || ($loglevel == 5) ) {
		$rand_value = '0000000';
		$http_ret_code = '200 OK';
	} else {
		$rand_value = mt_rand(1000000, 9000000);
		$http_ret_code = '403 Forbidden';
	}

	/*$LOG_FILE = dirname(__FILE__) . '/var/logs/firewall_' . date('Y-m') . '.log';
	if (! $handle = fopen($LOG_FILE, 'a') ) {
		if ($MagenfCheckDebug) { $nfdebug.= STAG .'unable to write to log'. "\t" . '[ERROR]  ' . $LOG_FILE . ETAG; }
		return;
	}*/

   //if (strlen($logdata) > 100) { $logdata = substr($logdata, 0, 100) . '...'; }

    $message =  
      '[' . $http_ret_code . '] ' . '[' . $_SERVER['REQUEST_METHOD'] . '] ' .
      '[' . $_SERVER['SCRIPT_NAME'] . '] ' . '[' . $loginfo . '] ' .
      '[' . nf_bin2hex_string($logdata) . ']' . "\n";
   Mage::getModel('wall/logs')
        ->setData(array('summary'=>$message,'ruleid'=>$ruleid,'level'=>$loglevel,'ip'=>$ip_address,'incidentid'=>$rand_value,'created_time'=>time()))
        ->save();
   Mage::log($message, null, "firewall_-".date('Y-m-d').".log");
  // fclose($handle);
}
/* ================================================================ */
function nf_benchmarks() {

   return round( (microtime(true) - NF_STARTTIME), 5);

}
/* ================================================================ */
// EOF
?>
