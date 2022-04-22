<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$qti = new PessoalCLTI();

/* Recupera informações dos Admin */
$row = $qti->SelectAllQualif();

@$act = $_GET['act'];

/* Formulário para NIP/CPF */
if ($act == NULL) {
    echo "
    <div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"nip_cpf\" role=\"form\" action=\"?cmd=qualificacao&act=cad\" 
                    method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                        <legend>Qualificação em TI - Cadastro</legend>
                            <div class=\"form-group\">
                                <label for=\"nip_cpf\">Informe o NIP/CPF:</label>
                                <input id=\"nip_cpf\" class=\"form-control\" type=\"num\" name=\"nip_cpf\" autocomplete=\"off\"
                                    placeholder=\"NIP/CPF\" maxlength=\"11\" autofocus=\"true\" required=\"true\">
                            </div>
                        </fieldset>
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Localizar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];

    if ($param){
        $qti->idtb_qualificacao_clti = $param;
        $qualiti = $qti->SelectIdQualif();
    }
    else{
        @$qti->usuario = $_POST['nip_cpf'];
        $qualiti = $qti->ChecaNIPCPF();
        if ($qualiti){
            $qualiti = (object)['idtb_lotacao_clti'=>$qualiti->idtb_lotacao_clti,'idtb_qualificacao_clti'=>'',
                'sigla_posto_grad'=>$qualiti->sigla_posto_grad,'nome_guerra'=>$qualiti->nome_guerra,
                'instituicao'=>'','tipo'=>'','nome_curso'=>'','meio'=>'','situacao'=>'','data_conclusao'=>NULL,
                'carga_horaria'=>'','custo'=>''];
         }
        else{
            echo "<h5>Não foi encontrado pessoal do CLTI com este NIP/CPF.</h5>
                <meta http-equiv=\"refresh\" content=\"3;?cmd=qualificacao \">";
        }
    }

    echo "
	<div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"insereusuario\" role=\"form\" action=\"?cmd=qualificacao&act=insert\" 
                        method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>";

                            echo"
                            <legend>Qualificação na Área de TI ($qualiti->sigla_posto_grad - $qualiti->nome_guerra)</legend>

                            <input id=\"idtb_lotacao_clti\" type=\"hidden\" name=\"idtb_lotacao_clti\" 
                                value=\"$qualiti->idtb_lotacao_clti\">
                            
                            <div class=\"form-group\">
                                <label for=\"instituicao\">Instituição de Ensino:</label>
                                <input id=\"instituicao\" class=\"form-control\" type=\"text\" name=\"instituicao\"
                                    placeholder=\"ex. Universidade Federal do RN\" minlength=\"2\" autocomplete=\"off\"
                                    style=\"text-transform:uppercase\" required=\"true\" autofocus=\"true\"
                                    value=\"$qualiti->instituicao\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"tipo\">Tipo do Curso:</label>
                                <select id=\"tipo\" class=\"form-control\" name=\"tipo\">
                                    <option value=\"$qualiti->tipo\" selected=\"true\">$qualiti->tipo</option>
                                    <option value=\"GRADUAÇÃO\">GRADUAÇÃO</option>
                                    <option value=\"BACHARELADO\">BACHARELADO</option>
                                    <option value=\"POSGRAD\">PÓS GRADUAÇÃO</option>
                                    <option value=\"MESTRADO\">MESTRADO</option>
                                    <option value=\"DOUTORADO\">DOUTORADO</option>
                                    <option value=\"TÉCNICO\">TÉCNICO</option>
				                    <option value=\"CERTIFICAÇÃO\">CERTIFICAÇÃO</option>
				                    <option value=\"ESPECIAL\">CURSO ESPECIAL</option>
				                    <option value=\"EXPEDITO\">CURSO EXPEDITO</option>
                                    <option value=\"LIVRE\">LIVRE</option>
                                </select>
                            </div>

                            <div class=\"form-group\">
                                <label for=\"nome_curso\">Nome do Curso:</label>
                                <input id=\"nome_curso\" class=\"form-control\" type=\"text\" name=\"nome_curso\"
                                    placeholder=\"ex. Análise de Sistemas\" minlength=\"2\" autocomplete=\"off\"
                                    style=\"text-transform:uppercase\" required=\"true\" value=\"$qualiti->nome_curso\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"meio\">Modo do Curso:</label>
                                <select id=\"meio\" class=\"form-control\" name=\"meio\">
                                    <option value=\"$qualiti->meio\" selected=\"true\">$qualiti->meio</option>
                                    <option value=\"PRESENCIAL\">PRESENCIAL</option>
                                    <option value=\"SEMIPRESENCIAL\">SEMIPRESENCIAL</option>
                                    <option value=\"EAD\">EAD</option>
                                </select>
                            </div>

                            <div class=\"form-group\">
                                <label for=\"situacao\">Situação:</label>
                                <select id=\"situacao\" class=\"form-control\" name=\"situacao\">
                                    <option value=\"$qualiti->situacao\" selected=\"true\">$qualiti->situacao</option>
                                    <option value=\"CONCLUIÍDO\">CONCLUÍDO</option>
                                    <option value=\"EM ANDAMENTO\">EM ANDAMENTO</option>
                                </select>
                            </div>

                            <div class=\"form-group\">
                                <label for=\"data_conclusao\">Data de Conclusão:</label>
                                <input id=\"data_conclusao\" class=\"form-control\" type=\"date\" name=\"data_conclusao\" 
                                    value=\"$qualiti->data_conclusao\" autocomplete=\"off\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"carga_horaria\" class=\"control-label\">Carga Horária:</label>
                                <input id=\"carga_horaria\" class=\"form-control\" type=\"number\" name=\"carga_horaria\"
                                    required=\"true\" value=\"$qualiti->carga_horaria\" autocomplete=\"off\">
                            </div>

                            <div class=\"form-group\">
                                <label for=\"custo\" class=\"control-label\">Custo (Obrigatório se custeado pela OM):</label>
                                <input id=\"custo\" class=\"form-control\" type=\"number\" name=\"custo\"
                                    value=\"$qualiti->custo\" autocomplete=\"off\">
                            </div>
                        </fieldset>
                        <input id=\"idtb_qualificacao_clti\" type=\"hidden\" name=\"idtb_qualificacao_clti\" 
                            value=\"$qualiti->idtb_qualificacao_clti\">
                        <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                    </form>
                </div>
            </main>
        </div>
    </div>";
}

/* Monta quadro */
if (($row) AND ($act == NULL)) {

    $qti->ordena = "ORDER BY idtb_posto_grad, tipo, nome_curso, data_conclusao ASC LIMIT 30";
    $qualiti = $qti->SelectAllQualif();

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Posto/Grad./Esp.</th>
                        <th scope=\"col\">NIP</th>
                        <th scope=\"col\">Nome de Guerra</th>
                        <th scope=\"col\">Curso</th>
                        <th scope=\"col\">Situação</th>
			<th scope=\"col\">Conclusão</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    foreach ($qualiti as $key => $value) {

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
                        <td>$identificacao</td>
                        <td>$value->nome_guerra</td>
                        <td>$value->tipo $value->nome_curso</td>
                        <td>$value->situacao</td>
			            <td>$value->data_conclusao</td>
                        <td><a href=\"?cmd=qualificacao&act=cad&param=".$value->idtb_qualificacao_clti."\">Editar</a> - 
                            Excluir</td>
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
        $idtb_qualificacao_clti = $_POST['idtb_qualificacao_clti'];
        $qti->idtb_qualificacao_clti = $idtb_qualificacao_clti;
        $qti->idtb_lotacao_clti = $_POST['idtb_lotacao_clti'];
        $qti->instituicao = mb_strtoupper($_POST['instituicao'],'UTF-8');
        $qti->tipo = mb_strtoupper($_POST['tipo'],'UTF-8');
        $qti->nome_curso = mb_strtoupper($_POST['nome_curso'],'UTF-8');
        $qti->meio = mb_strtoupper($_POST['meio'],'UTF-8');
        $qti->situacao = mb_strtoupper($_POST['situacao'],'UTF-8');
        $data_conclusao = $_POST['data_conclusao'];
        $qti->data_conclusao = $data_conclusao;
        $qti->carga_horaria = $_POST['carga_horaria'];
        $qti->custo = $_POST['custo'];

        /* Opta pelo Método Update */
        if ($idtb_qualificacao_clti){
            if ($data_conclusao == NULL) {
                $qti->data_conclusao = 'NULL';
                $row = $qti->UpdateQualifAnd();
            }
            else{
                $row = $qti->UpdateQualif();
            }
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=qualificacao\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }
        /* Opta pelo Método Insert */
        else{
            if ($data_conclusao == NULL) {
                $qti->data_conclusao = 'NULL';
                $row = $qti->InsertQualifAnd();
            }
            else{
                $row = $qti->InsertQualif();
            }
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=qualificacao\">";
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