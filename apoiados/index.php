<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
**/

/** Leitura de parâmetros */
if (isset($_GET['cmd'])){
  $cmd = $_GET['cmd'];
}

/* ClasSe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$config = new Config();
$apoiados = new OrgaosApoiados();

/* URL Recuperada do Banco de Dados */
$url = $config->SelectURL();

include "../head.php";

include "../nav.php";

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
                <h1 class=\"h2\">Órgãos Apoiados</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                <div class=\"btn-group madminr-2\">
                    <a href=\"?cmd=apoiados\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Órgãos Apoiados</button></a>
                    <a href=\"?cmd=apoiados&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Cadastro</button></a>
                </div>
                </div>
            </div>";
        include "apoiados.inc.php";
        echo"
            </main>
            </div>
            </div>";
      
        break;

    case 'pessoalti':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
            <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 
                border-bottom\">
                <h1 class=\"h2\">Órgãos Apoiados - Pessoal de TI</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                <div class=\"btn-group madminr-2\">
                    <a href=\"?cmd=pessoalti\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Ativos</button></a>
                    <a href=\"?cmd=pessoalti&act=inativos\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Inativos</button></a>
                    <a href=\"?cmd=pessoalti&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Cadastro</button></a>
                </div>
                </div>
            </div>";
        include "pessoalti.inc.php";
        echo"
            </main>
            </div>
            </div>";
        
        break;

    case 'setores':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
            <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 
                border-bottom\">
                <h1 class=\"h2\">Órgãos Apoiados - Setores</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                <div class=\"btn-group madminr-2\">
                    <a href=\"?cmd=setores\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Inativos</button></a>
                    <a href=\"?cmd=setores&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
                        Cadastro</button></a>
                </div>
                </div>
            </div>";
        include "setores.inc.php";
        echo"
            </main>
            </div>
            </div>";
        
        break; 
    
    default:
        echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
          <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom\">
            <h1 class=\"h2\">Módulo Órgãos Apoiados</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
              <div class=\"btn-group mr-2\">
                <a href=\"?cmd=apoiados\"><button class=\"btn btn-sm btn-outline-secondary\">Órgãos Apoiados</button></a>
                <a href=\"?cmd=pessoalti\"><button class=\"btn btn-sm btn-outline-secondary\">Pessoal de TI</button></a>
              </div>
            </div>
          </div>
          <p>Órgãos Apoiados: XX </p>
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