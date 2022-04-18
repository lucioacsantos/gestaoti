<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Clasee de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$config = new Config();

/* Recupera informações do CLTI */
$row = $config->SelectAllCLTI();

@$act = $_GET['act'];

/* Checa se há cadastro do CLTI */
if (($row == '0') AND ($act == NULL)) {
	echo "<h5>Não há um CLTI cadastrado, clique <a href=\"?cmd=gerclti&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carregar form para cadastro do CLTI */
if ($act == 'cad') {
    @$param = $_GET['param'];

    if ($param){
        $config->idtb_clti = $param;
        $gerclti = $config->SelectIdCLTI();
    }
    else{
        $gerclti = (object)['idtb_admin'=>'','nome'=>'','sigla'=>'','indicativo'=>'','data_ativacao'=>''];
    }
    
	echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"form\" action=\"?cmd=gerclti&act=insert\" method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>";
                            #Prepara formulário para atualização de dados
                            if ($param){
                                echo"
                                <legend>CLTI - Cadastro</legend>

                                    <input id=\"idclti\" class=\"form-control\" name=\"idclti\"
                                        value=\"$gerclti->idtb_clti\" hidden=\"true\">

                                    <div class=\"form-group\">
                                        <label for=\"nomeclti\">Nome do CLTI:</label>
                                        <input id=\"nomeclti\" class=\"form-control\" type=\"text\" name=\"nomeclti\"
                                            value=\"$gerclti->nome\" minlength=\"2\" required=\"true\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"siglaclti\">Sigla do CLTI:</label>
                                        <input id=\"siglaclti\" class=\"form-control\" type=\"text\" name=\"siglaclti\"
                                        value=\"$gerclti->sigla\" minlength=\"2\" required=\"true\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"indicativoclti\">Indicativo Naval do CLTI:</label>
                                        <input id=\"indicativoclti\" class=\"form-control\" type=\"text\" name=\"indicativoclti\"
                                        value=\"$gerclti->indicativo\" minlength=\"2\" required=\"true\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"dataativacao\">Data de Ativação do CLTI:</label>
                                        <input id=\"dataativacao\" class=\"form-control\" type=\"date\" name=\"dataativacao\"
                                        value=\"$gerclti->data_ativacao\" minlength=\"2\" required=\"true\">
                                    </div>";
                            }
                            else{
                                echo"
                                    <legend>CLTI - Cadastro</legend>

                                    <div class=\"form-group\">
                                        <label for=\"nomeclti\">Nome do CLTI:</label>
                                        <input id=\"nomeclti\" class=\"form-control\" type=\"text\" name=\"nomeclti\"
                                            placeholder=\"Nome do CLTI\" minlength=\"2\" required=\"true\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"siglaclti\">Sigla do CLTI:</label>
                                        <input id=\"siglaclti\" class=\"form-control\" type=\"text\" name=\"siglaclti\"
                                            placeholder=\"Sigla do CLTI\" minlength=\"2\" required=\"true\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"indicativoclti\">Indicativo Naval do CLTI:</label>
                                        <input id=\"indicativoclti\" class=\"form-control\" type=\"text\" name=\"indicativoclti\"
                                            placeholder=\"Indicativo Naval do CLTI\" minlength=\"2\" required=\"true\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"dataativacao\">Data de Ativação do CLTI:</label>
                                        <input id=\"dataativacao\" class=\"form-control\" type=\"date\" name=\"dataativacao\"
                                            placeholder=\"Data de Ativação do CLTI\" minlength=\"2\" required=\"true\" autocomplete=\"off\">
                                    </div>";
                            }
                        echo"
                        </fieldset>
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/** Monta quadro */
if (($row) AND ($act == NULL)) {
   
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Nome do CLTI</th>
                        <th scope=\"col\">Sigla</th>
                        <th scope=\"col\">Indicativo</th>
                        <th scope=\"col\">Data de Ativação</th>
                        <th scope=\"col\">Lotação de Oficiais</th>
                        <th scope=\"col\">Lotação de Praças</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>
                <tr>
                    <td>".$row->nome."</td>
                    <td>".$row->sigla."</td>
                    <td>".$row->indicativo."</td>
                    <td>".$row->data_ativacao."</td>
                    <td>".$row->efetivo_oficiais."</td>
                    <td>".$row->efetivo_pracas."</td>
                    <td><a href=\"?cmd=gerclti&act=cad&param=".$row->idtb_clti."\">Editar</a> - 
                        Excluir</td>
                </tr>
                </tbody>
            </table>
            </div>";
}

/* Método INSERT/UPDATE */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){

        @$idtb_clti = $_POST['idclti'];
        $config->idtb_clti = $idtb_clti;
        $config->nome = $_POST['nomeclti'];
        $config->sigla = $_POST['siglaclti'];
        $config->indicativo = $_POST['indicativoclti'];
        $config->data_ativacao = $_POST['dataativacao'];

        /* Opta pelo Método Update */
        if ($idtb_clti){
            $row = $config->UpdateCLTI();    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=gerclti\">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            }
        }
        else{
            $row = $config->InsertCLTI();    
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=gerclti\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            }
        }
    }
    else{
        echo "<h5>Ocorreu algum erro, usuário não autenticado.</h5>
            <meta http-equiv=\"refresh\" content=\"1;$url\">";
    }
}
?>