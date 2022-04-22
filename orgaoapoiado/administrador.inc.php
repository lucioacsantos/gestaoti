<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$adm = new ControlePrivilegios();
$om = new OMApoiadas();
$et = new Estacoes();

$omapoiada = $_SESSION['id_om_apoiada'];
$om->idtb_om_apoiadas = $omapoiada;

/* Recupera informações */
$row = $adm->SelectAllAdm();

@$act = $_GET['act'];

/* Checa Informações */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há ET com permissões de administrador,<br />
		 clique <a href=\"?cmd=administrador&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro de Admin */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $adm->idtb_permissoes_admin = $param;
        $controle = $adm->SelectIdAdm();
        $et->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
        $estacoes = $et->SelectIdOMETView();
    }
    else{
        $et->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
        $estacoes = $et->SelectIdOMETView();
        $controle = (object)['tb_permissoes_admin'=>'','idtb_estacoes'=>'','autorizacao'=>'','nome'=>''];
    }

    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"controleadmin\" role=\"form\" action=\"?cmd=administrador&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                        <legend>Permissões de Administrador - Cadastro</legend>
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
                        </fieldset>
                        <input id=\"tb_permissoes_admin\" type=\"hidden\" name=\"tb_permissoes_admin\"  
                            value=\"$controle->tb_permissoes_admin\">
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
    $adm->idtb_om_apoiadas = $omapoiada;
    $controle = $adm->SelectAdmOM();
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Estação de Trabalho</th>
                        <th scope=\"col\">Autorizacao</th>
                    </tr>
                </thead>";
    foreach ($controle as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->nome."</th>
                        <td>".$value->autorizacao."</td>
                        <td><a href=\"?cmd=administrador&act=cad&param=".$value->idtb_permissoes_admin."\">Editar</a></td>
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
        $tb_permissoes_admin = $_POST['tb_permissoes_admin'];
        $adm->tb_permissoes_admin = $tb_permissoes_admin;
        $adm->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $adm->idtb_estacoes = $_POST['idtb_estacoes'];
        $adm->autorizacao = mb_strtoupper($_POST['autorizacao'],'UTF-8');

        /* Opta pelo Método Update */
        if ($tb_permissoes_admin){
            $row = $adm->UpdateAdmin();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=administrador \">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }        
        else{
            /* Opta pelo Método Insert */
            $row = $adm->InsertAdmin();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=administrador\">";
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