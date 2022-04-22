<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Clasee de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$config = new Config();
$ativos = new Monitoramento();


/* Recupera informações de Servidores */
$srv = $ativos->SelectSrv();

/** Gateway das OM Apoiadas */


foreach ($srv as $key => $value){
    $row = $ativos->PingAtivo($value->end_ip);
    if ( preg_match("/bytes from/",$row) ) {
        echo "$value->nome ONLINE\n";
    }
    else {
        echo "$value->nome OFFLINE\n";
    }
    $row = $ativos->PortaSrv($value->end_ip,'80');
    if ($row){
        echo "$value->nome HTTP ONLINE\n";
    }
    else {
        echo "$value->nome HTTP OFFLINE\n";
    }
}

?>