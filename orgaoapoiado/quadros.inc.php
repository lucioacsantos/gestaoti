<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$config = new Config();
$cont = new Contadores();

@$cmd = $_GET['cmd'];

if (isset($_SESSION['user_name'])){
    $perfil = $_SESSION['perfil']; 
    $omapoiada = $_SESSION['id_om_apoiada'];
    $et = $cont->CountET("AND idtb_om_apoiadas = $omapoiada");
    $srv = $cont->CountSrv("AND idtb_om_apoiadas = $omapoiada");
    $conect = $cont->CountConect("AND idtb_om_apoiadas = $omapoiada");
    $usb = $cont->CountUSBLiberado("AND idtb_om_apoiadas = $omapoiada");
    $adm = $cont->CountPermAdmin("AND idtb_om_apoiadas = $omapoiada");
    $naopad = $cont->CountSoftNaoPad("AND idtb_om_apoiadas = $omapoiada");
    $pessti = $cont->CountPessTI("AND idtb_om_apoiadas = $omapoiada");
    $qualiti = $cont->CountQualiTI("AND idtb_om_apoiadas = $omapoiada");
    $pessom = $cont->CountPessoalOM("AND idtb_om_apoiadas = $omapoiada");
    $perfint = $cont->CountControleInternet("AND idtb_om_apoiadas = $omapoiada");
    $sigdem = $cont->CountFuncSiGDEM("AND idtb_om_apoiadas = $omapoiada");
    echo "
        <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Quadros de Situação</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
            <div class=\"btn-group mr-2\">
                <!--<a href=\"?cmd=gerclti\"><button class=\"btn btn-sm btn-outline-secondary\">Gerenciamento do CLTI</button></a>
                <a href=\"?cmd=sistema\"><button class=\"btn btn-sm btn-outline-secondary\">Configurações</button></a>-->
            </div>
            </div>
        </div>
        <h4>Estações de Trabalho</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                    <th scope=\"col\">OM</th>
                    <th scope=\"col\">SO</th>
                    <th scope=\"col\">Qtde</th>
                    <th scope=\"col\">Req.Mínimos</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($et as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla</td>
                    <td>$value->descricao $value->versao</td>
                    <th scope=\"row\">$value->cont</th>
                    <td>$value->req_minimos</td>
                </tr>";
            }
            echo"
            </tbody>
        </table>
        <h4>Servidores</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                <th scope=\"col\">OM</th>
                <th scope=\"col\">SO</th>
                <th scope=\"col\">Qtde</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($srv as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla</td>
                    <td>$value->descricao $value->versao</td>
                    <th scope=\"row\">$value->cont</th>
                </tr>";
            }
            echo"
            </tbody>
        </table>
        <h4>Equipamentos de Conecitividade</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                    <th scope=\"col\">OM</th>
                    <th scope=\"col\">Qtde</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($conect as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla</td>
                    <th scope=\"row\">$value->cont</th>
                </tr>";
            }
            echo"
            </tbody>
        </table>
        <h4>Armazenamento USB Liberado</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                <th scope=\"col\">OM</th>
                <th scope=\"col\">Qtde</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($conect as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla</td>
                    <th scope=\"row\">$value->cont</th>
                </tr>";
            }
            echo"
            </tbody>
        </table>
        <h4>Permissões de Administrador</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                <th scope=\"col\">OM</th>
                <th scope=\"col\">Qtde</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($adm as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla</td>
                    <th scope=\"row\">$value->cont</th>
                </tr>";
            }
            echo"
            </tbody>
        </table>
        <h4>Software Não Padronizados</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                <th scope=\"col\">OM</th>
                <th scope=\"col\">Qtde</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($naopad as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla</td>
                    <th scope=\"row\">$value->cont</th>
                </tr>";
            }
            echo"
            </tbody>
        </table>
        <h4>Pessoal de TI</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                <th scope=\"col\">OM</th>
                <th scope=\"col\">Qtde</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($pessti as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla_om</td>
                    <th scope=\"row\">$value->cont</th>
                </tr>";
            }
            echo"
            </tbody>
        </table>
        <h4>Qualificação do Pessoal de TI</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                <th scope=\"col\">OM</th>
                <th scope=\"col\">Qtde</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($qualiti as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla_om</td>
                    <th scope=\"row\">$value->cont</th>
                </tr>";
            }
            echo"
            </tbody>
        </table>
        <h4>Usuários das OM</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                <th scope=\"col\">OM</th>
                <th scope=\"col\">Qtde</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($pessom as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla_om</td>
                    <th scope=\"row\">$value->cont</th>
                </tr>";
            }
            echo"
            </tbody>
        </table>
        <h4>Perfis de Internet</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                <th scope=\"col\">OM</th>
                <th scope=\"col\">Qtde</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($perfint as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla</td>
                    <th scope=\"row\">$value->cont</th>
                </tr>";
            }
            echo"
            </tbody>
        </table>
        <h4>Funções do SiGDEM</h4>
        <table class=\"table table-bordered\">
            <thead>
                <tr>
                <th scope=\"col\">OM</th>
                <th scope=\"col\">Qtde</th>
                </tr>
            </thead>
            <tbody>";
            foreach ($sigdem as  $key => $value){
                echo"              
                <tr>
                    <td>$value->sigla_om</td>
                    <th scope=\"row\">$value->cont</th>
                </tr>";
            }
            echo"
            </tbody>
        </table>  
        </main>
        </div>
    </div>";
}
else{
    echo "<h5>Acesso não autorizado!</h5>
      <meta http-equiv=\"refresh\" content=\"5;$url\">";
}

?>