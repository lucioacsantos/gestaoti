<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
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
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/apoiados/?cmd=apoiados\">
                    <span data-feather=\"anchor\"></span>
                    Órgãos Apoiados
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/gerti/?cmd=pesti\">
                    <span data-feather=\"users\"></span>
                    Pessoal TI
                  </a>
                </li>
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
                <h6 class=\"sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted\">
                  <span>Ativos de TI</span>
                  <span data-feather=\"plus-circle\"></span>
                </h6>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/ativosti/?cmd=estacoes\">
                    <span data-feather=\"monitor\"></span>
                    Estações de Trabalho
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/ativosti/?cmd=servidores\">
                    <span data-feather=\"server\"></span>
                    Servidores
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/ativosti/?cmd=dvr\">
                    <span data-feather=\"video\"></span>
                    DVR
                  </a>
                </li>
                <li class=\"nav-item\">
                  <a class=\"nav-link\" href=\"$url/ativosti/?cmd=conectividade\">
                    <span data-feather=\"command\"></span>
                    Conectividade
                  </a>
                </li>
              </ul>";
              }
              else{
                echo"
                <h6 class=\"sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted\">
                    <span>Ocorreu algum erro, tente novamente!</span>
                    <span data-feather=\"plus-circle\"></span>
                  </h6>
              </ul>";
              }
              ?>
          </div>
        </nav>