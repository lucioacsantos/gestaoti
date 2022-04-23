<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "class/constantes.inc.php";
$config = new Config();
$url = $config->SelectURL();
$versao = $config->SelectVersao();
$_SESSION ['msg'] = "";
$msg = $_SESSION ['msg'];

?>

<!doctype html>
<html lang="pt_BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Integrado para Gestão de Sistemas e Serviços de Tecnologia da Informação">
    <meta name="author" content="Lúcio ALEXANDRE Correia dos Santos AJSantos lucio.alexandre@ajsantos.com.br">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <?php echo "<link rel=\"icon\" href=\"$url/favicon.ico\">"; ?>

    <title>...::: SGTI :::...</title>

    <?php
    /* Carrega CSS a partir da $url */
    echo"
    <!-- Bootstrap core CSS -->
    <link href=\"$url/css/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- Stylesheet CSS -->
    <link href=\"$url/css/signin.css\" rel=\"stylesheet\">";

    ?>

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

  </head>

  <body>

<?php

@$act = $_GET['act'];

if ($act == NULL){
  include_once("login.inc.php");
}

/* Método Login */
if ($act == 'login') {
  $usr = new Usuario();
  $usr->usuario = $_POST['usuario'];
  $hash = sha1(md5($_POST['senha']));
  $salt = sha1(md5($usr->usuario));
  $senha = $salt.$hash;
  $usr->senha = $senha;

  $row = $usr->Login();
    
	if ($row != NULL) {

    $usr->idtb_pessoal_ti = $row->idtb_pessoal_ti;
    $funcaoti = $usr->Perfil($row->idtb_funcoes_ti);

    /** Verificar falhas de login do usuário comum */
    /*if ($venc_senha < 1){
      $_SESSION ['msg'] = "Sua senha venceu! Entre em contato com o CLTI!";
      $msg = $_SESSION ['msg'];
      $_SESSION['logged_in'] = false;
      include_once("login.inc.php");
    }
    else{*/
      $_SESSION['logged_in'] = true;
      $_SESSION['user_id'] = $row->idtb_pessoal_ti;
      $_SESSION['venc_senha'] = $usr->GetVencSenha();
      $_SESSION['usuario'] = $usr->usuario;
      $_SESSION['user_name'] = $row->nome_guerra;
      $_SESSION['perfil'] = $funcaoti;
      $_SESSION['status'] = $row->status;
      $_SESSION['idtb_orgaos_apoiados'] = $row->idtb_orgaos_apoiados;
      $_SESSION['sigla_orgaos_apoiados'] = $row->sigla;
      
      header('Location: index.php');
    //}
	}
	else {
    $_SESSION ['msg'] = "Usuário ou senha incorretos!";
    $msg = $_SESSION ['msg'];
    include_once("login.inc.php");
	}
}

?>