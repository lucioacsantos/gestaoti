<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "class/constantes.inc.php";
$usr = new Usuario();

/** -1 Dias para Vencimento de Senha */
$row = $usr->DiasVenc();

/** Gera Relatório de Situação Diários */




?>