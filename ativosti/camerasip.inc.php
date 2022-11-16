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
$cam = new DVRCameras();
$om = new OrgaosApoiados();
$ip = new IP();

/* Recupera informações */
$row = $cam->SelectCamIP();

/* Checa se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há câmeras cadastradas.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $cam->idtb_cameras = $param;
        $cameras = $cam->SelectIdCamIP();
    }
    else{
        $cameras = (object)['idtb_cameras'=>'','idtb_orgaos_apoiados'=>'','marca'=>'','modelo'=>'','end_ip'=>'',
            'localizacao'=>'','status'=>''];
    }
    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"cameras\" role=\"form\" action=\"?cmd=cameras&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Memórias - Cadastro</legend>
                            <div class=\"form-group\">
                                <label for=\"marca\">Marca:</label>
                                <input id=\"marca\" class=\"form-control\" type=\"text\" name=\"marca\"
                                       placeholder=\"ex. Intelbrás\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$cameras->marca\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"modelo\">Modelo:</label>
                                <input id=\"modelo\" class=\"form-control\" type=\"text\" name=\"modelo\"
                                       placeholder=\"ex. x35\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$cameras->modelo\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"end_ip\">Endereço IP:</label>
                                <input id=\"end_ip\" class=\"form-control\" type=\"number\" name=\"end_ip\" autocomplete=\"off\"
                                       placeholder=\"xxx.xxx.xxx.xxx\" required=\"true\" value=\"$cameras->end_ip\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"localizacao\">Localização:</label>
                                <input id=\"localizacao\" class=\"form-control\" type=\"number\" name=\"localizacao\" autocomplete=\"off\"
                                       placeholder=\"ex. Sala de espera\" required=\"true\" value=\"$cameras->localizacao\">
                            </div>
                        </fieldset>
                        <input type=\"hidden\" name=\"idtb_cameras\" value=\"$cameras->idtb_cameras\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro de memórias */
if (($row) AND ($act == NULL)) {

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Marca</th>
                        <th scope=\"col\">Modelo</th>
                        <th scope=\"col\">End.IP</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    $cam->ordena = "ORDER BY marca,modelo,end_ip ASC";
    $cameras = $cam->SelectAllMem();
    foreach ($cameras as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->marca."</th>
                        <td>".$value->modelo."</td>
                        <td>".$value->end_ip."</td>
                        <td><a href=\"?cmd=cameras&act=cad&param=".$value->idtb_cameras."\">
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
        $idtb_cameras = $_POST['idtb_cameras'];
        $cam->idtb_cameras = $_POST['idtb_cameras'];
        $cam->modelo = strtoupper($_POST['modelo']);
        $cam->marca = strtoupper($_POST['marca']);
        $cam->end_ip = $_POST['end_ip'];
        
        if ($idtb_cameras){
            
            $row = $cam->UpdateMem();
    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=cameras\">";
            }
    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }

        else{
            
            $row = $cam->InsertMem();
    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=cameras\">";
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