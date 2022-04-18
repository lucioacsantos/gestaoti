<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** TODO: Modificar para nova classe de interação com o banco */

/* Classe de interação com o PostgreSQL */
require_once "../class/pgsql.class.php";
$pg = new PgSql();

/* Recupera informações do tipo de CLTI */
$sql = "SELECT * FROM db_clti.tb_servidores";

$row = $pg->getRow($sql);

@$act = $_GET['act'];

/* Checa se o tipo de CLTI está cadastrado */
if (($row == '0') AND ($act == NULL)) {
	echo "<h5>Não há servidores cadastrados,<br />
		 clique <a href=\"?cmd=servidores&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro de Servidores */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $servidor = $pg->getRow("SELECT * FROM db_clti.vw_servidores WHERE idtb_servidores = '$param'");
    }
    else{
        $servidor = (object)['idtb_servidores'=>'','idtb_om_apoiadas'=>'','sigla'=>'','modelo'=>'','idtb_proc_modelo'=>'',
            'clock_proc'=>'','qtde_proc'=>'','memoria'=>'','armazenamento'=>'','idtb_sor'=>'','end_ip'=>'', 'end_mac'=>'',
            'finalidade'=>'','data_aquisicao'=>'','data_garantia'=>'','fabricante'=>'','localizacao'=>'','proc_fab'=>'',
            'proc_modelo'=>'','versao'=>'','descricao'=>''];
    }
    $omapoiada = $pg->getRows("SELECT * FROM db_clti.tb_om_apoiadas ORDER BY sigla ASC");
    $so = $pg->getRows("SELECT * FROM db_clti.tb_sor ORDER BY desenvolvedor,versao ASC");
    $proc = $pg->getRows("SELECT * FROM db_clti.vw_processadores ORDER BY fabricante ASC");
    
    include "servidores-formcad.inc.php";
}

/* Monta quadro com servidores */
if (($row) AND ($act == NULL)) {

    $srv = $pg->getRows("SELECT * FROM db_clti.vw_servidores ORDER BY idtb_om_apoiadas ASC");

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

    foreach ($srv as $key => $value) {
        
        echo"       <tr>
                    <th scope=\"row\">".$value->sigla."</th>
                    <td>".$value->fabricante." / ".$value->modelo."</td>
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
        $idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $fabricante = strtoupper($_POST['fabricante']);
        $modelo = strtoupper($_POST['modelo']);
        $idtb_proc_modelo = $_POST['idtb_proc_modelo'];
        $clock_proc = $_POST['clock_proc'];
        $qtde_proc = $_POST['qtde_proc'];
        $memoria = $_POST['memoria'];
        $armazenamento = $_POST['armazenamento'];
        $end_ip = $_POST['end_ip'];
        $end_mac = $_POST['end_mac'];
        $finalidade = strtoupper($_POST['finalidade']);
        $idtb_sor = $_POST['idtb_sor'];
        $localizacao = strtoupper($_POST['localizacao']);
        $data_aquisicao = $_POST['data_aquisicao'];
        $data_garantia = $_POST['data_garantia'];
        $status = $_POST['status'];

        /* Opta pelo Método Update */
        if ($idtb_servidores){

            $sql = "UPDATE db_clti.tb_servidores SET 
                idtb_om_apoiadas='$idtb_om_apoiadas', fabricante='$fabricante', modelo='$modelo', 
                idtb_proc_modelo='$idtb_proc_modelo', clock_proc='$clock_proc', qtde_proc='$qtde_proc', memoria='$memoria', 
                armazenamento='$armazenamento', end_ip='$end_ip', end_mac='$end_mac', idtb_sor='$idtb_sor', 
                finalidade='$finalidade', data_aquisicao='$data_aquisicao', data_garantia='$data_garantia', 
                localizacao='$localizacao', status='$status'
            WHERE idtb_servidores='$idtb_servidores'";
    
            $pg->exec($sql);
        
            foreach ($pg as $key => $value) {
                if ($value != '0') {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=servidores\">";
                }
        
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                }
            break;
                }
        }

        /* Opta pelo Método Insert */
        else{

            $checa_ip = $pg->getRow("SELECT end_ip FROM db_clti.tb_conectividade WHERE end_ip = '$end_ip'");
            $checa_ip = $pg->getRow("SELECT end_ip FROM db_clti.tb_estacoes WHERE end_ip = '$end_ip'");
            $checa_ip = $pg->getRow("SELECT end_ip FROM db_clti.tb_servidores WHERE end_ip = '$end_ip'");

            if ($checa_ip){
                echo "<h5>Endereço IP informado já está em uso, 
                    por favor verifique!</h5>
                    <meta http-equiv=\"refresh\" content=\"5;url=?cmd=servidores\">";
            }

            else{

                $sql = "INSERT INTO db_clti.tb_servidores(
                        idtb_om_apoiadas, fabricante, modelo, idtb_proc_modelo, clock_proc, 
                        qtde_proc, memoria, armazenamento, end_ip, end_mac, idtb_sor, 
                        finalidade, data_aquisicao, data_garantia, localizacao, status)

                    VALUES ('$idtb_om_apoiadas', '$fabricante', '$modelo', '$idtb_proc_modelo', '$clock_proc',
                        '$qtde_proc', '$memoria', '$armazenamento','$end_ip', '$end_mac', '$idtb_sor', '$finalidade', 
                        '$data_aquisicao', '$data_garantia', '$localizacao', '$status')";
            
                $pg->exec($sql);
            
                foreach ($pg as $key => $value) {
                    if ($value != '0') {
                        echo "<h5>Resgistros incluídos no banco de dados.</h5>
                        <meta http-equiv=\"refresh\" content=\"1;url=?cmd=servidores\">";
                    }
            
                    else {
                        echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
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