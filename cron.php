<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "class/constantes.inc.php";
$usr = new Usuario();

/** -1 Dias para Vencimento de Senha */
$row = $usr->DiasVenc();
$row = $usr->DiasVencCLTI();

/** Gera Relatório de Serviço Diário */




?>