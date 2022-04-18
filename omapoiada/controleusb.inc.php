<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$usb = new ControlePrivilegios();
$om = new OMApoiadas();
$et = new Estacoes();

$omapoiada = $_SESSION['id_om_apoiada'];
$om->idtb_om_apoiadas = $omapoiada;

/* Recupera informações */
$row = $usb->SelectAll();

@$act = $_GET['act'];

/* Checa Informações */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há ET com USB liberado,<br />
		 clique <a href=\"?cmd=controleusb&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $usb->idtb_controle_usb = $param;
        $controle = $usb->SelectId();
        $et->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
        $estacoes = $et->SelectIdOMETView();
    }
    else{
        $et->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
        $estacoes = $et->SelectIdOMETView();
        $controle = (object)['idtb_controle_usb'=>'','idtb_estacoes'=>'','autorizacao'=>'','nome'=>''];
    }

    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"controleusb\" role=\"form\" action=\"?cmd=controleusb&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                        <legend>Autorização USB - Cadastro</legend>
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
                        <input id=\"idtb_controle_usb\" type=\"hidden\" name=\"idtb_controle_usb\"  
                            value=\"$controle->idtb_controle_usb\">
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
    $usb->idtb_om_apoiadas = $omapoiada;
    $controle = $usb->SelectOMAll();
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
                        <td><a href=\"?cmd=controleusb&act=cad&param=".$value->idtb_controle_usb."\">Editar</a></td>
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
        $idtb_controle_usb = $_POST['idtb_controle_usb'];
        $usb->idtb_controle_usb = $idtb_controle_usb;
        $usb->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $usb->idtb_estacoes = $_POST['idtb_estacoes'];
        $usb->autorizacao = mb_strtoupper($_POST['autorizacao'],'UTF-8');

        /* Opta pelo Método Update */
        if ($idtb_controle_usb){
            $row = $usb->Update();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=controleusb \">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }        
        else{
            /* Opta pelo Método Insert */
            $row = $usb->Insert();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=controleusb\">";
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