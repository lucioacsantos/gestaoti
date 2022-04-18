<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/** TODO: Documentar Classes/Funções */

/* Inicializa Sessão */
session_start();

/* Função para Verificar Login */
function isLoggedIn(){
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
        return false;
    }
    return true;
}

/** Classe Configurações */
class Config
{
    public $idtb_clti;
    public $idtb_config;
    public $valor;
    public $nome;
    public $sigla;
    public $indicativo;
    public $data_ativacao;
    public $publicacao;
    public $datapublicacao;
    public $tipoclti;
    public $lotacaooficiais;
    public $lotacaopracas;
    public $ordena;

    function SelectAll()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_config");
        return $row;
    }
    function SelectURL()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT valor FROM db_clti.tb_config WHERE parametro='URL'");
        return $row;
    }
    function SelectVersao()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT valor FROM db_clti.tb_config WHERE parametro='VERSAO'");
        return $row;
    }
    function SelectEstado()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_config WHERE parametro='ESTADO'");
        return $row;
    }
    function SelectCidade()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_config WHERE parametro='CIDADE'");
        return $row;
    }
    function UpdateConfig()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_config SET valor = '$this->valor' WHERE idtb_config = '$this->idtb_config'");
        return $row;
    }
    function SelectSigla()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT sigla FROM db_clti.tb_clti");
        return $row;
    }
    function SelectAllCLTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_clti");
        return $row;
    }
    function SelectIdCLTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_clti WHERE idtb_clti='$this->idtb_clti'");
        return $row;
    }
    function UpdateCLTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_clti SET (nome,sigla,indicativo,data_ativacao) = ('$this->nome',
            '$this->sigla','$this->indicativo','$this->data_ativacao') WHERE idtb_clti='$this->idtb_clti'";
        $row = $pg->exec($sql);
        return $row;
    }
    function InsertCLTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_clti (nome,sigla,indicativo,data_ativacao) VALUES ('$this->nome',
            '$this->sigla','$this->indicativo','$this->data_ativacao')";
        $row = $pg->exec($sql);
        return $row;
    }
    function SelectAllTiposCLTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT * FROM db_clti.tb_tipos_clti";
        $row = $pg->getRows($sql);
        return $row;
    }
    function InsertTiposCLTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_tipos_clti(norma_atual, data_norma, tipo_clti, lotacao_oficiais, lotacao_pracas)
            VALUES ('$this->publicacao','$this->datapublicacao','$this->tipoclti','$this->lotacaooficiais',
            '$this->lotacaopracas')";
        $row = $pg->exec($sql);
        return $row;
    }
    function AtualizaLotacao()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_clti SET (efetivo_oficiais, efetivo_pracas) = ('$this->lotacaooficiais',
            '$this->lotacaopracas')";
        $row = $pg->exec($sql);
        return $row;
    }
}

/** Classe Perfil da Internet */
class PerfilInternet
{
    public $idtb_perfil_internet;
    public $nome;
    public $status;

    /** Seleciona todos os perfis */
    public function SelectAll(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_perfil_internet WHERE status='ATIVO' ");
        return $row;
    }

    /** Seleciona Perfil pelo ID */
    public function SelectId(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_perfil_internet 
            WHERE idtb_perfil_internet = $this->idtb_perfil_internet");
        return $row;
    }

    /** Conta Perfis Existentes */
    public function SelectCount(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_perfil_internet) FROM db_clti.tb_perfil_internet");
        return $row;
    }

    /** Insere Perfil */
    public function InsertPerfil(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("INSERT INTO db_clti.tb_perfil_internet (nome,status) VALUES ('$this->nome','$this->status') ");
        return $row;
    }

    /** Atualiza Perfil */
    public function UpdatePerfil(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_perfil_internet SET (nome,status) = ('$this->nome','$this->status') 
            WHERE idtb_perfil_internet = $this->idtb_perfil_internet");
        return $row;
    }
}

/** Classe Funções do SiGDEM */
class FuncSiGDEM
{
    public $idtb_funcoes_sigdem;
    public $idtb_om_apoiadas;
    public $descricao;
    public $sigla;
    public $idtb_pessoal_om;
    
    /** Seleciona todas as funções */
    public function SelectAll(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_funcoes_sigdem ORDER BY descricao");
        return $row;
    }
    /** Seleciona todas as funções da OM */
    public function SelectOMAll(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_funcoes_sigdem WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas 
            ORDER BY sigla ");
        return $row;
    }
    /** Seleciona Função pelo ID */
    public function SelectId(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_funcoes_sigdem WHERE idtb_funcoes_sigdem = $this->idtb_funcoes_sigdem");
        return $row;
    }
    /** Insere Função */
    public function InsertFuncao(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("INSERT INTO db_clti.tb_funcoes_sigdem (idtb_om_apoiadas,descricao,sigla,idtb_pessoal_om) 
            VALUES ('$this->idtb_om_apoiadas','$this->descricao','$this->sigla','$this->idtb_pessoal_om') ");
        return $row;
    }
    /** Atualiza Função */
    public function UpdateFuncao(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_funcoes_sigdem SET (idtb_om_apoiadas,descricao,sigla,idtb_pessoal_om) 
            = ('$this->idtb_om_apoiadas','$this->descricao','$this->sigla','$this->idtb_pessoal_om') 
            WHERE idtb_funcoes_sigdem = $this->idtb_funcoes_sigdem");
        return $row;
    }
    /** Conta Funções pelo ID da OM */
    public function CountIdOMFuncSiGDEM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_funcoes_sigdem) AS qtde FROM db_clti.vw_funcoes_sigdem WHERE 
            idtb_om_apoiadas = $this->idtb_om_apoiadas";
        $row = $pg->getCol($sql);
        return $row;
    }
}

/* Classe Usuário */
class Usuario
{
    public $usuario;
    public $senha;
    public $iduser;
    public $ordena;

    /* Verificação de Login/Perfil Usuários da OM */
    public function LoginOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_pessoal_ti WHERE status = 'ATIVO' AND nip = '$this->usuario' 
            AND senha = '$this->senha' OR cpf = '$this->usuario' AND senha = '$this->senha' ");
        return $row;
    }
    public function perfilOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_pessoal_ti WHERE idtb_pessoal_ti = $this->iduser");
        return $row;
    }
    /* Verificação de Login/Perfil Usuários do CLTI */
    public function LoginCLTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_lotacao_clti WHERE status = 'ATIVO' AND nip = '$this->usuario' 
            AND senha = '$this->senha' OR cpf = '$this->usuario' AND senha = '$this->senha' ");
        return $row;
    }
    public function perfilCLTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_pessoal_clti WHERE idtb_lotacao_clti = $this->iduser");
        return $row;
    }
    public function GetVencSenha()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT dias_troca FROM db_clti.tb_dias_troca WHERE id_usuario = $this->iduser");
        return $row;
    }
    public function SetVencSenha($dias)
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_dias_troca SET dias_troca = $dias WHERE id_usuario = $this->iduser");
        return $row;
    }
    public function InsertVencSenha($dias)
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->insert("INSERT INTO db_clti.tb_dias_troca (dias_troca,id_usuario) VALUES ($dias,$this->iduser)",
            'idtb_dias_troca');
        return $row;
    }
    public function DiasVenc()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_dias_troca SET dias_troca = (dias_troca -1)");
        return $row;
    }
    public function GetVencSenhaCLTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT dias_troca FROM db_clti.tb_dias_troca_clti WHERE id_usuario = $this->iduser");
        return $row;
    }
    public function SetVencSenhaCLTI($dias)
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_dias_troca_clti SET dias_troca = $dias WHERE id_usuario = $this->iduser");
        return $row;
    }
    public function InsertVencSenhaCLTI($dias)
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->insert("INSERT INTO db_clti.tb_dias_troca_clti (dias_troca,id_usuario) VALUES ($dias,$this->iduser)",
            'idtb_dias_troca_clti');
        return $row;
    }
    public function DiasVencCLTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_dias_troca_clti SET dias_troca = (dias_troca -1)");
        return $row;
    }
}

/** Classe OM Apoiadas */
class OMAPoiadas
{
    public $idtb_om_apoiadas;
    public $estado;
    public $cidade;
    public $cod_om;
    public $nome;
    public $sigla;
    public $indicativo;
    public $idtb_om_setores;
    public $nome_setor;
    public $sigla_setor;
    public $cod_funcional;
    public $compart;
    public $ordena;
    public $ip_gw;

    /** OM */
    public function SelectAllOMTable()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_om_apoiadas $this->ordena");
        return $row;
    }
    public function SelectIdOMTable()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_om_apoiadas WHERE idtb_om_apoiadas=$this->idtb_om_apoiadas
        ");
        return $row;
    }
    public function UpdateOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_om_apoiadas SET (idtb_estado,idtb_cidade,cod_om,nome, sigla, indicativo) 
            = ('$this->estado','$this->cidade','$this->cod_om','$this->nome','$this->sigla','$this->indicativo') 
            WHERE idtb_om_apoiadas=$this->idtb_om_apoiadas";
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_om_apoiadas (idtb_estado,idtb_cidade,cod_om,nome, sigla, indicativo) 
            VALUES ('$this->estado','$this->cidade','$this->cod_om','$this->nome','$this->sigla','$this->indicativo')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllSetoresView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_setores WHERE idtb_om_apoiadas=$this->idtb_om_apoiadas $this->ordena");
        return $row;
    }
    public function SelectIdSetoresView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_setores WHERE idtb_om_setores=$this->idtb_om_setores");
        return $row;
    }
    public function InsertSetores()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_om_setores (idtb_om_apoiadas,nome_setor,sigla_setor,cod_funcional,compartimento) 
            VALUES ('$this->idtb_om_apoiadas','$this->nome_setor','$this->sigla_setor','$this->cod_funcional',
            '$this->compart')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateSetores()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_om_setores SET (idtb_om_apoiadas,nome_setor,sigla_setor,cod_funcional,compartimento) 
            = ('$this->idtb_om_apoiadas','$this->nome_setor','$this->sigla_setor','$this->cod_funcional',
            '$this->compart') WHERE idtb_om_setores='$this->idtb_om_setores'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function CountOMApoiadas()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_om_apoiadas) FROM db_clti.tb_om_apoiadas");
        return $row;
    }
    public function SelectAllEstado()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_estado");
        return $row;
    }
    public function SelectIdEstado()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_estado WHERE id='$this->estado'");
        return $row;
    }
    public function SelectUfEstado()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT id FROM db_clti.tb_estado WHERE uf='$this->estado'");
        return $row;
    }
    public function SelectAllCidade()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_cidade");
        return $row;
    }
    public function SelectIdCidade()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_cidade WHERE id='$this->cidade'");
        return $row;
    }
    public function SelectNomeCidade()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT id FROM db_clti.tb_cidade WHERE nome='$this->cidade'");
        return $row;
    }
    public function InsertGw()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("INSERT INTO db_clti.tb_gw_om (ip_gw) VALUES ($this->ip_gw) ");
        return $row;
    }
    public function UpdateGw()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_gw_om  SET (ip_gw) = ($this->ip_gw) 
            WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas");
        return $row;
    }
}

/** Classe Pessoal TI */
class PessoalTI
{
    public $idtb_pessoal_ti;
    public $idtb_om_apoiadas;
    public $idtb_posto_grad;
    public $idtb_corpo_quadro;
    public $idtb_especialidade;
    public $nip;
    public $cpf;
    public $nip_cpf;
    public $usuario;
    public $nome;
    public $nome_guerra;
    public $correio_eletronico;
    public $status;
    public $senha;
    public $idtb_funcoes_ti;
    public $descricao;
    public $sigla;
    public $idtb_qualificacao_ti;
    public $nome_curso;
    public $instituicao;
    public $data_conclusao;
    public $carga_horaria;
    public $tipo;
    public $custo;
    public $meio;
    public $situacao;
    public $ordena;

    public function ChecaNIPCPF()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_pessoal_ti WHERE nip = '$this->usuario' OR cpf = '$this->usuario'");
        return $row;
    }
    public function ChecaCorreio()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_pessoal_ti WHERE correio_eletronico = '$this->correio_eletronico'");
        return $row;
    }
    public function SelectALLAdmin()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_ti WHERE sigla_funcao='ADMIN' AND status='ATIVO' 
            $this->ordena");
        return $row;
    }
    public function SelectAdminInativos()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_ti WHERE sigla_funcao='ADMIN' AND status='INATIVO' 
            $this->ordena");
        return $row;
    }
    public function SelectIdPesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_pessoal_ti WHERE idtb_pessoal_ti = '$this->idtb_pessoal_ti' AND status = 'ATIVO'");
        return $row;
    }
    public function SelectIdOMPesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_ti WHERE idtb_om_apoiadas = '$this->idtb_om_apoiadas' AND status = 'ATIVO' $this->ordena");
        return $row;
    }
    public function InsertPesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_pessoal_ti(idtb_om_apoiadas,idtb_posto_grad,idtb_corpo_quadro,
            idtb_especialidade,nip,cpf,nome,nome_guerra,correio_eletronico,status,senha,idtb_funcoes_ti)
            VALUES ('$this->idtb_om_apoiadas','$this->idtb_posto_grad','$this->idtb_corpo_quadro',
            '$this->idtb_especialidade','$this->nip','$this->cpf','$this->nome','$this->nome_guerra',
            '$this->correio_eletronico','$this->status','$this->senha','$this->idtb_funcoes_ti')";
        $row = $pg->insert($sql, 'idtb_pessoal_ti');
        return $row;
    }
    public function UpdatePesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_pessoal_ti SET (idtb_om_apoiadas,idtb_posto_grad,idtb_corpo_quadro,
            idtb_especialidade,nip,cpf,nome,nome_guerra,correio_eletronico,status,idtb_funcoes_ti)
            = ('$this->idtb_om_apoiadas','$this->idtb_posto_grad','$this->idtb_corpo_quadro','$this->idtb_especialidade',
            '$this->nip','$this->cpf','$this->nome','$this->nome_guerra','$this->correio_eletronico','$this->status',
            '$this->idtb_funcoes_ti') WHERE idtb_pessoal_ti='$this->idtb_pessoal_ti' ";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateSenhaPesti()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_pessoal_ti SET senha='$this->senha' WHERE idtb_pessoal_ti='$this->idtb_pessoal_ti'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllOSIC()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_ti WHERE sigla_funcao='OSIC' AND status='ATIVO' $this->ordena");
        return $row;
    }
    public function SelectOSICInativos()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_ti WHERE sigla_funcao='OSIC' AND status='INATIVO' $this->ordena");
        return $row;
    }
    public function SelectAllPesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_ti WHERE status='ATIVO' $this->ordena");
        return $row;
    }
    public function SelectAllFuncoesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_funcoes_ti");
        return $row;
    }
    public function SelectOutrasFuncoesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_funcoes_ti WHERE sigla != 'ADMIN' AND sigla != 'OSIC' ");
        return $row;
    }
    public function SelectIdFuncoesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_funcoes_ti WHERE idtb_funcoes_ti='$this->idtb_funcoes_ti'");
        return $row;
    }
    public function UpdateFuncoesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_funcoes_ti SET (descricao,sigla)=('$this->descricao','$this->sigla')
            WHERE idtb_funcoes_ti='$this->idtb_funcoes_ti'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertFuncoesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_funcoes_ti (descricao,sigla) VALUES ('$this->descricao','$this->sigla')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllQualif()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_qualificacao_pesti $this->ordena");
        return $row;
    }
    public function SelectIdQualif()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_qualificacao_pesti 
            WHERE idtb_qualificacao_ti='$this->idtb_qualificacao_ti'");
        return $row;
    }
    public function InsertQualif()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_qualificacao_ti(idtb_pessoal_ti, instituicao, tipo, nome_curso, 
            meio, situacao, data_conclusao, carga_horaria, custo) VALUES ('$this->idtb_pessoal_ti', 
            '$this->instituicao', '$this->tipo', '$this->nome_curso','$this->meio', '$this->situacao', 
            '$this->data_conclusao', '$this->carga_horaria', '$this->custo')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateQualif()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_qualificacao_ti SET (idtb_pessoal_ti, instituicao, tipo, nome_curso, 
            meio, situacao, data_conclusao, carga_horaria, custo) = ('$this->idtb_pessoal_ti', 
            '$this->instituicao', '$this->tipo', '$this->nome_curso','$this->meio', '$this->situacao', 
            '$this->data_conclusao', '$this->carga_horaria', '$this->custo')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function CountAdmin()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_pessoal_ti) AS qtde FROM db_clti.vw_pessoal_ti GROUP BY idtb_funcoes_ti 
            HAVING idtb_funcoes_ti=1 ";
        $row = $pg->getCol($sql);
        return $row;
    }
    public function CountOSIC()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_pessoal_ti) AS qtde FROM db_clti.vw_pessoal_ti GROUP BY idtb_funcoes_ti 
            HAVING idtb_funcoes_ti=2 ";
        $row = $pg->getCol($sql);
        return $row;
    }
    public function CountPesTI()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_pessoal_ti) AS qtde FROM db_clti.vw_pessoal_ti GROUP BY idtb_funcoes_ti 
            HAVING idtb_funcoes_ti!=1 AND idtb_funcoes_ti!=2 ";
        $row = $pg->getCol($sql);
        return $row;
    }
    public function CountPesTIOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_pessoal_ti) AS qtde FROM db_clti.vw_pessoal_ti 
            WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas ";
        $row = $pg->getCol($sql);
        return $row;
    }
    public function PesTIDesativar()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_pessoal_ti SET status = 'INATIVO' WHERE idtb_pessoal_ti='$this->idtb_pessoal_ti' ";
        $row = $pg->exec($sql);
        return $row;
    }
    public function PesTIAtivar()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_pessoal_ti SET status = 'ATIVO' WHERE idtb_pessoal_ti='$this->idtb_pessoal_ti' ";
        $row = $pg->exec($sql);
        return $row;
    }
}

/** Classe Pessoal OM */
class PessoalOM
{
    public $idtb_pessoal_om;
    public $idtb_om_apoiadas;
    public $idtb_posto_grad;
    public $idtb_corpo_quadro;
    public $idtb_especialidade;
    public $idtb_controle_internet;
    public $perfis;
    public $nip;
    public $cpf;
    public $nip_cpf;
    public $usuario;
    public $nome;
    public $nome_guerra;
    public $correio_eletronico;
    public $status;
    public $foradaareati;
    public $sigla;
    public $ordena;

    public function ChecaNIPCPF()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_pessoal_om WHERE nip = '$this->usuario' OR cpf = '$this->usuario'");
        return $row;
    }
    public function ChecaCorreio()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_pessoal_om WHERE correio_eletronico = '$this->correio_eletronico'");
        return $row;
    }
    public function SelectIdPesOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_pessoal_om WHERE idtb_pessoal_om = '$this->idtb_pessoal_om'");
        return $row;
    }
    public function InsertPesOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_pessoal_om(idtb_om_apoiadas,idtb_posto_grad,idtb_corpo_quadro,
            idtb_especialidade,nip,cpf,nome,nome_guerra,correio_eletronico,foradaareati,status)
            VALUES ('$this->idtb_om_apoiadas','$this->idtb_posto_grad','$this->idtb_corpo_quadro',
            '$this->idtb_especialidade','$this->nip','$this->cpf','$this->nome','$this->nome_guerra',
            '$this->correio_eletronico','$this->foradaareati','$this->status')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdatePesOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_pessoal_om SET (idtb_om_apoiadas,idtb_posto_grad,idtb_corpo_quadro,
            idtb_especialidade,nip,cpf,nome,nome_guerra,correio_eletronico,foradaareati,status)
            = ('$this->idtb_om_apoiadas','$this->idtb_posto_grad','$this->idtb_corpo_quadro','$this->idtb_especialidade',
            '$this->nip','$this->cpf','$this->nome','$this->nome_guerra','$this->correio_eletronico','$this->foradaareati','$this->status') 
            WHERE idtb_pessoal_om='$this->idtb_pessoal_om' ";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllPesOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_om WHERE status='ATIVO' $this->ordena");
        return $row;
    }
    public function SelectIdOMPesOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_om WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas 
            AND status='ATIVO' $this->ordena");
        return $row;
    }
    public function CountPesOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_pessoal_om) AS qtde FROM db_clti.vw_pessoal_om GROUP BY idtb_om_apoiadas 
            HAVING status='ATIVO' ";
        $row = $pg->exec($sql);
        return $row;
    }
    public function CountIdOMPesOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_pessoal_om) AS qtde FROM db_clti.vw_pessoal_om WHERE status='ATIVO' AND
            idtb_om_apoiadas = $this->idtb_om_apoiadas";
        $row = $pg->getCol($sql);
        return $row;
    }
    /** Perfis de Internet */
    public function SelectPerfilAll()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT * FROM db_clti.vw_controle_internet ORDER BY idtb_om_apoiadas";
        $row = $pg->getRows($sql);
        return $row;
    }
    public function SelectPerfilOM()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT * FROM db_clti.vw_controle_internet WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas";
        $row = $pg->getRows($sql);
        return $row;
    }
    public function SelectPerfilID()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT * FROM db_clti.vw_controle_internet WHERE idtb_controle_internet = $this->idtb_controle_internet";
        $row = $pg->getRow($sql);
        return $row;
    }
    public function InsertPerfil()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_controle_internet(idtb_om_apoiadas,idtb_pessoal_om,perfis)
            VALUES ('$this->idtb_om_apoiadas','$this->idtb_pessoal_om','$this->perfis')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdatePerfil()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_controle_internet SET (idtb_om_apoiadas,idtb_pessoal_om,perfis)
            = ('$this->idtb_om_apoiadas','$this->idtb_pessoal_om','$this->perfis') 
            WHERE idtb_controle_internet='$this->idtb_controle_internet' ";
        $row = $pg->exec($sql);
        return $row;
    }
}

/** Classe Pessoal CLTI */
class PessoalCLTI
{
    public $idtb_lotacao_clti;
    public $idtb_posto_grad;
    public $idtb_corpo_quadro;
    public $idtb_especialidade;
    public $nip;
    public $cpf;
    public $usuario;
    public $nome;
    public $nome_guerra;
    public $correio_eletronico;
    public $status;
    public $senha;
    public $perfil;
    public $idtb_qualificacao_clti;
    public $nome_curso;
    public $instituicao;
    public $data_conclusao;
    public $carga_horaria;
    public $tipo;
    public $custo;
    public $meio;
    public $situacao;
    public $ordena;

    public function ChecaNIPCPF()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_pessoal_clti WHERE nip = '$this->usuario' OR cpf = '$this->usuario'");
        return $row;
    }
    public function ChecaCorreio()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_lotacao_clti WHERE correio_eletronico = '$this->correio_eletronico'");
        return $row;
    }
    public function SelectALL()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_clti WHERE status='ATIVO' $this->ordena");
        return $row;
    }
    public function SelectEscalaSV()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_clti WHERE status='ATIVO' AND tarefa = 'Escala de Serviço' $this->ordena");
        return $row;
    }
    public function SelectInativos()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_pessoal_clti WHERE status='INATIVO' $this->ordena");
        return $row;
    }
    public function SelectId()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_pessoal_clti WHERE idtb_lotacao_clti = '$this->idtb_lotacao_clti'");
        return $row;
    }
    public function SelectTarefa()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT tarefa FROM db_clti.tb_lotacao_clti WHERE idtb_lotacao_clti = '$this->idtb_lotacao_clti'");
        return $row;
    }
    public function Insert()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_lotacao_clti(idtb_posto_grad,idtb_corpo_quadro,
            idtb_especialidade,nip,cpf,nome,nome_guerra,correio_eletronico,status,senha,perfil)
            VALUES ('$this->idtb_posto_grad','$this->idtb_corpo_quadro',
            '$this->idtb_especialidade','$this->nip','$this->cpf','$this->nome','$this->nome_guerra',
            '$this->correio_eletronico','$this->status','$this->senha','$this->perfil')";
        $row = $pg->insert($sql,'idtb_lotacao_clti');
        return $row;
    }
    public function Update()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_lotacao_clti SET (idtb_posto_grad,idtb_corpo_quadro,
        idtb_especialidade,nip,cpf,nome,nome_guerra,correio_eletronico,status,perfil)
        = ('$this->idtb_posto_grad','$this->idtb_corpo_quadro','$this->idtb_especialidade',
        '$this->nip','$this->cpf','$this->nome','$this->nome_guerra','$this->correio_eletronico','$this->status',
        '$this->perfil') WHERE idtb_lotacao_clti='$this->idtb_lotacao_clti'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateSenha()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_lotacao_clti SET senha= '$this->senha' 
            WHERE idtb_lotacao_clti='$this->idtb_lotacao_clti'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function PesCLTIDesativar()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_lotacao_clti SET status = 'INATIVO'  WHERE idtb_lotacao_clti='$this->idtb_lotacao_clti'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function PesCLTIAtivar()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_lotacao_clti SET status = 'ATIVO'  WHERE idtb_lotacao_clti='$this->idtb_lotacao_clti'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllQualif()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_qualificacao_clti $this->ordena");
        return $row;
    }
    public function SelectIdQualif()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_qualificacao_clti WHERE 
            idtb_qualificacao_clti='$this->idtb_qualificacao_clti' OR nip='$this->idtb_qualificacao_clti'
            OR cpf='$this->idtb_qualificacao_clti'");
        return $row;
    }
    public function InsertQualif()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_qualificacao_clti(idtb_lotacao_clti, instituicao, tipo, nome_curso, 
            meio, situacao, data_conclusao, carga_horaria, custo) VALUES ('$this->idtb_lotacao_clti', 
            '$this->instituicao', '$this->tipo', '$this->nome_curso','$this->meio', '$this->situacao', 
            '$this->data_conclusao', '$this->carga_horaria', '$this->custo')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertQualifAnd()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_qualificacao_clti(idtb_lotacao_clti, instituicao, tipo, nome_curso, 
            meio, situacao, data_conclusao, carga_horaria, custo) VALUES ('$this->idtb_lotacao_clti', 
            '$this->instituicao', '$this->tipo', '$this->nome_curso','$this->meio', '$this->situacao', 
            $this->data_conclusao, '$this->carga_horaria', '$this->custo')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateQualif()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_qualificacao_clti SET (idtb_lotacao_clti, instituicao, tipo, nome_curso, 
            meio, situacao, data_conclusao, carga_horaria, custo) = ('$this->idtb_lotacao_clti', 
            '$this->instituicao', '$this->tipo', '$this->nome_curso','$this->meio', '$this->situacao', 
            '$this->data_conclusao', '$this->carga_horaria', '$this->custo') 
            WHERE idtb_qualificacao_clti = $this->idtb_qualificacao_clti";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateQualifAnd()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_qualificacao_clti SET (idtb_lotacao_clti, instituicao, tipo, nome_curso, 
            meio, situacao, data_conclusao, carga_horaria, custo) = ('$this->idtb_lotacao_clti', 
            '$this->instituicao', '$this->tipo', '$this->nome_curso','$this->meio', '$this->situacao', 
            $this->data_conclusao, '$this->carga_horaria', '$this->custo') 
            WHERE idtb_qualificacao_clti = $this->idtb_qualificacao_clti";
        $row = $pg->exec($sql);
        return $row;
    }
    public function CountOficiais()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(nip) FROM db_clti.tb_lotacao_clti WHERE idtb_posto_grad < '10' AND nip != '12345678' ";
        $row = $pg->exec($sql);
        return $row;
    }
    public function CountPracas()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(nip) FROM db_clti.tb_lotacao_clti WHERE idtb_posto_grad > '9' AND idtb_posto_grad < '21' 
            AND nip != '12345678' ";
        $row = $pg->exec($sql);
        return $row;
    }
    public function CountFCivil()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(nip) FROM db_clti.tb_lotacao_clti WHERE idtb_posto_grad = '21' AND nip != '12345678' ";
        $row = $pg->exec($sql);
        return $row;
    }
    public function AddTarefa($idtb_lotacao_clti,$tarefa)
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_lotacao_clti SET tarefa = '$tarefa' WHERE idtb_lotacao_clti = $idtb_lotacao_clti";
        $row = $pg->exec($sql);
        return $row;
    }

}

/** Classe Militar */
class Militar
{
    public $idtb_corpo_quadro;
    public $idtb_posto_grad;
    public $idtb_especialidade;
    public $nome;
    public $sigla;
    public $exibir;
    public $ordena;

    public function SelectAllPostoGrad()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_posto_grad ORDER BY idtb_posto_grad ASC");
        return $row;
    }
    public function SelectIDPostoGrad()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_posto_grad WHERE idtb_posto_grad = $this->idtb_posto_grad");
        return $row;
    }
    public function InsertPostoGrad()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_posto_grad(nome,sigla) VALUES ('$this->nome','$this->sigla')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdatePostoGrad()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_posto_grad SET (nome,sigla) = ('$this->nome','$this->sigla')
            WHERE idtb_posto_grad = $this->idtb_posto_grad";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllCorpoQuadro()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_corpo_quadro");
        return $row;
    }
    public function SelectIDCorpoQuadro()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_corpo_quadro WHERE idtb_corpo_quadro = $this->idtb_corpo_quadro");
        return $row;
    }
    public function InsertCorpoQuadro()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_corpo_quadro(nome,sigla,exibir) VALUES ('$this->nome','$this->sigla',
            '$this->exibir')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateCorpoQuadro()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_corpo_quadro SET (nome,sigla,exibir) = ('$this->nome','$this->sigla',
            '$this->exibir') WHERE idtb_corpo_quadro = $this->idtb_corpo_quadro";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllEspec()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_especialidade ORDER BY nome");
        return $row;
    }
    public function SelectIDEspec()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_especialidade WHERE idtb_especialidade = $this->idtb_especialidade");
        return $row;
    }
    public function InsertEspec()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_especialidade(nome,sigla,exibir) VALUES ('$this->nome','$this->sigla',
            '$this->exibir')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateEspec()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_especialidade SET (nome,sigla,exibir) = ('$this->nome','$this->sigla',
            '$this->exibir') WHERE idtb_especialidade = $this->idtb_especialidade";
        $row = $pg->exec($sql);
        return $row;
    }
}

/* Classe Eq. Conectividade  */
class Conectividade
{
    public $idtb_conectividade;
    public $ordena;
    public $idtb_om_apoiadas;
    public $fabricante;
    public $modelo;
    public $nome;
    public $qtde_portas;
    public $end_ip;
    public $idtb_om_setores;
    public $data_aquisicao;
    public $data_garantia;
    public $status;

    public function SelectAllConectTable()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_conectividade");
        return $row;
    }
    public function UpdateConect()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_conectividade SET (idtb_om_apoiadas, fabricante, modelo, nome, qtde_portas, end_ip, 
            idtb_om_setores, data_aquisicao, data_garantia, status) = ('$this->idtb_om_apoiadas', '$this->fabricante', 
            '$this->modelo', '$this->nome', '$this->qtde_portas', '$this->end_ip', '$this->idtb_om_setores', 
            '$this->data_aquisicao', '$this->data_garantia', '$this->status') 
            WHERE idtb_conectividade='$this->idtb_conectividade'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertConect()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_conectividade(idtb_om_apoiadas, fabricante, modelo, nome, qtde_portas, end_ip, 
            idtb_om_setores, data_aquisicao, data_garantia, status) VALUES ('$this->idtb_om_apoiadas', '$this->fabricante', 
            '$this->modelo', '$this->nome', '$this->qtde_portas', '$this->end_ip', '$this->idtb_om_setores', 
            '$this->data_aquisicao', '$this->data_garantia', '$this->status')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllConectView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_conectividade");
        return $row;
    }
    public function SelectIdConectView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_conectividade WHERE idtb_conectividade = $this->idtb_conectividade");
        return $row;
    }
    public function SelectAllOMConectView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_conectividade WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas");
        return $row;
    }
    public function SelectFiltroAllOMConectView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_conectividade WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas
            AND idtb_conectividade != $this->idtb_conectividade");
        return $row;
    }
    public function CountConect()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_conectividade) FROM db_clti.tb_conectividade";
        $row = $pg->exec($sql);
        return $row;
    }
    public function CountIdOMConec()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_conectividade) AS qtde FROM db_clti.vw_conectividade WHERE 
            idtb_om_apoiadas = $this->idtb_om_apoiadas";
        $row = $pg->getCol($sql);
        return $row;
    }
}

/* Classe Mapeamento da Infraestrutura  */
class MapaInfra
{
    public $idtb_mapainfra;
    public $ordena;
    public $idtb_om_apoiadas;
    public $idtb_conectividade;
    public $idtb_conectividade_orig;
    public $idtb_conectividade_dest;
    public $idtb_servidores_dest;
    public $idtb_estacoes_dest;
    public $porta_orig;
    public $porta_dest;

    public function SelectAllMapaTable()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_mapainfra");
        return $row;
    }
    public function UpdateMapaInfra()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_mapainfra SET (idtb_conectividade_orig, idtb_conectividade_dest, idtb_servidores_dest, 
            idtb_estacoes_dest, porta_orig, porta_dest) = ('$this->idtb_conectividade_orig',
            '$this->idtb_conectividade_dest', '$this->idtb_servidores_dest', '$this->idtb_estacoes_dest', 
            '$this->porta_orig', '$this->porta_dest') 
            WHERE idtb_mapainfra='$this->idtb_mapainfra'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertSRVMapaInfra()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_mapainfra(idtb_conectividade_orig, idtb_servidores_dest, porta_orig, idtb_om_apoiadas) 
            VALUES ('$this->idtb_conectividade_orig', '$this->idtb_servidores_dest', '$this->porta_orig',
            '$this->idtb_om_apoiadas')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertETMapaInfra()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_mapainfra(idtb_conectividade_orig, idtb_estacoes_dest, porta_orig, idtb_om_apoiadas) 
            VALUES ('$this->idtb_conectividade_orig','$this->idtb_estacoes_dest', '$this->porta_orig', 
            '$this->idtb_om_apoiadas')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertConecMapaInfra()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_mapainfra(idtb_conectividade_orig, idtb_conectividade_dest, porta_orig, 
            porta_dest, idtb_om_apoiadas) 
            VALUES ('$this->idtb_conectividade_orig','$this->idtb_conectividade_dest', '$this->porta_orig', 
            '$this->porta_dest','$this->idtb_om_apoiadas')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllMapaView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_mapainfra");
        return $row;
    }
    public function SelectIdMapaView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_mapainfra WHERE idtb_mapainfra = $this->idtb_mapainfa");
        return $row;
    }
    public function SelectAllOMMapaView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_mapainfra WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas");
        return $row;
    }
    public function ChecaET()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT * FROM db_clti.tb_mapainfra WHERE idtb_estacoes_dest = $this->idtb_estacoes_dest";
        $row = $pg->getRow($sql);
        return $row;
    }
    public function ChecaSRV()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT * FROM db_clti.tb_mapainfra WHERE idtb_servidores_dest = $this->idtb_servidores_dest";
        $row = $pg->getRow($sql);
        return $row;
    }
    public function ChecaConec()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT * FROM db_clti.tb_mapainfra WHERE idtb_conectividade_dest = $this->idtb_conectividade_dest 
            AND porta_dest = $this->porta_dest";
        $row = $pg->getRow($sql);
        return $row;
    }
    public function ChecaPorta()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT porta_orig,porta_dest FROM db_clti.tb_mapainfra WHERE 
            idtb_conectividade_orig = $this->idtb_conectividade OR idtb_conectividade_dest = $this->idtb_conectividade";
        $row = $pg->getRows($sql);
        return $row;
    }
    public function CountPortasOcupadas()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_mapainfra) FROM db_clti.tb_mapainfra WHERE 
            idtb_conectividade_orig = $this->idtb_conectividade OR idtb_conectividade_dest = $this->idtb_conectividade ";
        $row = $pg->getCol($sql);
        return $row;
    }
    public function CountMapa()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_mapainfra) FROM db_clti.tb_mapainfra";
        $row = $pg->exec($sql);
        return $row;
    }
}

/** Classe Estações de Trabalho */
class Estacoes
{
    public $idtb_estacoes;
    public $ordena;
    public $idtb_om_apoiadas;
    public $fabricante;
    public $modelo;
    public $nome;
    public $end_ip;
    public $idtb_om_setores;
    public $data_aquisicao;
    public $data_garantia;
    public $idtb_proc_modelo;
    public $clock_proc;
    public $idtb_memorias;
    public $memoria;
    public $armazenamento;
    public $end_mac;
    public $idtb_sor;
    public $req_minimos;
    public $idtb_manutencao_et;
    public $data_entrada;
    public $data_saida;
    public $diagnostico;
    public $custo_manutencao;
    public $situacao;
    public $status;

    public function SelectAllETTable()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_estacoes");
        return $row;
    }
    public function UpdateET()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_estacoes SET
            (idtb_om_apoiadas, fabricante, modelo, nome, end_ip, idtb_om_setores, data_aquisicao, data_garantia,
            idtb_proc_modelo, clock_proc, idtb_memorias,memoria, armazenamento, end_mac, idtb_sor,
            req_minimos, status) = 
            ('$this->idtb_om_apoiadas', '$this->fabricante', '$this->modelo', '$this->nome', '$this->end_ip', 
            '$this->idtb_om_setores', '$this->data_aquisicao', '$this->data_garantia', '$this->idtb_proc_modelo', 
            '$this->clock_proc', '$this->idtb_memorias', '$this->memoria', '$this->armazenamento', '$this->end_mac', 
            '$this->idtb_sor','$this->req_minimos', '$this->status') WHERE idtb_estacoes='$this->idtb_estacoes'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertET()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_estacoes
            (idtb_om_apoiadas, fabricante, modelo, nome, end_ip, idtb_om_setores, data_aquisicao, data_garantia,
            idtb_proc_modelo, clock_proc, idtb_memorias,memoria, armazenamento, end_mac, idtb_sor,
            req_minimos, status) VALUES 
            ('$this->idtb_om_apoiadas', '$this->fabricante', '$this->modelo', '$this->nome', '$this->end_ip', 
            '$this->idtb_om_setores', '$this->data_aquisicao', '$this->data_garantia', '$this->idtb_proc_modelo', 
            '$this->clock_proc', '$this->idtb_memorias', '$this->memoria', '$this->armazenamento', '$this->end_mac', 
            '$this->idtb_sor', '$this->req_minimos', '$this->status')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllETView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_estacoes");
        return $row;
    }
    public function SelectIdETView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_estacoes WHERE idtb_estacoes = $this->idtb_estacoes");
        return $row;
    }
    public function SelectIdOMETView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_estacoes WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas
            $this->ordena ");
        return $row;
    }
    public function SelectMntAbertoET(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_manutencao_et WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas");
        return $row;
    }
    public function SelectIdMntET(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_manutencao_et 
            WHERE idtb_manutencao_et = $this->idtb_manutencao_et");
        return $row;
    }
    public function InsertMntET(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_manutencao_et (idtb_estacoes,idtb_om_apoiadas,data_entrada,diagnostico,
            custo_manutencao,situacao) VALUES ('$this->idtb_estacoes','$this->idtb_om_apoiadas','$this->data_entrada',
            '$this->diagnostico','$this->custo_manutencao','$this->situacao')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateMntET(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_manutencao_et SET (data_saida,diagnostico,custo_manutencao,
            situacao) = ($this->data_saida,'$this->diagnostico','$this->custo_manutencao','$this->situacao') 
            WHERE idtb_manutencao_et='$this->idtb_manutencao_et'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateETManut()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_estacoes SET status = '$this->status' WHERE idtb_estacoes='$this->idtb_estacoes'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function CountET()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_estacoes) FROM db_clti.tb_estacoes";
        $row = $pg->exec($sql);
        return $row;
    }
    public function CountIdOMET()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_estacoes) AS qtde FROM db_clti.vw_estacoes WHERE status!='RESSALVA' AND
            idtb_om_apoiadas = $this->idtb_om_apoiadas";
        $row = $pg->getCol($sql);
        return $row;
    }
}

/** Classe Servidores */
class Servidores
{
    public $idtb_servidores;
    public $ordena;
    public $idtb_om_apoiadas;
    public $fabricante;
    public $modelo;
    public $nome;
    public $end_ip;
    public $localizacao;
    public $data_aquisicao;
    public $data_garantia;
    public $idtb_proc_modelo;
    public $qtde_proc;
    public $clock_proc;
    public $idtb_memorias;
    public $memoria;
    public $armazenamento;
    public $end_mac;
    public $finalidade;
    public $idtb_sor;
    public $idtb_om_setores;
    public $status;

    public function SelectAllSrvTable()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_servidores");
        return $row;
    }
    public function UpdateSrv()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "UPDATE db_clti.tb_servidores SET 
            (idtb_om_apoiadas, fabricante, modelo, nome, idtb_proc_modelo, clock_proc, qtde_proc, memoria, 
            armazenamento, end_ip, end_mac, idtb_sor, finalidade, data_aquisicao, data_garantia, idtb_om_setores, 
            status) = 
            ('$this->idtb_om_apoiadas', '$this->fabricante', '$this->modelo', '$this->nome', '$this->idtb_proc_modelo', 
            '$this->clock_proc','$this->qtde_proc', '$this->memoria', '$this->armazenamento','$this->end_ip', 
            '$this->end_mac', '$this->idtb_sor', '$this->finalidade','$this->data_aquisicao', 
            '$this->data_garantia', '$this->idtb_om_setores', '$this->status')
            WHERE idtb_servidores='$this->idtb_servidores'";
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertSrv()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_servidores
            (idtb_om_apoiadas, fabricante, modelo, nome, idtb_proc_modelo, clock_proc, qtde_proc, memoria, 
            armazenamento, end_ip, end_mac, idtb_sor, finalidade, data_aquisicao, data_garantia, idtb_om_setores, 
            status) VALUES 
            ('$this->idtb_om_apoiadas', '$this->fabricante', '$this->modelo', '$this->nome', '$this->idtb_proc_modelo', 
            '$this->clock_proc','$this->qtde_proc', '$this->memoria', '$this->armazenamento','$this->end_ip', 
            '$this->end_mac', '$this->idtb_sor', '$this->finalidade','$this->data_aquisicao', 
            '$this->data_garantia', '$this->idtb_om_setores', '$this->status')";
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllSrvView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_servidores");
        return $row;
    }
    public function SelectIdSrvView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_servidores WHERE idtb_servidores = $this->idtb_servidores");
        return $row;
    }
    public function SelectIdOMSrvView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_servidores WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas");
        return $row;
    }
    public function CountSrv()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_servidores) FROM db_clti.tb_servidores";
        $row = $pg->exec($sql);
        return $row;
    }
    public function CountIdOMSrv()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_servidores) AS qtde FROM db_clti.vw_servidores WHERE status='EM PRODUÇÃO' AND
            idtb_om_apoiadas = $this->idtb_om_apoiadas";
        $row = $pg->getCol($sql);
        return $row;
    }
}

/** Classe Verifica IP */
class IP
{
    public $end_ip;
    
    public function SearchIP()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_conectividade WHERE end_ip = '$this->end_ip'");
        $row = $pg->getRows("SELECT * FROM db_clti.tb_estacoes WHERE end_ip = '$this->end_ip'");
        $row = $pg->getRows("SELECT * FROM db_clti.tb_servidores WHERE end_ip = '$this->end_ip'");
        return $row;
    }
}

/** Classe Sistemas Operacionais & Softwares*/
class SO
{
    public $idtb_sor;
    public $idtb_soft_padronizados;
    public $desenvolvedor;
    public $descricao;
    public $versao;
    public $situacao;
    public $ordena;
    public $status;
    public $software;
    public $categoria;
    
    public function SelectAllSO()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_sor $this->ordena");
        return $row;
    }
    public function SelectIdSO()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_sor WHERE idtb_sor='$this->idtb_sor'");
        return $row;
    }
    public function SelectSOAtivo()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_sor WHERE situacao = 'ATIVO'");
        return $row;
    }
    public function UpdateSO()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = ("UPDATE db_clti.tb_sor SET desenvolvedor='$this->desenvolvedor',descricao='$this->descricao',
            versao='$this->versao',situacao='$this->situacao' WHERE idtb_sor='$this->idtb_sor'");
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertSO()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = ("INSERT INTO db_clti.tb_sor(desenvolvedor,descricao,versao,situacao) 
            VALUES ('$this->desenvolvedor','$this->descricao','$this->versao','$this->situacao')");
        $row = $pg->exec($sql);
        return $row;
    }
    public function SelectAllSoft()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_soft_padronizados");
        return $row;
    }
    public function SelectAllSoftAtivos()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_soft_padronizados WHERE status = 'ATIVO' ORDER BY software");
        return $row;
    }
    public function SelectSoftID()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_soft_padronizados 
            WHERE idtb_soft_padronizados = $this->idtb_soft_padronizados ");
        return $row;
    }
    public function UpdateSoftware()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = ("UPDATE db_clti.tb_soft_padronizados SET categoria='$this->categoria',software='$this->software',
            status='$this->status' WHERE idtb_soft_padronizados='$this->idtb_soft_padronizados'");
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertSoftware()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = ("INSERT INTO db_clti.tb_soft_padronizados(categoria,software,status) 
            VALUES ('$this->categoria','$this->software','$this->status')");
        $row = $pg->exec($sql);
        return $row;
    }
}

/** Classe Hardware */
class Hardware
{
    public $idtb_proc_fab;
    public $idtb_proc_modelo;
    public $idtb_memorias;
    public $nome;
    public $modelo;
    public $tipo;
    public $clock;
    public $ordena;
    
    /** Processadores */
    public function SelectAllProcFab()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_proc_fab $this->ordena");
        return $row;
    }
    public function SelectIdProcFab()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_proc_fab WHERE idtb_proc_fab='$this->idtb_proc_fab'");
        return $row;
    }
    public function SelectAllProcModelo()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_proc_modelo $this->ordena");
        return $row;
    }
    public function SelectIdProcModelo()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_proc_modelo WHERE idtb_proc_modelo='$this->idtb_proc_modelo'");
        return $row;
    }
    public function SelectAllProcView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_processadores $this->ordena");
        return $row;
    }
    public function SelectIdProcView()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_processadores WHERE idtb_proc_modelo='$this->idtb_proc_modelo'");
        return $row;
    }
    public function UpdateProcFab()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = ("UPDATE db_clti.tb_proc_fab SET nome='$this->nome' WHERE idtb_proc_fab='$this->idtb_proc_fab'");
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertProcFab()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = ("INSERT INTO db_clti.tb_proc_fab(nome) VALUES ('$this->nome'");
        $row = $pg->exec($sql);
        return $row;
    }
    public function UpdateProcModelo()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = ("UPDATE db_clti.tb_proc_modelo SET idtb_proc_fab='$this->idtb_proc_fab',modelo='$this->modelo'
            WHERE idtb_proc_modelo='$this->idtb_proc_modelo'");
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertProcModelo()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = ("INSERT INTO db_clti.tb_proc_modelo(idtb_proc_fab,modelo) 
            VALUES ('$this->idtb_proc_fab','$this->modelo')");
        $row = $pg->exec($sql);
        return $row;
    }
    /** Memórias */
    public function SelectAllMem()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_memorias $this->ordena");
        return $row;
    }
    public function SelectIdMem()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_memorias WHERE idtb_memorias='$this->idtb_memorias'");
        return $row;
    }
    public function UpdateMem()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = ("UPDATE db_clti.tb_memorias SET tipo='$this->tipo',modelo='$this->modelo',clock='$this->clock'
            WHERE idtb_memorias='$this->idtb_memorias'");
        $row = $pg->exec($sql);
        return $row;
    }
    public function InsertMem()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = ("INSERT INTO db_clti.tb_memorias(tipo,modelo,clock) 
            VALUES ('$this->tipo','$this->modelo','$this->clock'");
        $row = $pg->exec($sql);
        return $row;
    }
}

/** Classe Privilégios da ET */
class ControlePrivilegios
{
    public $idtb_controle_usb;
    public $idtb_permissoes_admin;
    public $idtb_nao_padronizados;
    public $idtb_estacoes;
    public $idtb_om_apoiadas;
    public $soft_autorizados;
    public $autorizacao;
    
    /** Seleciona todas as funções */
    public function SelectAll(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_controle_usb ");
        return $row;
    }
    public function SelectAllAdm(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_permissoes_admin ");
        return $row;
    }
    public function SelectAllNaoPad(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_nao_padronizados ");
        return $row;
    }

    /** Seleciona todas as funções da OM */
    public function SelectAdmOM(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_permissoes_admin WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas 
            ORDER BY nome ");
        return $row;
    }
    public function SelectNaoPadOM(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_nao_padronizados WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas 
            ORDER BY nome ");
        return $row;
    }
    public function SelectOMAll(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.vw_controle_usb WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas 
            ORDER BY nome ");
        return $row;
    }

    /** Seleciona Função pelo ID */
    public function SelectId(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_controle_usb WHERE idtb_controle_usb = $this->idtb_controle_usb");
        return $row;
    }
    public function SelectIdAdm(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_permissoes_admin 
            WHERE idtb_permissoes_admin = $this->idtb_permissoes_admin");
        return $row;
    }
    public function SelectIdNaoPad(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_nao_padronizados 
            WHERE idtb_nao_padronizados = $this->idtb_nao_padronizados");
        return $row;
    }
    public function SelectIdETNaoPad(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.vw_nao_padronizados 
            WHERE idtb_estacoes = $this->idtb_estacoes");
        return $row;
    }

    /** Insere Função */
    public function Insert(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("INSERT INTO db_clti.tb_controle_usb (idtb_estacoes,idtb_om_apoiadas,autorizacao) 
            VALUES ('$this->idtb_estacoes','$this->idtb_om_apoiadas','$this->autorizacao') ");
        return $row;
    }
    public function InsertAdmin(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("INSERT INTO db_clti.tb_permissoes_admin (idtb_estacoes,idtb_om_apoiadas,autorizacao) 
            VALUES ('$this->idtb_estacoes','$this->idtb_om_apoiadas','$this->autorizacao') ");
        return $row;
    }
    public function InsertNaoPad(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("INSERT INTO db_clti.tb_nao_padronizados (idtb_estacoes,idtb_om_apoiadas,autorizacao,
            soft_autorizados) VALUES ('$this->idtb_estacoes','$this->idtb_om_apoiadas','$this->autorizacao',
            '$this->soft_autorizados') ");
        return $row;
    }

    /** Atualiza Função */
    public function Update(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_controle_usb SET (idtb_estacoes,idtb_om_apoiadas,autorizacao) 
            = ('$this->idtb_estacoes','$this->idtb_om_apoiadas','$this->autorizacao') 
            WHERE idtb_controle_usb = $this->idtb_controle_usb");
        return $row;
    }
    public function UpdateAdmin(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_permissoes_admin SET (idtb_estacoes,idtb_om_apoiadas,autorizacao) 
            = ('$this->idtb_estacoes','$this->idtb_om_apoiadas','$this->autorizacao') 
            WHERE idtb_permissoes_admin = $this->idtb_permissoes_admin");
        return $row;
    }
    public function UpdateNaoPad(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_nao_padronizados SET (idtb_estacoes,idtb_om_apoiadas,autorizacao,
            soft_autorizados) = ('$this->idtb_estacoes','$this->idtb_om_apoiadas','$this->autorizacao',
            '$this->soft_autorizados') WHERE idtb_nao_padronizados = $this->idtb_nao_padronizados");
        return $row;
    }

    /** Contagens */
    public function CountIdOMUSB()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_controle_usb) AS qtde FROM db_clti.vw_controle_usb WHERE 
            idtb_om_apoiadas = $this->idtb_om_apoiadas";
        $row = $pg->getCol($sql);
        return $row;
    }
    public function CountIdOMAdmin()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_permissoes_admin) AS qtde FROM db_clti.vw_controle_admin WHERE 
            idtb_om_apoiadas = $this->idtb_om_apoiadas";
        $row = $pg->getCol($sql);
        return $row;
    }
    public function CountIdOMNaoPad()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "SELECT COUNT(idtb_nao_padronizados) AS qtde FROM db_clti.vw_nao_padronizados WHERE 
            idtb_om_apoiadas = $this->idtb_om_apoiadas";
        $row = $pg->getCol($sql);
        return $row;
    }
}

class PAD{
    public $idtb_pad_sic_tic;
    public $idtb_om_apoiadas;
    public $ano_base;
    public $data_assinatura;
    public $data_revisao;
    public $data_ade;
    public $status;
    public $idtb_temas_pad_sic_tic;
    public $tema;
    public $justificativa;
    public $idtb_ade_pad_sic_tic;
    public $idtb_pessoal_om;

    /** Seleciona PAD */
    public function SelectPADCorrente(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_pad_sic_tic WHERE status = 'CORRENTE' 
            AND idtb_om_apoiadas = $this->idtb_om_apoiadas ORDER BY ano_base DESC");
        return $row;
    }
    public function SelectPADOM(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_pad_sic_tic WHERE idtb_om_apoiadas = $this->idtb_om_apoiadas ");
        return $row;
    }
    public function SelectTemasIdPAD(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_temas_pad_sic_tic WHERE idtb_pad_sic_tic = $this->idtb_pad_sic_tic ");
        return $row;
    }
    /** Insert PAD */
    public function InsertPAD(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->insert("INSERT INTO db_clti.tb_pad_sic_tic (idtb_om_apoiadas, ano_base, data_assinatura, data_revisao,
            status) VALUES ($this->idtb_om_apoiadas, $this->ano_base, '$this->data_assinatura', '$this->data_revisao', 
            '$this->status') ",'idtb_pad_sic_tic');
        return $row;
    }
    public function InsertTemaPadrão(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("INSERT INTO db_clti.tb_temas_pad_sic_tic (idtb_pad_sic_tic, tema, status) 
            VALUES ($this->idtb_pad_sic_tic, 'Adestramento básico de SIC', 'PREVISTO'),
            ($this->idtb_pad_sic_tic, 'Conceitos Gerais de SIC', 'PREVISTO'),
            ($this->idtb_pad_sic_tic, 'ISIC da OM', 'PREVISTO'),
            ($this->idtb_pad_sic_tic, 'Recursos de SIC', 'PREVISTO'),
            ($this->idtb_pad_sic_tic, 'Legislação, Normas e Documentos de SIC', 'PREVISTO'),
            ($this->idtb_pad_sic_tic, 'Ativação dos Planos de Contingência da OM', 'PREVISTO'),
            ($this->idtb_pad_sic_tic, 'Segurança Orgânica, no que se refere à SIC', 'PREVISTO'),
            ($this->idtb_pad_sic_tic, 'Normas para a salvaguarda de materiais controlados, dados, informações, 
                documentos e materiais sigilosos', 'PREVISTO'),
            ($this->idtb_pad_sic_tic, 'Recursos Criptológicos', 'PREVISTO'),
            ($this->idtb_pad_sic_tic, 'Engenharia Social', 'PREVISTO'),
            ($this->idtb_pad_sic_tic, 'Crimes de Informática', 'PREVISTO'); ");
        return $row;
    }
    public function InsertTema(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("INSERT INTO db_clti.tb_temas_pad_sic_tic (idtb_pad_sic_tic, tema, status) 
            VALUES ($this->idtb_pad_sic_tic, '$this->tema', 'PREVISTO') ");
        return $row;
    }
    public function VerificaPresente(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("SELECT * FROM db_clti.tb_ade_pad_sic_tic WHERE idtb_temas_pad_sic_tic = $this->idtb_temas_pad_sic_tic
            AND idtb_pessoal_om = $this->idtb_pessoal_om ");
        return $row;
    }
    public function InsertPresente(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("INSERT INTO db_clti.tb_ade_pad_sic_tic (idtb_temas_pad_sic_tic, idtb_pessoal_om) 
            VALUES ($this->idtb_temas_pad_sic_tic, $this->idtb_pessoal_om) ");
        return $row;
    }
    public function UpdateDataTema(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_temas_pad_sic_tic SET (data_ade, status) = 
            ('$this->data_ade', 'REALIZADO') WHERE idtb_temas_pad_sic_tic = $this->idtb_temas_pad_sic_tic ");
        return $row;
    }
    public function UpdateJustificativa(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_temas_pad_sic_tic SET (justificativa, status) = 
            ('$this->justificativa', 'NÃO REALIZADO') WHERE idtb_temas_pad_sic_tic = $this->idtb_temas_pad_sic_tic ");
        return $row;
    }
}

/** Classe Contadores */
class Contadores{
    public function CountSrv($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT COUNT(idtb_servidores) as cont, sigla,descricao,versao FROM db_clti.vw_servidores 
            WHERE status ='EM PRODUÇÃO' $condicao GROUP BY sigla,descricao,versao");
        return $row;
    }
    public function CountTotalSrv($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_servidores) FROM db_clti.vw_servidores WHERE status ='EM PRODUÇÃO' $condicao");
        return $row;
    }
    public function CountET($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT sigla, COUNT(idtb_estacoes) as cont, descricao,versao,req_minimos 
            FROM db_clti.vw_estacoes WHERE status ='EM PRODUÇÃO' $condicao GROUP BY sigla, req_minimos, descricao, versao ");
        return $row;
    }
    public function CountTotalET($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_estacoes) FROM db_clti.vw_estacoes WHERE status ='EM PRODUÇÃO' $condicao");
        return $row;
    }
    public function CountConect($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT COUNT(idtb_conectividade) as cont, idtb_om_apoiadas, sigla  FROM db_clti.vw_conectividade 
            WHERE status ='EM PRODUÇÃO' $condicao GROUP BY idtb_om_apoiadas,sigla");
        return $row;
    }
    public function CountTotalConect($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_conectividade) FROM db_clti.vw_conectividade WHERE status ='EM PRODUÇÃO' 
            $condicao");
        return $row;
    }
    public function CountUSBLiberado($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT COUNT(idtb_controle_usb) as cont, sigla  FROM db_clti.vw_controle_usb 
            WHERE autorizacao IS NOT NULL $condicao GROUP BY sigla");
        return $row;
    }
    public function CountPermAdmin($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT COUNT(idtb_permissoes_admin) as cont, sigla  FROM db_clti.vw_permissoes_admin 
            WHERE autorizacao IS NOT NULL $condicao GROUP BY sigla");
        return $row;
    }
    public function CountSoftNaoPad($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT COUNT(idtb_nao_padronizados) as cont, sigla  FROM db_clti.vw_nao_padronizados 
            WHERE autorizacao IS NOT NULL $condicao GROUP BY sigla");
        return $row;
    }
    public function CountPessTI($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT COUNT(idtb_pessoal_ti) as cont, sigla_om  FROM db_clti.vw_pessoal_ti 
            WHERE status ='ATIVO' $condicao GROUP BY sigla_om ");
        return $row;
    }
    public function CountTotalPessTI($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_pessoal_ti) FROM db_clti.vw_pessoal_ti WHERE status ='ATIVO' $condicao");
        return $row;
    }
    public function CountQualiTI($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT COUNT(idtb_qualificacao_ti) as cont, sigla_om FROM db_clti.vw_qualificacao_pesti 
            WHERE situacao IS NOT NULL $condicao GROUP BY sigla_om ");
        return $row;
    }
    public function CountPessoalOM($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT COUNT(idtb_pessoal_om) as cont, sigla_om  FROM db_clti.vw_pessoal_om 
            WHERE status ='ATIVO' $condicao GROUP BY sigla_om ");
        return $row;
    }
    public function CountTotalPessoalOM($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_pessoal_om) FROM db_clti.vw_pessoal_om WHERE status ='ATIVO' $condicao");
        return $row;
    }
    public function CountControleInternet($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT COUNT(idtb_controle_internet) as cont, sigla, perfis FROM db_clti.vw_controle_internet 
            WHERE perfis IS NOT NULL $condicao GROUP BY sigla,perfis ");
        return $row;
    }
    public function CountFuncSiGDEM($condicao){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT COUNT(idtb_funcoes_sigdem) as cont, sigla_om FROM db_clti.vw_funcoes_sigdem 
            WHERE sigla IS NOT NULL $condicao GROUP BY sigla_om");
        return $row;
    }
    public function CountLotOfCLTI(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT efetivo_oficiais FROM db_clti.tb_clti ");
        return $row;
    }
    public function CountLotPrCLTI(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT efetivo_pracas FROM db_clti.tb_clti ");
        return $row;
    }
    public function CountEfetCLTI(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_lotacao_clti) as cont FROM db_clti.vw_pessoal_clti WHERE status ='ATIVO'
            AND nip != '12345678' ");
        return $row;
    }
    public function CountEfetOfCLTI(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_lotacao_clti) as cont FROM db_clti.vw_pessoal_clti WHERE status ='ATIVO'
            AND idtb_posto_grad < 12 AND nip != '12345678'  ");
        return $row;
    }
    public function CountEfetPrCLTI(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_lotacao_clti) as cont FROM db_clti.vw_pessoal_clti WHERE status ='ATIVO'
            AND idtb_posto_grad BETWEEN 12 AND 20 AND nip != '12345678'  ");
        return $row;
    }
    public function CountEfetCivilCLTI(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_lotacao_clti) as cont FROM db_clti.vw_pessoal_clti WHERE status ='ATIVO'
            AND idtb_posto_grad = 21 AND nip != '12345678'  ");
        return $row;
    }
    public function CountQualiCLTI(){
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT COUNT(idtb_qualificacao_clti) as cont  FROM db_clti.vw_qualificacao_clti");
        return $row;
    }
}

/** Classe Monitoramento */
class Monitoramento
{
    public $end_ip;
    
    public function SelectSrv()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT nome,end_ip FROM db_clti.tb_servidores WHERE status = 'EM PRODUÇÃO'");
        return $row;
    }
    public function PingAtivo()
    {
        $comando = "/bin/ping -c 1 " . $this->end_ip;
        $saida = shell_exec($comando);
        return $saida;
    }
    public function PortaSrv($ip,$porta)
    {
        $saida = @fsockopen($ip, $porta, $errno, $errstr, 1);
        return $saida;
    }
}

/** Classe Relatórios de Serviço */
class RelServico
{
    public $idtb_rel_servico;
    public $sup_sai_servico;
    public $sup_entra_servico;
    public $num_rel;
    public $data_entra_servico;
    public $data_sai_servico;
    public $cel_funcional;
    public $sit_backup;
    public $status;
    public $idtb_rel_servico_ocorrencias;
    public $ocorrencia;

    public function NumRel()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getCol("SELECT prox_num FROM db_clti.tb_numerador WHERE parametro = 'RelServico'");
        return $row;
    }
    public function SelectId()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_rel_servico WHERE num_rel = $this->num_rel");
        return $row;
    }
    public function SelectAprovados()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_rel_servico WHERE status = 'Relatório aprovado' ORDER BY idtb_rel_servico ASC");
        return $row;
    }
    public function SelectEmAndamento()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_rel_servico WHERE status = 'Em andamento' ORDER BY idtb_rel_servico ASC");
        return $row;
    }
    public function SelectEncerrados()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_rel_servico WHERE status = 'Encerrado' ORDER BY idtb_rel_servico ASC");
        return $row;
    }
    public function SelectSupCiente()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_rel_servico WHERE status = 'Sup. que entra ciente' ORDER BY idtb_rel_servico ASC");
        return $row;
    }
    public function Insert()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $sql = "INSERT INTO db_clti.tb_rel_servico (sup_sai_servico, sup_entra_servico, num_rel, data_entra_servico, 
            data_sai_servico, cel_funcional, sit_servidores, sit_backup, status) VALUES ($this->sup_sai_servico, $this->sup_entra_servico, $this->num_rel, 
            '$this->data_entra_servico', '$this->data_sai_servico', '$this->cel_funcional', '$this->sit_servidores', '$this->sit_backup', '$this->status')";
        $row1 = $pg->insert($sql, 'idtb_rel_servico');
        $row2 = $pg->exec("UPDATE db_clti.tb_numerador SET prox_num = prox_num +1 WHERE parametro = 'RelServico' ");
        return array($row1,$row2);
    }
    public function Update()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_rel_servico SET (sup_sai_servico, sup_entra_servico, num_rel, data_entra_servico, 
            data_sai_servico, cel_funcional, sit_servidores, sit_backup, status) = ($this->sup_sai_servico, $this->sup_entra_servico, $this->num_rel, 
            '$this->data_entra_servico', '$this->data_sai_servico', '$this->cel_funcional', '$this->sit_servidores', '$this->sit_backup', '$this->status') 
            WHERE num_rel = $this->num_rel");
        return $row;
    }
    public function SelectOcorrenciaId()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRow("SELECT * FROM db_clti.tb_rel_servico_ocorrencias WHERE idtb_rel_servico_ocorrencias = $this->idtb_rel_servico_ocorrencias ");
        return $row;
    }
    public function SelectOcorrenciaNumRel()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_rel_servico_ocorrencias WHERE num_rel = $this->num_rel ");
        return $row;
    }
    public function SelectOcorrenciaAndamento()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->getRows("SELECT * FROM db_clti.tb_rel_servico_ocorrencias WHERE status = 'Em andamento' ");
        return $row;
    }
    public function InsertOcorrencia()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->insert("INSERT INTO db_clti.tb_rel_servico_ocorrencias (num_rel,ocorrencia,status) VALUES
            ($this->num_rel,'$this->ocorrencia','Em andamento')",'idtb_rel_servico_ocorrencias');
        return $row;
    }
    public function UpdateOcorrencia()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->exec("UPDATE db_clti.tb_rel_servico_ocorrencias SET (num_rel,ocorrencia,status) = 
            ($this->num_rel,'$this->ocorrencia','$this->status') WHERE idtb_rel_servico_ocorrencias = $this->idtb_rel_servico_ocorrencias ");
        return $row;
    }
    public function AtualizaStatus()
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row1 = $pg->exec("UPDATE db_clti.tb_rel_servico SET status = '$this->status' WHERE num_rel = $this->num_rel ");
        $row2 = $pg->exec("UPDATE db_clti.tb_rel_servico_ocorrencias SET status = '$this->status' WHERE 
            num_rel = $this->num_rel ");
        return array($row1,$row2);
    }
    public function RegLog($idtb_lotacao_clti,$num_rel,$cod_aut,$data_hora)
    {
        require_once "pgsql.class.php";
        $pg = new PgSql();
        $row = $pg->insert("INSERT INTO db_clti.tb_rel_servico_log (idtb_lotacao_clti,num_rel,cod_aut,data_hora)
            VALUES ($idtb_lotacao_clti,$num_rel,'$cod_aut','$data_hora')",'idtb_lotacao_clti');
        return $row;
    }
}