<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Clasee de interação com o PostgreSQL */
require_once "class/constantes.inc.php";
$config = new Config();
$url = $config->SelectURL();
$sigla = $config->SelectSigla();
$versao = $config->SelectVersao();

?>

<!doctype html>
<html lang="pt_BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Integrado para Centros Locais de Tecnologia da Informação">
    <meta name="author" content="99242991 Lúcio ALEXANDRE Correia dos Santos">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <?php echo "<link rel=\"icon\" href=\"$url/favicon.ico\">"; ?>

    <title>...::: SisCLTI :::...</title>

    <?php
    /* Carrega CSS a partir da $url */
    echo"
    <!-- Bootstrap core CSS -->
    <link href=\"$url/css/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- Dashboard CSS  -->
    <link href=\"$url/css/dashboard.css\" rel=\"stylesheet\">

    <!-- ForValidation CSS  -->
    <link href=\"$url/css/form-validation.css\" rel=\"stylesheet\">

    <!-- Stylesheet CSS -->
    <link href=\"$url/css/stylesheet.css\" rel=\"stylesheet\">";

    ?>

  </head>

  <body>