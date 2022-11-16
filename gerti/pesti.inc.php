<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
**/

/** Leitura de parâmetros */
$oa = $cmd = $param = $act = $senha = NULL;
if (isset($_GET['oa'])){
  $oa = $_GET['oa'];
}

if (isset($_GET['cmd'])){
  $cmd = $_GET['cmd'];
}

if (isset($_GET['act'])){
  $act = $_GET['act'];
}

if (isset($_GET['param'])){
  $param = $_GET['param'];
}

if (isset($_GET['senha'])){
    $senha = $_GET['senha'];
  }

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
require_once "../class/queries.inc.php";
$pesti = new PessoalTI();
$config = new Config();
$usr = new Usuario();
$acesso = new Principal();

/* Recupera informações */
$row = $pesti->SelectAllPesTI();

/* Checa se há técnicos cadastrados */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há técnicos cadastrados neste CLTI,<br />
		 clique <a href=\"?cmd=pesti&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro de técnicos */
if ($act == 'cad') {
    if ($param){
        $pesti->idtb_pessoal_ti = $param;
        $pti = $pesti->SelectIdPesTI();
    }
    else{
        $pti = (object)['idtb_pessoal_ti'=>'','idtb_orgaos_apoiados'=>'1','sigla_apoiados'=>'GES.TI','cpf'=>'','nome'=>'','nome_guerra'=>'',
            'correio_eletronico'=>'','idtb_funcoes_ti'=>'','desc_funcao'=>'','sigla_funcao'=>'','status'=>''];
    }
	echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"insereusuario\" action=\"?cmd=pesti&act=insert\" method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>";
                            #Prepara formulário para atualização de dados
                            if ($param){
                                if ($senha){
                                    echo"
                                    <legend>Lotação do CLTI - Troca de Senha</legend>
                                    <input id=\"nome\" type=\"text\" name=\"nome\" hidden=\"true\" value=\"$pti->nome\">
                                    <input id=\"nomeguerra\" type=\"text\" name=\"nomeguerra\" hidden=\"true\" value=\"$pti->nome_guerra\">
                                    <input id=\"correio_eletronico\" type=\"email\" name=\"correio_eletronico\" hidden=\"true\"
                                        value=\"$pti->correio_eletronico\">
                                    <input id=\"ativo\" type=\"hidden\" name=\"ativo\" value=\"ATIVO\">
                                    <div class=\"form-group\">
                                        <label for=\"cpf\">CPF (Servidores Civis):</label>
                                        <input id=\"cpf\" class=\"form-control\" type=\"text\" name=\"cpf\" readonly=\"true\"
                                            placeholder=\"CPF (Servidores Civis)\" maxlength=\"11\" value=\"$pti->cpf\" autocomplete=\"off\">
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"senha\" class=\"control-label\">Trocar Senha:</label>
                                        <input id=\"senha\" class=\"form-control\" type=\"password\" name=\"senha\"
                                            placeholder=\"Senha Segura\" maxlength=\"25\">
                                        <div class=\"help-block with-errors\"></div>
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"confirmasenha\" class=\"control-label\">Confirme a Senha:</label>
                                        <input id=\"confirmasenha\" class=\"form-control\" type=\"password\" name=\"confirmasenha\"
                                            placeholder=\"Confirmação da Senha\" maxlength=\"25\">
                                        <div class=\"help-block with-errors\"></div>
                                    </div>";
                                }
                                #Em caso de alteração de outros dados
                                else{
                                    echo"
                                    <legend>Lotação do CLTI - Alteração</legend>
                                    <div class=\"form-group\">
                                        <label for=\"nome\">Nome Completo:</label>
                                        <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                            placeholder=\"Nome Completo\" minlength=\"2\" autocomplete=\"off\"
                                            style=\"text-transform:uppercase\" required=\"true\" value=\"$pti->nome\">
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"nomeguerra\">Nome de Guerra:</label>
                                        <input id=\"nomeguerra\" class=\"form-control\" type=\"text\" name=\"nomeguerra\"
                                            placeholder=\"Nome de Guerra\" minlength=\"2\" autocomplete=\"off\"
                                            style=\"text-transform:uppercase\" required=\"true\" value=\"$pti->nome_guerra\">
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"correio_eletronico\">Correio Eletrônico:</label>
                                        <input id=\"correio_eletronico\" class=\"form-control\" type=\"email\" 
                                            name=\"correio_eletronico\" placeholder=\"nome@email.com\" 
                                            minlength=\"2\" style=\"text-transform:uppercase\" required=\"true\" 
                                            value=\"$pti->correio_eletronico\" autocomplete=\"off\">
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"cpf\">CPF (Servidores Civis):</label>
                                        <input id=\"cpf\" class=\"form-control\" type=\"text\" name=\"cpf\" readonly=\"true\"
                                            placeholder=\"CPF (Servidores Civis)\" maxlength=\"11\" value=\"$pti->cpf\" autocomplete=\"off\">
                                    </div>
                                    <div class=\"form-group\">
                                        <label for=\"ativo\" class=\"control-label\">Situação:</label>
                                        <select id=\"ativo\" class=\"form-control\" name=\"ativo\">
                                            <option value=\"$pti->status\" selected=\"true\">$pti->status</option>
                                            <option value=\"ATIVO\">ATIVO</option>
                                            <option value=\"INATIVO\">INATIVO</option>
                                    </div>
                                    <input id=\"senha\" type=\"hidden\" name=\"senha\" value=\"\">";
                                }
                            }
                            #Prepara formulário para inclusão
                            else{
                            echo"
                            <legend>Lotação do CLTI - Cadastro</legend>
                            <div class=\"form-group\">
                                <label for=\"cpf\">CPF (Servidores Civis):</label>
                                <input id=\"cpf\" class=\"form-control\" type=\"text\" name=\"cpf\" autocomplete=\"off\"
                                       placeholder=\"CPF (Servidores Civis)\" maxlength=\"11\" value=\"$pti->cpf\" required=\"true\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"nome\">Nome Completo:</label>
                                <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                       placeholder=\"Nome Completo\" minlength=\"2\" autocomplete=\"off\"
                                       style=\"text-transform:uppercase\" required=\"true\" value=\"$pti->nome\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"nomeguerra\">Nome de Guerra:</label>
                                <input id=\"nomeguerra\" class=\"form-control\" type=\"text\" name=\"nomeguerra\"
                                       placeholder=\"Nome de Guerra\" minlength=\"2\" autocomplete=\"off\"
                                       style=\"text-transform:uppercase\" required=\"true\" value=\"$pti->nome_guerra\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"correio_eletronico\">Correio Eletrônico:</label>
                                <input id=\"correio_eletronico\" class=\"form-control\" type=\"email\" name=\"correio_eletronico\"
                                    placeholder=\"nome@email.com\" minlength=\"2\" autocomplete=\"off\"
                                    style=\"text-transform:uppercase\" required=\"true\" value=\"$pti->correio_eletronico\">
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
                            value=\"$pti->idtb_pessoal_ti\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Pessoal de TI com Acesso ao Sistema */
if (($row) AND ($act == NULL)) {
    $pesti->ordena = "ORDER BY idtb_pessoal_ti ASC";
    $pti = $pesti->SelectAllPesTI();
        echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">CPF</th>
                        <th scope=\"col\">Nome</th>
                        <th scope=\"col\">Nome de Guerra</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    foreach ($pti as $key => $value) {
        echo"       <tr>
                        <td>".$value->cpf."</td>
                        <td>".$value->nome."</td>
                        <td>".$value->nome_guerra."</td>
                        <td><a href=\"?cmd=pesti&act=cad&param=".$value->idtb_pessoal_ti."\">Editar</a> - 
                            <a href=\"?cmd=pesti&act=cad&param=".$value->idtb_pessoal_ti."&senha=troca\">Senha</a> -
                            <a href=\"?cmd=pesti&act=desativar&param=".$value->idtb_pessoal_ti."\">Desativar</a>
                        </td>
                    </tr>";
    };
    echo"
                </tbody>
            </table>
            </div>";
}

if ($act == 'inativos') {
    $pesti->ordena = "ORDER BY idtb_pessoal_ti ASC";
    $pti = $pesti->SelectPesTIInativos();
        echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Posto/Grad./Esp.</th>
                        <th scope=\"col\">NIP/CPF</th>
                        <th scope=\"col\">Nome</th>
                        <th scope=\"col\">Nome de Guerra</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";
    foreach ($pti as $key => $value) {
        echo"       <tr>
                        <td>".$value->cpf."</td>
                        <td>".$value->nome."</td>
                        <td>".$value->nome_guerra."</td>
                        <td><a href=\"?cmd=pesti&act=cad&param=".$value->idtb_pessoal_ti."\">Editar</a> - 
                            <a href=\"?cmd=pesti&act=cad&param=".$value->idtb_pessoal_ti."&senha=troca\">Senha</a> -
                            <a href=\"?cmd=pesti&act=ativar&param=".$value->idtb_pessoal_ti."\">Reativar</a>
                        </td>
                    </tr>";
    };
    echo"
                </tbody>
            </table>
            </div>";
}

/* Método INSERT */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){
        $idtb_pessoal_ti = $_POST['idtb_pessoal_ti'];
        $pesti->idtb_pessoal_ti = $idtb_pessoal_ti;
        $cpf = $_POST['cpf'];
        $pesti->cpf = $cpf;
        $pesti->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $pesti->nome_guerra = mb_strtoupper($_POST['nomeguerra'],'UTF-8');
        $pesti->correio_eletronico = mb_strtoupper($_POST['correio_eletronico'],'UTF-8');
        $pesti->status = mb_strtoupper($_POST['ativo'],'UTF-8');
        $pesti->perfil = "GES.TI";
        $pesti->idtb_orgaos_apoiados = 1;
        $pesti->idtb_funcoes_ti = 1;
        $pesti->usuario = $cpf;
        /* Opta pelo Método Update */
        if ($idtb_pessoal_ti){
            $senha = $_POST['senha'];
            if($senha==NULL){
                $row = $pesti->UpdatePesTI();
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=pesti\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    echo(pg_result_error($row) . "<br />\n");
                }
            }
            else{
                $acesso->var1 = $_POST['cpf'];
                $acesso->var2 = $_POST['senha'];
                $var = $acesso->Executa();
                if ($var){
                    $pesti->senha = $var->var5;
                }
                $row = $pesti->UpdateSenhaPesTI();
                if ($row) {
                    $usr->iduser = $idtb_pessoal_ti;
                    $pwd = $usr->SetVencSenha(5);
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=pesti\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    echo(pg_result_error($row) . "<br />\n");
                }
            }
        }
        /* Opta pelo Método Insert */
        else{
            $checa_cpf = $pesti->ChecaCPF();
            $correio = $pesti->ChecaCorreio();
            if ($checa_cpf != NULL) {
                echo "<h5>Já existe um técnico cadastrado com esse CPF.</h5>";
            }
            elseif ($correio != NULL){
                echo "<h5>Já existe um técnico cadastrado com esse Correio Eletrônico.</h5>";
            }
            else {
                $acesso->var1 = $_POST['cpf'];
                $acesso->var2 = $_POST['senha'];
                $var = $acesso->Executa();
                if ($var){
                    $pesti->senha = $var->var5;
                }
                $row = $pesti->InsertPesTI();
                if ($row) {
                    $usr->iduser = $row;
                    $pwd = $usr->InsertVencSenha(5);
                    echo "<h5>Resgistros incluídos no banco de dados id $row.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=pesti\">";
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

if ($act == 'ativar') {
    if (isset($_SESSION['status'])){
        $pesti->idtb_pessoal_ti = $param;
        $row = $pesti->PestiAtivar();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=pesti\">";
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
        $pesti->idtb_pessoal_ti = $param;
        $row = $pesti->PestiDesativar();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=pesti\">";
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