<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$conect = new Conectividade();
$mapainfra = new MapaInfra();
$omap = new OMAPoiadas();
$ip = new IP();

$omapoiada = $_SESSION['id_om_apoiada'];
$omap->idtb_om_apoiadas = $omapoiada;
$conectividade = $conect->SelectAllConectView();

@$act = $_GET['act'];

/* Checa se há item cadastrado */
if (($conectividade == NULL) AND ($act == NULL)) {
	echo "<h5>Não há equipamentos de conectividade cadastrados,<br />
		 clique <a href=\"?cmd=conectividade&act=cad\">aqui</a> para fazê-lo.</h5>";
}

/* Carrega form para cadastro */
if ($act == 'cad') {
    @$param = $_GET['param'];
    if ($param){
        $conect->idtb_conectividade = $param;
        $conectividade = $conect->SelectIdConectView();
    }
    else{
        $conectividade = (object)['idtb_conectividade'=>'','idtb_om_apoiadas'=>'','modelo'=>'','nome'=>'','end_ip'=>'',
            'data_aquisicao'=>'','data_garantia'=>'','fabricante'=>'','qtde_portas'=>'','idtb_om_setores'=>'',
            'sigla_setor'=>'','idtb_om_apoiadas'=>'','sigla'=>'','compartimento'=>'',];
    }
    $conect->ordena = "ORDER BY nome_setor ASC";
    $local = $omap->SelectAllSetoresView();

	include "conectividade-formcad.inc.php";
}

/* Monta quadro com equipamentos de conectividade */
if (($conectividade) AND ($act == NULL)) {

    $omapoiada = $_SESSION['id_om_apoiada'];
    if ($omapoiada != ''){
        $conect->idtb_om_apoiadas = $omapoiada;
        $conectividade = $conect->SelectAllOMConectView();
    }
    else{
        $conectividade = $conect->SelectAllConectView();
    }

    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">OM Apoiada</th>
                        <th scope=\"col\">Localização</th>
                        <th scope=\"col\">Fabricante</th>
                        <th scope=\"col\">Modelo</th>
                        <th scope=\"col\">Nome</th>
                        <th scope=\"col\">Qtde. Portas</th>
                        <th scope=\"col\">Endereço IP</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";

    foreach ($conectividade as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->sigla."</th>
                        <td>".$value->compartimento."</td>
                        <td>".$value->fabricante."</td>
                        <td>".$value->modelo."</td>
                        <td>".$value->nome."</td>
                        <td>".$value->qtde_portas."</td>
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

/* Método INSERT/UPDATE */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){
        $idtb_conectividade = $_POST['idtb_conectividade'];
        $conect->idtb_conectividade = $idtb_conectividade;
        $conect->idtb_om_apoiadas = $_POST['idtb_om_apoiadas'];
        $conect->fabricante = mb_strtoupper($_POST['fabricante'],'UTF-8');
        $conect->modelo = mb_strtoupper($_POST['modelo'],'UTF-8');
        $conect->nome = mb_strtoupper($_POST['nome'],'UTF-8');
        $conect->qtde_portas = $_POST['qtde_portas'];
        $conect->end_ip = $_POST['end_ip'];
        $ip->end_ip = $_POST['end_ip'];
        $conect->idtb_om_setores = mb_strtoupper($_POST['idtb_om_setores'],'UTF-8');
        $conect->data_aquisicao = $_POST['data_aquisicao'];
        $conect->data_garantia = $_POST['data_garantia'];
        $conect->status = $_POST['status'];

        /* Opta pelo Método Update */
        if ($idtb_conectividade){

            $checa_ip = $ip->SearchIP();
            if ($checa_ip){
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