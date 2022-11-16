<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
**/

/* ClasSe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$config = new Config();
/*$om = new OMApoiadas();
$pesti = new PessoalTI();
$srv = new Servidores();
$et = new Estacoes();
$conect = new Conectividade();
$cont = new Contadores();
$qtdeom = $om->CountOMApoiadas();
$qtdeadmin = $pesti->CountAdmin();
$qtdeosic = $pesti->CountOSIC();
$qtdepesti = $pesti->CountPesTI();
$qtdesrv = $srv->CountSrv();
$qtdeet = $et->CountET();
$qtdeconect = $conect->CountConect();*/

/* URL Recuperada do Banco de Dados */
$url = $config->SelectURL();

include "../head.php";

include "../nav.php";

@$cmd = $_GET['cmd'];

if (isset($_SESSION['user_name'])){
  $perfil = $_SESSION['perfil']; 
  if ($perfil == 'GES.TI'){

    /* Montagem do grid html5 conforme módulo solicitado */
    switch ($cmd) {

    case 'apoiados':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
            <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 
                border-bottom\">
                <h1 class=\"h2\">Gerenciamento - Parâmetros de Configuração</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                <div class=\"btn-group madminr-2\">
                    <a href=\"?cmd=sistema\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Configurações</button></a>
                    <a href=\"$url/update.php\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Atualizar</button></a>
                </div>
                </div>
            </div>";
        include "sistema.inc.php";
        echo"
            </main>
            </div>
            </div>";
      
        break;
    
    case 'pesti':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
              <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 
                border-bottom\">
                <h1 class=\"h2\">Gerenciamento - Lotação do CLTI</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                  <div class=\"btn-group mr-2\">
                    <a href=\"?cmd=pesti&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
                    <a href=\"?cmd=pesti&act=inativos\"><button class=\"btn btn-sm btn-outline-secondary\">Inativos</button></a>
                  </div>
                </div>
              </div>";
        include "pesti.inc.php";
        echo"
            </main>
            </div>
            </div>";
  
        break;
    
    default:

        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
              <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 
                border-bottom\">
                <h1 class=\"h2\">Módulo de Gerenciamento do Sistema</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                  <div class=\"btn-group mr-2\">
                    <a href=\"?cmd=sistema\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Configurações</button></a>
                    <a href=\"$url/update.php\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Atualizar</button></a>
                  </div>
                </div>
              </div>
              <p>Chamados Totais: xx Chamados</p>
              <p>Chamados no Mês Corrente: xx Chamados</p>
              <p>Incidentes de TIC Relatados: xx Incidentes</p>
              <p>Tráfego do Correio Eletrônico (Mês Anterior): xx Mensagens</p>
              <p>Usuários do Correio Eletrônico: xx Usuários</p>
              <p>Tráfego de Dados Estimado de Correio Eletrônico: xx Gigabytes</p>
              <p>Tráfego de Dados Total Estimado (Backbone CLTI): xx Gigabytes</p>
            </main>
          </div>
        </div>";
        break;
    }
  }
  else{
    echo "<h5>Acesso não autorizado!</h5>
      <meta http-equiv=\"refresh\" content=\"5;$url\">";
  }
}
include "../foot.php";
?>