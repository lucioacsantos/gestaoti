<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe MySQLi */
class MySQL
{
    /* Declaração de Variáveis */
    private $db;
    public  $num_rows;
    public  $last_id;
    public  $aff_rows;

    /** Função Construct */
    public function __construct()
    {
        require 'config.inc.php';
        $this->db = new mysqli($host,$username,$password,$database);
        if ($this->db -> connect_errno) {
          echo "Conexão falhou MySQL: " . $this->db -> connect_error;
          exit();
        }
    }
    /** Função Close */
    public function close()
    {
        $this->db -> close();
    }
    /** Select Retorna uma linha como objeto */
    public function getRow($sql)
    {
        $result = $this->db -> query($sql);
        $row = $result -> fetch_object();
        if ($this->db -> error) exit($this->db -> error);
        return $row;
    }
    /** Select Retorna array com várias linhas */
    public function getRows($sql)
    {
        $result = $this->db -> query($sql);
        if ($this->db -> error) exit($this->db -> error);
        $this->num_rows = $this->db -> affected_rows;
        $rows = array();
        while ($item = $result -> fetch_object()) {
            $rows[] = $item;
        }
        return $rows;
    }
    /** Select Retorna valor de uma coluna como string */
    public function getCol($sql)
    {
        $result = $this->db -> query($sql);
        $col = $result -> fetch_column();
        if ($this->db -> error) exit($this->db -> error);
        return $col;
    }
    /** Select Retorna array com todos os valores da coluna */
    public function getColValues($sql)
    {
        $result = $this->db -> query($sql);
        $arr = $result -> fetch_all();
        if ($this->db -> error) exit($this->db -> error);
        return $arr;
    }
    /** INSERT, UPDATE, DELETE e CREATE TABLE Retorna número de linhas afetadas */
    public function exec($sql)
    {
        $result = $this->db -> query($sql);
        if ($this->db -> error) exit($this->db -> error);
        return $result;
    }
}