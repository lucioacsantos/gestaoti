<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$conect = new Conectividade();
$om = new OMApoiadas();
$ip = new IP();

/* Recupera informações */
$row = $conect->SelectAllTable();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if (($row == NULL) AND ($act == NULL)) {
	echo "<h5>Não há equipamentos de conectividade cadastrados,<br />
		 clique <a href=\"?cmd=conectividade&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro com objetos do banco ou vazios */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $conect->idtb_conectividade = $param;
        $conectividade = $conect->SelectIdView();
    }
    else{
        $conectividade = (object)['idtb_conectividade'=>'','idtb_om_apoiadas'=>'','modelo'=>'','end_ip'=>'','data_aquisicao'=>'',
            'data_garantia'=>'','fabricante'=>'','localizacao'=>'','idtb_om_apoiadas'=>'','sigla'=>''];
    }
    $om->ordena = "ORDER BY sigla ASC";
    $omapoiada = $om->SelectAllTable();

	include "conectividade-formcad.inc.php";
}

/* Monta quadro */
if (($row) AND ($act == NULL)) {
    $conect->ordena = "ORDER BY idtb_om_apoiadas ASC";
    $conectividade = $conect->SelectAllView();

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">OM Apoiada</th>
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
                        <td><a href=\"?cmd=conectividade&act=cad&param=".$value->idtb_conectividade."\">Editar</a> - 
                            Excluir</td>
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

        $conect->idtb_conectividade = $_POST['idtb_conectividade'];
        $conect->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $conect->fabricante = strtoupper($_POST['fabricante']);
        $conect->modelo = strtoupper($_POST['modelo']);
        $conect->end_ip = $_POST['end_ip'];
        $ip->end_ip = $_POST['end_ip'];
        $conect->localizacao = strtoupper($_POST['localizacao']);
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
                $row = $conect->UpdateTable();
            
                foreach ($row as $key => $value) {
                    if ($value != '0') {
                        echo "<h5>Resgistros incluídos no banco de dados.</h5>
                        <meta http-equiv=\"refresh\" content=\"1;url=?cmd=conectividade\">";
                    }
                    else {
                        echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    }
                break;
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
                $row = $conect->InsertTable();
          
                foreach ($pg as $key => $value) {
                    if ($value != '0') {
                        echo "<h5>Resgistros incluídos no banco de dados.</h5>
                        <meta http-equiv=\"refresh\" content=\"1;url=?cmd=conectividade\">";
                    }
                    else {
                        echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
                    }
                break;
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