<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$et = new Estacoes();

$omapoiada = $_SESSION['id_om_apoiada'];
$et->idtb_om_apoiadas = $omapoiada;
$manutencaoet = $et->SelectMntAbertoET();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if ((!$manutencaoet) AND ($act == NULL)) {
	echo "<h5>Não há ET em manutenção cadastradas.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $et->idtb_manutencao_et = $param;
        $manutencaoet = $et->SelectIdMntET();
        if ($manutencaoet == NULL){
            $et->idtb_estacoes = $param;
            $estacoes = $et->SelectIdETView();
            $manutencaoet = (object)['idtb_manutencao_et'=>'','idtb_estacoes'=>$estacoes->idtb_estacoes,
                'idtb_om_apoiadas'=>$estacoes->idtb_om_apoiadas,'data_entrada'=>'','data_saida'=>'',
                'diagnostico'=>'','custo_manutencao'=>'','situacao'=>'Em Manutenção'];
        }
        
    }
    else{
        $manutencaoet = (object)['idtb_manutencao_et'=>'','idtb_estacoes'=>'','idtb_om_apoiadas'=>'','data_entrada'=>'',
            'data_saida'=>'','diagnostico'=>'','custo_manutencao'=>'','situacao'=>'Em Manutenção'];
    }
	include "manutencaoet-formcad.inc.php";
}

/* Monta quadro de manutenção */
if (($manutencaoet) AND ($act == NULL)) {
    $ordena = " ORDER BY idtb_manutencao_et ASC";
    $manutencaoet = $et->SelectMntAbertoET();

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Cód. Mnt.</th>
                        <th scope=\"col\">Cód. ET</th>
                        <th scope=\"col\">Entrada</th>
                        <th scope=\"col\">Saída</th>
                        <th scope=\"col\">Custo R$</th>
                        <th scope=\"col\">Situação</th>
                    </tr>
                </thead>";

    foreach ($manutencaoet as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->idtb_manutencao_et."</th>
                        <td>".$value->idtb_estacoes."</td>
                        <td>".$value->data_entrada."</td>
                        <td>".$value->data_saida."</td>
                        <td>".$value->custo_manutencao."</td>
                        <td>".$value->situacao."</td>
                        <td><a href=\"?cmd=manutencaoet&act=cad&param=".$value->idtb_manutencao_et."\">Editar</a> - 
                            <a href=\"?cmd=necaquisicao&act=cad&param=".$value->idtb_manutencao_et."\">Nec.Aquisição</a>
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
        $idtb_manutencao_et = $_POST['idtb_manutencao_et'];
        $et->idtb_manutencao_et = $idtb_manutencao_et;
        $et->idtb_estacoes = $_POST['idtb_estacoes'];
        $et->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $et->data_entrada = $_POST['data_entrada'];
        $data_saida = $_POST['data_saida'];
        $et->data_saida = $_POST['data_saida'];
        $et->diagnostico = mb_strtoupper($_POST['diagnostico'],'UTF-8');
        $et->custo_manutencao = $_POST['custo_manutencao'];
        $custo_manutencao = $_POST['custo_manutencao'];
        $situacao = mb_strtoupper($_POST['situacao'],'UTF-8');
        $et->situacao = $situacao;
        if ($situacao == 'EM PRODUÇÃO'){
            $et->status = "EM PRODUÇÃO";
        }
        else{
            $et->status = "EM MANUTENÇÃO";
        }
        

        if ($data_saida == NULL) {
            $et->data_saida = 'NULL';
        }
        if ($custo_manutencao == NULL) {
            $et->custo_manutencao = '0';
        }

        /* Opta pelo Método Update */
        if ($idtb_manutencao_et){
            $row = $et->UpdateMntET();
            if ($row) {
                $row = $et->UpdateETManut();
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=manutencaoet\">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }
        
        /* Opta pelo Método Insert */
        else {
            $row = $et->InsertMntET();
            if ($row) {
                $row = $et->UpdateETManut();
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=manutencaoet\">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }
    }
    else{
        echo "<h5>Ocorreu algum erro, usuário não autenticado.</h5>
            <meta http-equiv=\"refresh\" content=\"1;$url\">";
    }
}
?>