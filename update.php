<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "class/pgsql.class.php";
require_once "class/constantes.inc.php";
$pg = new PgSql();
$url = $pg->getCol("SELECT valor FROM gestaoti.tb_config WHERE parametro='URL'");

/* Verifica Sessão de Login Ativa */
/*if (!isLoggedIn()){
    header("Location: login_clti.php");
}

if (isset($_SESSION['user_name'])){
	$perfil = $_SESSION['perfil']; 
	if ($perfil == 'TEC_CLTI'){*/

echo"

<!doctype html>
<html lang=\"pt_BR\">
  <head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <meta name=\"description\" content=\"Sistema Integrado para Centros Locais de Tecnologia da Informação\">
    <meta name=\"author\" content=\"lucioacsantos@gmail.com Lúcio ALEXANDRE Correia dos Santos\">

    <title>...::: SisCLTI :::...</title>

    <link href=\"$url/css/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- Dashboard CSS  -->
    <link href=\"$url/css/dashboard.css\" rel=\"stylesheet\">

    <!-- ForValidation CSS  -->
    <link href=\"$url/css/form-validation.css\" rel=\"stylesheet\">

    <!-- Stylesheet CSS -->
    <link href=\"$url/css/stylesheet.css\" rel=\"stylesheet\">

  </head>

  <body>
  <div class=\"alert alert-primary\" role=\"alert\">Verificando atualizações...</div>";

$versao = $pg->getCol("SELECT valor FROM gestaoti.tb_config WHERE parametro='VERSAO' ");

if ($versao != '2.0'){

	/*echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Eq. Conectividade. Aguarde...</div>";
	$pg->exec("ALTER TABLE gestaoti.tb_conectividade ADD status varchar NULL;");
	$pg->exec("DROP VIEW gestaoti.vw_conectividade;");
	$pg->exec("CREATE OR REPLACE VIEW gestaoti.vw_conectividade
	AS SELECT conec.idtb_conectividade,
		conec.idtb_om_apoiadas,
		conec.fabricante,
		conec.modelo,
		conec.nome,
		conec.qtde_portas,
		conec.idtb_om_setores,
		conec.end_ip,
		conec.data_aquisicao,
		conec.data_garantia,
		conec.status,
		om.sigla,
		setores.sigla_setor,
		setores.compartimento
	   FROM gestaoti.tb_conectividade conec,
		gestaoti.tb_om_setores setores,
		gestaoti.tb_om_apoiadas om
	  WHERE conec.idtb_om_apoiadas = om.idtb_om_apoiadas AND conec.idtb_om_setores = setores.idtb_om_setores;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Controle de Internet. Aguarde...</div>";
	$pg->exec("ALTER TABLE gestaoti.tb_controle_internet ADD status varchar NULL;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Controle de USB Habilitado. Aguarde...</div>";		
	$pg->exec("ALTER TABLE gestaoti.tb_controle_usb ADD status varchar NULL;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Controle de Funções do SiGDEM. Aguarde...</div>";
	$pg->exec("ALTER TABLE gestaoti.tb_funcoes_sigdem ADD status varchar NULL;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE gestaoti.tb_config SET valor = '1.5.2' WHERE parametro='VERSAO' ");*/
	
	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 2.0. Aguarde...</div>
	<meta http-equiv=\"refresh\" content=\"5\">";
}

elseif ($versao == '2.0'){

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema está atualizado, Versão 2.0.</div>
	<meta http-equiv=\"refresh\" content=\"5;url=$url\">";

}

else{
	echo "<div class=\"alert alert-primary\" role=\"alert\">Verifique sua instalação!</div>";
}

/** Encerrando Verifica Sessão de Login Ativa */
/*	}
}*/

?>