<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** TODO: Disponibilizar novos gráficos */

function ativos_ti(){

  /* Classe de interação com o PostgreSQL */
  $path = dirname(__FILE__) . '';
  require_once "$path/../class/pgsql.class.php";
  $pg = new PgSql();

  #$servidores = $pg->getCol("SELECT COUNT(idtb_servidores) AS qtde FROM db_clti.vw_servidores ");

  #$estacoes = $pg->getCol("SELECT COUNT(idtb_estacoes) AS qtde FROM db_clti.vw_estacoes ");
  
  #$conectividade = $pg->getCol("SELECT COUNT(idtb_conectividade) AS qtde FROM db_clti.vw_conectividade ");

  echo"
  <script>
    new Chart(document.getElementById(\"ativos_ti\"), {
      type: 'bar',
      data: {
        labels: [\"Africa\", \"Asia\", \"Europe\", \"Latin America\", \"North America\"],
        datasets: [
          {
            label: \"Population (millions)\",
            backgroundColor: [\"#3e95cd\", \"#8e5ea2\",\"#3cba9f\",\"#e8c3b9\",\"#c45850\"],
            data: [2478,5267,734,784,433]
          }
        ]
      },
      options: {
        legend: { display: false },
        title: {
          display: true,
          text: 'Predicted world population (millions) in 2050'
        }
      }
    });
  </script>";
}
    
function pessoal_ti(){

  /* Classe de interação com o PostgreSQL */
  $path = dirname(__FILE__) . '';
  require_once "$path/../class/pgsql.class.php";
  $pg = new PgSql();

  $pessoal_ti = $pg->getRows("SELECT desc_funcao, sigla_funcao, COUNT(idtb_pessoal_ti) AS qtde FROM db_clti.vw_pessoal_ti 
      GROUP BY desc_funcao, sigla_funcao ORDER BY sigla_funcao; ");

  #$conectividade = $pg->getRows("SELECT descricao, versao, situacao, COUNT(descricao) AS qtde FROM db_clti.vw_conectividade 
  #  GROUP BY descricao, versao, situacao HAVING situacao='EM PRODUÇÃO' ORDER BY descricao, versao ");

  echo"
  <script>
    new Chart(document.getElementById(\"pessoal_ti\"), {
      type: 'line',
      data: {
        labels: [1500,1600,1700,1750,1800,1850,1900,1950,1999,2050],
        datasets: [{ 
            data: [86,114,106,106,107,111,133,221,783,2478],
            label: \"Africa\",
            borderColor: \"#3e95cd\",
            fill: false
          }, { 
            data: [282,350,411,502,635,809,947,1402,3700,5267],
            label: \"Asia\",
            borderColor: \"#8e5ea2\",
            fill: false
          }, { 
            data: [168,170,178,190,203,276,408,547,675,734],
            label: \"Europe\",
            borderColor: \"#3cba9f\",
            fill: false
          }, { 
            data: [40,20,10,16,24,38,74,167,508,784],
            label: \"Latin America\",
            borderColor: \"#e8c3b9\",
            fill: false
          }, { 
            data: [6,3,2,2,7,26,82,172,312,433],
            label: \"North America\",
            borderColor: \"#c45850\",
            fill: false
          }
        ]
      },
      options: {
        title: {
          display: true,
          text: 'World population per region (in millions)'
        }
      }
    });
  </script>";
}

function qualificacao_ti(){

  /* Classe de interação com o PostgreSQL */
  $path = dirname(__FILE__) . '';
  require_once "$path/../class/pgsql.class.php";
  $pg = new PgSql();

  #$pessoal_ti = $pg->getRows("SELECT funcao, descricao, COUNT(funcao) AS qtde FROM db_clti.vw_pessoal_ti 
      #GROUP BY funcao, descricao ORDER BY funcao; ");

  echo"
  <script>
  new Chart(document.getElementById(\"qualificacao_ti\"), {
    type: 'pie',
    data: {
      labels: [\"Africa\", \"Asia\", \"Europe\", \"Latin America\", \"North America\"],
      datasets: [{
        label: \"Population (millions)\",
        backgroundColor: [\"#3e95cd\", \"#8e5ea2\",\"#3cba9f\",\"#e8c3b9\",\"#c45850\"],
        data: [2478,5267,734,784,433]
      }]
    },
    options: {
      title: {
        display: true,
        text: 'Predicted world population (millions) in 2050'
      }
    }
  });
  </script>";
}

function grafico_barras(){

  /* Classe de interação com o PostgreSQL */
  $path = dirname(__FILE__) . '';
  require_once "$path/../class/pgsql.class.php";
  $new = new PessoalTI();
  $new->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
  $qtde_pesti = $new->CountPesTIOM();

  $new = new PessoalOM();
  $new->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
  $qtde_pesom = $new->CountIdOMPesOM();

  $new = new FuncSiGDEM();
  $new->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
  $qtde_sigdem = $new->CountIdOMFuncSiGDEM();

  $new = new Estacoes();
  $new->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
  $qtde_et = $new->CountIdOMET();

  $new = new Conectividade();
  $new->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
  $qtde_conec = $new->CountIdOMConec();

  $new = new Servidores();
  $new->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
  $qtde_srv = $new->CountIdOMSrv();

  $new = new ControlePrivilegios();
  $new->idtb_om_apoiadas = $_SESSION['id_om_apoiada'];
  $qtde_usb = $new->CountIdOMUSB();
  
  echo"
  <script>
  new Chart(document.getElementById(\"grafico_barras\"), {
    type: 'bar',
    data: {
      labels: [\"Pessoal de TI\", \"Usuários da OM\", \"Funções do SiGDEM\", \"Estações de Trabalho\", \"Eq. Conectividade\", 
        \"Servidores\", \"Disp. USB Liberado\"],
      datasets: [
        {
          label: \"Qtde.:\",
          backgroundColor: [\"#3e95cd\", \"#8e5ea2\",\"#3cba9f\",\"#e8c3b9\",\"#c45850\",\"#ee8434\",\"#6d4c3d\"],
          data: [".$qtde_pesti.",".$qtde_pesom.",".$qtde_sigdem.",".$qtde_et.",".$qtde_conec.",".$qtde_srv.",".$qtde_usb."]
        }
      ]
    },
    options: {
      legend: { display: false },
      scales: {
        yAxes: [{
            ticks: {
          beginAtZero: true
            }
        }]
          },
      title: {
        display: true,
        text: 'Estatísticas de TI'
      }
    }
  });

  </script>";
}

function grafico_barras_om(){

  /* Classe de interação com o PostgreSQL */
  $path = dirname(__FILE__) . '';
  require_once "$path/../class/constantes.inc.php";
  $cont = new Contadores();

  $et = $cont->CountTotalET(NULL);
  $srv = $cont->CountTotalSrv(NULL);
  $conec = $cont->CountTotalConect(NULL);
  $pessti = $cont->CountTotalPessTI(NULL);
  $pessom = $cont->CountTotalPessoalOM(NULL);

  echo"
  <script>
  new Chart(document.getElementById(\"grafico_barras_om\"), {
    type: 'bar',
    data: {
      labels: [\"Estações\", \"Servidores\", \"Eq.Conectividade\", \"Pessoal de TI\", \"Usuários\"],
      datasets: [
        {
          label: \"Qtde.:\",
          backgroundColor: [\"#3e95cd\", \"#8e5ea2\",\"#3cba9f\",\"#e8c3b9\",\"#c45850\"],
          data: [".$et.",".$srv.",".$conec.",".$pessti.",".$pessom."]
        }
      ]
    },
    options: {
      legend: { display: false },
      scales: {
        yAxes: [{
            ticks: {
          beginAtZero: true
            }
        }]
          },
      title: {
        display: true,
        text: 'Estatísticas de TI'
      }
    }
  });

  </script>";
}

?>