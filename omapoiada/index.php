<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$cfg = new Config();

/* URL Recuperada do Banco de Dados */
$url = $cfg->SelectURL();

include "../head.php";

include "../nav.php";

@$cmd = $_GET['cmd'];

/* Montagem do grid html5 conforme módulo solicitado */
switch ($cmd) {
  case 'setores':
		echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Gerenciamento - Setores da OM</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=setores\"><button class=\"btn btn-sm btn-outline-secondary\">Setores da OM</button></a>
                <a href=\"?cmd=setores&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
		include "setores.inc.php";
		echo"
		</main>
      </div>
    </div>";

  break;
    
	case 'pessoalti':
		echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Gerenciamento - Pessoal de TI</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=pessoalti\"><button class=\"btn btn-sm btn-outline-secondary\">Pessoal de TI</button></a>
                <a href=\"?cmd=pessoalti&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
		include "pessoalti.inc.php";
		echo"
		</main>
      </div>
    </div>";

  break;
  
  case 'pessoalom':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Gerenciamento - Pessoal da OM</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=pessoalom\"><button class=\"btn btn-sm btn-outline-secondary\">Pessoal da OM</button></a>
                <a href=\"?cmd=pessoalom&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "pessoalom.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;
    
  case 'funcsigdem':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Gerenciamento - Funções do SiGDEM</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=funcsigdem\"><button class=\"btn btn-sm btn-outline-secondary\">Funções do SiGDEM</button></a>
                <a href=\"?cmd=funcsigdem&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "funcsigdem.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;
    
  case 'controleusb':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Liberação do Armazenamento USB</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=controleusb\"><button class=\"btn btn-sm btn-outline-secondary\">ET/Usuários Autorizados</button></a>
                <a href=\"?cmd=controleusb&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "controleusb.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;

  case 'administrador':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Permissões de Administrador</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=administrador\"><button class=\"btn btn-sm btn-outline-secondary\">ET/Usuários Autorizados</button></a>
                <a href=\"?cmd=administrador&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "administrador.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;

  case 'naopad':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Autorização para Software não Padronizado</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=naopad\"><button class=\"btn btn-sm btn-outline-secondary\">ET/Usuários Autorizados</button></a>
                <a href=\"?cmd=naopad&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "naopad.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;
  
  case 'perfisinternet':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Perfis de Internet</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=perfisinternet\"><button class=\"btn btn-sm btn-outline-secondary\">Perfis de Internet</button></a>
                <a href=\"?cmd=perfisinternet&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "perfisinternet.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;

	case 'cursosti':
		echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Gerenciamento - Cursos na Área de TI</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=cursosti\"><button class=\"btn btn-sm btn-outline-secondary\">Cursos de TI</button></a>
                <a href=\"?cmd=cursosti&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
		include "cursosti.inc.php";
		echo"
		</main>
      </div>
    </div>";

  break;
  
  case 'servidores':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Gerenciamento - Servidores</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=servidores\"><button class=\"btn btn-sm btn-outline-secondary\">Servidores</button></a>
                <a href=\"?cmd=servidores&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro de Servidores</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "servidores.inc.php";
    echo"
    </main>
      </div>
    </div>";

    break;
  
  case 'estacoes':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Gerenciamento - Estações de Trabalho</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=estacoes\"><button class=\"btn btn-sm btn-outline-secondary\">Estações de Trabalho</button></a>
                <a href=\"?cmd=estacoes&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro de ET</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "estacoes.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;

  case 'manutencaoet':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Manutenção - Estações de Trabalho</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "manutencaoet.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;
      
  case 'necaquisicao':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Manutenção - Estações de Trabalho</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=necaquisicao\"><button class=\"btn btn-sm btn-outline-secondary\">
                  Nec. de Aquisição</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "necaquisicao.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;
  
  case 'conectividade':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Gerenciamento - Equipamentos de Conectividade</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=conectividade\"><button class=\"btn btn-sm btn-outline-secondary\">Equipamentos de Conectividade</button></a>
                <a href=\"?cmd=conectividade&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro de Equipamentos</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>";
    include "conectividade.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;

  case 'mapainfra':
    @$param = $_GET['param'];
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Mapeamento da Infraestrutura de Rede</h1>
            <!--<div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=mapainfra&act=et&param=".$param."\"><button class=\"btn btn-sm btn-outline-secondary\">
                  Estação de Trabalho</button></a>
                <a href=\"?cmd=mapainfra&act=srv&param=".$param."\"><button class=\"btn btn-sm btn-outline-secondary\">
                  Servidor</button></a>
                <a href=\"?cmd=mapainfra&act=conec&param=".$param."\"><button class=\"btn btn-sm btn-outline-secondary\">
                  Eq. Conectividade</button></a>
              </div>-->
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            <!--</div>-->
          </div>";
    include "mapainfra.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;

  case 'padsictic':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Plano de Adestramento de SIC/TIC</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=padsictic&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
                  Cadastrar PAD SIC/TIC</button></a>
              </div>
            </div>
          </div>";
    include "padsictic.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;

  case 'tri_tret':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">TRI/TRET</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=tri_tret&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
                  Cadastrar</button></a>
              </div>
            </div>
          </div>";
    include "tri_tret.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;

  case 'quadros':
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">";
    include "quadros.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;
  
  case 'vat':
    @$param = $_GET['param'];
    echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Visitas de Apoio Técnico</h1>
            <!--<div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=mapainfra&act=et&param=".$param."\"><button class=\"btn btn-sm btn-outline-secondary\">
                  Estação de Trabalho</button></a>
                <a href=\"?cmd=mapainfra&act=srv&param=".$param."\"><button class=\"btn btn-sm btn-outline-secondary\">
                  Servidor</button></a>
                <a href=\"?cmd=mapainfra&act=conec&param=".$param."\"><button class=\"btn btn-sm btn-outline-secondary\">
                  Eq. Conectividade</button></a>
              </div>-->
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            <!--</div>-->
          </div>";
    include "vat.inc.php";
    echo"
    </main>
      </div>
    </div>";

  break;
	
	default:

		echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Módulo de Gerenciamento do Pessoal de TI</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=pessoalti\"><button class=\"btn btn-sm btn-outline-secondary\">Pessoal de TI</button></a>
                <a href=\"?cmd=cursosti\"><button class=\"btn btn-sm btn-outline-secondary\">Cursos de TI</button></a>
              </div>
              <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
                <span data-feather=\"calendar\"></span>
                Esta Semana
              </button>-->
            </div>
          </div>
          <p>OM Apoiadas: xx OM</p>
          <p>Servidores: xx Servidores</p>
          <p>Estações de Trabalho (ET): xx Estações de Trabalho</p>
          <p>Pessoal de TI (OM Apoiadas): xx Técnicos de TI</p>
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

include "../foot.php";
?>