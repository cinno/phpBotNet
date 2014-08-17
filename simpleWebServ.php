<?php
set_time_limit(0);
$command="/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";
$localIP = exec ($command);
echo $localIP;
$socket = stream_socket_server("tcp://$localIP".':8080', $errorNumber, $errorString);
if (!$socket) {
  echo "$errorNumber ($errorString)<br />\n";
} else {
  while ($conn = stream_socket_accept($socket)) {
  	$logFile = fOpen('logFile.txt','a');
  	echo $socket;
  	$input = fread($conn, 1024);
  	echo gettype($input);
  	logFileAppend($input,$logFile);
  	handleIncomingTraffic($input,$conn);
  	//print_r($input);
  	
    fwrite($conn, '<html><body>hello</body></html>');
    //fclose($conn);
  }
  fclose($socket);
}
function handleIncomingTraffic($HttpRequest,$connection)
{
	if (strpos($HttpRequest, 'addToBotNet')!=0) {
		echo 'added to botnet';
		checkFingerPrint();
	} else {
		fwrite($connection, "200 OK HTTP/1.1\r\n"
                         . "Connection: close\r\n"
                         . "Content-Type: text/html\r\n"
                         . "\r\n"
                         . "<html><body>Hello World!</html> ");
		echo 'other';
	}
	
}
function checkFingerPrint()
{
	fwrite($GLOBALS['conn'], 'requestFingerPrint');
	$fingerPrintInput = fread($GLOBALS['conn'], 2048);
	if (strpos($fingerPrintInput, '>>FingerPrint<<')!=0) {
		echo 'finger print recieved';
	} else {
		echo 'fingerprint error';
	}
	
}
function fingerPrint()
{

}
function addToBotNet()
{

}
function logFileAppend($stringForLog,$logFileStream)
{
	$dateTime = date('Y-m-d H:i:s');
	$outputString=$stringForLog;

	$output = "\n".$dateTime.'='."\n".$outputString;
	echo $output;
	if(fwrite($logFileStream, $output)==false)
		echo 'error writing';
}
?>
