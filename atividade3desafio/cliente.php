<?php
$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
$client_side_sock = dirname(__FILE__).'/client.sock';
socket_bind($socket, $client_side_sock);

$server_side_sock = dirname(__FILE__).'/server.sock';

$msg = '1,2,3';
$len = strlen($msg);

socket_sendto($socket, $msg, $len, 0, $server_side_sock);

$buf = '';
$from = '';

$bytes_recieved = socket_recvfrom($socket, $buf, 65536, 0, $from);

echo $buf . PHP_EOL;

unlink($client_side_sock);