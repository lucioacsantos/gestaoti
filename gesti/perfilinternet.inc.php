<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$perfil = new PerfilInternet();

/* Recupera informações */
$row = $perfil->SelectAll();

@$act = $_GET['act'];

/* Checa Informações */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Perfis de Internet cadastrados,<br />
		 clique <a href=\"?cmd=perfilinternet&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $perfil->idtb_perfil_internet = $param;
        $perfilid = $perfil->SelectId();
    }
    else{
        $perfilid = (object)['idtb_perfil_internet'=>'','nome'=>'','status'=>''];
    }

    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"insereperfilinterent\" role=\"form\" action=\"?cmd=perfilinternet&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                        <legend>Perfil de Internet - Cadastro</legend>
                            <div class=\"form-group\">
                                <label for=\"nome\">Nome do Perfil:</label>
                                <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                    placeholder=\"ex. Padrão\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                                    required=\"true\" autofocus=\"true\" value=\"$perfilid->nome\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"status\">Código do Perfil:</label>
                                <select id=\"status\" class=\"form-control\" name=\"status\">
                                    <option value=\"$perfilid->status\" selected=\"true\">$perfilid->status</option>
                                    <option value=\"ATIVO\">ATIVO</option>
                                    <option value=\"INATIVO\">INATIVO</option>
                                </select>
                            </div>                            
                        </fieldset>
                        <input id=\"idtb_perfil_internet\" type=\"hidden\" name=\"idtb_perfil_internet\" 
                            value=\"$perfilid->idtb_perfil_internet\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro */
if (($row) AND ($act == NULL)) {
    $perfis = $perfil->SelectAll();
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Id</th>
                        <th scope=\"col\">Nome</th>
                        <th scope=\"col\">Status</th>
                    </tr>
                </thead>";
    foreach ($perfis as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->idtb_perfil_internet."</th>
                        <td>".$value->nome."</td>
                        <td>".$value->status."</td>
                        <td><a href=\"?cmd=perfilinternet&act=cad&param=".$value->idtb_perfil_internet."\">Editar</a></td>
                    </tr>";
    }
    echo"
                </tbody>
            </table>
            </div>";
}
/* Método INSERT/UPDATE */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){
        $idtb_perfil_internet = $_POST['idtb_perfil_internet'];
        $perfil->idtb_perfil_internet = $idtb_perfil_internet;
        $perfil->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $perfil->status = mb_strtoupper($_POST['status'],'UTF-8');

        /* Opta pelo Método Update */
        if ($idtb_perfil_internet){
            $row = $perfil->UpdatePerfil();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=perfilinternet \">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }        
        else{
            /* Opta pelo Método Insert */
            $row = $perfil->InsertPerfil();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=perfilinternet\">";
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