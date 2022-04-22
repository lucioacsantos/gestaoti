<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$fti = new PessoalTI();

/* Recupera informações */
$row = $fti->SelectAllFuncoesTI();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Funções de TI cadastradas,<br />
		 clique <a href=\"?cmd=funcoesti&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $fti->idtb_funcoes_ti = $param;
        $funcoesti = $fti->SelectIdFuncoesTI();
    }
    else{
        $funcoesti = (object)['idtb_funcoes_ti'=>'','descricao'=>'','sigla'=>''];
    }
    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"insertso\" role=\"form\" action=\"?cmd=funcoesti&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Funções de TI - Cadastro</legend>

                            <div class=\"form-group\">
                                <label for=\"descricao\">Descrição:</label>
                                <input id=\"descricao\" class=\"form-control\" type=\"text\" name=\"descricao\"
                                       placeholder=\"ex. Administrador da Rede Local\" autocomplete=\"off\"
                                       style=\"text-transform:uppercase\" autofocus=\"true\"
                                       required=\"true\" value=\"$funcoesti->descricao\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"sigla\">Sigla:</label>
                                <input id=\"sigla\" class=\"form-control\" type=\"text\" name=\"sigla\"
                                       placeholder=\"ex. ADMIN\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                                       required=\"true\" value=\"$funcoesti->sigla\">
                            </div>

                        </fieldset>
                        <input type=\"hidden\" name=\"idtb_funcoes_ti\" value=\"$funcoesti->idtb_funcoes_ti\">
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
                        <th scope=\"col\">Descrição</th>
                        <th scope=\"col\">Sigla</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";
    $fti->ordena = "ORDER BY descricao ASC";
    $funcoesti = $fti->SelectAllFuncoesTI();

    foreach ($funcoesti as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->descricao."</th>
                        <td>".$value->sigla."</td>
                        <td><a href=\"?cmd=funcoesti&act=cad&param=".$value->idtb_funcoes_ti."\">Editar</a> - 
                            Excluir</td>
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
        $idtb_funcoes_ti = $_POST['idtb_funcoes_ti'];
        $fti->idtb_funcoes_ti = $idtb_funcoes_ti;
        $fti->descricao = mb_strtoupper($_POST['descricao'],'UTF-8');
        $fti->sigla = mb_strtoupper($_POST['sigla'],'UTF-8');
        
        if ($idtb_funcoes_ti){
            $row = $fti->UpdateFuncoesTI();    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=funcoesti\">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }
        else {
            $row = $fti->InsertFuncoesTI();    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=funcoesti\">";
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