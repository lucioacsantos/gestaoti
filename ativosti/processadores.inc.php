<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$hw = new Hardware();

/* Recupera informações */
$row = $hw->SelectAllProcModelo();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Processadores cadastrados,<br />
		 clique <a href=\"?cmd=processadores&act=cadfab\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro de Fabricante */
if ($act == 'cadfab') {
    @$param = $_GET['param'];
    if ($param){
        $hw->idtb_proc_fab = $param;
        $procfab = $hw->SelectIdProcFab();
    }
    else{
        $procfab = (object)['idtb_proc_fab'=>'','nome'=>''];
    }
    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"procfab\" role=\"form\" action=\"?cmd=processadores&act=insertfab\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Processadores - Cadastro</legend>

                            <div class=\"form-group\">
                                <label for=\"fabricante\">Fabricante:</label>
                                <input id=\"fabricante\" class=\"form-control\" type=\"text\" name=\"fabricante\"
                                       placeholder=\"fabricante\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                                       required=\"true\" value=\"$procfab->nome\">
                            </div>

                        </fieldset>
                        <input type=\"hidden\" name=\"idtb_proc_fab\" value=\"$procfab->idtb_proc_fab\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Carrega form para cadastro de Modelos */
if ($act == 'cadproc') {
    @$param = $_GET['param'];
    if ($param){
        $hw->idtb_proc_modelo = $param;
        $procmodelo = $hw->SelectIdProcView();
    }
    else{
        $procmodelo = (object)['idtb_proc_modelo'=>'','idtb_proc_fab'=>'','fabricante'=>'','modelo'=>''];
    }
    $hw->ordena = "ORDER BY nome ASC";
    $procfab = $hw->SelectAllProcFab();
    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"procfab\" role=\"form\" action=\"?cmd=processadores&act=insertmodelo\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Processadores - Cadastro</legend>

                            <div class=\"form-group\">
                                <label for=\"idtb_proc_fab\">Fabricante:</label>
                                <select id=\"idtb_proc_fab\" class=\"form-control\" name=\"idtb_proc_fab\">
                                    <option value=\"$procmodelo->idtb_proc_fab\" selected=\"true\">
                                        ".$procmodelo->fabricante."</option>";
                                    foreach ($procfab as $key => $value) {
                                        echo"<option value=\"".$value->idtb_proc_fab."\">
                                            ".$value->nome."</option>";
                                    };
                                echo "</select>
                            </div>

                            <div class=\"form-group\">
                                <label for=\"modelo\">Modelo:</label>
                                <input id=\"modelo\" class=\"form-control\" type=\"text\" name=\"modelo\"
                                       placeholder=\"modelo\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$procmodelo->modelo\" autocomplete=\"off\">
                            </div>

                        </fieldset>
                        <input type=\"hidden\" name=\"idtb_proc_modelo\" value=\"$procmodelo->idtb_proc_modelo\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro de processadores */
if (($row) AND ($act == NULL)) {

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Fabricante</th>
                        <th scope=\"col\">Modelo</th>
                    </tr>
                </thead>";

    $hw->ordena = "ORDER BY fabricante,modelo ASC";
    $proc = $hw->SelectAllProcView();
    foreach ($proc as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">
                            <a href=\"?cmd=processadores&act=cadfab&param=".$value->idtb_proc_fab."\">
                                ".$value->fabricante."</a>
                        </th>
                        <td>
                            <a href=\"?cmd=processadores&act=cadproc&param=".$value->idtb_proc_modelo."\">
                                ".$value->modelo."</a>
                        </td>
                    </tr>";
    };
    echo"
                </tbody>
            </table>
            </div>";
}

/* Método INSERT/UPDATE FABRICANTE */
if ($act == 'insertfab') {
    if (isset($_SESSION['status'])){
        $idtb_proc_fab = strtoupper($_POST['idtb_proc_fab']);
        $hw->idtb_proc_fab = strtoupper($_POST['idtb_proc_fab']);
        $hw->nome = strtoupper($_POST['fabricante']);
        
        if ($idtb_proc_fab){
            
            $row = $hw->UpdateProcFab();
    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=processadores\">";
            }
    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }

        else{
            
            $row = $hw->InsertProcFab();
    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=processadores\">";
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

/* Método INSERT/UPDATE MODELO */
if ($act == 'insertmodelo') {
    if (isset($_SESSION['status'])){
        $idtb_proc_modelo = $_POST['idtb_proc_modelo'];
        $hw->idtb_proc_modelo = $_POST['idtb_proc_modelo'];
        $hw->idtb_proc_fab = $_POST['idtb_proc_fab'];
        $hw->modelo = strtoupper($_POST['modelo']);
        
        if ($idtb_proc_modelo){
            $row = $hw->UpdateProcModelo();    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=processadores\">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }
        else{            
            $row = $hw->InsertProcModelo();    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=processadores\">";
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