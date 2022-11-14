CREATE TABLE gestaoti.tb_orgao_gestor (
	idtb_orgao_gestor INT auto_increment NOT NULL,
	nome varchar(255) NOT NULL,
	abreviatura varchar(45) NOT NULL,
	dpto_responsavel varchar(255) NOT NULL,
	cnpj varchar(14) NULL,
	CONSTRAINT tb_orgao_gestor_pkey PRIMARY KEY (idtb_orgao_gestor)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT='Tabela contendo Informações do Órgão Gestor de TI.';

CREATE TABLE gestaoti.tb_config (
	idtb_config INT auto_increment NOT NULL,
	parametro varchar(255) NULL,
	valor varchar(255) NULL,
	CONSTRAINT tb_config_pkey PRIMARY KEY (idtb_config)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT='Tabela contendo Configurações do Sistema.';

CREATE TABLE gestaoti.tb_funcoes_ti (
	idtb_funcoes_ti INT auto_increment NOT NULL,
	descricao varchar(255) NOT NULL,
	sigla varchar(45) NOT NULL,
	CONSTRAINT tb_funcao_ti_pkey PRIMARY KEY (idtb_funcoes_ti)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Funções de TI.';

CREATE TABLE gestaoti.tb_memorias (
	idtb_memorias INT auto_increment NOT NULL,
	tipo varchar(255) NOT NULL,
	modelo varchar(255) NOT NULL,
	clock int4 NOT NULL,
	CONSTRAINT tb_memorias_pkey PRIMARY KEY (idtb_memorias)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Modelos de Memórias RAM.';

CREATE TABLE gestaoti.tb_pais (
	id INT auto_increment NOT NULL,
	nome varchar(60) NOT NULL,
	sigla varchar(10) NOT NULL,
	CONSTRAINT pais_pkey PRIMARY KEY (id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo País.';

CREATE TABLE gestaoti.tb_estado (
	id INT auto_increment NOT NULL,
	nome varchar(75) NOT NULL,
	uf varchar(5) NOT NULL,
	pais int4 NOT NULL,
	CONSTRAINT estado_pkey PRIMARY KEY (id),
	CONSTRAINT tb_estado_pais_fkey FOREIGN KEY (pais) REFERENCES gestaoti.tb_pais(id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Estados.';

CREATE TABLE gestaoti.tb_cidade (
	id INT auto_increment NOT NULL,
	nome varchar(120) NOT NULL,
	estado int4 NOT NULL,
	CONSTRAINT cidade_pkey PRIMARY KEY (id),
	CONSTRAINT tb_cidade_estado_fkey FOREIGN KEY (estado) REFERENCES gestaoti.tb_estado(id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Cidades.';

CREATE TABLE gestaoti.tb_proc_fab (
	idtb_proc_fab INT auto_increment NOT NULL,
	nome varchar(255) NOT NULL,
	CONSTRAINT tb_proc_fab_nome_key UNIQUE (nome),
	CONSTRAINT tb_proc_fab_pkey PRIMARY KEY (idtb_proc_fab)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Fabricantes de Processadores.';

CREATE TABLE gestaoti.tb_registro_log (
	idtb_registro_log INT auto_increment NOT NULL,
	data_acao date NOT NULL,
	acao varchar(255) NOT NULL,
	cpf_resp varchar (11) NOT NULL,
	CONSTRAINT tb_registro_log_pkey PRIMARY KEY (idtb_registro_log)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Registros de LOG.';

CREATE TABLE gestaoti.tb_sor (
	idtb_sor INT auto_increment NOT NULL,
	desenvolvedor varchar(512) NOT NULL,
	descricao varchar(255) NOT NULL,
	versao varchar(45) NOT NULL,
	situacao varchar(45) NOT NULL,
	CONSTRAINT tb_sor_pkey PRIMARY KEY (idtb_sor)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Sisteamas Operacionais.';

CREATE TABLE gestaoti.tb_proc_modelo (
	idtb_proc_modelo INT auto_increment NOT NULL,
	idtb_proc_fab int4 NOT NULL,
	modelo varchar(255) NOT NULL,
	CONSTRAINT tb_proc_modelo_modelo_key UNIQUE (modelo),
	CONSTRAINT tb_proc_modelo_pkey PRIMARY KEY (idtb_proc_modelo),
	CONSTRAINT tb_proc_modelo_idtb_proc_fab_fkey FOREIGN KEY (idtb_proc_fab) 
		REFERENCES gestaoti.tb_proc_fab(idtb_proc_fab)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Modelos de Processadores.';

CREATE TABLE gestaoti.tb_orgaos_apoiados (
	idtb_orgaos_apoiados INT auto_increment NOT NULL,
	cnpj varchar (14) NOT NULL,
	nome varchar(255) NOT NULL,
	sigla varchar(45) NOT NULL,
	idtb_estado int4 NOT NULL,
	idtb_cidade int4 NOT NULL,
	status varchar(45) NOT NULL,
	CONSTRAINT tb_orgaos_apoiados_cnpj_nome_sigla_key UNIQUE (cnpj, nome, sigla),
	CONSTRAINT tb_orgaos_apoiados_pkey PRIMARY KEY (idtb_orgaos_apoiados),
	CONSTRAINT tb_orgaos_apoiados_id_cidade_fkey FOREIGN KEY (idtb_cidade) REFERENCES gestaoti.tb_cidade(id),
	CONSTRAINT tb_orgaos_apoiados_id_estado_fkey FOREIGN KEY (idtb_estado) REFERENCES gestaoti.tb_estado(id)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Órgãos Apoiadas pelo Gestor de TI.';

CREATE TABLE gestaoti.tb_setores_orgaos (
	idtb_setores_orgaos INT auto_increment NOT NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	nome_setor varchar(255) NOT NULL,
	sigla_setor varchar(255) NOT NULL,
	cod_funcional varchar(255) NULL,
	compartimento varchar(255) NULL,
	status varchar(45) NULL,
	CONSTRAINT tb_setores_orgaos_pk PRIMARY KEY (idtb_setores_orgaos),
	CONSTRAINT tb_setores_orgaos_fk FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Setores dos Órgãos.';

CREATE TABLE gestaoti.tb_pessoal_orgaos (
	idtb_pessoal_orgaos INT auto_increment NOT NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	cpf varchar(11) NOT NULL,
	nome varchar(255) NOT NULL,
	nome_guerra varchar(255) NOT NULL,
	correio_eletronico varchar(255) NOT NULL,
	status varchar(45) NOT NULL,
	CONSTRAINT tb_pessoal_orgaos_pkey PRIMARY KEY (idtb_pessoal_orgaos),
	CONSTRAINT tb_pessoal_orgaos_idtb_orgaos_apoiados_fkey FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Pessoal (Usuários) da OM';

CREATE TABLE gestaoti.tb_pessoal_ti (
	idtb_pessoal_ti INT auto_increment NOT NULL,
	idtb_orgaos_apoiados int4 NULL,
	cpf varchar(11) NOT NULL,
	nome varchar(255) NOT NULL,
	nome_guerra varchar(255) NOT NULL,
	correio_eletronico varchar(255) NOT NULL,
	senha varchar(255) NOT NULL,
	idtb_funcoes_ti int4 NOT NULL,
	status varchar(45) NULL,
	CONSTRAINT tb_pessoal_ti_pkey PRIMARY KEY (idtb_pessoal_ti),
	CONSTRAINT tb_pessoal_ti_idtb_funcoes_ti_fkey FOREIGN KEY (idtb_funcoes_ti) 
		REFERENCES gestaoti.tb_funcoes_ti(idtb_funcoes_ti),
	CONSTRAINT tb_pessoal_ti_idtb_orgaos_apoiados_fkey FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Pessoal de TI.';

CREATE TABLE gestaoti.tb_servidores (
	idtb_servidores INT auto_increment NOT NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	fabricante varchar(255) NOT NULL,
	modelo varchar(255) NOT NULL,
	idtb_proc_modelo int4 NOT NULL,
	clock_proc float4 NOT NULL,
	qtde_proc int4 NOT NULL,
	memoria int4 NULL,
	armazenamento int4 NULL,
	end_ip varchar(255) NULL,
	end_mac varchar(255) NULL,
	idtb_sor int4 NOT NULL,
	finalidade varchar(255) NOT NULL,
	data_aquisicao date NULL,
	data_garantia date NULL,
	nome varchar(50) NULL,
	status varchar(45) NULL,
	CONSTRAINT tb_servidores_pkey PRIMARY KEY (idtb_servidores),
	CONSTRAINT tb_servidores_un UNIQUE (nome),
	CONSTRAINT tb_servidores_idtb_orgaos_apoiados_fkey FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados),
	CONSTRAINT tb_servidores_idtb_proc_modelo_fkey FOREIGN KEY (idtb_proc_modelo) 
		REFERENCES gestaoti.tb_proc_modelo(idtb_proc_modelo),
	CONSTRAINT tb_servidores_idtb_sor_fkey FOREIGN KEY (idtb_sor) REFERENCES gestaoti.tb_sor(idtb_sor)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Servidores.';

CREATE TABLE gestaoti.tb_conectividade (
	idtb_conectividade INT auto_increment NOT NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	fabricante varchar(255) NOT NULL,
	modelo varchar(255) NOT NULL,
	end_ip varchar(255) NULL,
	data_aquisicao date NOT NULL,
	data_garantia date NULL,
	idtb_setores_orgaos int4 NULL,
	qtde_portas int4 NULL,
	nome varchar(50) NULL,
	status varchar(45) NULL,
	CONSTRAINT tb_conectividade_end_ip_key UNIQUE (end_ip),
	CONSTRAINT tb_conectividade_pkey PRIMARY KEY (idtb_conectividade),
	CONSTRAINT tb_conectividade_un UNIQUE (nome),
	CONSTRAINT tb_conectividade_fk FOREIGN KEY (idtb_setores_orgaos) 
		REFERENCES gestaoti.tb_setores_orgaos(idtb_setores_orgaos),
	CONSTRAINT tb_conectividade_idtb_orgaos_apoiados_fkey FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Equipamentos de Conectividade.';

CREATE TABLE gestaoti.tb_estacoes (
	idtb_estacoes INT auto_increment NOT NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	idtb_proc_modelo int4 NOT NULL,
	clock_proc float4 NOT NULL,
	fabricante varchar(255) NOT NULL,
	modelo varchar(255) NOT NULL,
	nome varchar(255) NOT NULL,
	memoria varchar(255) NOT NULL,
	armazenamento varchar(255) NOT NULL,
	idtb_sor int4 NOT NULL,
	end_ip varchar(255) NULL,
	end_mac varchar(255) NULL,
	data_aquisicao date NULL,
	data_garantia date NULL,
	idtb_memorias int4 NULL,
	idtb_setores_orgaos int4 NOT NULL DEFAULT 1,
	status varchar(45) NULL,
	CONSTRAINT tb_estacoes_pkey PRIMARY KEY (idtb_estacoes),
	CONSTRAINT tb_estacoes_un UNIQUE (nome),
	CONSTRAINT tb_estacoes_fk FOREIGN KEY (idtb_memorias) REFERENCES gestaoti.tb_memorias(idtb_memorias),
	CONSTRAINT tb_estacoes_fk_1 FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados),
	CONSTRAINT tb_estacoes_fk_2 FOREIGN KEY (idtb_proc_modelo) 
		REFERENCES gestaoti.tb_proc_modelo(idtb_proc_modelo),
	CONSTRAINT tb_estacoes_fk_3 FOREIGN KEY (idtb_sor) REFERENCES gestaoti.tb_sor(idtb_sor),
	CONSTRAINT tb_estacoes_fk_4 FOREIGN KEY (idtb_setores_orgaos) 
		REFERENCES gestaoti.tb_setores_orgaos(idtb_setores_orgaos)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Estações de Trabalho.';

CREATE TABLE gestaoti.tb_manutencao_et (
	idtb_manutencao_et INT auto_increment NOT NULL,
	idtb_estacoes int4 NOT NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	data_entrada date NOT NULL,
	data_saida date NULL,
	diagnostico varchar(255) NULL,
	custo_manutencao float4 NULL,
	situacao varchar(255) NOT NULL,
	CONSTRAINT tb_manutencao_et_pk PRIMARY KEY (idtb_manutencao_et),
	CONSTRAINT tb_manutencao_et_fk FOREIGN KEY (idtb_estacoes) REFERENCES gestaoti.tb_estacoes(idtb_estacoes),
	CONSTRAINT tb_manutencao_et_fk_1 FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Controle de Manutenção das ET.';

CREATE TABLE gestaoti.tb_mapainfra (
	idtb_mapainfra INT auto_increment NOT NULL,
	idtb_conectividade_orig int4 NOT NULL,
	idtb_conectividade_dest int4 NULL,
	idtb_servidores_dest int4 NULL,
	idtb_estacoes_dest int4 NULL,
	porta_orig int4 NOT NULL,
	porta_dest int4 NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	CONSTRAINT tb_mapainfra_pk PRIMARY KEY (idtb_mapainfra),
	CONSTRAINT tb_mapainfra_fk_1 FOREIGN KEY (idtb_estacoes_dest) 
		REFERENCES gestaoti.tb_estacoes(idtb_estacoes),
	CONSTRAINT tb_mapainfra_fk_2 FOREIGN KEY (idtb_servidores_dest) 
		REFERENCES gestaoti.tb_servidores(idtb_servidores),
	CONSTRAINT tb_mapainfra_fk_3 FOREIGN KEY (idtb_conectividade_orig) 
		REFERENCES gestaoti.tb_conectividade(idtb_conectividade),
	CONSTRAINT tb_mapainfra_fk_4 FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados),
	CONSTRAINT tb_mapainfra_fk_5 FOREIGN KEY (idtb_conectividade_dest) 
		REFERENCES gestaoti.tb_conectividade(idtb_conectividade)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Mapeamentos dos pontos de rede da infraestrutura,';

CREATE TABLE gestaoti.tb_nec_aquisicao (
	idtb_nec_aquisicao INT auto_increment NOT NULL,
	idtb_manutencao_et int4 NOT NULL,
	desc_nec_aquisicao varchar(255) NULL,
	preco_cotado float4 NULL,
	previsao_aquisicao date NULL,
	situacao varchar(255) NULL,
	motivo_cancelamento varchar(255) NULL,
	CONSTRAINT tb_nec_aquisicao_pk PRIMARY KEY (idtb_nec_aquisicao),
	CONSTRAINT tb_nec_aquisicao_fk FOREIGN KEY (idtb_manutencao_et) 
		REFERENCES gestaoti.tb_manutencao_et(idtb_manutencao_et)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Necessidades de Aquisição de Material de TI para reparos de ET.';

CREATE TABLE gestaoti.tb_dias_troca (
		idtb_dias_troca INT auto_increment NOT NULL,
		idtb_pessoal_ti int4 NOT NULL,
		dias_troca int4 NOT NULL,
		CONSTRAINT tb_dias_troca_pkey PRIMARY KEY (idtb_dias_troca),
		CONSTRAINT tb_dias_troca_fk_1 FOREIGN KEY (idtb_pessoal_ti) 
			REFERENCES gestaoti.tb_pessoal_ti(idtb_pessoal_ti)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Dias para Troca de Senha';

CREATE TABLE gestaoti.tb_numerador (
		idtb_numerador INT auto_increment NOT NULL,
		parametro varchar(255) NOT NULL,
		prox_num int4 NOT NULL DEFAULT 1,
		CONSTRAINT tb_numerador_pkey PRIMARY KEY (idtb_numerador)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo Números de Documentos';

CREATE TABLE gestaoti.tb_dvr (
		idtb_dvr INT auto_increment NOT NULL,
		idtb_orgaos_apoiados int4 NOT NULL,
		marca varchar (255) NOT NULL,
		modelo varchar (255) NOT NULL,
		end_ip varchar (15) NOT NULL,
		idtb_setores_orgaos int4 NULL,
		qtde_cameras int4 NOT NULL,
		status varchar(45) NULL,
		CONSTRAINT tb_dvr_pkey PRIMARY KEY (idtb_dvr),
		CONSTRAINT tb_dvr_fk_1 FOREIGN KEY (idtb_orgaos_apoiados) 
			REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados),
		CONSTRAINT tb_dvr_fk_2 FOREIGN KEY (idtb_setores_orgaos) 
			REFERENCES gestaoti.tb_setores_orgaos(idtb_setores_orgaos)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo DVR';

CREATE TABLE gestaoti.tb_cameras (
		idtb_cameras INT auto_increment NOT NULL,
		idtb_dvr int4 NOT NULL,
		marca varchar (255) NOT NULL,
		modelo varchar (255) NOT NULL,
		localizacao varchar (255) NOT NULL,
		status varchar(45) NULL,
		CONSTRAINT tb_cameras_pkey PRIMARY KEY (idtb_cameras),
		CONSTRAINT tb_cameras_fk_1 FOREIGN KEY (idtb_dvr) 
			REFERENCES gestaoti.tb_dvr(idtb_dvr)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo câmeras';

CREATE TABLE gestaoti.tb_cameras_ip (
		idtb_cameras_ip INT auto_increment NOT NULL,
		idtb_orgaos_apoiados int4 NOT NULL,
		marca varchar (255) NOT NULL,
		modelo varchar (255) NOT NULL,
		end_ip varchar (15) NOT NULL,
		localizacao varchar (255) NOT NULL,
		status varchar(45) NULL,
		CONSTRAINT tb_cameras_ip_pkey PRIMARY KEY (idtb_cameras_ip),
		CONSTRAINT tb_cameras_ip_fk_1 FOREIGN KEY (idtb_orgaos_apoiados) 
			REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo câmeras IP';

CREATE TABLE gestaoti.tb_usuarios_senhas (
		idtb_usuarios_senhas INT auto_increment NOT NULL,
		tipo_ativo varchar (255) NOT NULL,
		id_ativo int4 NOT NULL,
		usuario varchar (255) NOT NULL,
		senha varchar (255) NOT NULL,
		status varchar (45) NOT NULL,
		CONSTRAINT tb_usuarios_senhas_pkey PRIMARY KEY (idtb_usuarios_senhas)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT = 'Tabela contendo usuários e senhas dos ativos de TI';

CREATE TABLE gestaoti.tb_chaves_cripto (
		idtb_chaves_cripto INT auto_increment NOT NULL,
		idtb_pessoal_ti int4 NOT NULL,
		senha_cripto varchar (255) NOT NULL,
		chave_cripto varchar (6) NOT NULL,
		status varchar (45) NOT NULL,
		CONSTRAINT tb_chaves_cripto_pkey PRIMARY KEY (idtb_chaves_cripto),
		CONSTRAINT tb_chaves_cripto_fkey FOREIGN KEY (idtb_pessoal_ti) REFERENCES gestaoti.tb_pessoal_ti(idtb_pessoal_ti)
)
ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_0900_ai_ci
COMMENT='Tabela contendo chaves de criptografia';