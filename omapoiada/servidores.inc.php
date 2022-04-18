<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
$srv = new Servidores();
$om = new OMApoiadas();
$ip = new IP();
$sor = new SO();
$hw = new Hardware();

$omapoiada = $_SESSION['id_om_apoiada'];
$om->idtb_om_apoiadas = $omapoiada;

$servidor = $srv->SelectAllSrvTable();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if ((!$servidor) AND ($act == NULL)) {
	echo "<h5>Não há servidores cadastrados,<br />
		 clique <a href=\"?cmd=servidores&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro de Servidores */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $srv->idtb_servidores = $param;
        $servidor = $srv->SelectIdSrvView();
    }
    else{
        $servidor = (object)['idtb_servidores'=>'','idtb_om_apoiadas'=>'','sigla'=>'','modelo'=>'','nome'=>'',
            'idtb_proc_modelo'=>'','clock_proc'=>'','qtde_proc'=>'','memoria'=>'','armazenamento'=>'','idtb_sor'=>'',
            'end_ip'=>'', 'end_mac'=>'','finalidade'=>'','data_aquisicao'=>'','data_garantia'=>'','fabricante'=>'',
            'idtb_om_setores'=>'','sigla_setor'=>'','proc_fab'=>'','proc_modelo'=>'','versao'=>'','descricao'=>'',
            'compartimento'=>'',];
    }
    $sor->ordena = "ORDER BY desenvolvedor,versao ASC";
    $so = $sor->SelectSOAtivo();
    $hw->ordena = "ORDER BY fabricante ASC";
    $proc = $hw->SelectAllProcView();
    $hw->ordena = "ORDER BY tipo DESC";
    $mem = $hw->SelectAllMem();
    $om->ordena = "ORDER BY nome_setor ASC";
    $local = $om->SelectAllSetoresView();
    
    include "servidores-formcad.inc.php";
}

/* Monta quadro com servidores */
if (($servidor) AND ($act == NULL)) {

    if ($omapoiada != ''){
        $srv->idtb_om_apoiadas = $omapoiada;
        $servidores = $srv->SelectIdOMSrvView();
    }
    else{
        $ordena = "ORDER BY idtb_om_apoiadas ASC";
        $servidores = $srv->SelectAllSrvView();
    }

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">OM Apoiada</th>
                        <th scope=\"col\">Cód.</th>
                        <th scope=\"col\">Fabricante/Modelo</th>
                        <th scope=\"col\">Nome</th>
                        <th scope=\"col\">Hardware</th>
                        <th scope=\"col\">Sistema Operacional</th>
                        <th scope=\"col\">Endereço IP/MAC</th>
                        <th scope=\"col\">Situação</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    foreach ($servidores as $key => $value) {
        
        echo"       <tr>
                    <th scope=\"row\">".$value->sigla."</th>
                    <td>".$value->idtb_servidores."</td>
                    <td>".$value->fabricante." / ".$value->modelo."</td>
                    <td>".$value->nome."</td>
                    <td>".$value->proc_fab." - ".$value->proc_modelo." - ".$value->clock_proc." GHz "
                        .$value->memoria." GB/RAM ".$value->armazenamento." GB/HD</td>
                    <td>".$value->descricao." - ".$value->versao."</td>
                    <td>".$value->end_ip." / ".$value->end_mac."</td>
                    <td>";
                    if ($value->status == "EM PRODUÇÃO"){
                        echo "<span data-feather=\"check-circle\"></span></td>";
                    }
                    if ($value->status == "EM MANUTENÇÃO"){
                        echo "<span data-feather=\"activity\"></span></td>";
                    }
                    if ($value->status == "SEM ATIVIDADE"){
                        echo "<span data-feather=\"alert-triangle\"></span></td>";
                    }
            echo  "<td><a href=\"?cmd=servidores&act=cad&param=".$value->idtb_servidores."\">Editar</a> - 
                    Excluir</td>
                </tr>";
            }
            echo"
            </tbody>
            </table>
            </div>";
}

/* Método INSERT/UPDATE */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){
        $idtb_servidores = $_POST['idtb_servidores'];
        $srv->idtb_servidores = $idtb_servidores;
        $srv->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $srv->fabricante = mb_strtoupper($_POST['fabricante'],'UTF-8');
        $srv->modelo = mb_strtoupper($_POST['modelo'],'UTF-8');
        $srv->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $srv->idtb_proc_modelo = $_POST['idtb_proc_modelo'];
        $srv->clock_proc = $_POST['clock_proc'];
        $srv->qtde_proc = $_POST['qtde_proc'];
        $srv->memoria = $_POST['memoria'];
        $srv->armazenamento = $_POST['armazenamento'];
        $srv->end_ip = $_POST['end_ip'];
        $ip->end_ip = $_POST['end_ip'];
        $srv->end_mac = $_POST['end_mac'];
        $srv->finalidade = mb_strtoupper($_POST['finalidade'],'UTF-8');
        $srv->idtb_sor = $_POST['idtb_sor'];
        $srv->idtb_om_setores = mb_strtoupper($_POST['idtb_om_setores'],'UTF-8');
        $srv->data_aquisicao = $_POST['data_aquisicao'];
        $srv->data_garantia = $_POST['data_garantia'];
        $srv->status = $_POST['status'];

        /* Opta pelo Método Update */
        if ($idtb_servidores){

            $row = $srv->UpdateSrv();        
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=servidores\">";
            }
    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            }
        }
        /* Opta pelo Método Insert */
        else{
            $checa_ip = $ip->SearchIP();
            if ($checa_ip){
                echo "<h5>Endereço IP informado já está em uso, 
                    por favor verifique!</h5>
                    <meta http-equiv=\"refresh\" content=\"5;url=?cmd=servidores\">";
            }
            else{
                $row = $srv->InsertSrv();
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=servidores\">";
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