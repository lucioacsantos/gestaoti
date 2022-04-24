<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Clasee de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$config = new Config();
$cont = new Contadores();

/* URL Recuperada do Banco de Dados */
$url = $config->SelectURL();

include "../head.php";

include "../nav.php";

include "tabelas.inc.php";

include "../foot.php";
?>