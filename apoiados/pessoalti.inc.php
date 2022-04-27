<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$apoiados = new OrgaosApoiados();
$pessti = new PessoalTI();
$usr = new Usuario();
$cfg = new Config();

/* Recupera informações */
$row = $pessti->SelectAllPesTI();

@$act = $_GET['act'];

/* Checa se há pessoal cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há Pessoal de TI cadastrado,<br />
		 clique <a href=\"?cmd=pessoalti&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    @$senha = $_GET['senha'];
    if ($param){
        $pessti->idtb_pessoal_ti = $param;
        $pessoal = $pessti->SelectIdPesTI();
    }
    else{
        $orgaos = $apoiados->SelectApoiados();
        $funcoes = $pessti->SelectAllFuncoesTI();
        $pessoal = (object)['idtb_pessoal_ti'=>'','idtb_orgaos_apoiados'=>'','cpf'=>'','nome'=>'','nome_guerra'=>'',
            'correio_eletronico'=>'','status'=>'','senha'=>'','idtb_funcoes_ti'=>''];
    }
    
	echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"insereusuario\" role=\"form\" action=\"?cmd=pessoalti&act=insert\" method=\"post\" 
                        enctype=\"multipart/form-data\">
                        <fieldset>";
                            if ($param)
                            {
                                #Form alteração de senha
                                if ($senha)
                                {
                                    echo"
                                    <legend>Pessoal de TI - Cadastro</legend>
                                    <input id=\"apoiados\" class=\"form-control\" name=\"apoiados\" 
                                        value=\"$pessoal->idtb_orgaos_apoiados\" hidden=\"true\">
                                    <input id=\"cpf\" class=\"form-control\" type=\"number\" name=\"cpf\"
                                        value=\"$pessoal->cpf\" hidden=\"true\">
                                    <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                        value=\"$pessoal->nome\" hidden=\"true\">
                                    <input id=\"nome_guerra\" class=\"form-control\" type=\"text\" name=\"nome_guerra\"
                                        value=\"$pessoal->nome_guerra\" hidden=\"true\">
                                    <input id=\"correio_eletronico\" class=\"form-control\" type=\"text\" 
                                        name=\"correio_eletronico\" value=\"$pessoal->correio_eletronico\" hidden=\"true\">
                                    <input id=\"idtb_funcoes_ti\" class=\"form-control\" name=\"idtb_funcoes_ti\"
                                        value=\"$pessoal->idtb_funcoes_ti\" hidden=\"true\">
                                    <div class=\"form-group\">
                                        <label for=\"senha\" class=\"control-label\">Senha:</label>
                                        <input id=\"senha\" class=\"form-control\" type=\"password\" name=\"senha\"
                                            placeholder=\"Senha Segura\" minlength=\"8\" 
                                            maxlength=\"25\" required=\"true\">
                                        <div class=\"help-block with-errors\"></div>
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"confirmasenha\" class=\"control-label\">Confirme a Senha:</label>
                                        <input id=\"confirmasenha\" class=\"form-control\" type=\"password\" name=\"confirmasenha\"
                                            placeholder=\"Confirmação da Senha\" minlength=\"8\"
                                            maxlength=\"25\" required=\"true\">
                                        <div class=\"help-block with-errors\"></div>
                                    </div>
                                    <input id=\"ativo\" type=\"hidden\" name=\"ativo\" value=\"ATIVO\">";
                                }
                                #Form alteração de dados
                                else
                                {
                                    echo"
                                    <legend>Pessoal de TI - Cadastro</legend>
                                    <div class=\"form-group\">
                                        <label for=\"apoiados\">Órgão Apoiado:</label>
                                        <select id=\"apoiados\" class=\"form-control\" name=\"apoiados\">
                                            <option value=\"$pessoal->idtb_orgaos_apoiados\" selected=\"true\">
                                                $pessoal->sigla_apoiados</option>";
                                            foreach ($orgaos as $key => $value) {
                                                echo"<option value=\"".$value->idtb_orgaos_apoiados."\">
                                                    ".$value->sigla."</option>";
                                            };
                                        echo "</select>
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"cpf\">CPF:</label>
                                        <input id=\"cpf\" class=\"form-control\" type=\"number\" name=\"cpf\"
                                            placeholder=\"CPF\" maxlength=\"11\" required=\"true\" 
                                            value=\"$pessoal->cpf\" autocomplete=\"off\">
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"nome\">Nome:</label>
                                        <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                            style=\"text-transform:uppercase\" placeholder=\"Nome\" 
                                            minlength=\"2\" required=\"true\" value=\"$pessoal->nome\" autocomplete=\"off\">
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"nome_guerra\">Nome de Guerra:</label>
                                        <input id=\"nome_guerra\" class=\"form-control\" type=\"text\" name=\"nome_guerra\"
                                            style=\"text-transform:uppercase\" placeholder=\"Nome de Guerra\" 
                                            minlength=\"2\" required=\"true\" value=\"$pessoal->nome_guerra\" autocomplete=\"off\">
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"correio_eletronico\">Correio Eletrônico:</label>
                                        <input id=\"correio_eletronico\" class=\"form-control\" type=\"text\" name=\"correio_eletronico\"
                                            style=\"text-transform:uppercase\" placeholder=\"Correio Eletrônico\" 
                                            minlength=\"2\" required=\"true\" value=\"$pessoal->correio_eletronico\" autocomplete=\"off\">
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"idtb_funcoes_ti\">Função de TI:</label>
                                        <select id=\"idtb_funcoes_ti\" class=\"form-control\" name=\"idtb_funcoes_ti\">
                                            <option value=\"$pessoal->idtb_funcoes_ti\" selected=\"true\">
                                                $pessoal->sigla_funcao</option>";
                                            foreach ($funcoes as $key => $value) {
                                                echo"<option value=\"".$value->idtb_funcoes_ti."\">
                                                    ".$value->sigla."</option>";
                                            };
                                        echo "</select>
                                    </div>
                                    <input id=\"senha\" class=\"form-control\" type=\"password\" name=\"senha\"
                                            value=\"\" hidden=\"true\">
                                    <input id=\"confirmasenha\" class=\"form-control\" type=\"password\" name=\"confirmasenha\"
                                        value=\"\" hidden=\"true\">
                                    <input id=\"ativo\" type=\"hidden\" name=\"ativo\" value=\"ATIVO\">";
                                }
                            }
                            #Form inclusão
                            else
                            {
                                echo"
                                <legend>Pessoal de TI - Cadastro</legend>
                                <div class=\"form-group\">
                                    <label for=\"apoiados\">Órgão Apoiado:</label>
                                    <select id=\"apoiados\" class=\"form-control\" name=\"apoiados\">
                                        <option value=\"$pessoal->idtb_orgaos_apoiados\" selected=\"true\">
                                            $pessoal->sigla_apoiados</option>";
                                        foreach ($orgaos as $key => $value) {
                                            echo"<option value=\"".$value->idtb_orgaos_apoiados."\">
                                                ".$value->sigla."</option>";
                                        };
                                    echo "</select>
                                </div>
                                <div class=\"form-group\">
                                    <label for=\"cpf\">CPF:</label>
                                    <input id=\"cpf\" class=\"form-control\" type=\"number\" name=\"cpf\"
                                        placeholder=\"CPF\" maxlength=\"11\" required=\"true\" 
                                        value=\"$pessoal->cpf\" autocomplete=\"off\">
                                </div>
                                <div class=\"form-group\">
                                    <label for=\"nome\">Nome:</label>
                                    <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                        style=\"text-transform:uppercase\" placeholder=\"Nome\" 
                                        minlength=\"2\" required=\"true\" value=\"$pessoal->nome\" autocomplete=\"off\">
                                </div>
                                <div class=\"form-group\">
                                    <label for=\"nome_guerra\">Nome de Guerra:</label>
                                    <input id=\"nome_guerra\" class=\"form-control\" type=\"text\" name=\"nome_guerra\"
                                        style=\"text-transform:uppercase\" placeholder=\"Nome de Guerra\" 
                                        minlength=\"2\" required=\"true\" value=\"$pessoal->nome_guerra\" autocomplete=\"off\">
                                </div>
                                <div class=\"form-group\">
                                    <label for=\"correio_eletronico\">Correio Eletrônico:</label>
                                    <input id=\"correio_eletronico\" class=\"form-control\" type=\"text\" name=\"correio_eletronico\"
                                        style=\"text-transform:uppercase\" placeholder=\"Correio Eletrônico\" 
                                        minlength=\"2\" required=\"true\" value=\"$pessoal->correio_eletronico\" autocomplete=\"off\">
                                </div>
                                <div class=\"form-group\">
                                    <label for=\"idtb_funcoes_ti\">Função de TI:</label>
                                    <select id=\"idtb_funcoes_ti\" class=\"form-control\" name=\"idtb_funcoes_ti\">
                                        <option value=\"$pessoal->idtb_funcoes_ti\" selected=\"true\">
                                            $pessoal->sigla_funcao</option>";
                                        foreach ($funcoes as $key => $value) {
                                            echo"<option value=\"".$value->idtb_funcoes_ti."\">
                                                ".$value->sigla."</option>";
                                        };
                                    echo "</select>
                                </div>
                                <div class=\"form-group\">
                                    <label for=\"senha\" class=\"control-label\">Senha:</label>
                                    <input id=\"senha\" class=\"form-control\" type=\"password\" name=\"senha\"
                                        placeholder=\"Senha Segura\" minlength=\"8\" 
                                        maxlength=\"25\" required=\"true\">
                                    <div class=\"help-block with-errors\"></div>
                                </div>
                                <div class=\"form-group\">
                                    <label for=\"confirmasenha\" class=\"control-label\">Confirme a Senha:</label>
                                    <input id=\"confirmasenha\" class=\"form-control\" type=\"password\" name=\"confirmasenha\"
                                        placeholder=\"Confirmação da Senha\" minlength=\"8\"
                                        maxlength=\"25\" required=\"true\">
                                    <div class=\"help-block with-errors\"></div>
                                </div>
                                <input id=\"ativo\" type=\"hidden\" name=\"ativo\" value=\"ATIVO\">";
                            }
                        echo"
                        </fieldset>
                        <input id=\"idtb_pessoal_ti\" type=\"hidden\" name=\"idtb_pessoal_ti\" 
                            value=\"$pessoal->idtb_pessoal_ti\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro de Pessoal de TI Ativo */
if (($row) AND ($act == NULL)) {

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">CPF</th>
                        <th scope=\"col\">Nome</th>
                        <th scope=\"col\">Correio Eletrônico</th>
                        <th scope=\"col\">Órgão Apoiado</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    $pessti->ordena = "ORDER BY nome ASC";
    $pessoal = $pessti->SelectAllPesTI();

    foreach ($pessoal as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$pessti->FormatCPF($value->cpf)."</th>
                        <td>".$value->nome_guerra."</td>
                        <td>".$value->correio_eletronico."</td>
                        <td>".$value->sigla_apoiados."</td>
                        <td><a href=\"?cmd=pessoalti&act=cad&param=".$value->idtb_pessoal_ti."\">Editar</a> - 
                            <a href=\"?cmd=pessoalti&act=cad&param=".$value->idtb_pessoal_ti."&senha=troca\">Senha</a> - 
                            <a href=\"?cmd=pessoalti&act=desativar&param=".$value->idtb_pessoal_ti."\">Desativar</a>
                        </td>
                    </tr>";
    };
    echo"
                </tbody>
            </table>
            </div>";
}

/* Monta quadro de Pessoal de TI Inativo */
if ($act == 'inativos') {

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">CPF</th>
                        <th scope=\"col\">Nome</th>
                        <th scope=\"col\">Correio Eletrônico</th>
                        <th scope=\"col\">Órgão Apoiado</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    $pessti->ordena = "ORDER BY nome ASC";
    $pessoal = $pessti->SelectPesTIInativos();

    foreach ($pessoal as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$pessti->FormatCPF($value->cpf)."</th>
                        <td>".$value->nome_guerra."</td>
                        <td>".$value->correio_eletronico."</td>
                        <td>".$value->sigla_apoiados."</td>
                        <td><a href=\"?cmd=pessoalti&act=cad&param=".$value->idtb_pessoal_ti."\">Editar</a> - 
                            <a href=\"?cmd=pessoalti&act=cad&param=".$value->idtb_pessoal_ti."&senha=troca\">Senha</a> - 
                            <a href=\"?cmd=pessoalti&act=ativar&param=".$value->idtb_pessoal_ti."\">Reativar</a>
                        </td>
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
        $idtb_pessoal_ti = $_POST['idtb_pessoal_ti'];
        $pessti->idtb_pessoal_ti = $_POST['idtb_pessoal_ti'];
        $pessti->idtb_orgaos_apoiados = $_POST['apoiados'];
        $cpf = $_POST['cpf'];
        $usuario = $cpf;
        $pessti->cpf = $cpf;
        $pessti->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $pessti->nome_guerra = mb_strtoupper($_POST['nome_guerra'],'UTF-8');
        $pessti->correio_eletronico = mb_strtoupper($_POST['correio_eletronico'],'UTF-8');
        $pessti->status = mb_strtoupper($_POST['ativo'],'UTF-8');
        $pessti->idtb_funcoes_ti = $_POST['idtb_funcoes_ti'];
        $pessti->usuario = $cpf;
        /* Opta pelo Método Update */
        if ($idtb_pessoal_ti){
            $senha = $_POST['senha'];
            if($senha==NULL){
                $row = $pessti->UpdatePesTI();
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=pessoalti\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    echo(pg_result_error($row) . "<br />\n");
                }
            }
            else{
                $hash = sha1(md5($senha));
                $salt = sha1(md5($usuario));
                $pessti->senha = $salt.$hash;
                $row = $pessti->UpdateSenhaPesti();
                if ($row) {
                    $usr->iduser = $idtb_pessoal_ti;
                    $pwd = $usr->SetVencSenha(5);
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=pessoalti\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    echo(pg_result_error($row) . "<br />\n");
                }
            }            
        }
        /* Opta pelo Método Insert */
        else{
            /* Checa se há pessoal com mesmo CPF/Email cadastrado */
            $cpf = $pessti->ChecaCPF();
            $correio = $pessti->ChecaCorreio();
            if ($cpf != NULL) {
                echo "<h5>Já existe um usuário cadastrado com esse CPF.</h5>";
            }
            elseif ($correio != NULL){
                echo "<h5>Já existe um usuário cadastrado com esse Correio Eletrônico.</h5>";
            }
            else {
                $senha = $_POST['senha'];
                $hash = sha1(md5($senha));
                $salt = sha1(md5($usuario));
                $pessti->senha = $salt.$hash;
                $row = $pessti->InsertPesTI();
                if ($row) {
                    $usr->iduser = $row;
                    $pwd = $usr->SetVencSenha(5);
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=pessoalti\">";
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

/** Ativar/Desativar Usuário */
if ($act == 'ativar') {
    if (isset($_SESSION['status'])){
        @$param = $_GET['param'];
        $pessti->idtb_pessoal_ti = $param;
        $row = $pessti->PesTIAtivar();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=pessoalti\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
    }
    else{
        echo "<h5>Ocorreu algum erro, usuário não autenticado.</h5>
            <meta http-equiv=\"refresh\" content=\"1;$url\">";
    }
}

if ($act == 'desativar') {
    if (isset($_SESSION['status'])){
        @$param = $_GET['param'];
        $pessti->idtb_pessoal_ti = $param;
        $row = $pessti->PesTIDesativar();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=pessoalti\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
    }
    else{
        echo "<h5>Ocorreu algum erro, usuário não autenticado.</h5>
            <meta http-equiv=\"refresh\" content=\"1;$url\">";
    }
}

?>