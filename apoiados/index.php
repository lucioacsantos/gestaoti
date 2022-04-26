<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* ClasSe de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";
$config = new Config();
$apoiados = new OrgaosApoiados();

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

    case 'cad':
        echo "
            <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
            <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 
                border-bottom\">
                <h1 class=\"h2\">Órgãos Apoiados</h1>
                <div class=\"btn-toolbar mb-2 mb-md-0\">
                <div class=\"btn-group madminr-2\">
                    <a href=\"?cmd=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
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
    
    default:
        echo "
        <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
        <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 
            border-bottom\">
            <h1 class=\"h2\">Órgãos Apoiados</h1>
            <div class=\"btn-toolbar mb-2 mb-md-0\">
            <div class=\"btn-group madminr-2\">
                <a href=\"?cmd=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
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
    }
  }
  else{
    echo "<h5>Acesso não autorizado!</h5>
      <meta http-equiv=\"refresh\" content=\"5;$url\">";
  }
}
include "../foot.php";
?>