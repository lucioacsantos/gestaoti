<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$mapainfra = new MapaInfra();
$estacoes = new Estacoes();
$servidores = new Servidores();
$conect = new Conectividade;

$omapoiada = $_SESSION['id_om_apoiada'];
$mapainfra->idtb_om_apoiadas = $omapoiada;
$estacoes->idtb_om_apoiadas = $omapoiada;
$servidores->idtb_om_apoiadas = $omapoiada;
$conect->idtb_om_apoiadas = $omapoiada;
$conexoes = $mapainfra->SelectAllOMMapaView();
$conectividade = $conect->SelectAllConectView();
$etom = $estacoes->SelectIdOMETView();
$srvom = $servidores->SelectIdOMSrvView();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if (($conectividade == NULL) AND ($act == NULL)) {
	echo "<h5>Não há equipamentos de conectividade cadastrados,<br />
        clique <a href=\"?cmd=conectividade&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    $conect->idtb_conectividade = $param;
    $mapainfra->idtb_conectividade = $param;
    $portas_conectadas = $mapainfra->ChecaPorta();
    $conectividade = $conect->SelectIdConectView();
    echo "<h5>Configurando ativo ".$conectividade->fabricante." - ".$conectividade->modelo."
         - ".$conectividade->qtde_portas." Portas.</h5>
        <div class=\"container-fluid col-6\">
            <div class=\"row\">
                <main>
                    <div id=\"form-cadastro\">
                        <form id=\"form\" action=\"\" method=\"get\" 
                            enctype=\"multipart/form-data\">
                        <fieldset>
                            <div class=\"form-group\">
                                <legend>Porta de Origem:</legend>
                                <input type=\"hidden\" id=\"cmd\" name=\"cmd\" value=\"mapainfra\">";
    $portas_livres = array(0);
    for ($i=1; $i <= $conectividade->qtde_portas; $i++) {
        $portas_livres[] = $i;
    }
    foreach ($portas_conectadas as $key => $value){
        unset($portas_livres[$value->porta_orig]);
        unset($portas_livres[$value->porta_dest]);
        unset($portas_livres[0]);
    }
    foreach ($portas_livres as $value){
        if ($value == 0){
            continue;
        }
        else{
            echo"
                                <input type=\"radio\" id=\"porta_orig\" name=\"porta_orig\" value=\"$value\" required=\"true\">
                                    <label for=\"coding\"> $value </label>";
        }
    }
    echo"
                            </div>
                            <div class=\"form-group\">
                                <legend>Selecione o Ativo de Destino</legend>
                                <input type=\"radio\" id=\"act\" name=\"act\" value=\"et\" required=\"true\">
                                    <label for=\"coding\"> Estação de Trabalho </label>
                                <input type=\"radio\" id=\"act\" name=\"act\" value=\"srv\" required=\"true\">
                                    <label for=\"coding\"> Servidor </label>
                                <input type=\"radio\" id=\"act\" name=\"act\" value=\"conec\" required=\"true\">
                                    <label for=\"coding\"> Eq. Conectividade </label>
                                <input type=\"hidden\" id=\"param\" name=\"param\" value=\"$param\">
                                <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Slecionar Ativo\">
                            </div>
                        </fieldset>
                    </div>
                </main>
            </div>
        </div>        
        
        </form>";
}

/* Carrega form para cadastro de ET */
if ($act == 'et') {
    @$param = $_GET['param'];
    @$porta_orig = $_GET['porta_orig'];
    @$idtb_mapainfra = $_GET['id'];
    if ($idtb_mapainfra){
        $mapainfra->idtb_mapainfra = $idtb_mapainfra;
        $conexoes = $mapainfra->SelectIdMapaInfra();
    }
    elseif ($param){
        $conexoes = (object)['idtb_mapainfra'=>'','idtb_conectividade_orig'=>$param,'idtb_conectividade_dest'=>'',
            'idtb_servidores_dest'=>'','idtb_estacoes_dest'=>'','porta_orig'=>$porta_orig,'porta_dest'=>'','idtb_om_apoiadas'=>''];
    }
    else{
        $conexoes = (object)['idtb_mapainfra'=>'','idtb_conectividade_orig'=>'','idtb_conectividade_dest'=>'',
            'idtb_servidores_dest'=>'','idtb_estacoes_dest'=>'','porta_orig'=>'','porta_dest'=>'','idtb_om_apoiadas'=>''];
    }

	include "mapainfra-et.inc.php";
}
/* Carrega form para cadastro de Servidor */
if ($act == 'srv') {
    @$param = $_GET['param'];
    @$porta_orig = $_GET['porta_orig'];
    @$idtb_mapainfra = $_GET['id'];
    if ($idtb_mapainfra){
        $mapainfra->idtb_mapainfra = $idtb_mapainfra;
        $conexoes = $mapainfra->SelectIdMapaView();
    }
    elseif ($param){
        $conexoes = (object)['idtb_mapainfra'=>'','idtb_conectividade_orig'=>$param,'idtb_conectividade_dest'=>'',
            'idtb_servidores_dest'=>'','idtb_estacoes_dest'=>'','porta_orig'=>$porta_orig,'porta_dest'=>'','idtb_om_apoiadas'=>''];
    }
    else{
        $conexoes = (object)['idtb_mapainfra'=>'','idtb_conectividade_orig'=>'','idtb_conectividade_dest'=>'',
            'idtb_servidores_dest'=>'','idtb_estacoes_dest'=>'','porta_orig'=>'','porta_dest'=>'','idtb_om_apoiadas'=>''];
    }

	include "mapainfra-srv.inc.php";
}
/* Carrega form para cadastro de Cascateamento */
if ($act == 'conec') {
    @$param = $_GET['param'];
    @$porta_orig = $_GET['porta_orig'];
    @$idtb_mapainfra = $_GET['id'];
    if ($idtb_mapainfra){
        $mapainfra->idtb_mapainfra = $idtb_mapainfra;
        $conexoes = $mapainfra->SelectIdMapaView();
    }
    elseif ($param){
        $conexoes = (object)['idtb_mapainfra'=>'','idtb_conectividade_orig'=>$param,'idtb_conectividade_dest'=>'',
            'idtb_servidores_dest'=>'','idtb_estacoes_dest'=>'','porta_orig'=>$porta_orig,'porta_dest'=>'','idtb_om_apoiadas'=>''];
    }
    else{
        $conexoes = (object)['idtb_mapainfra'=>'','idtb_conectividade_orig'=>'','idtb_conectividade_dest'=>'',
            'idtb_servidores_dest'=>'','idtb_estacoes_dest'=>'','porta_orig'=>'','porta_dest'=>'','idtb_om_apoiadas'=>''];
    }

	include "mapainfra-conec.inc.php";
}
if ($act == 'continuar') {
    $idtb_conectividade_dest = $_POST['idtb_conectividade_dest'];
    $idtb_conectividade_orig = $_POST['idtb_conectividade_orig'];
    $porta_orig = $_POST['porta_orig'];
    $idtb_mapainfra = $_POST['idtb_mapainfra'];
    $conect->idtb_conectividade = $idtb_conectividade_dest;
    $conecom = $conect->SelectIdConectView();
    $mapainfra->idtb_conectividade = $idtb_conectividade_dest;
    $portas_conectadas = $mapainfra->ChecaPorta();
    $portas_livres = array(0);

    for ($i=1; $i <= $conecom->qtde_portas; $i++) {
        $portas_livres[] = $i;
    }
    foreach ($portas_conectadas as $key => $value){
        unset($portas_livres[$value->porta_orig]);
        unset($portas_livres[$value->porta_dest]);
        unset($portas_livres[0]);
    }

    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                <form id=\"form\" action=\"?cmd=mapainfra&act=insert_conec\" method=\"post\" enctype=\"multipart/form-data\">
                <fieldset>
                    <legend>Equipamento de Conectividade - Cadastro</legend>
                    <div class=\"form-group\">
                        <label for=\"porta_dest\">Porta de Destino:</label>";
                    foreach ($portas_livres as $value){
                        if ($value == 0){
                            continue;
                        }
                        else{
                            echo"
                            <input type=\"radio\" id=\"porta_dest\" name=\"porta_dest\" value=\"$value\" required=\"true\">
                                <label for=\"coding\"> $value </label>";
                        }
                    }
                    echo"
                    </div>
                </fieldset>
                <input type=\"hidden\" name=\"idtb_om_apoiadas\" value=\"$omapoiada\">
                <input type=\"hidden\" name=\"idtb_conectividade_orig\" value=\"$idtb_conectividade_orig\">
                <input type=\"hidden\" name=\"idtb_conectividade_dest\" value=\"$idtb_conectividade_dest\">
                <input type=\"hidden\" name=\"porta_orig\" value=\"$porta_orig\">
                <input type=\"hidden\" name=\"idtb_mapainfra\" value=\"$idtb_mapainfra\">
                <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                </form>
                </div>
            </main>
        </div>
    </div>";
}


/* Monta quadro com equipamentos de conectividade */
if (($conectividade) AND ($act == NULL)) {

    $omapoiada = $_SESSION['id_om_apoiada'];
    if ($omapoiada != ''){
        $conect->idtb_om_apoiadas = $omapoiada;
        $conectividade = $conect->SelectAllOMConectView();
    }
    else{
        $conectividade = $conect->SelectAllConectView();
    }

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">OM Apoiada</th>
                        <th scope=\"col\">Localização</th>
                        <th scope=\"col\">Fabricante</th>
                        <th scope=\"col\">Modelo</th>
                        <th scope=\"col\">Nome</th>
                        <th scope=\"col\">Qtde. Portas</th>
                        <th scope=\"col\">Portas Ocupadas</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    foreach ($conectividade as $key => $value) {

        $mapainfra->idtb_conectividade = $value->idtb_conectividade;
        $portas_ocupadas = $mapainfra->CountPortasOcupadas();
        
        echo"       <tr>
                        <th scope=\"row\">".$value->sigla."</th>
                        <td>".$value->compartimento."</td>
                        <td>".$value->fabricante."</td>
                        <td>".$value->modelo."</td>
                        <td>".$value->nome."</td>
                        <td>".$value->qtde_portas."</td>
                        <td>".$portas_ocupadas."</td>
                        <td>
                            <a href=\"?cmd=mapainfra&act=cad&param=".$value->idtb_conectividade."\">Cadastrar</a> ||
                            <a href=\"?cmd=mapainfra&act=mod&param=".$value->idtb_conectividade."\">Modificar</a>
                        </td>
                    </tr>";
    }
    echo"
                </tbody>
            </table>
            </div>";
}

/* Método INSERT/UPDATE ET */
if ($act == 'insert_et') {
    if (isset($_SESSION['status'])){
        $mapainfra->idtb_conectividade_orig = $_POST['idtb_conectividade_orig'];
        $mapainfra->idtb_estacoes_dest = $_POST['idtb_estacoes_dest'];
        $mapainfra->porta_orig = $_POST['porta_orig'];
        $mapainfra->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $idtb_mapainfra = $_POST['idtb_mapainfra'];
        $mapainfra->idtb_mapainfra = $idtb_mapainfra;

        /* Opta pelo Método Update */
        if ($idtb_mapainfra){
            $row = $mapainfra->UpdateETMapaInfra();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=mapainfra\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            }
        }
        /* Opta pelo Método Insert */
        else {
            $checa_et = $mapainfra->ChecaET();
            if ($checa_et){
                echo "<h5>Estação de Trabalho já conectada, verifique.</h5>
                    <meta http-equiv=\"refresh\" content=\"5;url=?cmd=mapainfra\">";
            }
            else{
                $row = $mapainfra->InsertETMapaInfra();
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=mapainfra\">";
                }        
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                }
            }
        }
    }
    else{
        echo "<h5>Ocorreu algum erro, usuário não autenticado.</h5>
            <meta http-equiv=\"refresh\" content=\"1;$url\">";
    }
}

/* Método INSERT/UPDATE SRV */
if ($act == 'insert_srv') {
    if (isset($_SESSION['status'])){
        $mapainfra->idtb_conectividade_orig = $_POST['idtb_conectividade_orig'];
        $mapainfra->idtb_servidores_dest = $_POST['idtb_servidores_dest'];
        $mapainfra->porta_orig = $_POST['porta_orig'];
        $mapainfra->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $idtb_mapainfra = $_POST['idtb_mapainfra'];
        $mapainfra->idtb_mapainfra = $idtb_mapainfra;

        /* Opta pelo Método Update */
        if ($idtb_mapainfra){
            $row = $mapainfra->UpdateSRVMapaInfra();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=mapainfra\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            }
        }
        /* Opta pelo Método Insert */
        else {
            $checa_srv = $mapainfra->ChecaSRV();
            if ($checa_srv){
                echo "<h5>Servidor já conectado, verifique.</h5>
                    <meta http-equiv=\"refresh\" content=\"5;url=?cmd=mapainfra\">";
            }
            else{
                $row = $mapainfra->InsertSRVMapaInfra();
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=mapainfra\">";
                }        
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                }
            }
        }
    }
    else{
        echo "<h5>Ocorreu algum erro, usuário não autenticado.</h5>
            <meta http-equiv=\"refresh\" content=\"1;$url\">";
    }
}

/* Método INSERT/UPDATE CONECTIVIDADE */
if ($act == 'insert_conec') {
    if (isset($_SESSION['status'])){
        $mapainfra->idtb_conectividade_orig = $_POST['idtb_conectividade_orig'];
        $mapainfra->idtb_conectividade_dest = $_POST['idtb_conectividade_dest'];
        $mapainfra->porta_orig = $_POST['porta_orig'];
        $mapainfra->porta_dest = $_POST['porta_dest'];
        $mapainfra->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $idtb_mapainfra = $_POST['idtb_mapainfra'];
        $mapainfra->idtb_mapainfra = $idtb_mapainfra;

        /* Opta pelo Método Update */
        if ($idtb_mapainfra){
            $row = $mapainfra->UpdateConecMapaInfra();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=mapainfra\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            }
        }
        /* Opta pelo Método Insert */
        else {
            $checa_conec = $mapainfra->ChecaConec();
            if ($checa_conec){
                echo "<h5>Equipamento e porta já conectados, verifique.</h5>
                    <meta http-equiv=\"refresh\" content=\"5;url=?cmd=mapainfra\">";
            }
            else{
                $row = $mapainfra->InsertConecMapaInfra();
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=mapainfra\">";
                }        
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                }
            }
        }
    }
    else{
        echo "<h5>Ocorreu algum erro, usuário não autenticado.</h5>
            <meta http-equiv=\"refresh\" content=\"1;$url\">";
    }
}
?>