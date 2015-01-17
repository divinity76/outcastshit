<?php
error_reporting(E_ALL);

function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
set_error_handler("exception_error_handler");

$curlh=hhb_curl_init();
$username="177777";
$password="nigerian";
$charactername="Nigerian";
$starttime=microtime(true);
login($curlh,$username,$password);
$total=500;
for($i=0;$i<$total;++$i){
	try{
createCharacter($curlh,$charactername);
}catch(Exception $ex){
}
try{
LogInAndCastMoneyAndLogOut();
}catch(Exception $ex){
		echo "failed login! error: ".$ex->getMessage(),PHP_EOL;

}
	try{
deleteCharacter($curlh,$charactername,$username);
}catch(Exception $ex){}
}
echo $total." characters: used ".(microtime(true)-$starttime). " seconds..";




function LogInAndCastMoneyAndLogOut(){
	
$socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
if($socket==false){
	   echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
	   return false;
}
assert(socket_set_block ( $socket)===true);
assert(socket_bind($socket,0,mt_rand(1024,5000))!==false);//mt_rand isn't reliable 100% of the time...
if(socket_connect($socket,
'87.92.70.35',7171
)!==true){
	   echo "socket_connect() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
	   return false;
	
}


$packets=array();
//$packets[]=hex2bin(str_replace(" ","","00"));
$packets[]=hex2bin(str_replace(" ","","C9 00 0A 03 64 F2 FF 07 00 66 75 63 6B 79 6F 75 19 00 78 58 35 38 34 38 4A 67 6A 72 49 45 70 6F 77 6F 4B 46 6B 66 72 69 72 47 4A 1C 00 31 4F 2B 45 56 48 66 68 6B 47 67 45 32 4C 32 34 48 61 69 4C 48 76 73 51 59 43 67 3D F7 02 00 71 B6 02 00 08 00 4E 69 67 65 72 69 61 6E 08 00 6E 69 67 65 72 69 61 6E 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 "));
$packets[]=hex2bin(str_replace(" ","","04 00 A0 02 00 01 03 00 98 03 00 03 00 98 04 00 03 00 98 03 00 03 00 98 04 00 "));
$packets[]=hex2bin(str_replace(" ","","0A 00 82 FF FF 03 00 00 33 0B 00 00 "));
$packets[]=hex2bin(str_replace(" ","","0F 00 78 FF FF 40 00 00 DB 0B 00 EA 03 EC 03 07 0F "));
$packets[]=hex2bin(str_replace(" ","","01 00 14"));//explicit logout packet
 
$replyBuf="";
$fullPacket="";
foreach($packets as $packet){
$sent=socket_write($socket,$packet,strlen($packet));
//usleep(50000);
}

//sleep(1);
//sleep(9);


socket_close($socket);
}

function createCharacter($curlh,$charactername){
	curl_setopt_array(
	$curlh,
	array(
	CURLOPT_POST=>true,
	CURLOPT_SSL_VERIFYHOST=>0,
	CURLOPT_POSTFIELDS=>
	array(
		'name'=>$charactername,
		'sex'=>"1",
		'vocation'=>"1",
		'city'=>'Vroengard',
		'submit'=>'Submit'
	)
	,
	CURLOPT_URL=>'http://outcastserver.com/account.php',
	));
	
	
	$ret=hhb_curl_exec($curlh,'http://outcastserver.com/account.php');
	if(stripos($ret,'CHARACTER SUCCESSFULLY CREATED')===false){
		echo "ERROR: COULD NOT CREATE CHARACTER!, ret:",$ret;
		throw new Exception("ERROR: COULD NOT CREATE CHARACTER!");
	}
	return true;
	}

function deleteCharacter($curlh,$charactername,$account){
//this is a GET request..	
	$url="http://outcastserver.com/account.php?delete=".urlencode($charactername)."&account=".urlencode($account);
	curl_setopt_array(
	$curlh,
	array(
	CURLOPT_POST=>false,
	CURLOPT_SSL_VERIFYHOST=>0,
	CURLOPT_URL=>$url
	));
	$ret=hhb_curl_exec($curlh,$url);
	if(stripos($ret,'Character deleted !')===false){
		echo "ERROR: COULD NOT DELETE CHARACTER!, ret:",$ret;
		throw new Exception("ERROR: COULD NOT DELETE CHARACTER!");
	}
	return true;
	}

function login($curlh,$username,$password){
	curl_setopt_array(
	$curlh,
	array(
	CURLOPT_POST=>true,
	CURLOPT_SSL_VERIFYHOST=>0,
	CURLOPT_POSTFIELDS=>
//	"account=".urlencode($username)."&password=".urlencode($password)
	array(
		'account'=>$username,
		'password'=>$password
	)
	,
	CURLOPT_URL=>'http://outcastserver.com/account.php',
	));
	$ret=hhb_curl_exec($curlh,'http://outcastserver.com/account.php');
	if(stripos($ret,'CREATE NEW CHARACTER')===false){
		echo "ERROR: COULD NOT LOG IN! ret:",$ret;
		throw new Exception("Could not log in!");
	}
	return true;//could be void..
}


function hhb_curl_init($custom_options_array = array()) {
    if(empty($custom_options_array)){
        $custom_options_array=array();
//i feel kinda bad about this.. argv[1] of curl_init wants a string(url), or NULL
//at least i want to allow NULL aswell :/
    }
    if (!is_array($custom_options_array)) {
        throw new InvalidArgumentException('$custom_options_array must be an array!');
    };
    $options_array = array(
        CURLOPT_AUTOREFERER => true,
        CURLOPT_BINARYTRANSFER => true,
        CURLOPT_COOKIESESSION => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_FORBID_REUSE => false,
        CURLOPT_HTTPGET => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT => 11,
        CURLOPT_ENCODING=>"",
        //CURLOPT_REFERER=>'example.org',
        //CURLOPT_USERAGE=>'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.146 Safari/537.36'
    );
    if (!array_key_exists(CURLOPT_COOKIEFILE, $custom_options_array)) {
    	//do this only conditionally because tmpfile() call..
    	 static $curl_cookiefiles_arr=array();//workaround for https://bugs.php.net/bug.php?id=66014
	 $curl_cookiefiles_arr[]=$options_array[CURLOPT_COOKIEFILE] = tmpfile();
	 $options_array[CURLOPT_COOKIEFILE] =stream_get_meta_data($options_array[CURLOPT_COOKIEFILE]);
	 $options_array[CURLOPT_COOKIEFILE]=$options_array[CURLOPT_COOKIEFILE]['uri']; 
    }
    //we can't use array_merge() because of how it handles integer-keys, it would/could cause corruption
    foreach($custom_options_array as $key => $val) {
        $options_array[$key] = $val;
    }
    unset($key, $val, $custom_options_array);
    $curl = curl_init();
    curl_setopt_array($curl, $options_array);
    return $curl;
}
$hhb_curl_domainCache = "";
function hhb_curl_exec($ch, $url) {
    global $hhb_curl_domainCache; //
    //$hhb_curl_domainCache=&$this->hhb_curl_domainCache;
    //$ch=&$this->curlh;
    	if(!is_resource($ch) || get_resource_type($ch)!=='curl')
	{
		throw new InvalidArgumentException('$ch must be a curl handle!');
	}
	if(!is_string($url))
	{
		throw new InvalidArgumentException('$url must be a string!');
	}
    $tmpvar = "";
    if (parse_url($url, PHP_URL_HOST) === null) {
        if (substr($url, 0, 1) !== '/') {
            $url = $hhb_curl_domainCache.'/'.$url;
        } else {
            $url = $hhb_curl_domainCache.$url;
        }
    };
    curl_setopt($ch, CURLOPT_URL, $url);
    $html = curl_exec($ch);
    if (curl_errno($ch)) {
        throw new Exception('Curl error (curl_errno='.curl_errno($ch).') on url '.var_export($url, true).': '.curl_error($ch));
        // echo 'Curl error: ' . curl_error($ch);
    }
    if ($html === '' && 203 != ($tmpvar = curl_getinfo($ch, CURLINFO_HTTP_CODE)) /*203 is "success, but no output"..*/ ) {
        throw new Exception('Curl returned nothing for '.var_export($url, true).' but HTTP_RESPONSE_CODE was '.var_export($tmpvar, true));
    };
    //remember that curl (usually) auto-follows the "Location: " http redirects..
    $hhb_curl_domainCache = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL), PHP_URL_HOST);
    return $html;
}
