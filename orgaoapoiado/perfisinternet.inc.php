<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$internet = new PerfilInternet();
$om = new OMApoiadas();
$pessom = new PessoalOM();

$omapoiada = $_SESSION['id_om_apoiada'];
$om->idtb_om_apoiadas = $omapoiada;

$perfis = $internet->SelectAll();
$qtde_perfis = $internet->SelectCount();

/* Recupera informações */
$row = $pessom->SelectPerfilAll();

@$act = $_GET['act'];

/* Formulário para NIP/CPF */
if ($act == NULL) {
    echo "
    <div class=\"container-fluid\">
        <div class=\"row\">
            <main>
                <div id=\"form-cadastro\">
                    <form id=\"nip_cpf\" role=\"form\" action=\"?cmd=perfisinternet&act=cad\" 
                    method=\"post\" enctype=\"multipart/form-data\">
                        <fieldset>
                        <legend>Perfil  de Internet</legend>
                            <div class=\"form-group\">
                                <label for=\"nip_cpf\">Informe o NIP/CPF:</label>
                                <input id=\"nip_cpf\" class=\"form-control\" type=\"num\" name=\"nip_cpf\" 
                                    placeholder=\"NIP/CPF\" maxlength=\"11\" autofocus=\"true\" required=\"true\" 
                                    autocomplete=\"off\">
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
        $pessom->idtb_controle_internet = $param;
        $usuario = $pessom->SelectPerfilID();
        echo "
                <div class=\"container-fluid\">
                    <div class=\"row\">
                        <main>
                            <div id=\"form-cadastro\">
                                <form id=\"perfil_internet\" role=\"form\" action=\"?cmd=perfisinternet&act=insert\" 
                                    method=\"post\" enctype=\"multipart/form-data\">
                                    <fieldset>
                                        <legend>Selecione os Perfis para: $usuario->posto_grad $usuario->nome_guerra</legend>
                                        <div class=\"form-group\">";
                                                foreach ($perfis as $key => $value) {
                                                    echo"
                                                    <input type=\"checkbox\" name=\"perfis[]\" 
                                                        value=\"".$value->idtb_perfil_internet."\">
                                                    <label for=\"perfis\"> ".$value->nome."</label><br>
                                                    ";
                                                };
                                            echo "
                                        </div>                                        
                                    </fieldset>
                                    <input id=\"idtb_controle_internet\" type=\"hidden\" name=\"idtb_controle_internet\" 
                                        value=\"$usuario->idtb_controle_internet\">
                                    <input id=\"idtb_pessoal_om\" type=\"hidden\" name=\"idtb_pessoal_om\" 
                                        value=\"$usuario->idtb_pessoal_om\">
                                    <input id=\"idtb_om_apoiadas\" type=\"hidden\" name=\"idtb_om_apoiadas\" 
                                        value=\"$usuario->idtb_om_apoiadas\">
                                    <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                                </form>
                            </div>
                        </main>
                    </div>
                </div>";
    }
    else{
        @$pessom->usuario = $_POST['nip_cpf'];
        $usuario = $pessom->ChecaNIPCPF();
        if ($usuario){
            $usuario = (object)['idtb_pessoal_om'=>$usuario->idtb_pessoal_om,'idtb_controle_internet'=>'',
                'sigla_om'=>$usuario->sigla_om,'posto_grad'=>$usuario->posto_grad,
                'idtb_om_apoiadas'=>$usuario->idtb_om_apoiadas,'nome_guerra'=>$usuario->nome_guerra,'perfis'=>''];            
            echo "
                <div class=\"container-fluid\">
                    <div class=\"row\">
                        <main>
                            <div id=\"form-cadastro\">
                                <form id=\"perfil_internet\" role=\"form\" action=\"?cmd=perfisinternet&act=insert\" 
                                    method=\"post\" enctype=\"multipart/form-data\">
                                    <fieldset>
                                        <legend>Selecione os Perfis para: $usuario->posto_grad $usuario->nome_guerra</legend>
                                        <div class=\"form-group\">";
                                                foreach ($perfis as $key => $value) {
                                                    echo"
                                                    <input type=\"checkbox\" name=\"perfis[]\" 
                                                        value=\"".$value->idtb_perfil_internet."\">
                                                    <label for=\"perfis\"> ".$value->nome."</label><br>
                                                    ";
                                                };
                                            echo "
                                        </div>                                        
                                    </fieldset>
                                    <input id=\"idtb_controle_internet\" type=\"hidden\" name=\"idtb_controle_internet\" 
                                        value=\"$usuario->idtb_controle_internet\">
                                    <input id=\"idtb_pessoal_om\" type=\"hidden\" name=\"idtb_pessoal_om\" 
                                        value=\"$usuario->idtb_pessoal_om\">
                                    <input id=\"idtb_om_apoiadas\" type=\"hidden\" name=\"idtb_om_apoiadas\" 
                                        value=\"$usuario->idtb_om_apoiadas\">
                                    <input class=\"btn btn-primary btn-block\" type=\"submit\" value=\"Salvar\">
                                </form>
                            </div>
                        </main>
                    </div>
                </div>";
         }
        else{
            echo "<h5>Não foi encontrado Usuário com este NIP/CPF.</h5>
                <meta http-equiv=\"refresh\" content=\"3;?cmd=perfisinternet \">";
        }
    }

    
}


/* Monta quadro */
if (($row) AND ($act == NULL)) {
    $pessom->idtb_om_apoiadas = $omapoiada;
    $controle = $pessom->SelectPerfilOM();
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Posto/Grad./Esp.</th>
                        <th scope=\"col\">Nome de Guerra</th>
                        <th scope=\"col\">Perfis</th>
                    </tr>
                </thead>";
    foreach ($controle as $key => $value) {
        $array = explode(", ",$value->perfis);
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
            echo"       <td>".$value->nome_guerra."</td>
                        <td>";
                        foreach ($array as $chave => $valor){
                            if  ($valor != 0){
                                $internet->idtb_perfil_internet = $valor;
                                $perfilcad = $internet->SelectId();
                                $perf = (array)($perfilcad);
                                echo "".$perf['nome']."</br>";
                            }
                        }
                        echo"
                        <td><a href=\"?cmd=perfisinternet&act=cad&param=".$value->idtb_controle_internet."\">Editar</a></td>
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
        $idtb_controle_internet = $_POST['idtb_controle_internet'];
        $pessom->idtb_controle_internet = $idtb_controle_internet;
        $pessom->idtb_pessoal_om = $_POST['idtb_pessoal_om'];
        $pessom->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];

        $array = [];
        $perfis_checkboxes = array_flip($_POST['perfis']);
        for ($i = 1; $i <= $qtde_perfis; $i++) {
            if (isset($perfis_checkboxes[$i])) {
                $array[] = $i;
            } else {
                $array[] = 0;
            }
        }
        $perfis_array = implode(', ', $array);
        $pessom->perfis = $perfis_array;

        /* Opta pelo Método Update */
        if ($idtb_controle_internet){
            $row = $pessom->UpdatePerfil();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=perfisinternet \">";
            }    
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                echo(pg_result_error($row) . "<br />\n");
            }
        }        
        else{
            /* Opta pelo Método Insert */
            $row = $pessom->InsertPerfil();
            if ($row) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;?cmd=perfisinternet\">";
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