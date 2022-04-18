<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$soft = new SO();

/* Recupera informações */
$row = $soft->SelectAllSoft();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Softwares cadastrados,<br />
		 clique <a href=\"?cmd=softpad&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro com objeto do banco ou vazio */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $soft->idtb_soft_padronizados = $param;
        $softpad = $soft->SelectSoftID();
    }
    else{
        $softpad = (object)['idtb_soft_padronizados'=>'','categoria'=>'','software'=>'','status'=>''];
    }
    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"insertso\" role=\"form\" action=\"?cmd=softpad&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Softwares Padronizados - Cadastro</legend>

                            <div class=\"form-group\">
                                <label for=\"categoria\">Categoria:</label>
                                <input id=\"categoria\" class=\"form-control\" type=\"text\" name=\"categoria\"
                                       placeholder=\"ex. Navegador/Segurança/Criptografia\" autocomplete=\"off\"
                                       style=\"text-transform:uppercase\" autofocus=\"true\"
                                       required=\"true\" value=\"$softpad->categoria\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"software\">software:</label>
                                <input id=\"software\" class=\"form-control\" type=\"text\" name=\"software\"
                                       placeholder=\"ex. MOZILLA FIREFOX\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                                       required=\"true\" value=\"$softpad->software\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"status\">Situação:</label>
                                <select id=\"status\" class=\"form-control\" name=\"status\">
                                <option value=\"$softpad->status\" selected=\"true\">$softpad->status</option>
                                    <option value=\"ATIVO\">Ativo</option>
                                    <option value=\"DESCONTINUADO\">Descontinuado</option>
                                </select>
                            </div>

                        </fieldset>
                        <input type=\"hidden\" name=\"idtb_soft_padronizados\" value=\"$softpad->idtb_soft_padronizados\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro */
if (($row) AND ($act == NULL)) {

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Categoria</th>
                        <th scope=\"col\">Software</th>
                        <th scope=\"col\">Status</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";
    $soft->ordena = "ORDER BY software ASC";
    $softpad = $soft->SelectAllSoftAtivos();

    foreach ($softpad as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->categoria."</th>
                        <td>".$value->software."</td>
                        <td>".$value->status."</td>
                        <td><a href=\"?cmd=softpad&act=cad&param=".$value->idtb_soft_padronizados."\">Editar</a> - 
                            Desativar</td>
                    </tr>";
    };
    echo"
                </tbody>
            </table>
            </div>";
}

/* Método INSERT/UPDATE */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){
        $idtb_soft_padronizados = $_POST['idtb_soft_padronizados'];
        $soft->idtb_soft_padronizados = $idtb_soft_padronizados;
        $soft->categoria = mb_strtoupper($_POST['categoria'],'UTF-8');
        $soft->software = mb_strtoupper($_POST['software'],'UTF-8');
        $soft->status = mb_strtoupper($_POST['status'],'UTF-8');
        
        if ($idtb_soft_padronizados){
            $row = $soft->UpdateSoftware();    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=softpad\">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }
        else {
            $row = $soft->InsertSoftware();    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=softpad\">";
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