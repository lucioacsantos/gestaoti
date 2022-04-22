<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$om = new OMAPoiadas();
$pom = new PessoalOM();
$et = new Estacoes();
$fs = new FuncSiGDEM();
$config = new Config();
$mil = new Militar();

/* Recupera informações */
$pom->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
$row = $pom->SelectIdOMPesOM();

@$act = $_GET['act'];

/* Checa Informações */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Pessoal cadastrado,<br />
		 clique <a href=\"?cmd=pessoalom&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $pom->idtb_pessoal_om = $param;
        $pessom = $pom->SelectIdPesOM();
        $readyonly = "readonly";
    }
    else{
        $pessom = (object)['idtb_pessoal_om'=>'','nip'=>'','cpf'=>'','nome'=>'','nome_guerra'=>'',
            'idtb_om_apoiadas'=>'','sigla_om'=>'','idtb_posto_grad'=>'8','sigla_posto_grad'=>'Primeiro Tenente',
            'idtb_corpo_quadro'=>'','sigla_corpo_quadro'=>'','idtb_especialidade'=>'','sigla_espec'=>'',
            'correio_eletronico'=>'','idtb_funcoes_sigdem'=>'','sigla'=>'','posto_grad'=>'Primeiro Tenente'];
        $readyonly = "";
    }
    $om->ordena = "ORDER BY sigla ASC";
	$omapoiada = $om->SelectAllOMTable();
    $postograd = $mil->SelectAllPostoGrad();
    $corpoquadro = $mil->SelectAllCorpoQuadro();
    $especialidade = $mil->SelectAllEspec();
    $idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"insereusuario\" role=\"form\" action=\"?cmd=pessoalom&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Pessoal da OM - Alteração</legend>
                            <input type=\"hidden\" name=\"idtb_om_apoiadas\" value=\"$idtb_om_apoiadas\">
                            <div class=\"form-group\">
                                <label for=\"postograd\">Posto/Graduação:</label>
                                <select id=\"postograd\" class=\"form-control\" name=\"postograd\">
                                    <option value=\"$pessom->idtb_posto_grad\" selected=\"true\">
                                        $pessom->posto_grad</option>";
                                    foreach ($postograd as $key => $value) {
                                        echo"<option value=\"".$value->idtb_posto_grad."\">
                                            ".$value->nome."</option>";
                                    };
                                echo "</select>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"corpoquadro\">Corpo/Quadro:</label>
                                <select id=\"corpoquadro\" class=\"form-control\" name=\"corpoquadro\">
                                    <option value=\"$pessom->idtb_corpo_quadro\" selected=\"true\">
                                        $pessom->corpo_quadro</option>";
                                    foreach ($corpoquadro as $key => $value) {
                                        echo"<option value=\"".$value->idtb_corpo_quadro."\">
                                            ".$value->nome."</option>";
                                    };
                                echo "</select>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"especialidade\">Especialidade:</label>
                                <select id=\"especialidade\" class=\"form-control\" name=\"especialidade\">
                                    <option value=\"$pessom->idtb_especialidade\" selected=\"true\">
                                        $pessom->espec</option>";
                                    foreach ($especialidade as $key => $value) {
                                        echo"<option value=\"".$value->idtb_especialidade."\">
                                            ".$value->nome."</option>";
                                    };
                                echo "</select>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"nome\">Nome Completo:</label>
                                <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                    placeholder=\"Nome Completo\" minlength=\"2\" autocomplete=\"off\"
                                    style=\"text-transform:uppercase\" required=\"true\" value=\"$pessom->nome\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"nomeguerra\">Nome de Guerra:</label>
                                <input id=\"nomeguerra\" class=\"form-control\" type=\"text\" name=\"nomeguerra\"
                                    placeholder=\"Nome de Guerra\" minlength=\"2\" autocomplete=\"off\"
                                    style=\"text-transform:uppercase\" required=\"true\" value=\"$pessom->nome_guerra\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"nip\">NIP:</label>
                                <input id=\"nip\" class=\"form-control\" type=\"text\" name=\"nip\" $readyonly
                                    placeholder=\"NIP\" maxlength=\"8\" required=\"true\" value=\"$pessom->nip\" 
                                    autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"cpf\">CPF (Servidores Civis):</label>
                                <input id=\"cpf\" class=\"form-control\" type=\"text\" name=\"cpf\" $readyonly
                                    placeholder=\"CPF (Servidores Civis)\" maxlength=\"11\" value=\"$pessom->cpf\" 
                                    autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"correio_eletronico\">Correio Eletrônico:</label>
                                <input id=\"correio_eletronico\" class=\"form-control\" type=\"email\" autocomplete=\"off\"
                                    name=\"correio_eletronico\" placeholder=\"Preferencialmente Zimbra\" 
                                    minlength=\"2\" style=\"text-transform:uppercase\" required=\"true\" 
                                    value=\"$pessom->correio_eletronico\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"foradaareati\">Fora da Área de TI:</label>
                                <select id=\"foradaareati\" class=\"form-control\" name=\"foradaareati\">
                                    <option value=\"$pessom->foradaareati\" selected=\"true\">$pessom->foradaareati</option>
                                    <option value=\"NÃO\">NÃO</option>
                                    <option value=\"SIM\">SIM</option>
                                </select>
                                <div class=\"help-block with-errors\"></div>
                            </div>
                            <div class=\"form-group\">
                                <label for=\"ativo\" class=\"control-label\">Situação:</label>
                                <select id=\"ativo\" class=\"form-control\" name=\"ativo\">
                                    <option value=\"$pessom->status\" selected=\"true\">$pessom->status</option>
                                    <option value=\"ATIVO\">ATIVO</option>
                                    <option value=\"INATIVO\">INATIVO</option>
                                </select>
                                <div class=\"help-block with-errors\"></div>
                            </div>
                        </fieldset>
                        <input id=\"idtb_pessoal_om\" type=\"hidden\" name=\"idtb_pessoal_om\" value=\"$pessom->idtb_pessoal_om\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro */
if (($row) AND ($act == NULL)) {
    $pom->ordena = "ORDER BY idtb_posto_grad DESC";
    $pom->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
    $pom->ordena = "ORDER BY idtb_posto_grad ASC";
    $pessom = $pom->SelectIdOMPesOM();
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Posto/Grad./Esp.</th>
                        <th scope=\"col\">NIP/CPF</th>
                        <th scope=\"col\">Nome de Guerra</th>
                        <th scope=\"col\">Correio Eletrônico</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";
    foreach ($pessom as $key => $value) {
        #Seleciona NIP caso seja militar da MB
        if ($value->nip != NULL) {
            $identificacao = $value->nip;
        }
        else{
            $identificacao = $value->cpf;
        }
        echo"       <tr>";
        if (($value->exibir_espec == 'NÃO') AND ($value->exibir_corpo_quadro == 'NÃO')){
            echo"       <th scope=\"row\">".$value->posto_grad."</th>";
        }
        elseif (($value->exibir_espec == 'NÃO') AND ($value->exibir_corpo_quadro != 'NÃO')){
            echo"       <th scope=\"row\">".$value->posto_grad." ".$value->corpo_quadro."</th>";
        }
        elseif (($value->exibir_espec != 'NÃO') AND ($value->exibir_corpo_quadro == 'NÃO')){
            echo"       <th scope=\"row\">".$value->posto_grad." ".$value->espec."</th>";
        }
        else {
            echo"       <th scope=\"row\">".$value->posto_grad." ".$value->corpo_quadro." 
                            ".$value->espec."</th>";
        }
            echo"       <td>".$identificacao."</td>
                        <td>".$value->nome_guerra."</td>
                        <td>".$value->correio_eletronico."</td>
                        <td><a href=\"?cmd=pessoalom&act=cad&param=".$value->idtb_pessoal_om."\">Editar</a></td>
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
        $idtb_pessoal_om = $_POST['idtb_pessoal_om'];
        $pom->idtb_pessoal_om = $idtb_pessoal_om;
        $pom->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $pom->idtb_posto_grad = $_POST['postograd'];
        $pom->idtb_corpo_quadro = $_POST['corpoquadro'];
        $pom->idtb_especialidade = $_POST['especialidade'];
        $nip = $_POST['nip'];
        $cpf = $_POST['cpf'];
        $pom->nip = $nip;
        $pom->cpf = $cpf;
        $pom->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $pom->nome_guerra = mb_strtoupper($_POST['nomeguerra'],'UTF-8');
        $pom->correio_eletronico = mb_strtoupper($_POST['correio_eletronico'],'UTF-8');
        $foradaareati = mb_strtoupper($_POST['foradaareati'],'UTF-8');
        $status = mb_strtoupper($_POST['ativo'],'UTF-8');
        if ($foradaareati == NULL){
            $pom->foradaareati = "NÃO";
        }
        else{
            $pom->foradaareati = $foradaareati;
        }
        if ($status == NULL){
            $pom->status = "ATIVO";
        }
        else{
            $pom->status = $status;
        }
        if ($nip == NULL) {
            $usuario = $cpf;
        }
        else {
            $usuario = $nip;
        }
        $pom->usuario = $usuario;
        /* Opta pelo Método Update */
        if ($idtb_pessoal_om){
            $row = $pom->UpdatePesOM();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=pessoalom \">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }        
        else{
            /* Checa se há Usuário com mesmo NIP/CPF cadastrado */
            $row = $pom->ChecaNIPCPF();
            if ($row) {
                echo "<h5>Já existe um Usuário cadastrado com esse NIP/CPF.</h5>";
            }
            $row = $pom->ChecaCorreio();
            if ($row) {
                echo "<h5>Já existe um Admin cadastrado com esse Correio Eletrônico.</h5>";
            }
            else {
                $row = $pom->InsertPesOM();
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;?cmd=pessoalom\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    echo(pg_result_error($row) . "<br />\n");
                }
            }
        }
    }
    else{
        echo "<h5>Ocorreu algum erro, usuário não autenticado.</h5>
            <meta http-equiv=\"refresh\" content=\"1;$url\">";
    }
}
?>