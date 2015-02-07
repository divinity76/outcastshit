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

$accountNumber="123123";
//$password="lolz";
//$accountNumber="124123";
$password="lolz";
$characterNames=array();
$characterNames[]="Axe Caster";
$characterNames[]="Knuckletaur";
$characterNames[]="Mash Dancer";
$characterNames[]="Sergeant Shocking";
//$characterNames[]="Weapon Kick";
/*
$characterNames[]="Derpa";
$characterNames[]="Derpb";			
$characterNames[]="Derpc";			
$characterNames[]="Derpd";			
$characterNames[]="Derpe";			
$characterNames[]="Derpf";			
$characterNames[]="Derpg";			
$characterNames[]="Derph";		
$characterNames[]="Derpi";			
$characterNames[]="Derpj";			
$characterNames[]="Derpk";			
$characterNames[]="Derpl";			
$characterNames[]="Derpm";			
$characterNames[]="Derpn";			
$characterNames[]="Derpo";			
$characterNames[]="Derpp";			
$characterNames[]="Derpq";			
$characterNames[]="Derpr";			
$characterNames[]="Derps";			
$characterNames[]="Derpt";			
$characterNames[]="Derpu";			
$characterNames[]="Derpv";			
$characterNames[]="Derpw";			
$characterNames[]="Derpx";			
$characterNames[]="Derpy";			
$characterNames[]="Derpz";
*/

$starttime=microtime(true);

$socketConnections=array();

foreach($characterNames as $character){
	$socketConnections[]=LogInAndReturnSocketHandle($accountNumber,$character,$password);
}
foo:
sleep(120);
foreach($socketConnections as $connection){
	AntikickAndPing($connection);
}
echo "done. sleeping.".PHP_EOL;
goto foo;

sleep(60000);
die("finito!");

function LogInAndReturnSocketHandle($accountNumber,$characterName,$password){
$socket=socket_create(AF_INET,SOCK_STREAM,SOL_TCP);
if($socket===false){
	throw new Exception("socket_create() failed: reason: " . socket_strerror(socket_last_error()));
}
assert(socket_set_block ( $socket)===true);
assert(socket_bind($socket,0,mt_rand(1024,5000))!==false);//TODO: don't use mt_rand... it has a (small) chance choosing a used address..
if(socket_connect($socket,
'87.92.70.35',7171
)!==true){
	   throw new Exception("socket_connect() failed: reason: " . socket_strerror(socket_last_error()));
}
//assert(socket_set_option($socket,getprotobyname('tcp'),SO_KEEPALIVE,1)===true);//TODO: confirm, is this really correct?

$packets=array();
$tmp=hex2bin('0A0364F2FF07006675636B796F7519007858353834384A676A724945706F776F4B466B66726972474A1C00314F2B45564866686B476745324C32344861694C487673515943673DF70200');
//i don't know what ^ means.. 1 byte is OS (linux or windows), 1 byte is client type (flash or c++), 
//2 bytes are client version, the rest? i haven't got a clue.
//looks like they are trying to curse anyone trying to read the protocol
// the protocol contains ascii english curse words...
$tmp.=uint32_t($accountNumber);
$tmp.=uint16_t(strlen($characterName));
$tmp.=$characterName;
$tmp.=uint16_t(strlen($password));
$tmp.=$password;
$tmp.=hex2bin('000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000');
//^i haven't got a clue what it means, but it's what the server wants.
addTCPChecksum($tmp); 
$packets[]=$tmp;
$packets[]=hex2bin("0400A00200010300980300030098040003009803000300980400");
//^meaning unknown, but required.
$packets[]=hex2bin("01001E");
#^send ping packet.
//now we should be logged in.
$replyBuf="";
$fullPacket="";
$sent=0;
$sentTotal=0;
foreach($packets as $packet){
echo "sending: ".bin2hex($packet).PHP_EOL.PHP_EOL;
$sentTotal+=$sent=socket_write($socket,$packet,strlen($packet));
usleep(80000);
//^not sure why we need to sleep, but if we send too fast, some packets never arrive :S
//usleep(50000);
}
//TODO: verify login successfull...
return $socket;
//socket_close($socket);
}


function AntikickAndPing($socket){
$packets=array();
$packets[]=hex2bin("01001E");
#^send ping packet.
$packets[]=hex2bin("0A0082FFFF060000FE0D0001");
#^eat ham in leftish hand.
$packets[]=hex2bin("01006F");
#^antikick packet ("look north");
$sentTotal=0;
$sent=0;
foreach($packets as $packet){
echo "sending: ".bin2hex($packet).PHP_EOL.PHP_EOL;
$sentTotal+=$sent=socket_write($socket,$packet,strlen($packet));
usleep(500000);
//usleep(50000);
}
}


function addTCPChecksum(&$data){
	$data=uint16_t(strlen($data)).$data;
}

function uint32_t($in){
	return pack("V",$in);
	}
function uint16_t($in){
return pack("v",$in);
	$byte1=0;
	$byte2=0;
	$i=0;
	for($i=0;$i<$in;++$i){
		++$byte1;
		if($byte1>255){
			$byte1=0;
			++$byte2;
			}
		}
		$ret=str_pad(dechex($byte1),2,"0",STR_PAD_LEFT).$ret=str_pad(dechex($byte2),2,"0",STR_PAD_LEFT);
		return $ret; 
}
