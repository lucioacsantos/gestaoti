<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$et = new Estacoes();
$om = new OMApoiadas();
$ip = new IP();
$sor = new SO();
$hw = new Hardware();

$omapoiada = $_SESSION['id_om_apoiada'];
$om->idtb_om_apoiadas = $omapoiada;

$row = $et->SelectAllETTable();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há estações cadastradas,<br />
		 clique <a href=\"?cmd=estacoes&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro Estações de Trabalho */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $et->idtb_estacoes = $param;
        $estacoes = $et->SelectIdETView();
    }
    else{
        $estacoes = (object)['idtb_estacoes'=>'','idtb_om_apoiadas'=>'','sigla'=>'','fabricante'=>'','modelo'=>'','nome'=>'',
            'idtb_proc_modelo'=>'','proc_modelo'=>'','proc_fab'=>'','clock_proc'=>'','idtb_memorias'=>'','tipo_mem'=>'',
            'modelo_mem'=>'','clock_mem'=>'','memoria'=>'','armazenamento'=>'','idtb_om_setores'=>'','sigla_setor'=>'',
            'idtb_sor'=>'','descricao'=>'','versao'=>'','end_ip'=>'','end_mac'=>'','data_aquisicao'=>'NULL',
            'compartimento'=>'','data_garantia'=>'NULL','localizacao'=>'','req_minimos'=>'','situacao'=>''];
    }
    $om->ordena = "ORDER BY cod_om ASC";
    $omap = $om->SelectAllOMTable();
    $sor->ordena = "ORDER BY desenvolvedor,versao ASC";
    $so = $sor->SelectSOAtivo();
    $hw->ordena = "ORDER BY fabricante ASC";
    $proc = $hw->SelectAllProcView();
    $hw->ordena = "ORDER BY tipo DESC";
    $mem = $hw->SelectAllMem();
    $om->ordena = "ORDER BY nome_setor ASC";
    $local = $om->SelectAllSetoresView();
    
    include "estacoes-formcad.inc.php";
}

/* Monta quadro com Estações de Trabalho */
if (($row) AND ($act == NULL)) {

    
    if ($omapoiada != ''){
        $et->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
        $estacoes = $et->SelectIdOMETView();
    }
    else{
        $et->ordena = "idtb_om_apoiadas ASC";
        $estacoes = $et->SelectAllETView();
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
                        <th scope=\"col\">Req. Mínimos</th>
                        <th scope=\"col\">Situação</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    foreach ($estacoes as $key => $value) {

        echo"       <tr>
                        <th scope=\"row\">".$value->sigla."</th>
                        <td>".$value->idtb_estacoes."</td>
                        <td>".$value->fabricante." / ".$value->modelo."</td>
                        <td>".$value->nome."</td>
                        <td>".$value->proc_fab." ".$value->proc_modelo." ".$value->clock_proc." GHz -  
                            ".$value->memoria." GB ".$value->tipo_mem." ".$value->modelo_mem." ".$value->clock_mem." GHz - 
                            ".$value->armazenamento." GB/HD</td>
                        <td>".$value->descricao." - ".$value->versao."</td>
                        <td>".$value->end_ip." / ".$value->end_mac."</td>
                        <td>".$value->req_minimos."</td>
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
                 echo  "<td>
                            <a href=\"?cmd=estacoes&act=cad&param=".$value->idtb_estacoes."\">Editar</a> - 
                            <a href=\"?cmd=manutencaoet&act=cad&param=".$value->idtb_estacoes."\">Manutenção</a>
                        </td>
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
        
        $idtb_estacoes = $_POST['idtb_estacoes'];
        $et->idtb_estacoes = $idtb_estacoes;
        $et->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $et->fabricante = mb_strtoupper($_POST['fabricante'],'UTF-8');
        $et->modelo = mb_strtoupper($_POST['modelo'],'UTF-8');
        $et->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $et->idtb_proc_modelo = $_POST['idtb_proc_modelo'];
        $et->clock_proc = $_POST['clock_proc'];
        $et->idtb_memorias = $_POST['idtb_memorias'];
        $et->memoria = mb_strtoupper($_POST['memoria'],'UTF-8');
        $et->armazenamento = mb_strtoupper($_POST['armazenamento'],'UTF-8');
        $et->end_ip = $_POST['end_ip'];
        $ip->end_ip = $_POST['end_ip'];
        $et->end_mac = $_POST['end_mac'];
        $et->idtb_sor = $_POST['idtb_sor'];
        $et->idtb_om_setores = $_POST['idtb_om_setores'];
        $et->data_aquisicao = $_POST['data_aquisicao'];
        $et->data_garantia = $_POST['data_garantia'];
        $et->req_minimos = $_POST['req_minimos'];
        $et->status = $_POST['status'];

        /* Opta pelo Método Update */
        if ($idtb_estacoes){
            $row = $et->UpdateET();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=estacoes\">";
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
                    <meta http-equiv=\"refresh\" content=\"5;url=?cmd=estacoes\">";
            }
            else{
                $row = $et->InsertET();            
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=estacoes\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>
                    ";
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