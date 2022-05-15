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

/* Clasee de interação com o PostgreSQL */
require_once "../class/constantes.inc.php";

$orgaos = new OrgaosApoiados();
$orgaos->idtb_orgaos_apoiados = $oa;
if ($oa) {
  $orgao = $orgaos->SelectApoiadosId();
}
else {
  $orgao = (object)['idtb_orgaos_apoiados'=>'','cnpj'=>'','nome'=>'','sigla'=>'','idtb_estado'=>'','idtb_cidade'=>'',
    'status'=>''];
}

include "../head.php";

include "../nav.php";

/* Montagem do grid html5 conforme módulo solicitado */
switch ($cmd) {

  case 'sistoperacionais':
		echo "
      <main role=\"main\" class=\"col-md-9 ml-sm-auto col-lg-10 px-4\">
        <div class=\"d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 
          mb-3 border-bottom\">
          <h1 class=\"h2\">Gerenciamento - Sistemas Operacionais</h1>
          <div class=\"btn-toolbar mb-2 mb-md-0\">
            <div class=\"btn-group mr-2\">
              <a href=\"?cmd=sistoperacionais\"><button class=\"btn btn-sm btn-outline-secondary\">
                Sistemas Operacionais</button></a>
              <a href=\"?cmd=sistoperacionais&act=cad\"><button class=\"btn btn-sm btn-outline-secondary\">
                Cadastro de SO/SOR</button></a>
            </div>
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
            </div>
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
            </div>
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
              <a href=\"?cmd=conectividade\"><button class=\"btn btn-sm btn-outline-secondary\">
                Equipamentos de Conectividade</button></a>
            </div>
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
          <h1 class=\"h2\">Gerenciamento - DVR</h1>
          <div class=\"btn-toolbar mb-2 mb-md-0\">
            <div class=\"btn-group mr-2\">
              <a href=\"?cmd=dvr\"><button class=\"btn btn-sm btn-outline-secondary\">DVR</button></a>
            </div>
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
          <h1 class=\"h2\">Gerenciamento - Câmeras</h1>
          <div class=\"btn-toolbar mb-2 mb-md-0\">
            <div class=\"btn-group mr-2\">
              <a href=\"?cmd=cameras\"><button class=\"btn btn-sm btn-outline-secondary\">Câmeras</button></a>
            </div>
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
          <h1 class=\"h2\">Cadastro de Ativos de TI</h1>
          <div class=\"btn-toolbar mb-2 mb-md-0\">
            <div class=\"btn-group mr-2\">
              <a href=\"?cmd=estacoes&act=cad&oa=$oa\">
                <button class=\"btn btn-sm btn-outline-secondary\">Estação de Trabalho</button></a>
              <a href=\"?cmd=servidores&act=cad&oa=$oa\">
                <button class=\"btn btn-sm btn-outline-secondary\">Servidor</button></a>
              <a href=\"?cmd=conectividade&act=cad&oa=$oa\">
                <button class=\"btn btn-sm btn-outline-secondary\">Eq.Conectividade</button></a>
              <!--<a href=\"?cmd=cameras&act=cad&param=ip&oa=$oa\">
                <button class=\"btn btn-sm btn-outline-secondary\">Câmeras IP</button></a>-->
              <a href=\"?cmd=dvr&act=cad&oa=$oa\">
                <button class=\"btn btn-sm btn-outline-secondary\">DVR</button></a>
              <!--<a href=\"?cmd=cameras&act=cad&oa=$oa\">
                <button class=\"btn btn-sm btn-outline-secondary\">Câmeras em DVR</button></a>-->
            </div>
          </div>
        </div>
        <p>Órgão Apoiado: ".$orgao->nome."</p>
      </main>
      </div>
    </div>";
	break;
}

include "../foot.php";
?>