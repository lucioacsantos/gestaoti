<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
**/

/** Leitura de parâmetros */
$oa = $cmd = $param = $act = NULL;
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

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$conect = new Conectividade();
$om = new OrgaosApoiados();
$ip = new IP();

/* Recupera informações */
$row = $conect->SelectAllConectTable();

/* Checa se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há equipamentos de conectividade cadastrados.</h5>";
}

/* Carrega form para cadastro com objetos do banco ou vazios */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $conect->idtb_conectividade = $param;
        $conectividade = $conect->SelectIdConectView();
    }
    else{
        $conectividade = (object)['idtb_conectividade'=>'','idtb_orgaos_apoiados'=>'','fabricante'=>'','modelo'=>'','nome'=>'',
            'qtde_portas'=>'','idtb_setores_orgaos'=>'','end_ip'=>'','data_aquisicao'=>'','data_garantia'=>'','status'=>'',
            'sigla'=>'','sigla_setor'=>'','compartimento'=>''];
    }
    $om->idtb_orgaos_apoiados = $oa;
    $local = $om->SelectSetores();
	include "conectividade-formcad.inc.php";
}

/* Monta quadro */
if (($row) AND ($act == NULL)) {
    $conect->ordena = "ORDER BY idtb_om_apoiadas ASC";
    $conectividade = $conect->SelectAllConectView();

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Órgão</th>
                        <th scope=\"col\">Fabricante</th>
                        <th scope=\"col\">Modelo</th>
                        <th scope=\"col\">Endereço IP</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    foreach ($conectividade as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->sigla."</th>
                        <td>".$value->fabricante."</td>
                        <td>".$value->modelo."</td>
                        <td>".$value->end_ip."</td>
                        <td><a href=\"?cmd=conectividade&act=cad&oa=$value->idtb_orgaos_apoiados&param=".$value->idtb_conectividade."\">
                            Editar</a></td>
                    </tr>";
    }
    echo"
                </tbody>
            </table>
            </div>";
}

/* Comando INSERT */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){
        $idtb_conectividade = $_POST['idtb_conectividade'];
        $conect->idtb_conectividade = $idtb_conectividade;
        $conect->idtb_orgaos_apoiados = $oa;
        $conect->fabricante = strtoupper($_POST['fabricante']);
        $conect->modelo = strtoupper($_POST['modelo']);
        $conect->nome = strtoupper($_POST['nome']);
        $conect->qtde_portas = $_POST['qtde_portas'];
        $conect->status = $_POST['status'];
        $conect->end_ip = $_POST['end_ip'];
        $ip->end_ip = $_POST['end_ip'];
        $conect->idtb_setores_orgaos = $_POST['idtb_setores_orgaos'];
        $conect->data_aquisicao = $_POST['data_aquisicao'];
        $conect->data_garantia = $_POST['data_garantia'];
        
        /* Opta pelo Método Update */
        if ($idtb_conectividade){
            $checa_ip = $ip->SearchIP();
            if ($checa_ip != NULL){
                echo "<h5>Endereço IP informado já está em uso, 
                    por favor verifique!</h5>
                    <meta http-equiv=\"refresh\" content=\"5;url=?cmd=conectividade\">";
            }
            else{
                $row = $conect->UpdateConect();            
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=conectividade\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                }
            }
        }
        /* Opta pelo Método Insert */
        else {
            $checa_ip = $ip->SearchIP();            
            if ($checa_ip){
                echo "<h5>Endereço IP informado já está em uso, 
                    por favor verifique!</h5>
                    <meta http-equiv=\"refresh\" content=\"5;url=?cmd=conectividade\">";
            }
            else{
                $row = $conect->InsertConect();
                if ($row) {
                    echo "<h5>Resgistros incluídos no banco de dados.</h5>
                    <meta http-equiv=\"refresh\" content=\"1;url=?cmd=conectividade\">";
                }
                else {
                    echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
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