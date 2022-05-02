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

$srv = new Servidores();
$om = new OrgaosApoiados();
$ip = new IP();
$sor = new SO();
$hw = new Hardware();

/* Recupera informações */
$row = $srv->SelectAll();

/* Verifica se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há servidores cadastradas.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    if ($param){
        $srv->idtb_servidores = $param;
        $servidor = $srv->SelectId();
    }
    else{
        $servidor = (object)['idtb_servidores'=>'','idtb_orgaos_apoiados'=>'','fabricante'=>'','modelo'=>'','sigla'=>'',
            'idtb_proc_modelo'=>'','proc_modelo'=>'','proc_fab'=>'','clock_proc'=>'','qtde_proc'=>'','memoria'=>'',
            'armazenamento'=>'','idtb_sor'=>'','descricao'=>'','versao'=>'','finalidade'=>'','idtb_setores_orgaos'=>'',
            'end_ip'=>'','end_mac'=>'','data_aquisicao'=>'NULL','data_garantia'=>'NULL','localizacao'=>'','status'=>'',
            'nome'=>''];
    }
    $om->idtb_orgaos_apoiados = $oa;
    $sor->ordena = "ORDER BY desenvolvedor,versao ASC";
    $so = $sor->SelectSOAtivo();
    $hw->ordena = "ORDER BY fabricante ASC";
    $proc = $hw->SelectAllProcView();
    $hw->ordena = "ORDER BY tipo DESC";
    $mem = $hw->SelectAllMem();
    $om->ordena = "ORDER BY nome_setor ASC";
    $local = $om->SelectSetores();
    
    include "servidores-formcad.inc.php";
}

/* Monta quadro com Estações de Trabalho */
if (($row) AND ($act == NULL)) {    
    $srv->ordena = "ORDER BY idtb_orgaos_apoiados ASC";
    $servidores = $srv->SelectAll();
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Órgão</th>
                        <th scope=\"col\">Fabricante/Modelo</th>
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
                        <td>".$value->fabricante." / ".$value->modelo."</td>
                        <td>".$value->proc_fab." ".$value->proc_modelo." ".$value->clock_proc." GHz -  
                            ".$value->memoria." GB - ".$value->armazenamento." GB/HD</td>
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
                 echo  "<td><a href=\"?cmd=servidores&oa=$value->idtb_orgaos_apoiados&act=cad&param=
                            ".$value->idtb_servidores."\">Editar</a>
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
        $idtb_servidores = $_POST['idtb_servidores'];
        $srv->idtb_servidores = $_POST['idtb_servidores'];
        $srv->idtb_orgaos_apoiados = $oa;
        $srv->fabricante = strtoupper($_POST['fabricante']);
        $srv->modelo = strtoupper($_POST['modelo']);
        $srv->nome = strtoupper($_POST['nome']);
        $srv->finalidade = strtoupper($_POST['finalidade']);
        $srv->idtb_proc_modelo = $_POST['idtb_proc_modelo'];
        $srv->clock_proc = $_POST['clock_proc'];
        $srv->qtde_proc = $_POST['qtde_proc'];
        $srv->memoria = strtoupper($_POST['memoria']);
        $srv->armazenamento = strtoupper($_POST['armazenamento']);
        $srv->end_ip = $_POST['end_ip'];
        $srv->end_mac = $_POST['end_mac'];
        $srv->idtb_sor = $_POST['idtb_sor'];
        $srv->data_aquisicao = $_POST['data_aquisicao'];
        $srv->data_garantia = $_POST['data_garantia'];
        $srv->status = $_POST['status'];

        /* Opta pelo Método Update */
        if ($idtb_servidores){
            $row = $srv->Update();        
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
                $row = $srv->Insert();            
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