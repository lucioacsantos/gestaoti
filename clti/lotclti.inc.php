<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$pesclti = new PessoalCLTI();
$config = new Config();
$mil = new Militar();
$usr = new Usuario();

/* Recupera informações */
$row = $pesclti->SelectALL();

@$act = $_GET['act'];

/* Checa se há técnicos cadastrados */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há técnicos cadastrados neste CLTI,<br />
		 clique <a href=\"?cmd=lotclti&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro de técnicos */
if ($act == 'cad') {
    @$param = $_GET['param'];
    @$senha = $_GET['senha'];
    if ($param){
        $pesclti->idtb_lotacao_clti = $param;
        $clti = $pesclti->SelectId();
    }
    else{
        $clti = (object)['idtb_lotacao_clti'=>'','nip'=>'','cpf'=>'','nome'=>'','nome_guerra'=>'',
            'idtb_om_apoiadas'=>'','sigla'=>'','idtb_posto_grad'=>'8','sigla_posto_grad'=>'Primeiro Tenente',
            'idtb_corpo_quadro'=>'','sigla_corpo_quadro'=>'','idtb_especialidade'=>'','sigla_espec'=>''];
    }
    $postograd = $mil->SelectAllPostoGrad();
    $corpoquadro = $mil->SelectAllCorpoQuadro();
    $especialidade = $mil->SelectAllEspec();
	echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"insereusuario\" action=\"?cmd=lotclti&act=insert\" method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>";
                            #Prepara formulário para atualização de dados
                            if ($param){
                                if ($senha){
                                    echo"
                                    <legend>Lotação do CLTI - Troca de Senha</legend>
                                    <input id=\"postograd\" class=\"form-control\" name=\"postograd\"
                                        value=\"$clti->idtb_posto_grad\" hidden=\"true\">
                                    <input id=\"corpoquadro\" class=\"form-control\" name=\"corpoquadro\"
                                        value=\"$clti->idtb_corpo_quadro\" hidden=\"true\">
                                    <input id=\"especialidade\" class=\"form-control\" name=\"especialidade\"
                                        value=\"$clti->idtb_especialidade\" hidden=\"true\">
                                    <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                        hidden=\"true\" value=\"$clti->nome\">
                                    <input id=\"nomeguerra\" class=\"form-control\" type=\"text\" name=\"nomeguerra\"
                                        hidden=\"true\" value=\"$clti->nome_guerra\">
                                    <input id=\"correio_eletronico\" class=\"form-control\" type=\"text\" autocomplete=\"off\"
                                        name=\"correio_eletronico\" hidden=\"required\" value=\"$clti->correio_eletronico\">

                                    <div class=\"form-group\">
                                        <label for=\"nip\">NIP:</label>
                                        <input id=\"nip\" class=\"form-control\" type=\"text\" name=\"nip\" readonly=\"true\"
                                            placeholder=\"NIP\" maxlength=\"8\" value=\"$clti->nip\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"cpf\">CPF (Servidores Civis):</label>
                                        <input id=\"cpf\" class=\"form-control\" type=\"text\" name=\"cpf\" readonly=\"true\"
                                            placeholder=\"CPF (Servidores Civis)\" maxlength=\"11\" value=\"$clti->cpf\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"ativo\" class=\"control-label\">Situação:</label>
                                        <input id=\"ativo\" class=\"form-control\" type=\"text\" name=\"ativo\" readonly=\"true\"
                                            value=\"$clti->status\" autocomplete=\"off\">
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
                                        <label for=\"postograd\">Posto/Graduação:</label>
                                        <select id=\"postograd\" class=\"form-control\" name=\"postograd\">
                                            <option value=\"$clti->idtb_posto_grad\" selected=\"true\">
                                                $clti->sigla_posto_grad</option>";
                                            foreach ($postograd as $key => $value) {
                                                echo"<option value=\"".$value->idtb_posto_grad."\">
                                                    ".$value->nome."</option>";
                                            };
                                        echo "</select>
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"corpoquadro\">Corpo/Quadro:</label>
                                        <select id=\"corpoquadro\" class=\"form-control\" name=\"corpoquadro\">
                                            <option value=\"$clti->idtb_corpo_quadro\" selected=\"true\">
                                                $clti->sigla_corpo_quadro</option>";
                                            foreach ($corpoquadro as $key => $value) {
                                                echo"<option value=\"".$value->idtb_corpo_quadro."\">
                                                    ".$value->nome."</option>";
                                            };
                                        echo "</select>
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"especialidade\">Especialidade:</label>
                                        <select id=\"especialidade\" class=\"form-control\" name=\"especialidade\">
                                            <option value=\"$clti->idtb_especialidade\" selected=\"true\">
                                                $clti->sigla_espec</option>";
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
                                            style=\"text-transform:uppercase\" required=\"true\" value=\"$clti->nome\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"nomeguerra\">Nome de Guerra:</label>
                                        <input id=\"nomeguerra\" class=\"form-control\" type=\"text\" name=\"nomeguerra\"
                                            placeholder=\"Nome de Guerra\" minlength=\"2\" autocomplete=\"off\"
                                            style=\"text-transform:uppercase\" required=\"true\" value=\"$clti->nome_guerra\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"correio_eletronico\">Correio Eletrônico:</label>
                                        <input id=\"correio_eletronico\" class=\"form-control\" type=\"email\" 
                                            name=\"correio_eletronico\" placeholder=\"Preferencialmente Zimbra\" 
                                            minlength=\"2\" style=\"text-transform:uppercase\" required=\"true\" 
                                            value=\"$clti->correio_eletronico\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"nip\">NIP:</label>
                                        <input id=\"nip\" class=\"form-control\" type=\"text\" name=\"nip\" readonly=\"true\"
                                            placeholder=\"NIP\" maxlength=\"8\" value=\"$clti->nip\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"cpf\">CPF (Servidores Civis):</label>
                                        <input id=\"cpf\" class=\"form-control\" type=\"text\" name=\"cpf\" readonly=\"true\"
                                            placeholder=\"CPF (Servidores Civis)\" maxlength=\"11\" value=\"$clti->cpf\" autocomplete=\"off\">
                                    </div>

                                    <div class=\"form-group\">
                                        <label for=\"ativo\" class=\"control-label\">Situação:</label>
                                        <select id=\"ativo\" class=\"form-control\" name=\"ativo\">
                                            <option value=\"$clti->status\" selected=\"true\">$clti->status</option>
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
                                <label for=\"postograd\">Posto/Graduação:</label>
                                <select id=\"postograd\" class=\"form-control\" name=\"postograd\">
                                    <option value=\"$clti->idtb_posto_grad\" selected=\"true\">
                                        $clti->sigla_posto_grad</option>";
                                    foreach ($postograd as $key => $value) {
                                        echo"<option value=\"".$value->idtb_posto_grad."\">
                                            ".$value->nome."</option>";
                                    };
                                echo "</select>
                            </div>

                            <div class=\"form-group\">
                                <label for=\"corpoquadro\">Corpo/Quadro:</label>
                                <select id=\"corpoquadro\" class=\"form-control\" name=\"corpoquadro\">
                                    <option value=\"$clti->idtb_corpo_quadro\" selected=\"true\">
                                        $clti->sigla_corpo_quadro</option>";
                                    foreach ($corpoquadro as $key => $value) {
                                        echo"<option value=\"".$value->idtb_corpo_quadro."\">
                                            ".$value->nome."</option>";
                                    };
                                echo "</select>
                            </div>

                            <div class=\"form-group\">
                                <label for=\"especialidade\">Especialidade:</label>
                                <select id=\"especialidade\" class=\"form-control\" name=\"especialidade\">
                                    <option value=\"$clti->idtb_especialidade\" selected=\"true\">
                                        $clti->sigla_espec</option>";
                                    foreach ($especialidade as $key => $value) {
                                        echo"<option value=\"".$value->idtb_especialidade."\">
                                            ".$value->nome."</option>";
                                    };
                                echo "</select>
                            </div>

                            <div class=\"form-group\">
                                <label for=\"nip\">NIP:</label>
                                <input id=\"nip\" class=\"form-control\" type=\"text\" name=\"nip\" autocomplete=\"off\"
                                       placeholder=\"NIP\" maxlength=\"8\" required=\"true\" value=\"$clti->nip\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"cpf\">CPF (Servidores Civis):</label>
                                <input id=\"cpf\" class=\"form-control\" type=\"text\" name=\"cpf\" autocomplete=\"off\"
                                       placeholder=\"CPF (Servidores Civis)\" maxlength=\"11\" value=\"$clti->cpf\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"nome\">Nome Completo:</label>
                                <input id=\"nome\" class=\"form-control\" type=\"text\" name=\"nome\"
                                       placeholder=\"Nome Completo\" minlength=\"2\" autocomplete=\"off\"
                                       style=\"text-transform:uppercase\" required=\"true\" value=\"$clti->nome\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"nomeguerra\">Nome de Guerra:</label>
                                <input id=\"nomeguerra\" class=\"form-control\" type=\"text\" name=\"nomeguerra\"
                                       placeholder=\"Nome de Guerra\" minlength=\"2\" autocomplete=\"off\"
                                       style=\"text-transform:uppercase\" required=\"true\" value=\"$clti->nome_guerra\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"correio_eletronico\">Correio Eletrônico:</label>
                                <input id=\"correio_eletronico\" class=\"form-control\" type=\"email\" name=\"correio_eletronico\"
                                    placeholder=\"Preferencialmente Zimbra\" minlength=\"2\" autocomplete=\"off\"
                                    style=\"text-transform:uppercase\" required=\"true\" value=\"$clti->correio_eletronico\">
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
                        <input id=\"idtb_lotacao_clti\" type=\"hidden\" name=\"idtb_lotacao_clti\" 
                            value=\"$clti->idtb_lotacao_clti\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro com lotação/efetivo
   O usuário padrão '12345678' não entra na contagem
*/
if (($row) AND ($act == NULL)) {
    $efclti = $cont->CountEfetCLTI();
    $ofclti = $cont->CountEfetOfCLTI();
    $prclti = $cont->CountEfetPrCLTI();
    $civclti = $cont->CountEfetCivilCLTI();
    $qualiclti = $cont->CountQualiCLTI();
    $pesclti->ordena = "ORDER BY idtb_posto_grad ASC";
    $clti = $pesclti->SelectALL();
    $lotof = $cont->CountLotOfCLTI();
    $lotpr = $cont->CountLotPrCLTI();
    $lotacao = $lotof+$lotpr;

    echo"<div class=\"table-responsive\">
        <table class=\"table table-hover\">
            <thead>
                <tr>
                    <th scope=\"col\">Pessoal do CLTI</th>
                    <th scope=\"col\">Lotação</th>
                    <th scope=\"col\">Efetivo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope=\"row\">#</th>
                    <td>".$lotacao."</td>
                    <td>".$efclti."</td>
                </tr>
                <tr>
                    <th scope=\"row\">Oficiais</th>
                    <td>".$lotof."</td>
                    <td>".$ofclti."</td>
                </tr>
                <tr>
                    <th scope=\"row\">Praças</th>
                    <td> ".$lotpr."</td>
                    <td> ".$prclti."</td>
                </tr>
                <tr>
                    <th scope=\"row\">Servidores Civis</th>
                    <td> 0</td>
                    <td> ".$civclti."</td>
                </tr>
            </tbody>
        </table>
        </div>
        <p></p>
        <p><h2>Equipe do CLTI</h2></p>";

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

    foreach ($clti as $key => $value) {

        #Seleciona NIP caso seja militar da MB
        if ($value->nip != NULL) {
            $identificacao = $value->nip;
        }
        else{
            $identificacao = $value->cpf;
        }

        echo"       <tr>";
                        if (($value->exibir_espec == 'NÃO') AND ($value->exibir_corpo_quadro == 'NÃO')){
                            echo"       <th scope=\"row\">".$value->sigla_posto_grad."</th>";
                        }
                        elseif (($value->exibir_espec == 'NÃO') AND ($value->exibir_corpo_quadro != 'NÃO')){
                            echo"       <th scope=\"row\">".$value->sigla_posto_grad." ".$value->sigla_corpo_quadro."</th>";
                        }
                        elseif (($value->exibir_espec != 'NÃO') AND ($value->exibir_corpo_quadro == 'NÃO')){
                            echo"       <th scope=\"row\">".$value->sigla_posto_grad." ".$value->sigla_espec."</th>";
                        }
                        else {
                            echo"       <th scope=\"row\">".$value->sigla_posto_grad." ".$value->sigla_corpo_quadro." 
                                            ".$value->sigla_espec."</th>";
                        }
                        echo"
                        <td>".$identificacao."</td>
                        <td>".$value->nome."</td>
                        <td>".$value->nome_guerra."</td>
                        <td><a href=\"?cmd=lotclti&act=cad&param=".$value->idtb_lotacao_clti."\">Editar</a> - 
                            <a href=\"?cmd=lotclti&act=cad&param=".$value->idtb_lotacao_clti."&senha=troca\">Senha</a> -
                            <a href=\"?cmd=lotclti&act=desativar&param=".$value->idtb_lotacao_clti."\">Desativar</a>
                        </td>
                    </tr>";
    };
    echo"
                </tbody>
            </table>
            </div>";
}

if ($act == 'inativos') {

    $pesclti->ordena = "ORDER BY idtb_posto_grad ASC";
    $clti = $pesclti->SelectInativos();

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

    foreach ($clti as $key => $value) {

        #Seleciona NIP caso seja militar da MB
        if ($value->nip != NULL) {
            $identificacao = $value->nip;
        }
        else{
            $identificacao = $value->cpf;
        }

        echo"       <tr>
                        <th scope=\"row\">".$value->sigla_posto_grad." ".$value->sigla_corpo_quadro." 
                            ".$value->sigla_espec."</th>
                        <td>".$identificacao."</td>
                        <td>".$value->nome."</td>
                        <td>".$value->nome_guerra."</td>
                        <td><a href=\"?cmd=lotclti&act=cad&param=".$value->idtb_lotacao_clti."\">Editar</a> - 
                            <a href=\"?cmd=lotclti&act=cad&param=".$value->idtb_lotacao_clti."&senha=troca\">Senha</a> -
                            <a href=\"?cmd=lotclti&act=ativar&param=".$value->idtb_lotacao_clti."\">Reativar</a>
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
        $idtb_lotacao_clti = $_POST['idtb_lotacao_clti'];
        $pesclti->idtb_lotacao_clti = $idtb_lotacao_clti;
        $pesclti->idtb_posto_grad = $_POST['postograd'];
        $pesclti->idtb_corpo_quadro = $_POST['corpoquadro'];
        $pesclti->idtb_especialidade = $_POST['especialidade'];
        $nip = $_POST['nip'];
        $pesclti->nip = $nip;
        $cpf = $_POST['cpf'];
        $pesclti->cpf = $cpf;
        $pesclti->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $pesclti->nome_guerra = mb_strtoupper($_POST['nomeguerra'],'UTF-8');
        $pesclti->correio_eletronico = mb_strtoupper($_POST['correio_eletronico'],'UTF-8');
        $pesclti->status = mb_strtoupper($_POST['ativo'],'UTF-8');
        $pesclti->perfil = "TEC_CLTI";
        if ($nip == NULL && $cpf == NULL){
            echo "<h5>NIP e CPF em branco, um dos itens deve ser preenchido!</h5>
            <meta http-equiv=\"refresh\" content=\"5;url=?cmd=admin\">";
        }
        if ($nip == NULL) {
            $usuario = $cpf;
        }
        else {
            $usuario = $nip;
        }
        $pesclti->usuario = $usuario;
        /* Opta pelo Método Update */
        if ($idtb_lotacao_clti){
            $senha = $_POST['senha'];

            if($senha==NULL){
                $row = $pesclti->Update();
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=lotclti\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    echo(pg_result_error($row) . "<br />\n");
                }
            }
            else{
                $hash = sha1(md5($senha));
                $salt = sha1(md5($usuario));
                $pesclti->senha = $salt.$hash;
                $row = $pesclti->UpdateSenha();
                if ($row) {
                    $usr->iduser = $idtb_lotacao_clti;
                    $pwd = $usr->SetVencSenhaCLTI(5);
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=lotclti\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    echo(pg_result_error($row) . "<br />\n");
                }
            }
        }
        /* Opta pelo Método Insert */
        else{
            $nip_cpf = $pesclti->ChecaNIPCPF();
            $correio = $pesclti->ChecaCorreio();
            if ($nip_cpf != NULL) {
                echo "<h5>Já existe um Admin cadastrado com esse NIP/CPF.</h5>";
            }
            elseif ($correio != NULL){
                echo "<h5>Já existe um Admin cadastrado com esse Correio Eletrônico.</h5>";
            }
            else {
                $senha = $_POST['senha'];
                $hash = sha1(md5($senha));
                $salt = sha1(md5($usuario));
                $pesclti->senha = $salt.$hash;
                $row = $pesclti->Insert();
                if ($row) {
                    $usr->iduser = $row;
                    $pwd = $usr->InsertVencSenhaCLTI(5);
                    echo "<h5>Resgistros incluídos no banco de dados id $row.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=lotclti\">";
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

if ($act == 'aprovrelsv'){
    @$param = $_POST['aprovrel'];
    if ($param){
        $row = $pesclti->AddTarefa($param,'Aprov.Rel.Sv');
        if ($row) {
            echo "<h5>Resgistros incluídos no banco de dados.</h5>
            <meta http-equiv=\"refresh\" content=\"1;url=?cmd=lotclti\">";
        }
        else {
            echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            echo(pg_result_error($row) . "<br />\n");
        }
    }
    else {
        $pesclti->ordena = 'ORDER BY idtb_posto_grad ASC';
        $clti = $pesclti->SelectALL();
        echo"
        <div class=\"container-fluid\">
            <div class=\"row\">
                <main>
                    <div id=\"form-cadastro\">
                        <form id=\"aprovrel\" action=\"?cmd=lotclti&act=aprovrelsv\" method=\"post\" enctype=\"multipart/form-data\">
                            <fieldset>
                                <div class=\"form-group\">
                                    <label for=\"aprovrel\">Selecione o aprovador:</label>
                                    <select id=\"aprovrel\" class=\"form-control\" name=\"aprovrel\">";
                                        foreach ($clti as $key => $value) {
                                            echo"<option value=\"".$value->idtb_lotacao_clti."\">
                                                ".$value->sigla_posto_grad." - ".$value->nome_guerra."</option>";
                                        };
                                    echo "</select>
                                </div>
                                <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                            </fildset>
                        </form>
                    </div>
                </main>
            </div>
        </div>";
    }
}

if ($act == 'servico'){
    @$param = $_POST['servico'];
    if ($param){
        $row = $pesclti->AddTarefa($param,'Escala de Serviço');
        if ($row) {
            echo "<h5>Resgistros incluídos no banco de dados.</h5>
            <meta http-equiv=\"refresh\" content=\"1;url=?cmd=lotclti\">";
        }
        else {
            echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            echo(pg_result_error($row) . "<br />\n");
        }
    }
    else {
        $pesclti->ordena = 'ORDER BY idtb_posto_grad ASC';
        $clti = $pesclti->SelectALL();
        echo"
        <div class=\"container-fluid\">
            <div class=\"row\">
                <main>
                    <div id=\"form-cadastro\">
                        <form id=\"servico\" action=\"?cmd=lotclti&act=servico\" method=\"post\" enctype=\"multipart/form-data\">
                            <fieldset>
                                <div class=\"form-group\">
                                    <label for=\"servico\">Selecione o Militar:</label>
                                    <select id=\"servico\" class=\"form-control\" name=\"servico\">";
                                        foreach ($clti as $key => $value) {
                                            echo"<option value=\"".$value->idtb_lotacao_clti."\">
                                                ".$value->sigla_posto_grad." - ".$value->nome_guerra."</option>";
                                        };
                                    echo "</select>
                                </div>
                                <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                            </fildset>
                        </form>
                    </div>
                </main>
            </div>
        </div>";
    }
}

if ($act == 'ativar') {
    if (isset($_SESSION['status'])){
        @$param = $_GET['param'];
        $pesclti->idtb_lotacao_clti = $param;
        $row = $pesclti->PesCLTIAtivar();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=lotclti\">";
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
        $pesclti->idtb_lotacao_clti = $param;
        $row = $pesclti->PesCLTIDesativar();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=lotclti\">";
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

if ($act == 'calcula') {
    if (isset($_SESSION['status'])){
        
        $qtdeet = $cont->CountTotalET();
        $config->lotacaooficiais = 2;
        $config->lotacaopracas = 5;

        if ($qtdeet > 750 && $qtdeet <= 1400){
            $pracas = ($qtdeet - 750) % 150;
            $oficiais = ($qtdeet - 750) % 350;
            $config->lotacaopracas = 5 + $pracas;
            $config->lotacaooficiais = 2 + $oficiais;
        }
        if ($qtdeet > 1400){
            $pracas = ($qtdeet - 750) % 150;
            $oficiais_1 = (1400 - 750) % 350;
            $oficiais_2 = ($qtdeet - 1400) % 1000;
            $config->lotacaopracas = 5 + $pracas;
            $config->lotacaooficiais = 2 + $oficiais_1 + $oficiais_2;
        }

        $row = $config->AtualizaLotacao();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=lotclti\">";
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