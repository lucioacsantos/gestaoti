<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$cfg = new Config();

/* Recupera informações */
$row = $cfg->SelectAll();

$cmd = $_GET['cmd'];
$act = $_GET['act'];

if ($row) {
    $config = $cfg->SelectAll();
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Parâmetro</th>
                        <th scope=\"col\">Configuração</th>
                        <th scope=\"col\">Novo Parâmetro</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    foreach ($config as $key => $value){
        
        echo"       <tr>
                        <th scope=\"row\">".$value->parametro."</th>
                        <td>".$value->valor."</td>
                        <td>
                            <form id=\"form\" action=\"?cmd=sistema&act=update\" method=\"post\" enctype=\"multipart/form-data\">
                                <input id=\"valor\" class=\"form-control\" type=\"text\" name=\"valor\"
                                       placeholder=\"Novo Parâmetro\" required=\"true\" autocomplete=\"off\">
                                <input id=\"idtb_config\" class=\"form-control\" type=\"text\" name=\"idtb_config\" 
                                    value=\"$value->idtb_config\" hidden=\"true\" autocomplete=\"off\">
                        </td>
                        <td>
                                <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                            </form>
                        </td>
                    </tr>";
    }
    echo"
                </tbody>
            </table>
            </div>";
}

/* Método UPDATE */
if ($act == 'update') {
    if (isset($_SESSION['status'])){
        $cfg->valor = $_POST['valor'];
        $cfg->idtb_config = $_POST['idtb_config'];
        $row = $cfg->UpdateConfig();
        if ($row) {
            echo "<h5>Resgistros incluídos no banco de dados.</h5>
            <meta http-equiv=\"refresh\" content=\"1;url=?cmd=sistema\">";
        }
        else {
            echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
        }
    }
    else{
        echo "<h5>Ocorreu algum erro, usuário não autenticado.</h5>
            <meta http-equiv=\"refresh\" content=\"1;$url\">";
    }
}
?>