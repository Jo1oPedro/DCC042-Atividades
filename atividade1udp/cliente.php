<?php

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
$client_side_sock = dirname(__FILE__).'/client.sock';
socket_bind($socket, $client_side_sock);

$server_side_sock = dirname(__FILE__).'/server.sock';

$msg = '2 + 2';
$len = strlen($msg);

$bytes_sent = socket_sendto($socket, $msg, $len , 0, $server_side_sock);

$buf = '';
$from = '';

$bytes_recieved = socket_recvfrom($socket, $buf, 65536, 0, $from);

echo "{$msg} = {$buf}" . PHP_EOL;

socket_close($socket);
unlink($client_side_sock);

