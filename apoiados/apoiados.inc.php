<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$apoiados = new OrgaosApoiados();
$cfg = new Config();

/* Recupera informações */
$row = $apoiados->SelectApoiados();

@$act = $_GET['act'];

/* Checa se há OM cadastradas */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Órgãos Apoiados cadastradoas,<br />
		 clique <a href=\"?cmd=apoiados&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro de OM */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $apoiados->idtb_orgaos_apoiados = $param;
        $om = $apoiados->SelectApoiadosId();
        $apoiados->estado = $om->idtb_estado;
        $estado = $apoiados->SelectEstadoId();
        $apoiados->cidade = $om->idtb_cidade;
        $cidade = $apoiados->SelectCidadeId();
    }
    else{
        $row = $cfg->SelectEstado();
        $ESTADO = $row->valor;
        $row = $cfg->SelectCidade();
        $CIDADE = $row->valor;
        $om = (object)['idtb_orgaos_apoiados'=>'','cnpj'=>'','nome'=>'','sigla'=>''];
        $estado = (object)['uf'=>$ESTADO];
        $cidade = (object)['nome'=>$CIDADE];
    }
    
	echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"insertom\" action=\"?cmd=apoiados&act=insert\" method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                            <legend>Órgãos Apoiados - Cadastro</legend>

                            <div class=\"form-group\">
                                <label for=\"estado\">Selecione o Estado:</label>
                                <select id=\"estado\" class=\"form-control\" name=\"estado\" value=\"$estado->uf\"></select>
                            </div>

                            <div class=\"form-group\">
                                <label for=\"cidade\">Selecione a Cidade:</label>
                                <select id=\"cidade\" class=\"form-control\" name=\"cidade\" value=\"$cidade->nome\"></select>
                            </div>

                            <div class=\"form-group\">
                                <label for=\"cnpj\">CNPJ:</label>
                                <input id=\"cnpj\" class=\"form-control\" type=\"number\" name=\"cnpj\"
                                       placeholder=\"CNPJ\" maxlength=\"15\" required=\"true\" 
                                       value=\"$om->cnpj\" autocomplete=\"off\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"nome\">Nome do Órgão:</label>
                                <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                       style=\"text-transform:uppercase\" placeholder=\"Nome do Órgão\" 
                                       minlength=\"2\" required=\"true\" value=\"$om->nome\" autocomplete=\"off\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"sigla\">Sigla do Órgão:</label>
                                <input id=\"sigla\" class=\"form-control\" type=\"text\" name=\"sigla\"
                                       style=\"text-transform:uppercase\" placeholder=\"Sigla do Órgão\" 
                                       minlength=\"2\" required=\"true\" value=\"$om->sigla\" autocomplete=\"off\">
                            </div>

                        </fieldset>
                        <input id=\"idtb_orgaos_apoiados\" type=\"hidden\" name=\"idtb_orgaos_apoiados\" value=\"$om->idtb_orgaos_apoiados\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro de OM */
if (($row) AND ($act == NULL)) {

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">CNPJ</th>
                        <th scope=\"col\">Nome</th>
                        <th scope=\"col\">Sigla</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    $apoiados->ordena = "ORDER BY nome ASC";
    $om = $apoiados->SelectApoiados();

    foreach ($om as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$apoiados->FormatCNPJ($value->cnpj)."</th>
                        <td>".$value->nome."</td>
                        <td>".$value->sigla."</td>
                        <td><a href=\"?cmd=apoiados&act=cad&param=".$value->idtb_orgaos_apoiados."\">Editar</a> - 
                            Excluir</td>
                    </tr>";
    };
    echo"
                </tbody>
            </table>
            </div>";
}

/* Método INSERT / UPDATE */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){
        $idtb_orgaos_apoiados = $_POST['idtb_orgaos_apoiados'];
        $apoiados->idtb_orgaos_apoiados = $idtb_orgaos_apoiados;
        $apoiados->estado = $_POST['estado'];
        $apoiados->cidade = $_POST['cidade'];
        $apoiados->cnpj = $_POST['cnpj'];
        $apoiados->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $apoiados->sigla = mb_strtoupper($_POST['sigla'],'UTF-8');
        $apoiados->estado = $apoiados->SelectEstadoUf();
        $apoiados->cidade = $apoiados->SelectNomeCidade();

        # Opta pelo método UPDATE
        if ($idtb_orgaos_apoiados){
            $row = $apoiados->UpdateApoiados();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=apoiados\">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }

        # Opta pelo método INSERT
        else{
            $row = $apoiados->InsertApoiados();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=apoiados\">";
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