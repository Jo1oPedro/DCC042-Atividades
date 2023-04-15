<?php

$socket = socket_create(AF_INET , SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket, 'localhost', 8080);
socket_listen($socket);

$clients = array($socket);

while(true) {
    $read = $clients;
    $write = $except = null;
    socket_select($read, $write, $except, 0, 200000); 

    if(count($read)) {
        $new_client = socket_accept($read[0]);
        $message = socket_read($new_client, 1024);

        if($message) {
            socket_write($new_client, $message . PHP_EOL);
        }
    }
}