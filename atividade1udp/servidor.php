<?php

require 'vendor/autoload.php';
use MathParser\StdMathParser as StdMathParser;
use MathParser\Interpreting\Evaluator;

/*unlink(dirname(__FILE__).'/server.sock');
unlink(dirname(__FILE__).'/client.sock');
die();*/

$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
$server_side_sock = dirname(__FILE__).'/server.sock';
socket_bind($socket, $server_side_sock);

$buf = '';
$from = '';
$message = socket_recvfrom($socket, $buf, 65536, 0, $from);

$mathParser = new StdMathParser();
$evaluator = new Evaluator();
$result = $mathParser->parse($buf);
$result = $result->evaluate($evaluator);

$len = strlen($result);
$bytes_sent = socket_sendto($socket, $result, $len, 0, $from);

unlink($server_side_sock);