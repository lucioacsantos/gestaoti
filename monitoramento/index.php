<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* ClasSe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$config = new Config();
$om = new OMApoiadas();
$conect = new Conectividade();

/* URL Recuperada do Banco de Dados */
$url = $config->SelectURL();

include "../head.php";

include "../nav.php";

@$cmd = $_GET['cmd'];

if (isset($_SESSION['user_name'])){
    $perfil = $_SESSION['perfil']; 
    if ($perfil == 'TEC_CLTI'){
        /* Montagem do grid html5 conforme módulo solicitado */
        switch ($cmd) {
        case 'monitoramento':
            echo "
                <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
                <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 
                    border-bottom\">
                    <h1 class=\"h2\">Subsistema de Monitoramento</h1>
                    <div class=\"btn-toolbar mb-2 mb-md-0\">
                    <div class=\"btn-group mr-2\">
                        <a href=\"?cmd=novogateway\"><button class=\"btn btn-sm btn-outline-secondary\">
                            Nogo Gateway de OM</button></a>
                    </div>
                    <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                        <span data-feather=\"calendar\"></span>
                        Esta Semana
                    </button>-->
                    </div>
                </div>";
            include "monitoramento.inc.php";
            echo"
            </main>
            </div>
            </div>";
            break;

        default:

        case 'novogateway':
            echo "
                <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
                <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 
                    border-bottom\">
                    <h1 class=\"h2\">Subsistema de Monitoramento</h1>
                    <div class=\"btn-toolbar mb-2 mb-md-0\">
                    <div class=\"btn-group mr-2\">
                        <a href=\"?cmd=novogateway\"><button class=\"btn btn-sm btn-outline-secondary\">
                            Nogo Gateway de OM</button></a>
                    </div>
                    <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                        <span data-feather=\"calendar\"></span>
                        Esta Semana
                    </button>-->
                    </div>
                </div>";
            include "monitoramento.inc.php";
            echo"
            </main>
            </div>
            </div>";
            break;

        default:

        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
              <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                <h1 class=\"h2\">Módulo de Gerenciamento do CLTI</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                  <div class=\"btn-group mr-2\">
                    <!--<a href=\"?cmd=tipoclti\"><button class=\"btn btn-sm btn-outline-secondary\">Tipo do CLTI</button></a>-->
                    <a href=\"?cmd=gerclti\"><button class=\"btn btn-sm btn-outline-secondary\">Gerenciamento do CLTI</button></a>
                    <a href=\"?cmd=sistema\"><button class=\"btn btn-sm btn-outline-secondary\">Configurações</button></a>
                    <a href=\"$url/update.php\"><button class=\"btn btn-sm btn-outline-secondary\">Atualizar</button></a>
                  </div>
                  <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                    <span data-feather=\"calendar\"></span>
                    Esta Semana
                  </button>-->
                </div>
              </div>
              <p>OM Apoiadas: ".$qtdeom." OM</p>
              <p>Pessoal de TI (Admin): ".$qtdeadmin."</p>
              <p>Pessoal de TI (OSIC): ".$qtdeosic."</p>
              <p>Pessoal de TI (Manutenção/Suporte): ".$qtdepesti."</p>
              <p>Servidores (Total): ".$qtdesrv."</p>
              <p>Estações de Trabalho (Total): ".$qtdeet."</p>
              <p>Equipamentos de Conectividade (Total): ".$qtdeconect."</p>
              <!--<p>Chamados Totais: xx Chamados</p>
              <p>Chamados no Mês Corrente: xx Chamados</p>
              <p>Incidentes de TIC Relatados: xx Incidentes</p>
              <p>Tráfego do Correio Eletrônico (Mês Anterior): xx Mensagens</p>
              <p>Usuários do Correio Eletrônico: xx Usuários</p>
              <p>Tráfego de Dados Estimado de Correio Eletrônico: xx Gigabytes</p>
              <p>Tráfego de Dados Total Estimado (Backbone CLTI): xx Gigabytes</p>-->
            </main>
            </div>
            </div>";
            break;
        }
    }
}

include "../foot.php";
?>