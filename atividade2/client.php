<?php

$socket = socket_create(AF_INET,  SOCK_STREAM, SOL_TCP);
socket_connect($socket, 'localhost', 8080);

socket_write($socket, 'Enviando mensagem do cliente tcp');

echo 'Msg recebida no cliente: ' . socket_read($socket, 1024);