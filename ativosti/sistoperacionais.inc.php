<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$so = new SO();

/* Recupera informações */
$row = $so->SelectAllSO();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Sistemas Operacionais cadastrados,<br />
		 clique <a href=\"?cmd=sistoperacionais&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $so->idtb_sor = $param;
        $sor = $so->SelectIdSO();
    }
    else{
        $sor = (object)['idtb_sor'=>'','desenvolvedor'=>'','descricao'=>'','versao'=>'','situacao'=>''];
    }
    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"insertso\" role=\"form\" action=\"?cmd=sistoperacionais&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Sistemas Operacionais - Cadastro</legend>

                            <div class=\"form-group\">
                                <label for=\"desenvolvedor\">Desenvolvedor:</label>
                                <input id=\"desenvolvedor\" class=\"form-control\" type=\"text\" name=\"desenvolvedor\"
                                       placeholder=\"Desenvolvedor\" style=\"text-transform:uppercase\" autofocus=\"true\"
                                       required=\"true\" value=\"$sor->desenvolvedor\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"descricao\">Descrição:</label>
                                <input id=\"descricao\" class=\"form-control\" type=\"text\" name=\"descricao\"
                                       placeholder=\"Descrição\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$sor->descricao\" autocomplete=\"off\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"versao\">Versão:</label>
                                <input id=\"versao\" class=\"form-control\" type=\"text\" name=\"versao\"
                                       placeholder=\"Versão\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$sor->versao\" autocomplete=\"off\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"situacao\">Situação:</label>
                                <select id=\"situacao\" class=\"form-control\" name=\"situacao\">
                                <option value=\"$sor->situacao\" selected=\"true\">$sor->situacao</option>
                                    <option value=\"ATIVO\">Ativo</option>
                                    <option value=\"DESCONTINUADO\">Descontinuado</option>
                                </select>
                            </div>

                        </fieldset>
                        <input type=\"hidden\" name=\"idtb_sor\" value=\"$sor->idtb_sor\">
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
                        <th scope=\"col\">Desenvolvedor</th>
                        <th scope=\"col\">Descrição</th>
                        <th scope=\"col\">Versão</th>
                        <th scope=\"col\">Situação</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    $ordena = "ORDER BY desenvolvedor,versao ASC";
    $sor = $so->SelectAllSO();
    echo "<p>Sistemas Operacionais: </p>";
    foreach ($sor as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->desenvolvedor."</th>
                        <td>".$value->descricao."</td>
                        <td>".$value->versao."</td>
                        <td>".$value->situacao."</td>
                        <td><a href=\"?cmd=sistoperacionais&act=cad&param=".$value->idtb_sor."\">Editar</a> - 
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
        $idtb_sor = $_POST['idtb_sor'];
        $so->idtb_sor = $_POST['idtb_sor'];
        $so->desenvolvedor = strtoupper($_POST['desenvolvedor']);
        $so->descricao = strtoupper($_POST['descricao']);
        $so->versao = strtoupper($_POST['versao']);
        $so->situacao = $_POST['situacao'];
        
        if ($idtb_sor){
            
            $row = $so->UpdateSO();
    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=sistoperacionais\">";
            }
    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }

        else {
            
            $row = $so->InsertSO();
    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=sistoperacionais\">";
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