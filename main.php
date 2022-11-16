<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
**/

$idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
$sigla_om = $_SESSION['om_apoiada'];
$perfil = $_SESSION['perfil'];

?>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <?php echo "<h1 class=\"h2\">ATIVOS DE TI ".$sigla_om."</h1>"; ?>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group mr-2">
                <!--<button class="btn btn-sm btn-outline-secondary">Enviar</button>
                <button class="btn btn-sm btn-outline-secondary">Exportar</button>-->
              </div>
              <!--<button class="btn btn-sm btn-outline-secondary dropdown-toggle">
                <span data-feather="calendar"></span>
                Esta Semana
              </button>-->
            </div>
          </div>
          <?php
            if ($perfil == 'TEC_CLTI'){
              echo"<canvas class=\"my-4 w-100\" id=\"grafico_barras_om\" width=\"900\" height=\"380\"></canvas>";
            }
            else{
              echo"<canvas class=\"my-4 w-100\" id=\"grafico_barras\" width=\"900\" height=\"380\"></canvas>";
            }
          ?>
        </main>
      </div>
    </div>