<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
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
$om = new OrgaosApoiados();

$om->idtb_orgaos_apoiados = $oa;
if ($oa) {
    $setores = $om->SelectSetores();
}

/* Checa se há item cadastrado e Carrega form para cadastro de setores */
if (($setores == NULL) AND ($act == NULL) OR ($act == 'cad')) {
    $act = 'cad';
	if ($param){
        $om->idtb_setores_orgaos = $param;
        $setores = $om->SelectSetoresId();
    }
    else{
        $setores = (object)['idtb_setores_orgaos'=>'','idtb_orgaos_apoiados'=>'','nome_setor'=>'','sigla_setor'=>'',
            'cod_funcional'=>'','compartimento'=>''];
    }    
    include "setores-formcad.inc.php";
}

/* Monta quadro de setores por OM */
if (($setores) AND ($act == NULL)) {
    echo"<div class=\"table-responsive\">
            <table class=\"table table-hover\">
                <thead>
                    <tr>
                        <th scope=\"col\">Órgão Apoiados</th>
                        <th scope=\"col\">Cód.Elem.Funcional</th>
                        <th scope=\"col\">Nome</th>
                        <th scope=\"col\">Sigla</th>
                        <th scope=\"col\">Compartimento</th>
                        <th scope=\"col\">Ações</th>
                    </tr>
                </thead>";
    foreach ($setores as $key => $value) {
        echo"       <tr>
                        <th scope=\"row\">".$value->sigla_om."</th>
                        <td>".$value->cod_funcional."</td>
                        <td>".$value->nome_setor."</td>
                        <td>".$value->sigla_setor."</td>
                        <td>".$value->compartimento."</td>
                        <td><a href=\"?cmd=setores&oa=$oa&act=cad&param=".$value->idtb_setores_orgaos."\">Editar</a> - 
                            Excluir</td>
                    </tr>";
    };
    echo"
                </tbody>
            </table>
            </div>";
}

/* Método INSERT/UPDATE */
if ($act == 'insert') {
    if (isset($_SESSION['status'])){
        $idtb_setores_orgaos = $_POST['idtb_setores_orgaos'];
        $om->idtb_setores_orgaos = $idtb_setores_orgaos;
        $om->nome_setor = mb_strtoupper($_POST['nome_setor'],'UTF-8');
        $om->sigla_setor = mb_strtoupper($_POST['sigla_setor'],'UTF-8');
        $om->cod_funcional = mb_strtoupper($_POST['cod_funcional'],'UTF-8');
        $om->compart = mb_strtoupper($_POST['compart'],'UTF-8');
        $om->idtb_orgaos_apoiados = $_POST['idtb_orgaos_apoiados'];
        $oa = $om->idtb_orgaos_apoiados;

        /* Opta pelo Método Update */
        if ($idtb_setores_orgaos){
            $update = $om->UpdateSetores();
            if ($update) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=setores&oa=$oa\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            }
        }
        /* Opta pelo Método Insert */
        else{
            $insert = $om->InsertSetores();
            if ($insert) {
                echo "<h5>Resgistros incluídos no banco de dados.</h5>
                <meta http-equiv=\"refresh\" content=\"1;url=?cmd=setores&oa=$oa\">";
            }
            else {
                echo "<h5>Ocorreu algum erro, tente novamente.</h5>";
            }
        }
    }
    else{
        echo "<h5>Ocorreu algum erro, usuário não autenticado.</h5>
            <meta http-equiv=\"refresh\" content=\"1;$url\">";
    }
}
?>