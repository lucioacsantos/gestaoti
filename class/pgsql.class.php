<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe PgSQL */
class PgSql
{
    /* Declaração de Variáveis */
    private $db;
    public  $num_rows;
    public  $last_id;
    public  $aff_rows;
    public function __construct()
    {
        $path = dirname(__FILE__) . '';
        require "$path/../config/config.php";
        $this->db = pg_connect("host=$host port=$port dbname=$dbname 
                                user=$user password=$password");
        if (!$this->db) exit();
    }
    public function close()
    {
        pg_close($this->db);
    }
    // SELECT
    // Retorna uma linha como objeto
    public function getRow($sql)
    {
        $result = pg_query($this->db, $sql);
        $row = pg_fetch_object($result);
        if (pg_last_error()) exit(pg_last_error());
        return $row;
    }
    // SELECT
    // Retorna array com várias linhas
    public function getRows($sql)
    {
        $result = pg_query($this->db, $sql);
        $this->num_rows = pg_num_rows($result);
        $rows = array();
        while ($item = pg_fetch_object($result)) {
            $rows[] = $item;
        }
        return $rows;
    }
    // SELECT
    // Retorna valor de uma coluna como string
    public function getCol($sql)
    {
        $result = pg_query($this->db, $sql);
        $col = pg_fetch_result($result, 0);
        return $col;
    }
    // SELECT
    // Retorna array com todos os valores da coluna
    public function getColValues($sql)
    {
        $result = pg_query($this->db, $sql);
        $arr = pg_fetch_all_columns($result);
        return $arr;
    }
    // INSERT
    // Retorna último id $id
    public function insert($sql, $id='id')
    {
        $sql .= ' RETURNING '.$id;
        $result = pg_query($this->db, $sql);
        $this->last_id = pg_fetch_result($result, 0);
        return $this->last_id;
    }
    // UPDATE, DELETE e CREATE TABLE
    // Retorna número de linhas afetadas
    public function exec($sql)
    {
        $result = pg_query($this->db, $sql);
        $this->aff_rows = pg_affected_rows($result);
        return $this->aff_rows;
    }
}