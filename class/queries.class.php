<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** OBS.: Classe antiga em desuso */

/* Inicializa Sessão */
session_start();

/* Registro de Tabelas e Visões */
$tb_cidade="db_clti.tb_cidade";
$tb_clti="db_clti.tb_clti";
$tb_conectividade="db_clti.tb_conectividade";
$tb_config="db_clti.tb_config";
$tb_corpo_quadro="db_clti.tb_corpo_quadro";
$tb_especialidade="db_clti.tb_especialidade";
$tb_estacoes="db_clti.tb_estacoes";
$tb_estado="db_clti.tb_estado";
$tb_funcoes_ti="db_clti.tb_funcoes_ti";
$tb_lotacao_clti="db_clti.tb_lotacao_clti";
$tb_manutencao_et="db_clti.tb_manutencao_et";
$tb_memorias="db_clti.tb_memorias";
$tb_nec_aquisicao="db_clti.tb_nec_aquisicao";
$tb_om_apoiadas="db_clti.tb_om_apoiadas";
$tb_om_setores="db_clti.tb_om_setores";
$tb_osic="db_clti.tb_osic";
$tb_pais="db_clti.tb_pais";
$tb_pessoal_ti="db_clti.tb_pessoal_ti";
$tb_posto_grad="db_clti.tb_posto_grad";
$tb_proc_fab="db_clti.tb_proc_fab";
$tb_proc_modelo="db_clti.tb_proc_modelo";
$tb_qualificacao_clti="db_clti.tb_qualificacao_clti";
$tb_qualificacao_ti="db_clti.tb_qualificacao_ti";
$tb_registro_log="db_clti.tb_registro_log";
$tb_servidores="db_clti.tb_servidores";
$tb_sor="db_clti.tb_sor";
$tb_tipos_clti="db_clti.tb_tipos_clti";
$vw_conectividade="db_clti.vw_conectividade";
$vw_estacoes="db_clti.vw_estacoes";
$vw_osic="db_clti.vw_osic";
$vw_pessoal_clti="db_clti.vw_pessoal_clti";
$vw_pessoal_ti="db_clti.vw_pessoal_ti";
$vw_processadores="db_clti.vw_processadores";
$vw_qualificacao_clti="db_clti.vw_qualificacao_clti";
$vw_qualificacao_pesti="db_clti.vw_qualificacao_pesti";
$vw_servidores="db_clti.vw_servidores";
$vw_setores="db_clti.vw_setores";

/* Função para Verificar Login */
function isLoggedIn(){
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
        return false;
    }
    return true;
}

/* Classe PgSQL */
class ConsultaSQL
{

    public function insert($tabela,$campos,$valores) 
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $query = $pg->exec("INSERT INTO $tabela ($campos) VALUES ($valores)");
        return $query;
    }

    public function update($tabela,$campos_valores,$condicoes) 
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $query = $pg->exec("UPDATE $tabela SET $campos_valores WHERE $condicoes");
        return $query;
    }

    public function select($campos,$tabela,$condicoes,$ordenacao)
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();

        if ($condicoes and $ordenacao){
            $query = $pg->getRow("SELECT $campos FROM $tabela WHERE $condicoes ORDER BY $ordenacao");
        }
        elseif ($condicoes and !$ordenacao){
            $query = $pg->getRow("SELECT $campos FROM $tabela WHERE $condicoes");
        }
        elseif (!$condicoes and $ordenacao){
            $query = $pg->getRow("SELECT $campos FROM $tabela ORDER BY $ordenacao");
        }
        else{
            $query = $pg->getRow("SELECT $campos FROM $tabela");
        }
        
        return $query;
    }

    public function selectMulti($campos,$tabela,$condicoes,$ordenacao)
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();

        if ($condicoes and $ordenacao){
            $query = $pg->getRows("SELECT $campos FROM $tabela WHERE $condicoes ORDER BY $ordenacao");
        }
        elseif ($condicoes and !$ordenacao){
            $query = $pg->getRows("SELECT $campos FROM $tabela WHERE $condicoes");
        }
        elseif (!$condicoes and $ordenacao){
            $query = $pg->getRows("SELECT $campos FROM $tabela ORDER BY $ordenacao");
        }
        else{
            $query = $pg->getRows("SELECT $campos FROM $tabela");
        }

        return $query;
    }

}
    
?>