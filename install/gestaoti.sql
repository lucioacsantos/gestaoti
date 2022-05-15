-- gestaoti.tb_orgao_gestor definition

-- Drop table

-- DROP TABLE gestaoti.tb_orgao_gestor;

CREATE TABLE gestaoti.tb_orgao_gestor (
	idtb_orgao_gestor serial NOT NULL,
	nome varchar(255) NOT NULL,
	abreviatura varchar(45) NULL,
	dpto_responsavel varchar (255) NULL,
	cnpj varchar(14) NULL,
	CONSTRAINT tb_orgao_gestor_pkey PRIMARY KEY (idtb_orgao_gestor)
);
COMMENT ON TABLE gestaoti.tb_orgao_gestor IS 'Tabela contendo Informações do Órgão Gestor de TI.';

-- Permissions

ALTER TABLE gestaoti.tb_orgao_gestor OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_orgao_gestor TO gestaoti;


-- gestaoti.tb_config definition

-- Drop table

-- DROP TABLE gestaoti.tb_config;

CREATE TABLE gestaoti.tb_config (
	idtb_config serial NOT NULL,
	parametro varchar(255) NULL,
	valor varchar(255) NULL,
	CONSTRAINT tb_config_pkey PRIMARY KEY (idtb_config)
);
COMMENT ON TABLE gestaoti.tb_config IS 'Tabela contendo Configurações do Sistema.';

-- Permissions

ALTER TABLE gestaoti.tb_config OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_config TO gestaoti;


-- gestaoti.tb_funcoes_ti definition

-- Drop table

-- DROP TABLE gestaoti.tb_funcoes_ti;

CREATE TABLE gestaoti.tb_funcoes_ti (
	idtb_funcoes_ti serial NOT NULL,
	descricao varchar(255) NOT NULL,
	sigla varchar(45) NOT NULL,
	CONSTRAINT tb_funcao_ti_pkey PRIMARY KEY (idtb_funcoes_ti)
);
COMMENT ON TABLE gestaoti.tb_funcoes_ti IS 'Tabela contendo Funções de TI.';

-- Permissions

ALTER TABLE gestaoti.tb_funcoes_ti OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_funcoes_ti TO gestaoti;


-- gestaoti.tb_memorias definition

-- Drop table

-- DROP TABLE gestaoti.tb_memorias;

CREATE TABLE gestaoti.tb_memorias (
	idtb_memorias serial NOT NULL,
	tipo varchar(255) NOT NULL,
	modelo varchar(255) NOT NULL,
	clock int4 NOT NULL,
	CONSTRAINT tb_memorias_pkey PRIMARY KEY (idtb_memorias)
);
COMMENT ON TABLE gestaoti.tb_memorias IS 'Tabela contendo Modelos de Memórias RAM.';

-- Permissions

ALTER TABLE gestaoti.tb_memorias OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_memorias TO gestaoti;


-- gestaoti.tb_pais definition

-- Drop table

-- DROP TABLE gestaoti.tb_pais;

CREATE TABLE gestaoti.tb_pais (
	id serial NOT NULL,
	nome varchar(60) NOT NULL,
	sigla varchar(10) NOT NULL,
	CONSTRAINT pais_pkey PRIMARY KEY (id)
);
COMMENT ON TABLE gestaoti.tb_pais IS 'Tabela contendo País.';

-- Permissions

ALTER TABLE gestaoti.tb_pais OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_pais TO gestaoti;


-- gestaoti.tb_proc_fab definition

-- Drop table

-- DROP TABLE gestaoti.tb_proc_fab;

CREATE TABLE gestaoti.tb_proc_fab (
	idtb_proc_fab serial NOT NULL,
	nome varchar(255) NOT NULL,
	CONSTRAINT tb_proc_fab_nome_key UNIQUE (nome),
	CONSTRAINT tb_proc_fab_pkey PRIMARY KEY (idtb_proc_fab)
);
COMMENT ON TABLE gestaoti.tb_proc_fab IS 'Tabela contendo Fabricantes de Processadores.';

-- Permissions

ALTER TABLE gestaoti.tb_proc_fab OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_proc_fab TO gestaoti;


-- gestaoti.tb_registro_log definition

-- Drop table

-- DROP TABLE gestaoti.tb_registro_log;

CREATE TABLE gestaoti.tb_registro_log (
	idtb_registro_log serial NOT NULL,
	data_acao date NOT NULL,
	acao varchar(255) NOT NULL,
	cpf_resp varchar (11) NOT NULL,
	CONSTRAINT tb_registro_log_pkey PRIMARY KEY (idtb_registro_log)
);
COMMENT ON TABLE gestaoti.tb_registro_log IS 'Tabela contendo Registros de LOG.';

-- Permissions

ALTER TABLE gestaoti.tb_registro_log OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_registro_log TO gestaoti;


-- gestaoti.tb_sor definition

-- Drop table

-- DROP TABLE gestaoti.tb_sor;

CREATE TABLE gestaoti.tb_sor (
	idtb_sor serial NOT NULL,
	desenvolvedor varchar(512) NOT NULL,
	descricao varchar(255) NOT NULL,
	versao varchar(45) NOT NULL,
	situacao varchar(45) NOT NULL,
	CONSTRAINT tb_sor_pkey PRIMARY KEY (idtb_sor)
);
COMMENT ON TABLE gestaoti.tb_sor IS 'Tabela contendo Sisteamas Operacionais.';

-- Permissions

ALTER TABLE gestaoti.tb_sor OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_sor TO gestaoti;


-- gestaoti.tb_estado definition

-- Drop table

-- DROP TABLE gestaoti.tb_estado;

CREATE TABLE gestaoti.tb_estado (
	id serial NOT NULL,
	nome varchar(75) NOT NULL,
	uf varchar(5) NOT NULL,
	pais int4 NOT NULL,
	CONSTRAINT estado_pkey PRIMARY KEY (id),
	CONSTRAINT tb_estado_pais_fkey FOREIGN KEY (pais) REFERENCES gestaoti.tb_pais(id)
);
COMMENT ON TABLE gestaoti.tb_estado IS 'Tabela contendo Estados.';

-- Permissions

ALTER TABLE gestaoti.tb_estado OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_estado TO gestaoti;


-- gestaoti.tb_proc_modelo definition

-- Drop table

-- DROP TABLE gestaoti.tb_proc_modelo;

CREATE TABLE gestaoti.tb_proc_modelo (
	idtb_proc_modelo serial NOT NULL,
	idtb_proc_fab int4 NOT NULL,
	modelo varchar(255) NOT NULL,
	CONSTRAINT tb_proc_modelo_modelo_key UNIQUE (modelo),
	CONSTRAINT tb_proc_modelo_pkey PRIMARY KEY (idtb_proc_modelo),
	CONSTRAINT tb_proc_modelo_idtb_proc_fab_fkey FOREIGN KEY (idtb_proc_fab) 
		REFERENCES gestaoti.tb_proc_fab(idtb_proc_fab)
);
COMMENT ON TABLE gestaoti.tb_proc_modelo IS 'Tabela contendo Modelos de Processadores.';

-- Permissions

ALTER TABLE gestaoti.tb_proc_modelo OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_proc_modelo TO gestaoti;


-- gestaoti.tb_cidade definition

-- Drop table

-- DROP TABLE gestaoti.tb_cidade;

CREATE TABLE gestaoti.tb_cidade (
	id serial NOT NULL,
	nome varchar(120) NOT NULL,
	estado int4 NOT NULL,
	CONSTRAINT cidade_pkey PRIMARY KEY (id),
	CONSTRAINT tb_cidade_estado_fkey FOREIGN KEY (estado) REFERENCES gestaoti.tb_estado(id)
);
COMMENT ON TABLE gestaoti.tb_cidade IS 'Tabela contendo Cidades.';

-- Permissions

ALTER TABLE gestaoti.tb_cidade OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_cidade TO gestaoti;


-- gestaoti.tb_orgaos_apoiados definition

-- Drop table

-- DROP TABLE gestaoti.tb_orgaos_apoiados;

CREATE TABLE gestaoti.tb_orgaos_apoiados (
	idtb_orgaos_apoiados serial NOT NULL,
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
);
COMMENT ON TABLE gestaoti.tb_orgaos_apoiados IS 'Tabela contendo Órgãos Apoiadas pelo Gestor de TI.';

-- Permissions

ALTER TABLE gestaoti.tb_orgaos_apoiados OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_orgaos_apoiados TO gestaoti;


-- gestaoti.tb_setores_orgaos definition

-- Drop table

-- DROP TABLE gestaoti.tb_setores_orgaos;

CREATE TABLE gestaoti.tb_setores_orgaos (
	idtb_setores_orgaos serial NOT NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	nome_setor varchar(255) NOT NULL,
	sigla_setor varchar(255) NOT NULL,
	cod_funcional varchar(255) NULL,
	compartimento varchar(255) NULL,
	status varchar(45) NULL,
	CONSTRAINT tb_setores_orgaos_pk PRIMARY KEY (idtb_setores_orgaos),
	CONSTRAINT tb_setores_orgaos_fk FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
);
CREATE UNIQUE INDEX tb_setores_orgaos_idtb_setores_orgaos_idx ON gestaoti.tb_setores_orgaos 
	USING btree (idtb_setores_orgaos);
COMMENT ON TABLE gestaoti.tb_setores_orgaos IS 'Tabela contendo Setores dos Órgãos.';

-- Permissions

ALTER TABLE gestaoti.tb_setores_orgaos OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_setores_orgaos TO gestaoti;


-- gestaoti.tb_pessoal_orgaos definition

-- Drop table

-- DROP TABLE gestaoti.tb_pessoal_orgaos;

CREATE TABLE gestaoti.tb_pessoal_orgaos (
	idtb_pessoal_orgaos serial NOT NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	cpf varchar(11) NOT NULL,
	nome varchar(255) NOT NULL,
	nome_guerra varchar(255) NOT NULL,
	correio_eletronico varchar(255) NOT NULL,
	status varchar(45) NOT NULL,
	CONSTRAINT tb_pessoal_orgaos_pkey PRIMARY KEY (idtb_pessoal_orgaos),
	CONSTRAINT tb_pessoal_orgaos_idtb_orgaos_apoiados_fkey FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
);
COMMENT ON TABLE gestaoti.tb_pessoal_orgaos IS 'Tabela contendo Pessoal (Usuários) da OM';

-- Permissions

ALTER TABLE gestaoti.tb_pessoal_orgaos OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_pessoal_orgaos TO gestaoti;


-- gestaoti.tb_pessoal_ti definition

-- Drop table

-- DROP TABLE gestaoti.tb_pessoal_ti;

CREATE TABLE gestaoti.tb_pessoal_ti (
	idtb_pessoal_ti serial NOT NULL,
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
);
COMMENT ON TABLE gestaoti.tb_pessoal_ti IS 'Tabela contendo Pessoal de TI.';

-- Permissions

ALTER TABLE gestaoti.tb_pessoal_ti OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_pessoal_ti TO gestaoti;


-- gestaoti.tb_servidores definition

-- Drop table

-- DROP TABLE gestaoti.tb_servidores;

CREATE TABLE gestaoti.tb_servidores (
	idtb_servidores serial NOT NULL,
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
);
COMMENT ON TABLE gestaoti.tb_servidores IS 'Tabela contendo Servidores.';

-- Permissions

ALTER TABLE gestaoti.tb_servidores OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_servidores TO gestaoti;


-- gestaoti.tb_conectividade definition

-- Drop table

-- DROP TABLE gestaoti.tb_conectividade;

CREATE TABLE gestaoti.tb_conectividade (
	idtb_conectividade serial NOT NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	fabricante varchar(255) NOT NULL,
	modelo varchar(255) NOT NULL,
	end_ip varchar(255) NULL,
	data_aquisicao date NOT NULL,
	data_garantia date NULL,
	idtb_setores_orgaos int4 NULL,
	qtde_portas int4 NULL, -- Quantidade de portas do ativo de rede
	nome varchar(50) NULL,
	status varchar(45) NULL,
	CONSTRAINT tb_conectividade_end_ip_key UNIQUE (end_ip),
	CONSTRAINT tb_conectividade_pkey PRIMARY KEY (idtb_conectividade),
	CONSTRAINT tb_conectividade_un UNIQUE (nome),
	CONSTRAINT tb_conectividade_fk FOREIGN KEY (idtb_setores_orgaos) 
		REFERENCES gestaoti.tb_setores_orgaos(idtb_setores_orgaos),
	CONSTRAINT tb_conectividade_idtb_orgaos_apoiados_fkey FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
);
COMMENT ON TABLE gestaoti.tb_conectividade IS 'Tabela contendo Equipamentos de Conectividade.';

-- Column comments

COMMENT ON COLUMN gestaoti.tb_conectividade.qtde_portas IS 'Quantidade de portas do ativo de rede';

-- Permissions

ALTER TABLE gestaoti.tb_conectividade OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_conectividade TO gestaoti;


-- gestaoti.tb_estacoes definition

-- Drop table

-- DROP TABLE gestaoti.tb_estacoes;

CREATE TABLE gestaoti.tb_estacoes (
	idtb_estacoes serial NOT NULL,
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
);
COMMENT ON TABLE gestaoti.tb_estacoes IS 'Tabela contendo Estações de Trabalho.';

-- Permissions

ALTER TABLE gestaoti.tb_estacoes OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_estacoes TO gestaoti;


-- gestaoti.tb_manutencao_et definition

-- Drop table

-- DROP TABLE gestaoti.tb_manutencao_et;

CREATE TABLE gestaoti.tb_manutencao_et (
	idtb_manutencao_et serial NOT NULL,
	idtb_estacoes int4 NOT NULL,
	idtb_orgaos_apoiados int4 NOT NULL,
	data_entrada date NOT NULL,
	data_saida date NULL,
	diagnostico bpchar(255) NULL,
	custo_manutencao float4 NULL,
	situacao varchar(255) NOT NULL,
	CONSTRAINT tb_manutencao_et_pk PRIMARY KEY (idtb_manutencao_et),
	CONSTRAINT tb_manutencao_et_fk FOREIGN KEY (idtb_estacoes) REFERENCES gestaoti.tb_estacoes(idtb_estacoes),
	CONSTRAINT tb_manutencao_et_fk_1 FOREIGN KEY (idtb_orgaos_apoiados) 
		REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
);
CREATE INDEX tb_manutencao_et_idtb_manutencao_et_idx ON gestaoti.tb_manutencao_et USING btree (idtb_manutencao_et);
COMMENT ON TABLE gestaoti.tb_manutencao_et IS 'Tabela contendo Controle de Manutenção das ET.';

-- Permissions

ALTER TABLE gestaoti.tb_manutencao_et OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_manutencao_et TO gestaoti;


-- gestaoti.tb_mapainfra definition

-- Drop table

-- DROP TABLE gestaoti.tb_mapainfra;

CREATE TABLE gestaoti.tb_mapainfra (
	idtb_mapainfra serial NOT NULL,
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
);
COMMENT ON TABLE gestaoti.tb_mapainfra IS 'Mapeamentos dos pontos de rede da infraestrutura,';

-- Permissions

ALTER TABLE gestaoti.tb_mapainfra OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_mapainfra TO gestaoti;


-- gestaoti.tb_nec_aquisicao definition

-- Drop table

-- DROP TABLE gestaoti.tb_nec_aquisicao;

CREATE TABLE gestaoti.tb_nec_aquisicao (
	idtb_nec_aquisicao serial NOT NULL,
	idtb_manutencao_et int4 NOT NULL,
	desc_nec_aquisicao varchar(255) NULL,
	preco_cotado float4 NULL,
	previsao_aquisicao date NULL,
	situacao varchar(255) NULL,
	motivo_cancelamento varchar(255) NULL,
	CONSTRAINT tb_nec_aquisicao_pk PRIMARY KEY (idtb_nec_aquisicao),
	CONSTRAINT tb_nec_aquisicao_fk FOREIGN KEY (idtb_manutencao_et) 
		REFERENCES gestaoti.tb_manutencao_et(idtb_manutencao_et)
);
CREATE INDEX tb_nec_aquisicao_idtb_nec_aquisicao_idx ON gestaoti.tb_nec_aquisicao USING btree (idtb_nec_aquisicao);
COMMENT ON TABLE gestaoti.tb_nec_aquisicao IS 'Tabela contendo Necessidades de Aquisição de Material de 
	TI para reparos de ET.';

-- Permissions

ALTER TABLE gestaoti.tb_nec_aquisicao OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_nec_aquisicao TO gestaoti;


-- gestaoti.tb_dias_troca definition

-- Drop table

-- DROP TABLE gestaoti.tb_dias_troca;

CREATE TABLE gestaoti.tb_dias_troca (
		idtb_dias_troca serial NOT NULL,
		idtb_pessoal_ti int4 NOT NULL,
		dias_troca int4 NOT NULL,
		CONSTRAINT tb_dias_troca_pkey PRIMARY KEY (idtb_dias_troca),
		CONSTRAINT tb_dias_troca_fk_1 FOREIGN KEY (idtb_pessoal_ti) 
			REFERENCES gestaoti.tb_pessoal_ti(idtb_pessoal_ti)
	);
COMMENT ON TABLE gestaoti.tb_dias_troca IS 'Tabela contendo Dias para Troca de Senha';

-- Permissions

ALTER TABLE gestaoti.tb_dias_troca OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_dias_troca TO gestaoti;


-- gestaoti.tb_numerador definition

-- Drop table

-- DROP TABLE gestaoti.tb_numerador;

CREATE TABLE gestaoti.tb_numerador (
		idtb_numerador serial NOT NULL,
		parametro varchar(255) NOT NULL,
		prox_num int4 NOT NULL DEFAULT 1,
		CONSTRAINT tb_numerador_pkey PRIMARY KEY (idtb_numerador)
	);
COMMENT ON TABLE gestaoti.tb_numerador IS 'Tabela contendo Números de Documentos';

-- Permissions

ALTER TABLE gestaoti.tb_numerador OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_numerador TO gestaoti;


-- gestaoti.tb_dvr definition

-- Drop table

-- DROP TABLE gestaoti.tb_dvr;

CREATE TABLE gestaoti.tb_dvr (
		idtb_dvr serial NOT NULL,
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
);
COMMENT ON TABLE gestaoti.tb_dvr IS 'Tabela contendo DVR';

-- Permissions

ALTER TABLE gestaoti.tb_dvr OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_dvr TO gestaoti;


-- gestaoti.tb_cameras definition

-- Drop table

-- DROP TABLE gestaoti.tb_cameras;

CREATE TABLE gestaoti.tb_cameras (
		idtb_cameras serial NOT NULL,
		idtb_dvr int4 NOT NULL,
		marca varchar (255) NOT NULL,
		modelo varchar (255) NOT NULL,
		localizacao varchar (255) NOT NULL,
		status varchar(45) NULL,
		CONSTRAINT tb_cameras_pkey PRIMARY KEY (idtb_cameras),
		CONSTRAINT tb_cameras_fk_1 FOREIGN KEY (idtb_dvr) 
			REFERENCES gestaoti.tb_dvr(idtb_dvr)
);
COMMENT ON TABLE gestaoti.tb_cameras IS 'Tabela contendo câmeras';

-- Permissions

ALTER TABLE gestaoti.tb_cameras OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_cameras TO gestaoti;


-- gestaoti.tb_cameras_ip definition

-- Drop table

-- DROP TABLE gestaoti.tb_cameras_ip;

CREATE TABLE gestaoti.tb_cameras_ip (
		idtb_cameras_ip serial NOT NULL,
		idtb_orgaos_apoiados int4 NOT NULL,
		marca varchar (255) NOT NULL,
		modelo varchar (255) NOT NULL,
		end_ip varchar (15) NOT NULL,
		localizacao varchar (255) NOT NULL,
		status varchar(45) NULL,
		CONSTRAINT tb_cameras_ip_pkey PRIMARY KEY (idtb_cameras_ip),
		CONSTRAINT tb_cameras_ip_fk_1 FOREIGN KEY (idtb_orgaos_apoiados) 
			REFERENCES gestaoti.tb_orgaos_apoiados(idtb_orgaos_apoiados)
);
COMMENT ON TABLE gestaoti.tb_cameras IS 'Tabela contendo câmeras IP';

-- Permissions

ALTER TABLE gestaoti.tb_cameras_ip OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_cameras_ip TO gestaoti;


-- gestaoti.tb_usuarios_senhas definition

-- Drop table

-- DROP TABLE gestaoti.tb_usuarios_senhas;

CREATE TABLE gestaoti.tb_usuarios_senhas (
		idtb_usuarios_senhas serial NOT NULL,
		tipo_ativo varchar (255) NOT NULL,
		id_ativo int4 NOT NULL,
		usuario varchar (255) NOT NULL,
		senha varchar (255) NOT NULL,
		status varchar (45) NOT NULL,
		CONSTRAINT tb_usuarios_senhas_pkey PRIMARY KEY (idtb_usuarios_senhas)
);
COMMENT ON TABLE gestaoti.tb_usuarios_senhas IS 'Tabela contendo usuários e senhas dos ativos de TI';

-- Permissions

ALTER TABLE gestaoti.tb_usuarios_senhas OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_usuarios_senhas TO gestaoti;


-- gestaoti.tb_chaves_cripto definition

-- Drop table

-- DROP TABLE gestaoti.tb_chaves_cripto

CREATE TABLE gestaoti.tb_chaves_cripto (
		idtb_chaves_cripto serial NOT NULL,
		idtb_pessoal_ti int4 NOT NULL,
		senha_cripto varchar (255) NOT NULL,
		chave_cripto varchar (6) NOT NULL,
		status varchar (45) NOT NULL,
		CONSTRAINT tb_chaves_cripto_pkey PRIMARY KEY (idtb_chaves_cripto),
		CONSTRAINT tb_chaves_cripto_fkey FOREIGN KEY (idtb_pessoal_ti) REFERENCES gestaoti.tb_pessoal_ti(idtb_pessoal_ti)
);
COMMENT ON TABLE gestaoti.tb_chaves_cripto IS 'Tabela contendo chaves de criptografia';

-- Permissions

ALTER TABLE gestaoti.tb_chaves_cripto OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.tb_chaves_cripto TO gestaoti;