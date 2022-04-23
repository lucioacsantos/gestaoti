<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/
 
// inicia a sessão
session_start();
 
// muda o valor de logged_in para false
$_SESSION['logged_in'] = false;
$_SESSION['user_id'] = '';
$_SESSION['usuario'] = '';
$_SESSION['posto_grad'] = '';
$_SESSION['user_name'] = '';
$_SESSION['perfil'] = '';
$_SESSION['status'] = '';
$_SESSION['id_om_apoiada'] = '';
$_SESSION['om_apoiada'] = '';
 
// finaliza a sessão
session_destroy();
 
// retorna para a index.php
header('Location: index.php');