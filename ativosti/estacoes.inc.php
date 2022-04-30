<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** Leitura de parâmetros */
$oa = $cmd = $param = $act = NULL;
if (isset($_GET['oa'])){
  $oa = $_GET['oa'];
}

if (isset($_GET['cmd'])){
  $cmd = $_GET['cmd'];
}

if (isset($_GET['act'])){
  $act = $_GET['act'];
}

if (isset($_GET['param'])){
  $param = $_GET['param'];
}

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";

$et = new Estacoes();
$om = new OrgaosApoiados();
$ip = new IP();
$sor = new SO();
$hw = new Hardware();

/* Recupera informações */
$row = $et->SelectAll();

/* Verifica se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há estações cadastradas.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    if ($param){
        $et->idtb_estacoes = $param;
        $estacoes = $et->SelectId();
    }
    else{
        $estacoes = (object)['idtb_estacoes'=>'','idtb_orgaos_apoiados'=>'','sigla'=>'','fabricante'=>'','modelo'=>'',
            'idtb_proc_modelo'=>'','proc_modelo'=>'','proc_fab'=>'','clock_proc'=>'','idtb_memorias'=>'','tipo_mem'=>'',
            'modelo_mem'=>'','clock_mem'=>'','memoria'=>'','armazenamento'=>'','idtb_sor'=>'','descricao'=>'','versao'=>'',
            'end_ip'=>'','end_mac'=>'','data_aquisicao'=>'NULL','data_garantia'=>'NULL','localizacao'=>'','status'=>'',
            'nome'=>''];
    }
    $om->ordena = "ORDER BY nome ASC";
    $omapoiada = $om->SelectApoiados();
    $sor->ordena = "ORDER BY desenvolvedor,versao ASC";
    $so = $sor->SelectSOAtivo();
    $hw->ordena = "ORDER BY fabricante ASC";
    $proc = $hw->SelectAllProcView();
    $hw->ordena = "ORDER BY tipo DESC";
    $mem = $hw->SelectAllMem();
    //$om->ordena = "ORDER BY nome_setor ASC";
    //$local = $om->SelectSetores();
    
    include "estacoes-formcad.inc.php";
}

/* Monta quadro com Estações de Trabalho */
if (($row) AND ($act == NULL)) {    
    $et->ordena = "ORDER BY idtb_orgaos_apoiados ASC";
    $estacoes = $et->SelectAll();
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">OM Apoiada</th>
                        <th scope=\"col\">Fabricante/Modelo</th>
                        <th scope=\"col\">Hardware</th>
                        <th scope=\"col\">Sistema Operacional</th>
                        <th scope=\"col\">Endereço IP/MAC</th>
                        <th scope=\"col\">Situação</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";
    foreach ($estacoes as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->sigla."</th>
                        <td>".$value->fabricante." / ".$value->modelo."</td>
                        <td>".$value->proc_fab." ".$value->proc_modelo." ".$value->clock_proc." GHz -  
                            ".$value->memoria." GB ".$value->tipo_mem." ".$value->modelo_mem." ".$value->clock_mem." GHz - 
                            ".$value->armazenamento." GB/HD</td>
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
                 echo  "<td><a href=\"?cmd=estacoes&act=cad&param=".$value->idtb_estacoes."\">Editar</a> - 
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
        $idtb_estacoes = $_POST['idtb_estacoes'];
        $et->idtb_estacoes = $_POST['idtb_estacoes'];
        $et->idtb_orgaos_apoiados = $_POST['idtb_orgaos_apoiados'];
        $et->fabricante = strtoupper($_POST['fabricante']);
        $et->modelo = strtoupper($_POST['modelo']);
        $et->idtb_proc_modelo = $_POST['idtb_proc_modelo'];
        $et->clock_proc = $_POST['clock_proc'];
        $et->idtb_memorias = $_POST['idtb_memorias'];
        $et->memoria = strtoupper($_POST['memoria']);
        $et->armazenamento = strtoupper($_POST['armazenamento']);
        $et->end_ip = $_POST['end_ip'];
        $et->end_mac = $_POST['end_mac'];
        $et->idtb_sor = $_POST['idtb_sor'];
        $et->localizacao = strtoupper($_POST['localizacao']);
        $et->data_aquisicao = $_POST['data_aquisicao'];
        $et->data_garantia = $_POST['data_garantia'];
        $et->status = $_POST['status'];

        /* Opta pelo Método Update */
        if ($idtb_estacoes){
            $row = $et->Update();        
            foreach ($row as $key => $value) {
                if ($value != '0') {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=estacoes\">";
                }        
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                }
            break;
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
                $row = $et->Insert();            
                foreach ($row as $key => $value) {
                    if ($value != '0') {
                        echo "<h5>Resgistros incluídos no banco de dados.</h5>
                        <meta http-equiv=\"refresh\" content=\"1;url=?cmd=estacoes\">";
                    }            
                    else {
                        echo "<h5>Ocorreu algum erro, tente novamente.</h5>
                        ";
                    }
                break;
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