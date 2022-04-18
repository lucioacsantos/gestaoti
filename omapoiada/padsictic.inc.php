<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$pad = new PAD();
$pesom = new PessoalOM();

/* Recupera informações dos PAD Ativos */
$pad->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
$row = $pad->SelectPADCorrente();

@$act = $_GET['act'];

/* Formulário para Cadastro */
if ((!$row) AND ($act == NULL) OR ($act == 'cad')) {
    echo "
    <div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"nip_cpf\" role=\"form\" action=\"?cmd=padsictic&act=insert\" 
                    method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                        <legend>PAD SIC/TIC - Cadastro</legend>
                            <div class=\"form-group\">
                                <label for=\"ano_base\">Ano Base:</label>
                                <input id=\"ano_base\" class=\"form-control\" type=\"number\" name=\"ano_base\" 
                                    required=\"true\" autocomplete=\"off\" autofocus=\"true\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"data_assinatura\">Data de Assinatura:</label>
                                <input id=\"data_assinatura\" class=\"form-control\" type=\"date\" name=\"data_assinatura\" 
                                    required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"data_revisao\">Data de Revisão:</label>
                                <input id=\"data_revisao\" class=\"form-control\" type=\"date\" name=\"data_revisao\" 
                                    required=\"true\" autocomplete=\"off\">
                            </div>
                            <div class=\"form-group\">
                                <label for=\"status\">Situação:</label>
                                <select id=\"status\" class=\"form-control\" name=\"status\">
                                    <option value=\"CORRENTE\" selected=\"true\">CORRENTE</option>
                                    <option value=\"FINALIZADO\">FINALIZADO</option>
                                </select>
                            </div>
                        </fieldset>
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Cadastrar\">
                    </form>
                </div>
            </main>
        </div>
    </div>
    <p>Os temas a seguir serão incluídos no PAD automaticamente:</p>
    <ul>
        <li> Adestramento Básico de SIC;</li>
        <li> Conceitos Gerais de SIC;</li>
        <li> Instruções de Segurança da Informação e Comunicações (ISIC) da OM;</li>
        <li> Recursos Computacionais Críticos;</li>
        <li> Normas e Documentos de SIC;</li>
        <li> Ativação dos Planos de Contingência da OM;</li>
        <li> Segurança Orgânica referente à SIC;</li>
        <li> Normas para a salvaguarda de materiais controlados, dados, informações, 
            documentos e materiais sigilosos;</li>
        <li> Recursos Criptológicos;</li>
        <li> Engenharia Social;</li>
        <li> Crimes de Informática;</li>
        <li> Uso oficial de mídas e redes sociais pela MB e de uso não oficial de 
            mídias e redes sociais pelo pessoal da MB;</li>
        <li> Utilização de dispositivos móveis inteligentes e celulares;</li>
        <li> Compartilhamento e exclusão segura de arquivos;</li>
        <li> Portal de Serviços da MB.</li>
    </ul>";
}

/* Método INSERT */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){
        $pad->ano_base = $_POST['ano_base'];
        $pad->data_assinatura = $_POST['data_assinatura'];
        $pad->data_revisao = $_POST['data_revisao'];
        $pad->status = $_POST['status'];

        $row = $pad->InsertPAD();
        if ($row) {
            $pad->idtb_pad_sic_tic = $row;
            $insert = $pad->InsertTemaPadrão();
            echo "<h5>Resgistros incluídos no banco de dados.</h5>
            <meta http-equiv=\"refresh\" content=\"1;?cmd=padsictic\">";
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

/** Cadastro de temas no PAD */
if ($act == 'cad_temas') {
    @$param = $_GET['param'];
    @$tema = $_POST['tema'];
    $pad->tema = $tema;
    $pad->idtb_pad_sic_tic = $param;
    if ($tema){
        $row = $pad->InsertTema();
        if ($row) {
            echo "<h5>Resgistro incluído no banco de dados.</h5>
            <meta http-equiv=\"refresh\" content=\"1;?cmd=padsictic\">";
        }
        else {
            echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            echo(pg_result_error($row) . "<br />\n");
        }
    }
    else {
    echo "
    <div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"padsictic\" role=\"form\" action=\"?cmd=padsictic&act=cad_temas&param=$param\" 
                    method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                        <legend>Informe o Tema</legend>
                        <div class=\"form-group\">
                            <input id=\"tema\" class=\"form-control\" type=\"text\" name=\"tema\" 
                                required=\"true\" autocomplete=\"off\" autofocus=\"true\">
                        </div>
                        </fieldset>
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Inserir\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
    }    
}

/** Registro de adestramentos */
if ($act == 'reg_ade') {
    @$param = $_GET['param'];
    $pad->idtb_pad_sic_tic = $param;
    $row = $pad->SelectTemasIdPAD();
    echo"<div class=\"table-responsive\">
            <p>Selecione o Tema do Adestramento</p>
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Tema</th>
                        <th scope=\"col\">Situação</th>
                    </tr>
                </thead>";
    foreach ($row as $key => $value) {
        echo"       <tr>
                        <td>$value->tema</td>
                        <td>$value->status</td>
                        <td>
                            <a href=\"?cmd=padsictic&act=reg_presentes&param=".$value->idtb_temas_pad_sic_tic."\">
                                | Registar Adestramento | </a>
                            <a href=\"?cmd=padsictic&act=reg_justificativa&param=".$value->idtb_temas_pad_sic_tic."\">
                                | Justifcar não Atendimento | </a>
                        </td>
                    </tr>";
    }
    echo"
                </tbody>
            </table>
            </div>";
}

/** Registro de presentes no adestramento */
if ($act == 'reg_presentes') {
    @$param = $_GET['param'];
    @$usuario = $_POST['nip_cpf'];
    @$idtb_pessoal_om = $_GET['presente'];
    if ($usuario){
        $pesom->usuario = $usuario;
        $presente = $pesom->ChecaNIPCPF();
        if ($presente){
            echo"<div class=\"table-responsive\">
                <table class=\"table table-hover\">
                    <thead>
                        <tr>
                            <th scope=\"col\">Posto/Grad./Esp.</th>
                            <th scope=\"col\">NIP/CPF</th>
                            <th scope=\"col\">Nome de Guerra</th>
                        </tr>
                    </thead>";
            #Seleciona NIP caso seja militar da MB
            if ($presente->nip != NULL) {
                $identificacao = $presente->nip;
            }
            else{
                $identificacao = $presente->cpf;
            }
            echo"       <tr>";
            if (($presente->exibir_espec == 'NÃO') AND ($presente->exibir_corpo_quadro == 'NÃO')){
                echo"       <th scope=\"row\">".$presente->posto_grad."</th>";
            }
            elseif (($presente->exibir_espec == 'NÃO') AND ($presente->exibir_corpo_quadro != 'NÃO')){
                echo"       <th scope=\"row\">".$presente->posto_grad." ".$presente->corpo_quadro."</th>";
            }
            elseif (($presente->exibir_espec != 'NÃO') AND ($presente->exibir_corpo_quadro == 'NÃO')){
                echo"       <th scope=\"row\">".$presente->posto_grad." ".$presente->espec."</th>";
            }
            else {
                echo"       <th scope=\"row\">".$presente->posto_grad." ".$presente->corpo_quadro." 
                                ".$presente->espec."</th>";
            }
                echo"       <td>$identificacao</td>
                            <td>$presente->nome_guerra</td>
                            <td><a href=\"?cmd=padsictic&act=reg_presentes&param=".$param."&presente=".$presente->idtb_pessoal_om."\">
                                Incluir</a></td>
                        </tr>
                    </tbody>
                </table>
                </div>";
        }
        else{
            echo "<p>Não foi localizado usuário da OM com este NIP/CPF.</p>";
        }
    }
    if ($idtb_pessoal_om){
        $pad->idtb_temas_pad_sic_tic = $param;
        $pad->idtb_pessoal_om = $idtb_pessoal_om;
        $row = $pad->VerificaPresente();
        if ($row) {
            echo "<h5>NIP/CPF já registrado para esse tema.</h5>
            <meta http-equiv=\"refresh\" 
                content=\"3;?cmd=padsictic&act=reg_presentes&param=".$pad->idtb_temas_pad_sic_tic."\">";
        }
        else {
            $row = $pad->InsertPresente();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" 
                    content=\"1;?cmd=padsictic&act=reg_presentes&param=".$pad->idtb_temas_pad_sic_tic."\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }
    }
    else {
    echo "
    <div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"nip_cpf\" role=\"form\" action=\"?cmd=padsictic&act=reg_presentes&param=".$param."\" 
                    method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                        <legend>Presença Ade. SIC/TIC</legend>
                            <div class=\"form-group\">
                                <label for=\"nip_cpf\">Informe o NIP/CPF:</label>
                                <input id=\"nip_cpf\" class=\"form-control\" type=\"num\" name=\"nip_cpf\" 
                                    placeholder=\"NIP/CPF\" maxlength=\"11\" autofocus=\"true\" required=\"true\" autocomplete=\"off\">
                            </div>
                        </fieldset>
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Localizar\">
                    </form>
                </div>
                <br/><a href=\"?cmd=padsictic&act=finalizar_tema&param=".$param."\" 
                    <button class=\"btn btn-block btn-danger\">Finalizar Tema</button></a>
            </main>
        </div>
    </div>";
    }
}

/** Finaliza tema ministrado/não ministrado */
if ($act == 'finalizar_tema') {
    @$param = $_GET['param'];
    $pad->idtb_temas_pad_sic_tic = $param;
    $data = date("Y-m-d");
    $pad->data_ade = $data;
    $row = $pad->UpdateDataTema();
    if ($row) {
        echo "<h5>Resgistros incluídos no banco de dados.</h5>
        <meta http-equiv=\"refresh\" 
            content=\"1;?cmd=padsictic\">";
    }
    else {
        echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
        echo(pg_result_error($row) . "<br />\n");
    }
}

/** Registra justificativa do não atendimento */
if ($act == 'reg_justificativa') {
    @$param = $_GET['param'];
    $pad->idtb_temas_pad_sic_tic = $param;
    $data = date("Y-m-d");
    $pad->data_ade = $data;
    @$justificativa = mb_strtoupper($_POST['justificativa'],'UTF-8');
    $pad->justificativa = $justificativa;
    if ($justificativa){
        $row = $pad->UpdateDataTema();
        if ($row) {
            $row = $pad->UpdateJustificativa();
            if ($row){
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=padsictic\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }            
        }
        else {
            echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            echo(pg_result_error($row) . "<br />\n");
        }
    }
    else {
        echo "
        <div class=\"container-fluid\">
            <div class=\"row\">
                <main>
                    <div id=\"form-cadastro\">
                        <form id=\"reg_justificativa\" role=\"form\" 
                            action=\"?cmd=padsictic&act=reg_justificativa&param=".$param."\" 
                            method=\"post\" enctype=\"multipart/form-data\">
                            <fieldset>
                            <legend>Justificativa do não Atendimento</legend>
                                <div class=\"form-group\">
                                    <label for=\"justificativa\">Justificativa:</label>
                                    <input id=\"justificativa\" class=\"form-control\" type=\"text\" name=\"justificativa\" 
                                        placeholder=\"Justificativa\" maxlength=\"255\" autofocus=\"true\" required=\"true\" 
                                        style=\"text-transform:uppercase\" autocomplete=\"off\">
                                </div>
                            </fieldset>
                            <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                        </form>
                    </div>
                </main>
            </div>
        </div>";
    }
}

/* Monta quadro */
if (($row) AND ($act == NULL)) {

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Ano Base</th>
                        <th scope=\"col\">Data de Assinatura</th>
                        <th scope=\"col\">Data de Revisão</th>
                        <th scope=\"col\">Situação</th>
                    </tr>
                </thead>";

    foreach ($row as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->ano_base."</th>
                        <td>$value->data_assinatura</td>
                        <td>$value->data_revisao</td>
                        <td>$value->status</td>
                        <td><a href=\"?cmd=padsictic&act=cad&param=".$value->idtb_pad_sic_tic."\">| Modificar | </a> 
                            <a href=\"?cmd=padsictic&act=cad_temas&param=".$value->idtb_pad_sic_tic."\">
                                | Inserir Novo Tema | </a> 
                            <a href=\"?cmd=padsictic&act=reg_ade&param=".$value->idtb_pad_sic_tic."\">
                                | Registar Adestramento | </a> 
                            <a href=\"?cmd=padsictic&act=reg_ade&param=".$value->idtb_pad_sic_tic."\">
                                | Registar Justificativa | </a>
                            <a href=\"?cmd=padsictic&act=rel_ade&param=".$value->idtb_pad_sic_tic."\">
                                | Relatório de Presença | </a>
                        </td>
                    </tr>";
    }
    echo"
                </tbody>
            </table>
            </div>";
}

?>