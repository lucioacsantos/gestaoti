<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Clasee de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$orgaos = new OrgaosApoiados();
$qtde = $orgaos->CountApoiados();

include "../head.php";

include "../nav.php";

@$cmd = $_GET['cmd'];

/* Montagem do grid html5 conforme módulo solicitado */
switch ($cmd) {

  case 'sistoperacionais':
		echo "
      <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
        <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
          <h1 class=\"h2\">Gerenciamento - Sistemas Operacionais</h1>
          <div class=\"btn-toolbar mb-2 mb-md-0\">
            <div class=\"btn-group mr-2\">
              <a href=\"?cmd=sistoperacionais\"><button class=\"btn btn-sm btn-outline-secondary\">Sistemas Operacionais</button></a>
              <a href=\"?cmd=sistoperacionais&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro de SO/SOR</button></a>
            </div>
            <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
              <span data-feather=\"calendar\"></span>
              Esta Semana
            </button>-->
          </div>
        </div>";
		include "sistoperacionais.inc.php";
		echo"
		  </main>
      </div>
    </div>";
  break;
  
  case 'processadores':
    echo "
      <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
        <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
          <h1 class=\"h2\">Gerenciamento - Processadores</h1>
          <div class=\"btn-toolbar mb-2 mb-md-0\">
            <div class=\"btn-group mr-2\">
              <a href=\"?cmd=processadores\"><button class=\"btn btn-sm btn-outline-secondary\">Processadores</button></a>
              <a href=\"?cmd=processadores&act=cadfab\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro Fabricante</button></a>
              <a href=\"?cmd=processadores&act=cadproc\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro Processador</button></a>
            </div>
            <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
              <span data-feather=\"calendar\"></span>
              Esta Semana
            </button>-->
          </div>
        </div>";
    include "processadores.inc.php";
    echo"
      </main>
      </div>
    </div>";
  break;

  case 'memorias':
    echo "
      <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
        <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
          <h1 class=\"h2\">Gerenciamento - Memórias</h1>
          <div class=\"btn-toolbar mb-2 mb-md-0\">
            <div class=\"btn-group mr-2\">
              <a href=\"?cmd=memorias\"><button class=\"btn btn-sm btn-outline-secondary\">Memórias</button></a>
              <a href=\"?cmd=memorias&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">Cadastro</button></a>
            </div>
            <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
              <span data-feather=\"calendar\"></span>
              Esta Semana
            </button>-->
          </div>
        </div>";
    include "memorias.inc.php";
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

  case 'dvr':
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
    include "dvr.inc.php";
    echo"
      </main>
      </div>
    </div>";
  break;

  case 'cameras':
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
    include "cameras.inc.php";
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
              <a href=\"?cmd=tipoclti\"><button class=\"btn btn-sm btn-outline-secondary\">Tipo do CLTI</button></a>
              <a href=\"?cmd=gerclti\"><button class=\"btn btn-sm btn-outline-secondary\">Gerenciamento do CLTI</button></a>
            </div>
            <!--<button class=\"btn btn-sm btn-outline-secondary dropdown-toggle\">
              <span data-feather=\"calendar\"></span>
              Esta Semana
            </button>-->
          </div>
        </div>
        <p>OM Apoiadas: ".$qtde." OM</p>
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