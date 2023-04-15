<?php
/*unlink(dirname(__FILE__).'/server.sock');
die();*/
$socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
$server_side_sock = dirname(__FILE__).'/server.sock';
socket_bind($socket, $server_side_sock);

$vector = new \Ds\Vector();
$vector->allocate(10);
$time = new DateTime();

/* Mantive utilizando a exclusão por fila na linha 33 e excluindo o buffer
    todo a cada 30s na linha 22, mas entendi que a proposta da
    atividade não era essa. Preferi focar o tempo livre 
    nos sockets do que na implementação basica 
*/

while(true) {
    $buf = '';
    $from = '';
    $messaqe = socket_recvfrom($socket, $buf, 65536, 0, $from);
    $new_time = new DateTime();

    if(( (int) $new_time->diff($time)->format('%s') ) > 30) {
        $vector->clear();
        $time = new DateTime();
    }

    $values = explode(',', $buf);
    $sendMessage = 'ACK';

    foreach($values as $value) {
        if($vector->count() > 10) {
            $sendMessage = 'Buffer full';
            $vector->shift();
        }
        $vector->push($value);
    };

    $len = strlen($sendMessage);

    $bytes_sent = socket_sendto($socket, $sendMessage, $len, 0, $from);
}

