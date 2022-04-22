<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* ClasSe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$config = new Config();
$om = new OMApoiadas();
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
$qtdeconect = $conect->CountConect();

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
      case 'tipoclti':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
              <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                <h1 class=\"h2\">Gerenciamento - Tipos de CLTI</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                  <div class=\"btn-group mr-2\">
                    <a href=\"?cmd=gerclti\"><button class=\"btn btn-sm btn-outline-secondary\">Gerenciamento do CLTI</button></a>
                  </div>
                  <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                    <span data-feather=\"calendar\"></span>
                    Esta Semana
                  </button>-->
                </div>
              </div>";
        include "tipoclti.inc.php";
        echo"
        </main>
          </div>
        </div>";

      break;

      case 'gerclti':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
              <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                <h1 class=\"h2\">Gerenciamento - CLTI Ativo</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                  <div class=\"btn-group mr-2\">
                    <a href=\"?cmd=gerclti\"><button class=\"btn btn-sm btn-outline-secondary\">Dados do CLTI</button></a>
                  </div>
                  <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                    <span data-feather=\"calendar\"></span>
                    Esta Semana
                  </button>-->
                </div>
              </div>";
        include "gerclti.inc.php";
        echo"
        </main>
          </div>
        </div>";

      break;

      case 'lotclti':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
              <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                <h1 class=\"h2\">Gerenciamento - Lotação do CLTI</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                  <div class=\"btn-group mr-2\">
                    <a href=\"?cmd=lotclti\"><button class=\"btn btn-sm btn-outline-secondary\">Efetivo do CLTI</button></a>
                    <a href=\"?cmd=lotclti&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
                    <a href=\"?cmd=lotclti&act=calcula\"><button class=\"btn btn-sm btn-outline-secondary\">Calcular Lotação</button></a>
                    <a href=\"?cmd=lotclti&act=inativos\"><button class=\"btn btn-sm btn-outline-secondary\">Inativos</button></a>
                    <a href=\"?cmd=lotclti&act=aprovrelsv\"><button class=\"btn btn-sm btn-outline-secondary\">Aprovador Rel. Serviço</button></a>
                    <a href=\"?cmd=lotclti&act=servico\"><button class=\"btn btn-sm btn-outline-secondary\">Escala de Serviço</button></a>
                  </div>
                  <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                    <span data-feather=\"calendar\"></span>
                    Esta Semana
                  </button>-->
                </div>
              </div>";
        include "lotclti.inc.php";
        echo"
        </main>
          </div>
        </div>";

      break;

      case 'qualificacao':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
              <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                <h1 class=\"h2\">Gerenciamento - Lotação do CLTI</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                  <div class=\"btn-group mr-2\">
                    <a href=\"?cmd=qualificacao\"><button class=\"btn btn-sm btn-outline-secondary\">Cursos Pessoal do CLTI</button></a>
                    <a href=\"?cmd=qualificacao&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
                  </div>
                  <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                    <span data-feather=\"calendar\"></span>
                    Esta Semana
                  </button>-->
                </div>
              </div>";
        include "qualificacao.inc.php";
        echo"
        </main>
          </div>
        </div>";
  
      break;

      case 'omapoiadas':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
              <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                <h1 class=\"h2\">Gerenciamento - OM Apoiadas pelo CLTI</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                  <div class=\"btn-group mr-2\">
                    <a href=\"?cmd=omapoiadas\"><button class=\"btn btn-sm btn-outline-secondary\">OM Apoiadas</button></a>
                    <a href=\"?cmd=omapoiadas&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Nova OM</button></a>
                  </div>
                  <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                    <span data-feather=\"calendar\"></span>
                    Esta Semana
                  </button>-->
                </div>
              </div>";
        include "omapoiadas.inc.php";
        echo"
        </main>
          </div>
        </div>";

      break;

      case 'osic':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
              <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                <h1 class=\"h2\">Gerenciamento - OSIC das OM Apoiadas</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                  <div class=\"btn-group mr-2\">
                    <a href=\"?cmd=osic\"><button class=\"btn btn-sm btn-outline-secondary\">
                      OSIC das OM</button></a>
                    <a href=\"?cmd=osic&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
                    <a href=\"?cmd=osic&act=inativos\"><button class=\"btn btn-sm btn-outline-secondary\">Inativos</button></a>
                  </div>
                  <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                    <span data-feather=\"calendar\"></span>
                    Esta Semana
                  </button>-->
                </div>
              </div>";
        include "osic.inc.php";
        echo"
        </main>
          </div>
        </div>";

      break;

      case 'admin':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
              <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                <h1 class=\"h2\">Gerenciamento - Admin das OM Apoiadas</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                  <div class=\"btn-group madminr-2\">
                    <a href=\"?cmd=admin\"><button class=\"btn btn-sm btn-outline-secondary\">Administradores</button></a>
                    <a href=\"?cmd=admin&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
                    <a href=\"?cmd=admin&act=inativos\"><button class=\"btn btn-sm btn-outline-secondary\">Inativos</button></a>
                  </div>
                  <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                    <span data-feather=\"calendar\"></span>
                    Esta Semana
                  </button>-->
                </div>
              </div>";
        include "admin.inc.php";
        echo"
        </main>
          </div>
        </div>";

      break;

      case 'funcoesti':
          echo "
              <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
                <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                  <h1 class=\"h2\">Gerenciamento - Funções de TI</h1>
                  <div class=\"btn-toolbar mb-2 mb-md-0\">
                    <div class=\"btn-group madminr-2\">
                      <a href=\"?cmd=funcoesti\"><button class=\"btn btn-sm btn-outline-secondary\">Funções de TI</button></a>
                      <a href=\"?cmd=funcoesti&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
                    </div>
                    <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                      <span data-feather=\"calendar\"></span>
                      Esta Semana
                    </button>-->
                  </div>
                </div>";
          include "funcoesti.inc.php";
          echo"
          </main>
            </div>
          </div>";
  
        break;

        case 'sistema':
          echo "
              <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
                <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                  <h1 class=\"h2\">Gerenciamento - Parâmetros de Configuração</h1>
                  <div class=\"btn-toolbar mb-2 mb-md-0\">
                    <div class=\"btn-group madminr-2\">
                      <a href=\"?cmd=sistema\"><button class=\"btn btn-sm btn-outline-secondary\">Configurações</button></a>
                    </div>
                    <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                      <span data-feather=\"calendar\"></span>
                      Esta Semana
                    </button>-->
                  </div>
                </div>";
          include "sistema.inc.php";
          echo"
          </main>
            </div>
          </div>";
      
        break;

        case 'perfilinternet':
          echo "
              <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
                <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                  <h1 class=\"h2\">Perfis de Internet</h1>
                  <div class=\"btn-toolbar mb-2 mb-md-0\">
                    <div class=\"btn-group mr-2\">
                      <a href=\"?cmd=perfilinternet\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Perfis</button></a>
                      <a href=\"?cmd=perfilinternet&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Cadastro</button></a>
                    </div>
                  </div>
                </div>";
          include "perfilinternet.inc.php";
          echo"
          </main>
            </div>
          </div>";
      
        break;

        case 'monitoramento':
          echo "
              <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
                <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                  <h1 class=\"h2\">Monitoramento</h1>
                  <div class=\"btn-toolbar mb-2 mb-md-0\">
                    <div class=\"btn-group mr-2\">
                      <a href=\"?cmd=monitoramento\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Perfis</button></a>
                      <a href=\"?cmd=monitoramento&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Cadastro</button></a>
                    </div>
                  </div>
                </div>";
          include "monitoramento.inc.php";
          echo"
          </main>
            </div>
          </div>";
      
        break;

        case 'relservico':
          echo "
              <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
                <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
                  <h1 class=\"h2\">Relatório de Serviço</h1>
                  <div class=\"btn-toolbar mb-2 mb-md-0\">
                    <div class=\"btn-group mr-2\">
                      <a href=\"?cmd=relservico&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Novo Relatório</button></a>
                      <a href=\"?cmd=relservico\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Em Andamento</button></a>
                      <a href=\"?cmd=relservico&act=encerrados\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Encerrados pelo Supervisor</button></a>
                      <a href=\"?cmd=relservico&act=agaprov\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Aguardando aprovação</button></a>
                      <a href=\"?cmd=relservico&act=aprovados\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Aprovados pelo Encarregado</button></a>
                    </div>
                  </div>
                </div>";
          include "relservico.inc.php";
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
  else{
    echo "<h5>Acesso não autorizado!</h5>
      <meta http-equiv=\"refresh\" content=\"5;$url\">";
  }
}
include "../foot.php";
?>
