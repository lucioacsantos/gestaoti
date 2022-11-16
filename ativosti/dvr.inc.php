<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
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
$dvrcam = new DVRCameras();
$om = new OrgaosApoiados();
$ip = new IP();

/* Recupera informações */
$row = $dvrcam->SelectAllDVR();

/* Verifica se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há DVR cadastrados.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    if ($param){
        $dvrcam->idtb_dvr = $param;
        $dvr = $dvrcam->SelectIdDVR();
    }
    else{
        $dvr = (object)['idtb_dvr'=>'','idtb_orgaos_apoiados'=>'','marca'=>'','modelo'=>'','end_ip'=>'',
            'idtb_setores_orgaos'=>'','sigla_setor'=>'','compartimento'=>'','qtde_cameras'=>'','status'=>''];
    }
    $om->idtb_orgaos_apoiados = $oa;
    $local = $om->SelectSetores();
    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"dvr\" role=\"form\" action=\"?cmd=dvr&oa=$oa&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>DVR - Cadastro</legend>
                            <div class=\"form-group\">
                                <label for=\"marca\">Marca:</label>
                                <input id=\"marca\" class=\"form-control\" type=\"text\" name=\"marca\"
                                       placeholder=\"ex. INTELBRAS\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$dvr->marca\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"modelo\">Modelo:</label>
                                <input id=\"modelo\" class=\"form-control\" type=\"text\" name=\"modelo\"
                                       placeholder=\"ex. MHDX 3016-C\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$dvr->modelo\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"end_ip\">Endereço IP:</label>
                                <input id=\"end_ip\" class=\"form-control\" type=\"text\" name=\"end_ip\" autocomplete=\"off\"
                                       placeholder=\"ex. 192.168.1.200\" required=\"true\" value=\"$dvr->end_ip\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"localizacao\">Localização:</label>
                                <select id=\"idtb_setores_orgaos\" class=\"form-control\" name=\"idtb_setores_orgaos\">
                                    <option value=\"$dvr->idtb_setores_orgaos\" selected=\"true\">
                                            ".$dvr->sigla_setor." - ".$dvr->compartimento."</option>";
                                        foreach ($local as $key => $value) {
                                            echo"<option value=\"".$value->idtb_setores_orgaos."\">
                                                ".$value->sigla_setor." - ".$value->compartimento."</option>";
                                        };
                                echo "</select>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"qtde_cameras\">Qtde. de Câmeras:</label>
                                <input id=\"qtde_cameras\" class=\"form-control\" type=\"number\" name=\"qtde_cameras\" autocomplete=\"off\"
                                    placeholder=\"ex. 12\" value=\"$dvr->qtde_cameras\" required=\"true\">
                            </div>";
                            if ($param){
                                echo"
                                <div class=\"form-group\">
                                <label for=\"status\">Situação:</label>
                                <select id=\"status\" class=\"form-control\" name=\"status\">
                                    <option value=\"$dvr->status\" selected=\"true\">
                                        $dvr->status</option>
                                    <option value=\"EM PRODUÇÃO\">EM PRODUÇÃO</option>
                                    <option value=\"EM MANUTENÇÃO\">EM MANUTENÇÃO</option>
                                </select>
                            </div>";
                            }
                            else{
                                echo"<input id=\"status\" type=\"hidden\" name=\"status\" 
                                value=\"EM PRODUÇÃO\">";
                            }
                        echo"</fieldset>
                        <input type=\"hidden\" name=\"idtb_dvr\" value=\"$dvr->idtb_dvr\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro de DVR */
if (($row) AND ($act == NULL)) {

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Marca</th>
                        <th scope=\"col\">Modelo</th>
                        <th scope=\"col\">end_ip</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    $dvrcam->ordena = "ORDER BY marca,modelo,end_ip ASC";
    $dvr = $dvrcam->SelectAllDVR();
    foreach ($dvr as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->marca."</th>
                        <td>".$value->modelo."</td>
                        <td>".$value->end_ip."</td>
                        <td><a href=\"?cmd=dvr&act=cad&oa=$value->idtb_orgaos_apoiados&param=".$value->idtb_dvr."\">
                                Editar</a>
                        </td>
                    </tr>";
    };
    echo"
                </tbody>
            </table>
            </div>";
}

/* Método INSERT/UPDATE Memória */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){
        $idtb_dvr = $_POST['idtb_dvr'];
        $dvrcam->idtb_dvr = $_POST['idtb_dvr'];
        $dvrcam->idtb_orgaos_apoiados = $oa;
        $dvrcam->modelo = strtoupper($_POST['modelo']);
        $dvrcam->marca = strtoupper($_POST['marca']);
        $dvrcam->end_ip = $_POST['end_ip'];
        $dvrcam->qtde_cameras = $_POST['qtde_cameras'];
        $dvrcam->idtb_setores_orgaos = $_POST['idtb_setores_orgaos'];
        $dvrcam->status = $_POST['status'];
        
        if ($idtb_dvr){
            $checa_ip = $ip->SearchIP();
            if ($checa_ip != NULL){
                echo "<h5>Endereço IP informado já está em uso, 
                    por favor verifique!</h5>
                    <meta http-equiv=\"refresh\" content=\"5;url=?cmd=conectividade\">";
            }
            else{
                $row = $dvrcam->UpdateDVR();
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=dvr\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    echo(pg_result_error($row) . "<br />\n");
                }
            }
        }
        else{  
            $checa_ip = $ip->SearchIP();            
            if ($checa_ip){
                echo "<h5>Endereço IP informado já está em uso, 
                    por favor verifique!</h5>
                    <meta http-equiv=\"refresh\" content=\"5;url=?cmd=conectividade\">";
            }
            else{          
                $row = $dvrcam->InsertDVR();    
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=dvr\">";
                }    
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    echo(pg_result_error($row) . "<br />\n");
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