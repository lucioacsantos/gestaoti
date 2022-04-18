<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$militar = new Militar();

/* Recupera informações */
$row = $militar->SelectAllEspec();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Especialidades cadastradas,<br />
		 clique <a href=\"?cmd=especialidade&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $militar->idtb_especialidade = $param;
        $especialidade = $militar->SelectIDEspec();
    }
    else{
        $especialidade = (object)['idtb_especialidade'=>'','nome'=>'', 'sigla'=>'','exibir'=>''];
    }
    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"especialidade\" role=\"form\" action=\"?cmd=especialidade&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Posto/Graduação - Cadastro</legend>

                            <div class=\"form-group\">
                                <label for=\"nome\">Especialidade:</label>
                                <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                       placeholder=\"ex. Eletrônica\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$especialidade->nome\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"sigla\">Sigla:</label>
                                <input id=\"sigla\" class=\"form-control\" type=\"text\" name=\"sigla\"
                                       placeholder=\"ex. ET\" style=\"text-transform:uppercase\" 
                                       required=\"true\" value=\"$especialidade->sigla\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"exibir\">Exibir:</label>
                                <select id=\"exibir\" class=\"form-control\" name=\"exibir\">
                                    <option value=\"$especialidade->exibir\" selected=\"true\">
                                        $especialidade->exibir</option>
                                    <option value=\"SIM\">SIM</option>
                                    <option value=\"NÃO\">NÃO</option>
                                </select>
                            </div>

                        </fieldset>
                        <input type=\"hidden\" name=\"idtb_especialidade\" value=\"$especialidade->idtb_especialidade\">
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
                        <th scope=\"col\">Especialidade.</th>
                        <th scope=\"col\">Sigla</th>
                        <th scope=\"col\">Exibir</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    $especialidade = $militar->SelectAllEspec();
    foreach ($especialidade as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->nome."</th>
                        <td>".$value->sigla."</td>
                        <td>".$value->exibir."</td>
                        <td><a href=\"?cmd=especialidade&act=cad&param=".$value->idtb_especialidade."\">
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
        $idtb_especialidade = $_POST['idtb_especialidade'];
        $militar->idtb_especialidade = $_POST['idtb_especialidade'];
        $militar->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $militar->sigla = mb_strtoupper($_POST['sigla'],'UTF-8');
        $militar->exibir = mb_strtoupper($_POST['exibir'],'UTF-8');
        
        if ($idtb_especialidade){
            
            $row = $militar->UpdateEspec();
    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=especialidade\">";
            }
    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }

        else{
            
            $row = $militar->InsertEspec();
    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=especialidade\">";
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