<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$funcsigdem = new FuncSiGDEM();
$om = new OMApoiadas();
$pesom = new PessoalOM();

$omapoiada = $_SESSION['id_om_apoiada'];
$om->idtb_om_apoiadas = $omapoiada;

/* Recupera informações */
$row = $funcsigdem->SelectAll();

@$act = $_GET['act'];

/* Checa Informações */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Funções do SiGDEM cadastradas,<br />
		 clique <a href=\"?cmd=funcsigdem&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $funcsigdem->idtb_funcoes_sigdem = $param;
        $funcaosigdem = $funcsigdem->SelectId();
        $pesom->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
        $pessoal = $pesom->SelectIdOMPesOM();
    }
    else{
        $pesom->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
        $pessoal = $pesom->SelectIdOMPesOM();
        $funcaosigdem = (object)['idtb_funcoes_sigdem'=>'','idtb_om_apoiadas'=>'','descricao'=>'','sigla'=>'', 
            'idtb_pessoal_om'=>'','posto_grad'=>'','espec'=>'','nome_guerra'=>''];
    }

    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"funcsigdem\" role=\"form\" action=\"?cmd=funcsigdem&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                        <legend>Função do SiGDEM - Cadastro</legend>
                            <div class=\"form-group\">
                                <label for=\"descricao\">Descrição:</label>
                                <input id=\"descricao\" class=\"form-control\" type=\"text\" name=\"descricao\"
                                    placeholder=\"ex. Encarregado do CLTI\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                                    required=\"true\" autofocus=\"true\" value=\"$funcaosigdem->descricao\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"sigla\">Sigla:</label>
                                <input id=\"sigla\" class=\"form-control\" type=\"text\" name=\"sigla\"
                                    placeholder=\"ex. DN-01.6\" style=\"text-transform:uppercase\" autocomplete=\"off\"
                                    required=\"true\" value=\"$funcaosigdem->sigla\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"idtb_pessoal_om\">Usuário Responsável:</label>
                                <select id=\"idtb_pessoal_om\" class=\"form-control\" name=\"idtb_pessoal_om\">
                                    <option value=\"$funcaosigdem->idtb_pessoal_om\" selected=\"true\">
                                        $funcaosigdem->posto_grad-$funcaosigdem->espec $funcaosigdem->nome_guerra</option>";
                                    foreach ($pessoal as $key => $value) {
                                        echo"<option value=\"".$value->idtb_pessoal_om."\">
                                            ".$value->posto_grad."-".$value->espec." ".$value->nome_guerra."</option>";
                                    };
                                echo "</select>
                            </div>
                        </fieldset>
                        <input id=\"idtb_funcoes_sigdem\" type=\"hidden\" name=\"idtb_funcoes_sigdem\" 
                            value=\"$funcaosigdem->idtb_funcoes_sigdem\">
                        <input type=\"hidden\" name=\"idtb_om_apoiadas\" value=\"$omapoiada\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro */
if (($row) AND ($act == NULL)) {
    $funcsigdem->idtb_om_apoiadas = $omapoiada;
    $funcoessigdem = $funcsigdem->SelectOMAll();
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Descrição</th>
                        <th scope=\"col\">Sigla</th>
                        <th scope=\"col\">Posto/Grad./Esp.</th>
                        <th scope=\"col\">Nome de Guerra</th>
                    </tr>
                </thead>";
    foreach ($funcoessigdem as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->descricao."</th>
                        <td>".$value->sigla."</td>";
                        if (($value->exibir_espec == 'NÃO') AND ($value->exibir_corpo_quadro == 'NÃO')){
                            echo"
                            <th scope=\"row\">".$value->posto_grad."</th>";
                        }
                        elseif (($value->exibir_espec == 'NÃO') AND ($value->exibir_corpo_quadro != 'NÃO')){
                            echo"
                            <th scope=\"row\">".$value->posto_grad." ".$value->corpo_quadro."</th>";
                        }
                        elseif (($value->exibir_espec != 'NÃO') AND ($value->exibir_corpo_quadro == 'NÃO')){
                            echo"
                            <th scope=\"row\">".$value->posto_grad." ".$value->espec."</th>";
                        }
                        else {
                            echo"
                            <th scope=\"row\">".$value->posto_grad." ".$value->corpo_quadro." 
                                    ".$value->espec."</th>";
                        }
                            echo"
                        <td>".$value->nome_guerra."</td>
                        <td><a href=\"?cmd=funcsigdem&act=cad&param=".$value->idtb_funcoes_sigdem."\">Editar</a></td>
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
        $idtb_funcoes_sigdem = $_POST['idtb_funcoes_sigdem'];
        $funcsigdem->idtb_funcoes_sigdem = $idtb_funcoes_sigdem;
        $funcsigdem->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $funcsigdem->descricao = mb_strtoupper($_POST['descricao'],'UTF-8');
        $funcsigdem->sigla = mb_strtoupper($_POST['sigla'],'UTF-8');
        $funcsigdem->idtb_pessoal_om = $_POST['idtb_pessoal_om'];

        /* Opta pelo Método Update */
        if ($idtb_funcoes_sigdem){
            $row = $funcsigdem->UpdateFuncao();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=funcsigdem \">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }        
        else{
            /* Opta pelo Método Insert */
            $row = $funcsigdem->InsertFuncao();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=funcsigdem\">";
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