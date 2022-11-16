<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
**/
ini_set("display_errors",1);
ini_set("display_startup_erros",1);
error_reporting(E_ALL);

/* Classe de interação com o PostgreSQL */
require_once "class/constantes.inc.php";
$config = new Config();
$url = $config->SelectURL();
$versao = $config->SelectVersao();

/* Verifica Sessão de Login Ativa */
if (!isLoggedIn()){
    header("Location: login.php");
}

/* Carrega Estrutura das Páginas */
include "head.php";

include "nav.php";

include "main.php";

include "foot.php";

?>