<?php
/**
*** lucioacsantos@gmail.com | Lúcio ALEXANDRE Correia dos Santos
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
    public $idtb_config;
    public $valor;
    public $nome;
    public $sigla;
    public $ordena;

    function SelectAll()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_config");
        return $row;
    }
    function SelectURL()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT valor FROM gestaoti.tb_config WHERE parametro='URL'");
        return $row;
    }
    function SelectVersao()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT valor FROM gestaoti.tb_config WHERE parametro='VERSAO'");
        return $row;
    }
    function SelectEstado()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_config WHERE parametro='ESTADO'");
        return $row;
    }
    function SelectCidade()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_config WHERE parametro='CIDADE'");
        return $row;
    }
    function UpdateConfig()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->exec("UPDATE gestaoti.tb_config SET valor = '$this->valor' WHERE idtb_config = '$this->idtb_config'");
        return $row;
    }
    function SelectSigla()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT sigla FROM gestaoti.tb_clti");
        return $row;
    }
}

/* Classe Usuário */
class Usuario
{
    public $iduser;
    public $usuario;
    public $senha;
    public $idtb_pessoal_ti;
    public $ordena;

    /* Verificação de Login/Perfil Usuários da OM */
    public function Login()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_pessoal_ti WHERE status = 'ATIVO' AND cpf = '$this->usuario' 
            AND senha = '$this->senha' ");
        return $row;
    }
    public function Perfil($idtb_funcoes_ti)
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT sigla FROM gestaoti.tb_funcoes_ti WHERE idtb_funcoes_ti = $idtb_funcoes_ti");
        return $row;
    }
    public function GetVencSenha()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT dias_troca FROM gestaoti.tb_dias_troca WHERE idtb_pessoal_ti = $this->idtb_pessoal_ti");
        return $row;
    }
    public function SetVencSenha($dias)
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->exec("UPDATE gestaoti.tb_dias_troca SET dias_troca = $dias WHERE idtb_pessoal_ti = $this->iduser");
        return $row;
    }
    public function InsertVencSenha($dias)
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->exec("INSERT INTO gestaoti.tb_dias_troca (dias_troca,idtb_pessoal_ti) VALUES ($dias,$this->iduser)");
        return $row;
    }
    public function DiasVenc()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->exec("UPDATE gestaoti.tb_dias_troca SET dias_troca = (dias_troca -1)");
        return $row;
    }
}

/** Classe Órgãos Apoiados */
class OrgaosApoiados
{
    public $idtb_orgaos_apoiados;
    public $estado;
    public $cidade;
    public $cnpj;
    public $nome;
    public $sigla;
    public $idtb_setores_orgaos;
    public $nome_setor;
    public $sigla_setor;
    public $cod_funcional;
    public $compart;
    public $ordena;
    public $ip_gw;

    /** OM */
    public function SelectApoiados()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_orgaos_apoiados $this->ordena");
        return $row;
    }
    public function SelectApoiadosId()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_orgaos_apoiados WHERE idtb_orgaos_apoiados=$this->idtb_orgaos_apoiados
        ");
        return $row;
    }
    public function UpdateApoiados()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_orgaos_apoiados SET idtb_estado='$this->estado',idtb_cidade='$this->cidade',
            cnpj='$this->cnpj',nome='$this->nome', sigla='$this->sigla'
            WHERE idtb_orgaos_apoiados=$this->idtb_orgaos_apoiados";
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertApoiados()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_orgaos_apoiados (idtb_estado,idtb_cidade,cnpj,nome,sigla,status) 
            VALUES ('$this->estado','$this->cidade','$this->cnpj','$this->nome','$this->sigla','ATIVO')";
        $row = $my->exec($sql);
        return $row;
    }
    public function SelectSetores()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_setores WHERE idtb_orgaos_apoiados=$this->idtb_orgaos_apoiados 
            $this->ordena");
        return $row;
    }
    public function SelectSetoresId()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.vw_setores WHERE idtb_setores_orgaos=$this->idtb_setores_orgaos");
        return $row;
    }
    public function InsertSetores()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_setores_orgaos (idtb_orgaos_apoiados,nome_setor,sigla_setor,cod_funcional,
                compartimento) 
            VALUES ('$this->idtb_orgaos_apoiados','$this->nome_setor','$this->sigla_setor','$this->cod_funcional',
                '$this->compart')";
        $row = $my->exec($sql);
        return $row;
    }
    public function UpdateSetores()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_setores_orgaos SET idtb_orgaos_apoiados='$this->idtb_orgaos_apoiados',
            nome_setor='$this->nome_setor',sigla_setor='$this->sigla_setor',cod_funcional='$this->cod_funcional',   
            compartimento='$this->compart'
            WHERE idtb_setores_orgaos='$this->idtb_setores_orgaos'";
        $row = $my->exec($sql);
        return $row;
    }
    public function CountApoiados()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_orgaos_apoiados) FROM gestaoti.tb_orgaos_apoiados");
        return $row;
    }
    public function SelectEstado()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_estado");
        return $row;
    }
    public function SelectEstadoId()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_estado WHERE id='$this->estado'");
        return $row;
    }
    public function SelectEstadoUf()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT id FROM gestaoti.tb_estado WHERE uf='$this->estado'");
        return $row;
    }
    public function SelectCidade()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_cidade");
        return $row;
    }
    public function SelectCidadeId()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_cidade WHERE id='$this->cidade'");
        return $row;
    }
    public function SelectNomeCidade()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT id FROM gestaoti.tb_cidade WHERE nome='$this->cidade'");
        return $row;
    }
    public function InsertGw()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->exec("INSERT INTO gestaoti.tb_gw_om (ip_gw) VALUES ($this->ip_gw) ");
        return $row;
    }
    public function UpdateGw()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->exec("UPDATE gestaoti.tb_gw_om  SET (ip_gw) = ($this->ip_gw) 
            WHERE idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados");
        return $row;
    }
    function FormatCNPJ($value)
    {
        $cnpj = preg_replace("/\D/", '', $value);
        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj);
    }

}

/** Classe Pessoal TI */
class PessoalTI
{
    public $idtb_pessoal_ti;
    public $idtb_orgaos_apoiados;
    public $cpf;
    public $usuario;
    public $nome;
    public $nome_guerra;
    public $correio_eletronico;
    public $status;
    public $senha;
    public $idtb_funcoes_ti;
    public $descricao;
    public $sigla;
    public $ordena;

    public function ChecaCPF()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_pessoal_ti WHERE cpf = '$this->usuario'");
        return $row;
    }
    public function ChecaCorreio()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_pessoal_ti WHERE correio_eletronico = '$this->correio_eletronico'");
        return $row;
    }
    public function SelectIdPesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.vw_pessoal_ti WHERE idtb_pessoal_ti = '$this->idtb_pessoal_ti' 
            AND status = 'ATIVO'");
        return $row;
    }
    public function SelectIdApoiadoPesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_pessoal_ti WHERE idtb_orgaos_apoiados = '$this->idtb_orgaos_apoiados'
            AND status = 'ATIVO' $this->ordena");
        return $row;
    }
    public function InsertPesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_pessoal_ti(idtb_orgaos_apoiados,cpf,nome,nome_guerra,correio_eletronico,
                status,senha,idtb_funcoes_ti)
            VALUES ('$this->idtb_orgaos_apoiados','$this->cpf','$this->nome','$this->nome_guerra',
                '$this->correio_eletronico','$this->status','$this->senha','$this->idtb_funcoes_ti')";
        $row = $my->exec($sql);
        return $row;
    }
    public function UpdatePesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_pessoal_ti SET idtb_orgaos_apoiados='$this->idtb_orgaos_apoiados',cpf='$this->cpf',
            nome='$this->nome',nome_guerra='$this->nome_guerra',correio_eletronico='$this->correio_eletronico',
            status='$this->status',idtb_funcoes_ti='$this->idtb_funcoes_ti'
            WHERE idtb_pessoal_ti='$this->idtb_pessoal_ti' ";
        $row = $my->exec($sql);
        return $row;
    }
    public function UpdateSenhaPesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_pessoal_ti SET senha='$this->senha' WHERE idtb_pessoal_ti='$this->idtb_pessoal_ti'";
        $row = $my->exec($sql);
        return $row;
    }
    public function SelectAllPesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_pessoal_ti WHERE status='ATIVO' $this->ordena");
        return $row;
    }
    public function SelectPesTIInativos()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_pessoal_ti WHERE status='INATIVO' $this->ordena");
        return $row;
    }
    public function SelectAllFuncoesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_funcoes_ti");
        return $row;
    }
    public function SelectIdFuncoesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_funcoes_ti WHERE idtb_funcoes_ti='$this->idtb_funcoes_ti'");
        return $row;
    }
    public function UpdateFuncoesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_funcoes_ti SET descricao='$this->descricao',sigla='$this->sigla'
            WHERE idtb_funcoes_ti='$this->idtb_funcoes_ti'";
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertFuncoesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_funcoes_ti (descricao,sigla) VALUES ('$this->descricao','$this->sigla')";
        $row = $my->exec($sql);
        return $row;
    }
    public function CountPesTI()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_pessoal_ti) AS qtde FROM gestaoti.tb_pessoal_ti GROUP BY idtb_funcoes_ti 
            HAVING idtb_funcoes_ti!=1 AND idtb_funcoes_ti!=2 ";
        $row = $my->getCol($sql);
        return $row;
    }
    public function CountPesTIApoiados()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_pessoal_ti) AS qtde FROM gestaoti.tb_pessoal_ti 
            WHERE idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados ";
        $row = $my->getCol($sql);
        return $row;
    }
    public function PesTIDesativar()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_pessoal_ti SET status = 'INATIVO' WHERE idtb_pessoal_ti='$this->idtb_pessoal_ti' ";
        $row = $my->exec($sql);
        return $row;
    }
    public function PesTIAtivar()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_pessoal_ti SET status = 'ATIVO' WHERE idtb_pessoal_ti='$this->idtb_pessoal_ti' ";
        $row = $my->exec($sql);
        return $row;
    }
    function FormatCPF($value)
    {
        $cpf = preg_replace("/\D/", '', $value);
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
    }
}

/** Classe Pessoal Órgãos Apoiados */
class PessoalOrgaosApoiados
{
    public $idtb_pessoal_om;
    public $idtb_orgaos_apoiados;
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
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.vw_pessoal_om WHERE nip = '$this->usuario' OR cpf = '$this->usuario'");
        return $row;
    }
    public function ChecaCorreio()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_pessoal_om WHERE correio_eletronico = '$this->correio_eletronico'");
        return $row;
    }
    public function SelectIdPesOM()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.vw_pessoal_om WHERE idtb_pessoal_om = '$this->idtb_pessoal_om'");
        return $row;
    }
    public function InsertPesOM()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_pessoal_om(idtb_orgaos_apoiados,idtb_posto_grad,idtb_corpo_quadro,
            idtb_especialidade,nip,cpf,nome,nome_guerra,correio_eletronico,foradaareati,status)
            VALUES ('$this->idtb_orgaos_apoiados','$this->idtb_posto_grad','$this->idtb_corpo_quadro',
            '$this->idtb_especialidade','$this->nip','$this->cpf','$this->nome','$this->nome_guerra',
            '$this->correio_eletronico','$this->foradaareati','$this->status')";
        $row = $my->exec($sql);
        return $row;
    }
    public function UpdatePesOM()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_pessoal_om SET idtb_orgaos_apoiados='$this->idtb_orgaos_apoiados',idtb_posto_grad='$this->idtb_posto_grad',
            idtb_corpo_quadro='$this->idtb_corpo_quadro',idtb_especialidade='$this->idtb_especialidade',nip='$this->nip',cpf='$this->cpf',
            nome'$this->nome',nome_guerra='$this->nome_guerra',correio_eletronico='$this->correio_eletronico',foradaareati='$this->foradaareati',
            status='$this->status'
            WHERE idtb_pessoal_om='$this->idtb_pessoal_om' ";
        $row = $my->exec($sql);
        return $row;
    }
    public function SelectAllPesOM()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_pessoal_om WHERE status='ATIVO' $this->ordena");
        return $row;
    }
    public function SelectIdOMPesOM()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_pessoal_om WHERE idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados 
            AND status='ATIVO' $this->ordena");
        return $row;
    }
    public function CountPesOM()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_pessoal_om) AS qtde FROM gestaoti.vw_pessoal_om GROUP BY idtb_orgaos_apoiados 
            HAVING status='ATIVO' ";
        $row = $my->exec($sql);
        return $row;
    }
    public function CountIdOMPesOM()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_pessoal_om) AS qtde FROM gestaoti.vw_pessoal_om WHERE status='ATIVO' AND
            idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados";
        $row = $my->getCol($sql);
        return $row;
    }
    /** Perfis de Internet */
    public function SelectPerfilAll()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.vw_controle_internet ORDER BY idtb_orgaos_apoiados";
        $row = $my->getRows($sql);
        return $row;
    }
    public function SelectPerfilOM()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.vw_controle_internet WHERE idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados";
        $row = $my->getRows($sql);
        return $row;
    }
    public function SelectPerfilID()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.vw_controle_internet WHERE idtb_controle_internet = $this->idtb_controle_internet";
        $row = $my->getRow($sql);
        return $row;
    }
    public function InsertPerfil()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_controle_internet(idtb_orgaos_apoiados,idtb_pessoal_om,perfis)
            VALUES ('$this->idtb_orgaos_apoiados','$this->idtb_pessoal_om','$this->perfis')";
        $row = $my->exec($sql);
        return $row;
    }
    public function UpdatePerfil()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_controle_internet SET idtb_orgaos_apoiados='$this->idtb_orgaos_apoiados',
            idtb_pessoal_om,perfis='$this->idtb_pessoal_om','$this->perfis')
            WHERE idtb_controle_internet='$this->idtb_controle_internet' ";
        $row = $my->exec($sql);
        return $row;
    }
}

/* Classe Eq. Conectividade  */
class Conectividade
{
    public $idtb_conectividade;
    public $ordena;
    public $idtb_orgaos_apoiados;
    public $fabricante;
    public $modelo;
    public $nome;
    public $qtde_portas;
    public $end_ip;
    public $idtb_setores_orgaos;
    public $data_aquisicao;
    public $data_garantia;
    public $status;

    public function SelectAllConectTable()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_conectividade");
        return $row;
    }
    public function UpdateConect()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_conectividade SET idtb_orgaos_apoiados='$this->idtb_orgaos_apoiados',fabricante='$this->fabricante',
            modelo='$this->modelo',nome='$this->nome',qtde_portas='$this->qtde_portas',end_ip='$this->end_ip',
            idtb_setores_orgaos='$this->idtb_setores_orgaos',data_aquisicao='$this->data_aquisicao',data_garantia='$this->data_garantia',
            status='$this->status'
            WHERE idtb_conectividade='$this->idtb_conectividade'";
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertConect()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_conectividade(idtb_orgaos_apoiados, fabricante, modelo, nome, qtde_portas, end_ip, 
            idtb_setores_orgaos, data_aquisicao, data_garantia, status) VALUES ('$this->idtb_orgaos_apoiados', '$this->fabricante', 
            '$this->modelo', '$this->nome', '$this->qtde_portas', '$this->end_ip', '$this->idtb_setores_orgaos', 
            '$this->data_aquisicao', '$this->data_garantia', '$this->status')";
        $row = $my->exec($sql);
        return $row;
    }
    public function SelectAllConectView()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_conectividade");
        return $row;
    }
    public function SelectIdConectView()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.vw_conectividade WHERE idtb_conectividade = $this->idtb_conectividade");
        return $row;
    }
    public function SelectAllOMConectView()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_conectividade WHERE idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados");
        return $row;
    }
    public function SelectFiltroAllOMConectView()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_conectividade WHERE idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados
            AND idtb_conectividade != $this->idtb_conectividade");
        return $row;
    }
    public function CountConect()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_conectividade) FROM gestaoti.tb_conectividade";
        $row = $my->exec($sql);
        return $row;
    }
    public function CountIdOMConec()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_conectividade) AS qtde FROM gestaoti.vw_conectividade WHERE 
            idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados";
        $row = $my->getCol($sql);
        return $row;
    }
}

/* Classe Mapeamento da Infraestrutura  */
class MapaInfra
{
    public $idtb_mapainfra;
    public $ordena;
    public $idtb_orgaos_apoiados;
    public $idtb_conectividade;
    public $idtb_conectividade_orig;
    public $idtb_conectividade_dest;
    public $idtb_servidores_dest;
    public $idtb_estacoes_dest;
    public $porta_orig;
    public $porta_dest;

    public function SelectAllMapaTable()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_mapainfra");
        return $row;
    }
    public function UpdateMapaInfra()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_mapainfra SET idtb_conectividade_orig='$this->idtb_conectividade_orig',
            idtb_conectividade_dest='$this->idtb_conectividade_dest',idtb_servidores_dest='$this->idtb_servidores_dest', 
            idtb_estacoes_dest='$this->idtb_estacoes_dest',porta_orig='$this->porta_orig',porta_dest='$this->porta_dest'
            WHERE idtb_mapainfra='$this->idtb_mapainfra'";
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertSRVMapaInfra()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_mapainfra(idtb_conectividade_orig, idtb_servidores_dest, porta_orig, idtb_orgaos_apoiados) 
            VALUES ('$this->idtb_conectividade_orig', '$this->idtb_servidores_dest', '$this->porta_orig',
            '$this->idtb_orgaos_apoiados')";
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertETMapaInfra()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_mapainfra(idtb_conectividade_orig, idtb_estacoes_dest, porta_orig, idtb_orgaos_apoiados) 
            VALUES ('$this->idtb_conectividade_orig','$this->idtb_estacoes_dest', '$this->porta_orig', 
            '$this->idtb_orgaos_apoiados')";
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertConecMapaInfra()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_mapainfra(idtb_conectividade_orig, idtb_conectividade_dest, porta_orig, 
            porta_dest, idtb_orgaos_apoiados) 
            VALUES ('$this->idtb_conectividade_orig','$this->idtb_conectividade_dest', '$this->porta_orig', 
            '$this->porta_dest','$this->idtb_orgaos_apoiados')";
        $row = $my->exec($sql);
        return $row;
    }
    public function SelectAllMapaView()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_mapainfra");
        return $row;
    }
    public function SelectIdMapaView()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.vw_mapainfra WHERE idtb_mapainfra = $this->idtb_mapainfa");
        return $row;
    }
    public function SelectAllOMMapaView()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_mapainfra WHERE idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados");
        return $row;
    }
    public function ChecaET()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_mapainfra WHERE idtb_estacoes_dest = $this->idtb_estacoes_dest";
        $row = $my->getRow($sql);
        return $row;
    }
    public function ChecaSRV()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_mapainfra WHERE idtb_servidores_dest = $this->idtb_servidores_dest";
        $row = $my->getRow($sql);
        return $row;
    }
    public function ChecaConec()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_mapainfra WHERE idtb_conectividade_dest = $this->idtb_conectividade_dest 
            AND porta_dest = $this->porta_dest";
        $row = $my->getRow($sql);
        return $row;
    }
    public function ChecaPorta()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT porta_orig,porta_dest FROM gestaoti.tb_mapainfra WHERE 
            idtb_conectividade_orig = $this->idtb_conectividade OR idtb_conectividade_dest = $this->idtb_conectividade";
        $row = $my->getRows($sql);
        return $row;
    }
    public function CountPortasOcupadas()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_mapainfra) FROM gestaoti.tb_mapainfra WHERE 
            idtb_conectividade_orig = $this->idtb_conectividade OR idtb_conectividade_dest = $this->idtb_conectividade ";
        $row = $my->getCol($sql);
        return $row;
    }
    public function CountMapa()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_mapainfra) FROM gestaoti.tb_mapainfra";
        $row = $my->exec($sql);
        return $row;
    }
}

/** Classe Estações de Trabalho */
class Estacoes
{
    public $idtb_estacoes;
    public $ordena;
    public $idtb_orgaos_apoiados;
    public $fabricante;
    public $modelo;
    public $nome;
    public $end_ip;
    public $idtb_setores_orgaos;
    public $data_aquisicao;
    public $data_garantia;
    public $idtb_proc_modelo;
    public $clock_proc;
    public $idtb_memorias;
    public $memoria;
    public $armazenamento;
    public $end_mac;
    public $idtb_sor;
    public $idtb_manutencao_et;
    public $data_entrada;
    public $data_saida;
    public $diagnostico;
    public $custo_manutencao;
    public $situacao;
    public $status;

    public function Update()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_estacoes SET idtb_orgaos_apoiados='$this->idtb_orgaos_apoiados',fabricante='$this->fabricante',
            modelo='$this->modelo',nome='$this->nome',end_ip='$this->end_ip',idtb_setores_orgaos='$this->idtb_setores_orgaos',
            data_aquisicao='$this->data_aquisicao',data_garantia='$this->data_garantia',idtb_proc_modelo='$this->idtb_proc_modelo',
            clock_proc='$this->clock_proc', idtb_memorias='$this->idtb_memorias',memoria='$this->memoria',armazenamento='$this->armazenamento',
            end_mac='$this->end_mac',idtb_sor='$this->idtb_sor',status='$this->status'
            WHERE idtb_estacoes='$this->idtb_estacoes'";
        $row = $my->exec($sql);
        return $row;
    }
    public function Insert()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_estacoes
            (idtb_orgaos_apoiados, fabricante, modelo, nome, end_ip, idtb_setores_orgaos, data_aquisicao, data_garantia,
            idtb_proc_modelo, clock_proc, idtb_memorias,memoria, armazenamento, end_mac, idtb_sor, status) VALUES 
            ('$this->idtb_orgaos_apoiados', '$this->fabricante', '$this->modelo', '$this->nome', '$this->end_ip', 
            '$this->idtb_setores_orgaos', '$this->data_aquisicao', '$this->data_garantia', '$this->idtb_proc_modelo', 
            '$this->clock_proc', '$this->idtb_memorias', '$this->memoria', '$this->armazenamento', '$this->end_mac', 
            '$this->idtb_sor', '$this->status')";
        $row = $my->exec($sql);
        return $row;
    }
    public function SelectAll()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_estacoes");
        return $row;
    }
    public function SelectId()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.vw_estacoes WHERE idtb_estacoes = $this->idtb_estacoes");
        return $row;
    }
    public function SelectIdOrgao()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_estacoes WHERE idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados
            $this->ordena ");
        return $row;
    }
    public function SelectMntAbertoET(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_manutencao_et WHERE idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados");
        return $row;
    }
    public function SelectIdMntET(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_manutencao_et 
            WHERE idtb_manutencao_et = $this->idtb_manutencao_et");
        return $row;
    }
    public function InsertMntET(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_manutencao_et (idtb_estacoes,idtb_orgaos_apoiados,data_entrada,diagnostico,
            custo_manutencao,situacao) VALUES ('$this->idtb_estacoes','$this->idtb_orgaos_apoiados','$this->data_entrada',
            '$this->diagnostico','$this->custo_manutencao','$this->situacao')";
        $row = $my->exec($sql);
        return $row;
    }
    public function UpdateMntET(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_manutencao_et SET data_saida=$this->data_saida,diagnostico='$this->diagnostico',
            custo_manutencao=$this->custo_manutencao',situacao='$this->situacao'
            WHERE idtb_manutencao_et='$this->idtb_manutencao_et'";
        $row = $my->exec($sql);
        return $row;
    }
    public function UpdateETManut()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_estacoes SET status = '$this->status' WHERE idtb_estacoes='$this->idtb_estacoes'";
        $row = $my->exec($sql);
        return $row;
    }
    public function CountET()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_estacoes) FROM gestaoti.tb_estacoes";
        $row = $my->exec($sql);
        return $row;
    }
    public function CountIdOrgao()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_estacoes) AS qtde FROM gestaoti.vw_estacoes WHERE status!='RESSALVA' AND
            idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados";
        $row = $my->getCol($sql);
        return $row;
    }
}

/** Classe Servidores */
class Servidores
{
    public $idtb_servidores;
    public $ordena;
    public $idtb_orgaos_apoiados;
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
    public $idtb_setores_orgaos;
    public $status;

    public function Update()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_servidores SET idtb_orgaos_apoiados='$this->idtb_orgaos_apoiados',fabricante='$this->fabricante',
            modelo='$this->modelo',nome='$this->nome',idtb_proc_modelo='$this->idtb_proc_modelo',clock_proc='$this->clock_proc',
            qtde_proc='$this->qtde_proc',memoria='$this->memoria',armazenamento='$this->armazenamento',end_ip='$this->end_ip',
            end_mac='$this->end_mac',idtb_sor='$this->idtb_sor',finalidade='$this->finalidade', data_aquisicao='$this->data_aquisicao',
            data_garantia='$this->data_garantia',status='$this->status'
            WHERE idtb_servidores='$this->idtb_servidores'";
        $row = $my->exec($sql);
        return $row;
    }
    public function Insert()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_servidores
            (idtb_orgaos_apoiados, fabricante, modelo, nome, idtb_proc_modelo, clock_proc, qtde_proc, memoria, 
            armazenamento, end_ip, end_mac, idtb_sor, finalidade, data_aquisicao, data_garantia, status) VALUES 
            ('$this->idtb_orgaos_apoiados', '$this->fabricante', '$this->modelo', '$this->nome', '$this->idtb_proc_modelo', 
            '$this->clock_proc','$this->qtde_proc', '$this->memoria', '$this->armazenamento','$this->end_ip', 
            '$this->end_mac', '$this->idtb_sor', '$this->finalidade','$this->data_aquisicao', 
            '$this->data_garantia','$this->status')";
        $row = $my->exec($sql);
        return $row;
    }
    public function SelectAll()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_servidores");
        return $row;
    }
    public function SelectId()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.vw_servidores WHERE idtb_servidores = $this->idtb_servidores");
        return $row;
    }
    public function SelectIdOMSrvView()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_servidores WHERE idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados");
        return $row;
    }
    public function CountSrv()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_servidores) FROM gestaoti.tb_servidores";
        $row = $my->exec($sql);
        return $row;
    }
    public function CountIdOMSrv()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT COUNT(idtb_servidores) AS qtde FROM gestaoti.vw_servidores WHERE status='EM PRODUÇÃO' AND
            idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados";
        $row = $my->getCol($sql);
        return $row;
    }
}

/** Classe DVR Cameras Cameras IP */
class DVRCameras
{
    public $idtb_cameras_ip;
    public $idtb_cameras;
    public $idtb_dvr;
    public $idtb_orgaos_apoiados;
    public $marca;
    public $modelo;
    public $end_ip;
    public $qtde_cameras;
    public $idtb_setores_orgaos;
    public $status;

    /** Funções para Câmeras IP */
    function SelectAllCamIP()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_cameras_ip WHERE status='EM PRODUÇÃO'";
        $row = $my->getRows($sql);
        return $row;
    }
    function SelectCamIP()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_cameras_ip WHERE status='EM PRODUÇÃO' AND
            idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados";
        $row = $my->getRows($sql);
        return $row;
    }
    function SelectIdCamIP()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_cameras_ip WHERE idtb_cameras_ip = $this->idtb_cameras_ip";
        $row = $my->getRows($sql);
        return $row;
    }
    function InsertCamIP()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_cameras_ip (idtb_orgaos_apoiados,marca,modelo,end_ip,idtb_setores_orgaos,status) VALUES
            ($this->idtb_orgaos_apoiados,'$this->marca','$this->modelo','$this->end_ip','$this->idtb_setores_orgaos',
            '$this->status')";
        $row = $my->exec($sql);
        return $row;
    }
    function UpdateCamIP()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_cameras_ip SET idtb_orgaos_apoiados=$this->idtb_orgaos_apoiados,marca='$this->marca',
            modelo='$this->modelo',end_ip='$this->end_ip',idtb_setores_orgaos='$this->idtb_setores_orgaos',status='$this->status'
            WHERE idtb_cameras_ip = $this->idtb_cameras_ip";
        $row = $my->exec($sql);
        return $row;
    }
    /** Funções para Câmeras em DVR */
    function SelectAllCam()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_cameras WHERE status='EM PRODUÇÃO'";
        $row = $my->getRows($sql);
        return $row;
    }
    function SelectCam()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_cameras WHERE status='EM PRODUÇÃO' AND
            idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados";
        $row = $my->getRows($sql);
        return $row;
    }
    function SelectIdCam()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_cameras WHERE idtb_cameras = $this->idtb_cameras";
        $row = $my->getRows($sql);
        return $row;
    }
    function InsertCam()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_cameras (idtb_dvr,marca,modelo,idtb_setores_orgaos,status) VALUES
            ($this->idtb_orgaos_apoiados,'$this->marca','$this->modelo','$this->idtb_setores_orgaos','$this->status')";
        $row = $my->exec($sql);
        return $row;
    }
    function UpdateCam()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_cameras SET idtb_dvr=$this->idtb_dvr,marca='$this->marca',modelo='$this->modelo',
            idtb_setores_orgaos='$this->idtb_setores_orgaos',status='$this->status'
            WHERE idtb_cameras = $this->idtb_cameras";
        $row = $my->exec($sql);
        return $row;
    }
    /** Funções para DVR */
    function SelectAllDVR()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_dvr WHERE status='EM PRODUÇÃO'";
        $row = $my->getRows($sql);
        return $row;
    }
    function SelectDVR()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.tb_dvr WHERE status='EM PRODUÇÃO' AND
            idtb_orgaos_apoiados = $this->idtb_orgaos_apoiados";
        $row = $my->getRows($sql);
        return $row;
    }
    function SelectIdDVR()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "SELECT * FROM gestaoti.vw_dvr WHERE idtb_dvr = $this->idtb_dvr";
        $row = $my->getRow($sql);
        return $row;
    }
    function InsertDVR()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_dvr (idtb_orgaos_apoiados,marca,modelo,end_ip,idtb_setores_orgaos,qtde_cameras,status) 
            VALUES ($this->idtb_orgaos_apoiados,'$this->marca','$this->modelo','$this->end_ip',$this->idtb_setores_orgaos,
            $this->qtde_cameras,'$this->status')";
        $row = $my->exec($sql);
        return $row;
    }
    function UpdateDVR()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "UPDATE gestaoti.tb_dvr SET idtb_orgaos_apoiados=$this->idtb_orgaos_apoiados,marca='$this->marca',modelo='$this->modelo',
            end_ip='$this->end_ip',idtb_setores_orgaos=$this->idtb_setores_orgaos,qtde_cameras=$this->qtde_cameras,status=$this->status'
            WHERE idtb_dvr = $this->idtb_dvr";
        $row = $my->exec($sql);
        return $row;
    }
}
/** Classe Verifica IP */
class IP
{
    public $end_ip;
    
    public function SearchIP()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_conectividade WHERE end_ip = '$this->end_ip'");
        $row = $my->getRows("SELECT * FROM gestaoti.tb_estacoes WHERE end_ip = '$this->end_ip'");
        $row = $my->getRows("SELECT * FROM gestaoti.tb_servidores WHERE end_ip = '$this->end_ip'");
        $row = $my->getRows("SELECT * FROM gestaoti.tb_cameras_ip WHERE end_ip = '$this->end_ip'");
        $row = $my->getRows("SELECT * FROM gestaoti.tb_dvr WHERE end_ip = '$this->end_ip'");
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
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_sor $this->ordena");
        return $row;
    }
    public function SelectIdSO()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_sor WHERE idtb_sor='$this->idtb_sor'");
        return $row;
    }
    public function SelectSOAtivo()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_sor WHERE situacao = 'ATIVO'");
        return $row;
    }
    public function UpdateSO()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = ("UPDATE gestaoti.tb_sor SET desenvolvedor='$this->desenvolvedor',descricao='$this->descricao',
            versao='$this->versao',situacao='$this->situacao' WHERE idtb_sor='$this->idtb_sor'");
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertSO()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = ("INSERT INTO gestaoti.tb_sor(desenvolvedor,descricao,versao,situacao) 
            VALUES ('$this->desenvolvedor','$this->descricao','$this->versao','$this->situacao')");
        $row = $my->exec($sql);
        return $row;
    }
    public function SelectAllSoft()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_soft_padronizados");
        return $row;
    }
    public function SelectAllSoftAtivos()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_soft_padronizados WHERE status = 'ATIVO' ORDER BY software");
        return $row;
    }
    public function SelectSoftID()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_soft_padronizados 
            WHERE idtb_soft_padronizados = $this->idtb_soft_padronizados ");
        return $row;
    }
    public function UpdateSoftware()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = ("UPDATE gestaoti.tb_soft_padronizados SET categoria='$this->categoria',software='$this->software',
            status='$this->status' WHERE idtb_soft_padronizados='$this->idtb_soft_padronizados'");
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertSoftware()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = ("INSERT INTO gestaoti.tb_soft_padronizados(categoria,software,status) 
            VALUES ('$this->categoria','$this->software','$this->status')");
        $row = $my->exec($sql);
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
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_proc_fab $this->ordena");
        return $row;
    }
    public function SelectIdProcFab()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_proc_fab WHERE idtb_proc_fab='$this->idtb_proc_fab'");
        return $row;
    }
    public function SelectAllProcModelo()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_proc_modelo $this->ordena");
        return $row;
    }
    public function SelectIdProcModelo()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_proc_modelo WHERE idtb_proc_modelo='$this->idtb_proc_modelo'");
        return $row;
    }
    public function SelectAllProcView()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.vw_processadores $this->ordena");
        return $row;
    }
    public function SelectIdProcView()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.vw_processadores WHERE idtb_proc_modelo='$this->idtb_proc_modelo'");
        return $row;
    }
    public function UpdateProcFab()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = ("UPDATE gestaoti.tb_proc_fab SET nome='$this->nome' WHERE idtb_proc_fab='$this->idtb_proc_fab'");
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertProcFab()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = ("INSERT INTO gestaoti.tb_proc_fab(nome) VALUES ('$this->nome'");
        $row = $my->exec($sql);
        return $row;
    }
    public function UpdateProcModelo()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = ("UPDATE gestaoti.tb_proc_modelo SET idtb_proc_fab='$this->idtb_proc_fab',modelo='$this->modelo'
            WHERE idtb_proc_modelo='$this->idtb_proc_modelo'");
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertProcModelo()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = ("INSERT INTO gestaoti.tb_proc_modelo(idtb_proc_fab,modelo) 
            VALUES ('$this->idtb_proc_fab','$this->modelo')");
        $row = $my->exec($sql);
        return $row;
    }
    /** Memórias */
    public function SelectAllMem()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_memorias $this->ordena");
        return $row;
    }
    public function SelectIdMem()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_memorias WHERE idtb_memorias='$this->idtb_memorias'");
        return $row;
    }
    public function UpdateMem()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = ("UPDATE gestaoti.tb_memorias SET tipo='$this->tipo',modelo='$this->modelo',clock='$this->clock'
            WHERE idtb_memorias='$this->idtb_memorias'");
        $row = $my->exec($sql);
        return $row;
    }
    public function InsertMem()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = ("INSERT INTO gestaoti.tb_memorias(tipo,modelo,clock) 
            VALUES ('$this->tipo','$this->modelo','$this->clock'");
        $row = $my->exec($sql);
        return $row;
    }
}

/** Classe Contadores */
class Contadores{
    public function CountSrv($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT COUNT(idtb_servidores) as cont, sigla,descricao,versao FROM gestaoti.vw_servidores 
            WHERE status ='EM PRODUÇÃO' $condicao GROUP BY sigla,descricao,versao");
        return $row;
    }
    public function CountTotalSrv($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_servidores) FROM gestaoti.vw_servidores WHERE status ='EM PRODUÇÃO' $condicao");
        return $row;
    }
    public function CountET($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT sigla, COUNT(idtb_estacoes) as cont, descricao,versao,req_minimos 
            FROM gestaoti.vw_estacoes WHERE status ='EM PRODUÇÃO' $condicao GROUP BY sigla, req_minimos, descricao, versao ");
        return $row;
    }
    public function CountTotalET($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_estacoes) FROM gestaoti.vw_estacoes WHERE status ='EM PRODUÇÃO' $condicao");
        return $row;
    }
    public function CountConect($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT COUNT(idtb_conectividade) as cont, idtb_orgaos_apoiados, sigla  FROM gestaoti.vw_conectividade 
            WHERE status ='EM PRODUÇÃO' $condicao GROUP BY idtb_orgaos_apoiados,sigla");
        return $row;
    }
    public function CountTotalConect($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_conectividade) FROM gestaoti.vw_conectividade WHERE status ='EM PRODUÇÃO' 
            $condicao");
        return $row;
    }
    public function CountUSBLiberado($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT COUNT(idtb_controle_usb) as cont, sigla  FROM gestaoti.vw_controle_usb 
            WHERE autorizacao IS NOT NULL $condicao GROUP BY sigla");
        return $row;
    }
    public function CountPermAdmin($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT COUNT(idtb_permissoes_admin) as cont, sigla  FROM gestaoti.vw_permissoes_admin 
            WHERE autorizacao IS NOT NULL $condicao GROUP BY sigla");
        return $row;
    }
    public function CountSoftNaoPad($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT COUNT(idtb_nao_padronizados) as cont, sigla  FROM gestaoti.vw_nao_padronizados 
            WHERE autorizacao IS NOT NULL $condicao GROUP BY sigla");
        return $row;
    }
    public function CountPessTI($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT COUNT(idtb_pessoal_ti) as cont, sigla_om  FROM gestaoti.tb_pessoal_ti 
            WHERE status ='ATIVO' $condicao GROUP BY sigla_om ");
        return $row;
    }
    public function CountTotalPessTI($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_pessoal_ti) FROM gestaoti.tb_pessoal_ti WHERE status ='ATIVO' $condicao");
        return $row;
    }
    public function CountQualiTI($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT COUNT(idtb_qualificacao_ti) as cont, sigla_om FROM gestaoti.vw_qualificacao_pesti 
            WHERE situacao IS NOT NULL $condicao GROUP BY sigla_om ");
        return $row;
    }
    public function CountPessoalOM($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT COUNT(idtb_pessoal_om) as cont, sigla_om  FROM gestaoti.vw_pessoal_om 
            WHERE status ='ATIVO' $condicao GROUP BY sigla_om ");
        return $row;
    }
    public function CountTotalPessoalOM($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_pessoal_om) FROM gestaoti.vw_pessoal_om WHERE status ='ATIVO' $condicao");
        return $row;
    }
    public function CountControleInternet($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT COUNT(idtb_controle_internet) as cont, sigla, perfis FROM gestaoti.vw_controle_internet 
            WHERE perfis IS NOT NULL $condicao GROUP BY sigla,perfis ");
        return $row;
    }
    public function CountFuncSiGDEM($condicao){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT COUNT(idtb_funcoes_sigdem) as cont, sigla_om FROM gestaoti.vw_funcoes_sigdem 
            WHERE sigla IS NOT NULL $condicao GROUP BY sigla_om");
        return $row;
    }
    public function CountLotOfCLTI(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT efetivo_oficiais FROM gestaoti.tb_clti ");
        return $row;
    }
    public function CountLotPrCLTI(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT efetivo_pracas FROM gestaoti.tb_clti ");
        return $row;
    }
    public function CountEfetCLTI(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_lotacao_clti) as cont FROM gestaoti.vw_pessoal_clti WHERE status ='ATIVO'
            AND nip != '12345678' ");
        return $row;
    }
    public function CountEfetOfCLTI(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_lotacao_clti) as cont FROM gestaoti.vw_pessoal_clti WHERE status ='ATIVO'
            AND idtb_posto_grad < 12 AND nip != '12345678'  ");
        return $row;
    }
    public function CountEfetPrCLTI(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_lotacao_clti) as cont FROM gestaoti.vw_pessoal_clti WHERE status ='ATIVO'
            AND idtb_posto_grad BETWEEN 12 AND 20 AND nip != '12345678'  ");
        return $row;
    }
    public function CountEfetCivilCLTI(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_lotacao_clti) as cont FROM gestaoti.vw_pessoal_clti WHERE status ='ATIVO'
            AND idtb_posto_grad = 21 AND nip != '12345678'  ");
        return $row;
    }
    public function CountQualiCLTI(){
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT COUNT(idtb_qualificacao_clti) as cont  FROM gestaoti.vw_qualificacao_clti");
        return $row;
    }
}

/** Classe Monitoramento */
class Monitoramento
{
    public $end_ip;
    
    public function SelectSrv()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT nome,end_ip FROM gestaoti.tb_servidores WHERE status = 'EM PRODUÇÃO'");
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
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getCol("SELECT prox_num FROM gestaoti.tb_numerador WHERE parametro = 'RelServico'");
        return $row;
    }
    public function SelectId()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_rel_servico WHERE num_rel = $this->num_rel");
        return $row;
    }
    public function SelectAprovados()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_rel_servico WHERE status = 'Relatório aprovado' ORDER BY idtb_rel_servico ASC");
        return $row;
    }
    public function SelectEmAndamento()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_rel_servico WHERE status = 'Em andamento' ORDER BY idtb_rel_servico ASC");
        return $row;
    }
    public function SelectEncerrados()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_rel_servico WHERE status = 'Encerrado' ORDER BY idtb_rel_servico ASC");
        return $row;
    }
    public function SelectSupCiente()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_rel_servico WHERE status = 'Sup. que entra ciente' ORDER BY idtb_rel_servico ASC");
        return $row;
    }
    public function Insert()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $sql = "INSERT INTO gestaoti.tb_rel_servico (sup_sai_servico, sup_entra_servico, num_rel, data_entra_servico, 
            data_sai_servico, cel_funcional, sit_servidores, sit_backup, status) VALUES ($this->sup_sai_servico, $this->sup_entra_servico, $this->num_rel, 
            '$this->data_entra_servico', '$this->data_sai_servico', '$this->cel_funcional', '$this->sit_servidores', '$this->sit_backup', '$this->status')";
        $row1 = $my->exec($sql);
        $row2 = $my->exec("UPDATE gestaoti.tb_numerador SET prox_num = prox_num +1 WHERE parametro = 'RelServico' ");
        return array($row1,$row2);
    }
    public function Update()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->exec("UPDATE gestaoti.tb_rel_servico SET sup_sai_servico=$this->sup_sai_servico,sup_entra_servico=$this->sup_entra_servico,
            num_rel=$this->num_rel,data_entra_servico='$this->data_entra_servico',data_sai_servico='$this->data_sai_servico',
            cel_funcional='$this->cel_funcional',sit_servidores='$this->sit_servidores',sit_backup='$this->sit_backup',status='$this->status'
            WHERE num_rel = $this->num_rel");
        return $row;
    }
    public function SelectOcorrenciaId()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRow("SELECT * FROM gestaoti.tb_rel_servico_ocorrencias WHERE idtb_rel_servico_ocorrencias = $this->idtb_rel_servico_ocorrencias ");
        return $row;
    }
    public function SelectOcorrenciaNumRel()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_rel_servico_ocorrencias WHERE num_rel = $this->num_rel ");
        return $row;
    }
    public function SelectOcorrenciaAndamento()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->getRows("SELECT * FROM gestaoti.tb_rel_servico_ocorrencias WHERE status = 'Em andamento' ");
        return $row;
    }
    public function InsertOcorrencia()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->exec("INSERT INTO gestaoti.tb_rel_servico_ocorrencias (num_rel,ocorrencia,status) VALUES
            ($this->num_rel,'$this->ocorrencia','Em andamento')");
        return $row;
    }
    public function UpdateOcorrencia()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->exec("UPDATE gestaoti.tb_rel_servico_ocorrencias SET num_rel=$this->num_rel,ocorrencia='$this->ocorrencia',
            status='$this->status' WHERE idtb_rel_servico_ocorrencias = $this->idtb_rel_servico_ocorrencias ");
        return $row;
    }
    public function AtualizaStatus()
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row1 = $my->exec("UPDATE gestaoti.tb_rel_servico SET status = '$this->status' WHERE num_rel = $this->num_rel ");
        $row2 = $my->exec("UPDATE gestaoti.tb_rel_servico_ocorrencias SET status = '$this->status' WHERE 
            num_rel = $this->num_rel ");
        return array($row1,$row2);
    }
    public function RegLog($idtb_lotacao_clti,$num_rel,$cod_aut,$data_hora)
    {
        require_once "mysqli.class.php";
        $my = new MySQL();
        $row = $my->exec("INSERT INTO gestaoti.tb_rel_servico_log (idtb_lotacao_clti,num_rel,cod_aut,data_hora)
            VALUES ($idtb_lotacao_clti,$num_rel,'$cod_aut','$data_hora')");
        return $row;
    }
}