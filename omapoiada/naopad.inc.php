<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$naopad = new ControlePrivilegios();
$om = new OMApoiadas();
$et = new Estacoes();

$omapoiada = $_SESSION['id_om_apoiada'];
$om->idtb_om_apoiadas = $omapoiada;

/* Recupera informações */
$row = $naopad->SelectAllNaoPad();

@$act = $_GET['act'];

/* Checa Informações */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há ET com softwares não padronizados,<br />
		 clique <a href=\"?cmd=naopad&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $naopad->idtb_nao_padronizados = $param;
        $controle = $naopad->SelectIdNaoPad();
        $et->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
        $estacoes = $et->SelectIdOMETView();
    }
    else{
        $et->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
        $estacoes = $et->SelectIdOMETView();
        $controle = (object)['idtb_nao_padronizados'=>'','idtb_estacoes'=>'','autorizacao'=>'','nome'=>'',
            'soft_autorizados'=>''];
    }

    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"naopad\" role=\"form\" action=\"?cmd=naopad&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                        <legend>Autorização Software Não Padronizado - Cadastro</legend>
                            <div class=\"form-group\">
                                <label for=\"idtb_estacoes\">Estação de Trabalho:</label>
                                <select id=\"idtb_estacoes\" class=\"form-control\" name=\"idtb_estacoes\">
                                    <option value=\"$controle->idtb_estacoes\" selected=\"true\">
                                        $controle->nome</option>";
                                    foreach ($estacoes as $key => $value) {
                                        echo"<option value=\"".$value->idtb_estacoes."\">
                                            ".$value->nome."</option>";
                                    };
                                echo "</select>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"autorizacao\">Doc. de Autorizacao:</label>
                                <input id=\"autorizacao\" class=\"form-control\" type=\"text\" name=\"autorizacao\"
                                    placeholder=\"ex. CI Nº 22/2020\" style=\"text-transform:uppercase\" 
                                    autocomplete=\"off\" required=\"true\" value=\"$controle->autorizacao\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"soft_autorizados\">Relacione os Softwares Autorizados:</label>
                                <input id=\"soft_autorizados\" class=\"form-control\" type=\"text\" name=\"soft_autorizados\"
                                    placeholder=\"ex. Photoshop/Corel Draw\" style=\"text-transform:uppercase\" 
                                    autocomplete=\"off\" required=\"true\" value=\"$controle->soft_autorizados\">
                            </div>
                        </fieldset>
                        <input id=\"idtb_nao_padronizados\" type=\"hidden\" name=\"idtb_nao_padronizados\"  
                            value=\"$controle->idtb_nao_padronizados\">
                        <input type=\"hidden\" name=\"idtb_om_apoiadas\" value=\"$omapoiada\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro */
if (($row) AND ($act == NULL)) {
    $naopad->idtb_om_apoiadas = $omapoiada;
    $controle = $naopad->SelectNaoPadOM();
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Estação de Trabalho</th>
                        <th scope=\"col\">Autorizacao</th>
                        <th scope=\"col\">Soft. Autorizados</th>
                    </tr>
                </thead>";
    foreach ($controle as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->nome."</th>
                        <td>".$value->autorizacao."</td>
                        <td>".$value->soft_autorizados."</td>
                        <td><a href=\"?cmd=naopad&act=cad&param=".$value->idtb_nao_padronizados."\">Editar</a></td>
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
        $idtb_nao_padronizados = $_POST['idtb_nao_padronizados'];
        $naopad->idtb_nao_padronizados = $idtb_nao_padronizados;
        $naopad->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $naopad->idtb_estacoes = $_POST['idtb_estacoes'];
        $naopad->autorizacao = mb_strtoupper($_POST['autorizacao'],'UTF-8');
        $naopad->soft_autorizados = mb_strtoupper($_POST['soft_autorizados'],'UTF-8');

        /* Opta pelo Método Update */
        if ($idtb_nao_padronizados){
            $row = $naopad->UpdateNaoPad();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=naopad \">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }        
        else{
            /* Opta pelo Método Insert */
            $row = $naopad->InsertNaoPad();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=naopad\">";
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