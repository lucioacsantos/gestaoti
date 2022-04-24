<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** Monta o menu lateral */

/* Classe de interação com o PostgreSQL */
require_once "class/constantes.inc.php";
$config = new Config();
$url = $config->SelectURL();
$versao = $config->SelectVersao();

?>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <p class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">
        <?php echo "SGTI v".$versao.""; ?>
      </p>
      <!--<input class="form-control form-control-dark w-100" type="text" placeholder="Pesquisa" aria-label="Pesquisa">-->
      <p class="navbar-brand">
        <?php 
          if (isset($_SESSION['user_name'])){
            echo "".$_SESSION['user_name']." - ".$_SESSION['perfil']." 
              - Validade da senha: ".$_SESSION['venc_senha']." dias.";
            $perfil = $_SESSION['perfil'];
          }
          else{
            // muda o valor de logged_in para false
            $_SESSION['logged_in'] = false;
            // finaliza a sessão
            session_destroy();
            // retorna para a login.php
            header('Location: '.$url.'/login.php');
          }          
        ?>
      </p>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="<?php echo "$url/troca_senha.php"; ?>">| Alterar Senha |</a>
        </li>
      </ul>
      <!--<ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="#">| Atualizar Dados |</a>
        </li>
      </ul>-->
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="<?php echo "$url/logout.php"; ?>">| Sair |</a>
        </li>
      </ul>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                  <a class="nav-link active" href="<?php echo "$url"; ?>">
                    <span data-feather="home"></span>
                    Início <span class="sr-only">(current)</span>
                  </a>
                </li>
              <?php
              if ($perfil == 'GES.TI'){
                echo"
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/sistema\">
                    <span data-feather=\"settings\"></span>
                    Configurações do Sistema
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/dashboard\">
                    <span data-feather=\"hash\"></span>
                    Quadros de Situação
                  </a>
                </li>
                <!-- Relatórios a configurar
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/clti/?cmd=relservico\">
                    <span data-feather=\"check-square\"></span>
                    Rel. Serviço
                  </a>
                </li>
                -->
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/monitoramento/?cmd=monitoramento\">
                    <span data-feather=\"grid\"></span>
                    Monitoramento
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/clti/?cmd=omapoiadas\">
                    <span data-feather=\"anchor\"></span>
                    OM Apoiadas
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/clti/?cmd=lotclti\">
                    <span data-feather=\"users\"></span>
                    Lotação do CLTI
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/clti/?cmd=qualificacao\">
                    <span data-feather=\"book-open\"></span>
                    Qualificação CLTI
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/clti/?cmd=osic\">
                    <span data-feather=\"users\"></span>
                    OSIC
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/clti/?cmd=admin\">
                    <span data-feather=\"users\"></span>
                    Admin
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/clti/?cmd=funcoesti\">
                    <span data-feather=\"crosshair\"></span>
                    Funções de TI
                  </a>
                </li>
                <!--<h6 class=\"sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted\">
                  <span>Ativos de TI</span>
                  <span data-feather=\"plus-circle\"></span>
                </h6>-->
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/ativosti/?cmd=sistoperacionais\">
                    <span data-feather=\"globe\"></span>
                    Sistemas Operacionais
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/ativosti/?cmd=processadores\">
                    <span data-feather=\"cpu\"></span>
                    Processadores
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/ativosti/?cmd=memorias\">
                    <span data-feather=\"credit-card\"></span>
                    Memórias
                  </a>
                </li>
              </ul>";
              }
              else{
                echo"
                <h6 class=\"sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted\">
                    <span>Dados da OM</span>
                    <span data-feather=\"plus-circle\"></span>
                  </h6>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=setores\">
                    <span data-feather=\"layout\"></span>
                    Setores da OM
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=padsictic\">
                    <span data-feather=\"file-text\"></span>
                    PAD SIC/TIC
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=quadros\">
                    <span data-feather=\"file-text\"></span>
                    Quadros de Situação
                  </a>
                </li>
                <!--<li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=vat\">
                    <span data-feather=\"folder\"></span>
                    Visitas de Apoio Técnico
                  </a>-->
                </li>
                <h6 class=\"sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted\">
                    <span>Equipamentos de TI</span>
                    <span data-feather=\"plus-circle\"></span>
                  </h6>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=servidores\">
                    <span data-feather=\"server\"></span>
                    Servidores
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=estacoes\">
                    <span data-feather=\"monitor\"></span>
                    Estações de Trabalho
                  </a>
                </li>
                </li>
                <!--<li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=manutencaoet\">
                    <span data-feather=\"alert-triangle\"></span>
                    Manutenção de ET
                  </a>
                </li>-->
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=controleusb\">
                    <span data-feather=\"clipboard\"></span>
                    Dispositivos USB
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=administrador\">
                    <span data-feather=\"alert-triangle\"></span>
                    Permissões de Administrador
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=naopad\">
                    <span data-feather=\"alert-circle\"></span>
                    Softwares não Padronizados
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=conectividade\">
                    <span data-feather=\"command\"></span>
                    Equipamentos de Conectividade
                  </a>
                </li>
                <!--<li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=mapainfra\">
                    <span data-feather=\"share-2\"></span>
                    Mapeamento da Infraestrutura
                  </a>-->
                </li>
                <h6 class=\"sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted\">
                    <span>Pessoal</span>
                    <span data-feather=\"plus-circle\"></span>
                  </h6>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=pessoalti\">
                    <span data-feather=\"user-plus\"></span>
                    Pessoal de TI
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=cursosti\">
                    <span data-feather=\"book-open\"></span>
                    Qualificação na Área de TI
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=pessoalom\">
                    <span data-feather=\"users\"></span>
                    Usuários da OM
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=tri_tret\">
                    <span data-feather=\"users\"></span>
                    TRI/TRET
                  </a>
                </li>
                <!--<li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=perfisinternet\">
                    <span data-feather=\"youtube\"></span>
                    Perfis de Internet
                  </a>
                </li>-->
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/omapoiada/?cmd=funcsigdem\">
                    <span data-feather=\"archive\"></span>
                    Funções do SiGDEM
                  </a>
                </li>
                <!--<li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"#\">
                    <span data-feather=\"bar-chart-2\"></span>
                    Relatórios
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"#\">
                    <span data-feather=\"layers\"></span>
                    Integração
                  </a>
                </li>-->
              </ul>";
              }
              ?>
          </div>
        </nav>