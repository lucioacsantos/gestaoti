<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$militar = new Militar();

/* Recupera informações */
$row = $militar->SelectAllPostoGrad();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Postos/Graduações cadastrados,<br />
		 clique <a href=\"?cmd=postograds&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $militar->idtb_posto_grad = $param;
        $postograd = $militar->SelectIDPostoGrad();
    }
    else{
        $postograd = (object)['idtb_posto_grad'=>'','nome'=>'', 'sigla'=>''];
    }
    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"postograd\" role=\"form\" action=\"?cmd=postograd&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Posto/Graduação - Cadastro</legend>

                            <div class=\"form-group\">
                                <label for=\"nome\">Posto/Graduação:</label>
                                <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                       placeholder=\"ex. Terceiro Sargento\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$postograd->nome\" autocomplete=\"off\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"sigla\">Sigla:</label>
                                <input id=\"sigla\" class=\"form-control\" type=\"text\" name=\"sigla\"
                                       placeholder=\"ex. 3ºSG\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$postograd->sigla\" autocomplete=\"off\">
                            </div>

                        </fieldset>
                        <input type=\"hidden\" name=\"idtb_posto_grad\" value=\"$postograd->idtb_posto_grad\">
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
                        <th scope=\"col\">Posto/Grad.</th>
                        <th scope=\"col\">Sigla</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    $postograd = $militar->SelectAllPostoGrad();
    foreach ($postograd as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->nome."</th>
                        <td>".$value->sigla."</td>
                        <td><a href=\"?cmd=postograd&act=cad&param=".$value->idtb_posto_grad."\">
                                Editar</a>
                        </td>
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
        $idtb_posto_grad = $_POST['idtb_posto_grad'];
        $militar->idtb_posto_grad = $_POST['idtb_posto_grad'];
        $militar->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $militar->sigla = mb_strtoupper($_POST['sigla'],'UTF-8');
        
        if ($idtb_posto_grad){
            
            $row = $militar->UpdatePostoGrad();
    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=postograd\">";
            }
    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }

        else{
            
            $row = $militar->InsertPostoGrad();
    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=postograd\">";
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