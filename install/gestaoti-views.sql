-- gestaoti.vw_conectividade source


CREATE OR REPLACE VIEW gestaoti.vw_conectividade
	AS SELECT conec.idtb_conectividade,
		conec.idtb_orgaos_apoiados,
		conec.fabricante,
		conec.modelo,
		conec.nome,
		conec.qtde_portas,
		conec.idtb_setores_orgaos,
		conec.end_ip,
		conec.data_aquisicao,
		conec.data_garantia,
		conec.status,
		orgao.sigla,
		setores.sigla_setor,
		setores.compartimento
	   FROM gestaoti.tb_conectividade conec,
		gestaoti.tb_setores_orgaos setores,
		gestaoti.tb_orgaos_apoiados orgao
	  WHERE conec.idtb_orgaos_apoiados = orgao.idtb_orgaos_apoiados AND conec.idtb_setores_orgaos = setores.idtb_setores_orgaos;

-- Permissions

ALTER TABLE gestaoti.vw_conectividade OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_conectividade TO gestaoti;


-- gestaoti.vw_estacoes source

CREATE OR REPLACE VIEW gestaoti.vw_estacoes
AS SELECT et.idtb_estacoes,
    et.idtb_orgaos_apoiados,
    et.idtb_proc_modelo,
    et.clock_proc,
    et.fabricante,
    et.modelo,
    et.nome,
    et.idtb_memorias,
    et.memoria,
    mem.tipo AS tipo_mem,
    mem.modelo AS modelo_mem,
    mem.clock AS clock_mem,
    et.armazenamento,
    et.idtb_sor,
    et.end_ip,
    et.end_mac,
    et.data_aquisicao,
    et.data_garantia,
    et.idtb_setores_orgaos,
    setores.sigla_setor,
    setores.compartimento,
    et.req_minimos,
    et.status,
    om.sigla,
    fab.idtb_proc_fab,
    fab.nome AS proc_fab,
    modelo.modelo AS proc_modelo,
    sor.descricao,
    sor.versao,
    sor.situacao
   FROM gestaoti.tb_estacoes et,
    gestaoti.tb_proc_fab fab,
    gestaoti.tb_proc_modelo modelo,
    gestaoti.tb_orgaos_apoiados om,
    gestaoti.tb_sor sor,
    gestaoti.tb_setores_orgaos setores,
    gestaoti.tb_memorias mem
  WHERE et.idtb_proc_modelo = modelo.idtb_proc_modelo AND et.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados AND et.idtb_sor = sor.idtb_sor AND modelo.idtb_proc_fab = fab.idtb_proc_fab AND et.idtb_memorias = mem.idtb_memorias AND et.idtb_setores_orgaos = setores.idtb_setores_orgaos;

-- Permissions

ALTER TABLE gestaoti.vw_estacoes OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_estacoes TO gestaoti;


-- gestaoti.vw_funcoes_sigdem source

CREATE OR REPLACE VIEW gestaoti.vw_funcoes_sigdem
AS SELECT funcsigdem.idtb_funcoes_sigdem,
    funcsigdem.idtb_orgaos_apoiados,
    funcsigdem.descricao,
    funcsigdem.sigla,
    funcsigdem.idtb_pessoal_om,
    posto_grad.sigla AS posto_grad,
    corpo_quadro.sigla AS corpo_quadro,
    corpo_quadro.exibir AS exibir_corpo_quadro,
    espec.sigla AS espec,
    espec.exibir AS exibir_espec,
    pesom.nome_guerra
   FROM gestaoti.tb_funcoes_sigdem funcsigdem,
    gestaoti.tb_pessoal_om pesom,
    gestaoti.tb_posto_grad posto_grad,
    gestaoti.tb_corpo_quadro corpo_quadro,
    gestaoti.tb_especialidade espec,
    gestaoti.tb_orgaos_apoiados om
  WHERE funcsigdem.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados AND funcsigdem.idtb_pessoal_om = pesom.idtb_pessoal_om AND pesom.idtb_posto_grad = posto_grad.idtb_posto_grad AND pesom.idtb_corpo_quadro = corpo_quadro.idtb_corpo_quadro AND pesom.idtb_especialidade = espec.idtb_especialidade;

-- Permissions

ALTER TABLE gestaoti.vw_funcoes_sigdem OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_funcoes_sigdem TO gestaoti;


-- gestaoti.vw_mapainfra source

CREATE OR REPLACE VIEW gestaoti.vw_mapainfra
AS SELECT mapa.idtb_mapainfra,
    mapa.idtb_conectividade_orig,
    conec.fabricante AS fab_orig,
    conec.modelo AS modelo_orig,
    conec.nome AS nome_orig,
    mapa.idtb_conectividade_dest,
    mapa.idtb_servidores_dest,
    mapa.idtb_estacoes_dest,
    mapa.porta_orig,
    mapa.porta_dest,
    mapa.idtb_orgaos_apoiados,
    om.sigla
   FROM gestaoti.tb_mapainfra mapa,
    gestaoti.tb_conectividade conec,
    gestaoti.tb_orgaos_apoiados om
  WHERE mapa.idtb_conectividade_orig = conec.idtb_conectividade AND mapa.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados;

-- Permissions

ALTER TABLE gestaoti.vw_mapainfra OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_mapainfra TO gestaoti;


-- gestaoti.vw_osic source

CREATE OR REPLACE VIEW gestaoti.vw_osic
AS SELECT osic.idtb_osic,
    osic.idtb_posto_grad,
    posto.sigla AS sigla_posto_grad,
    osic.idtb_corpo_quadro,
    corpo.sigla AS sigla_corpo_quadro,
    corpo.exibir AS exibir_corpo_quadro,
    osic.idtb_especialidade,
    espec.sigla AS sigla_espec,
    espec.exibir AS exibir_espec,
    osic.idtb_orgaos_apoiados,
    om.sigla AS sigla_om,
    osic.nip,
    osic.cpf,
    osic.nome,
    osic.nome_guerra,
    osic.correio_eletronico,
    osic.perfil,
    osic.status
   FROM gestaoti.tb_osic osic,
    gestaoti.tb_posto_grad posto,
    gestaoti.tb_corpo_quadro corpo,
    gestaoti.tb_especialidade espec,
    gestaoti.tb_orgaos_apoiados om
  WHERE osic.idtb_posto_grad = posto.idtb_posto_grad AND osic.idtb_corpo_quadro = corpo.idtb_corpo_quadro AND osic.idtb_especialidade = espec.idtb_especialidade AND osic.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados;

-- Permissions

ALTER TABLE gestaoti.vw_osic OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_osic TO gestaoti;


-- gestaoti.vw_pessoal_clti source

CREATE OR REPLACE VIEW gestaoti.vw_pessoal_clti
AS SELECT clti.idtb_lotacao_clti,
    clti.idtb_posto_grad,
    posto.sigla AS sigla_posto_grad,
    clti.idtb_corpo_quadro,
    corpo.sigla AS sigla_corpo_quadro,
    corpo.exibir AS exibir_corpo_quadro,
    clti.idtb_especialidade,
    espec.sigla AS sigla_espec,
    espec.exibir AS exibir_espec,
    clti.nip,
    clti.cpf,
    clti.nome,
    clti.nome_guerra,
    clti.correio_eletronico,
    clti.perfil,
    clti.status
   FROM gestaoti.tb_lotacao_clti clti,
    gestaoti.tb_posto_grad posto,
    gestaoti.tb_corpo_quadro corpo,
    gestaoti.tb_especialidade espec
  WHERE clti.idtb_posto_grad = posto.idtb_posto_grad AND clti.idtb_corpo_quadro = corpo.idtb_corpo_quadro AND clti.idtb_especialidade = espec.idtb_especialidade;

-- Permissions

ALTER TABLE gestaoti.vw_pessoal_clti OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_pessoal_clti TO gestaoti;


-- gestaoti.vw_pessoal_om source

CREATE OR REPLACE VIEW db_clti.vw_pessoal_om
	AS SELECT pesom.idtb_pessoal_om,
		pesom.idtb_posto_grad,
		posto.sigla AS posto_grad,
		pesom.idtb_corpo_quadro,
		corpo.sigla AS corpo_quadro,
		corpo.exibir AS exibir_corpo_quadro,
		pesom.idtb_especialidade,
		espec.sigla AS espec,
		espec.exibir AS exibir_espec,
		pesom.idtb_om_apoiadas,
		om.sigla AS sigla_om,
		pesom.nip,
		pesom.cpf,
		pesom.nome,
		pesom.nome_guerra,
		pesom.correio_eletronico,
		pesom.foradaareati,
		pesom.status
	   FROM db_clti.tb_pessoal_om pesom,
		db_clti.tb_posto_grad posto,
		db_clti.tb_corpo_quadro corpo,
		db_clti.tb_especialidade espec,
		db_clti.tb_om_apoiadas om
	  WHERE pesom.idtb_posto_grad = posto.idtb_posto_grad AND pesom.idtb_corpo_quadro = corpo.idtb_corpo_quadro 
		  AND pesom.idtb_especialidade = espec.idtb_especialidade AND pesom.idtb_om_apoiadas = om.idtb_om_apoiadas;

-- Permissions

ALTER TABLE gestaoti.vw_pessoal_om OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_pessoal_om TO gestaoti;


-- gestaoti.vw_pessoal_ti source

CREATE OR REPLACE VIEW gestaoti.vw_pessoal_ti
AS SELECT pesti.idtb_pessoal_ti,
    pesti.idtb_posto_grad,
    posto.sigla AS sigla_posto_grad,
    pesti.idtb_corpo_quadro,
    corpo.sigla AS sigla_corpo_quadro,
    corpo.exibir AS exibir_corpo_quadro,
    pesti.idtb_especialidade,
    espec.sigla AS sigla_espec,
    espec.exibir AS exibir_espec,
    pesti.idtb_orgaos_apoiados,
    om.sigla AS sigla_om,
    pesti.nip,
    pesti.cpf,
    pesti.nome,
    pesti.nome_guerra,
    pesti.correio_eletronico,
    pesti.idtb_funcoes_ti,
    funcao.descricao AS desc_funcao,
    funcao.sigla AS sigla_funcao,
    pesti.status
   FROM gestaoti.tb_pessoal_ti pesti,
    gestaoti.tb_posto_grad posto,
    gestaoti.tb_corpo_quadro corpo,
    gestaoti.tb_especialidade espec,
    gestaoti.tb_orgaos_apoiados om,
    gestaoti.tb_funcoes_ti funcao
  WHERE pesti.idtb_posto_grad = posto.idtb_posto_grad AND pesti.idtb_corpo_quadro = corpo.idtb_corpo_quadro AND pesti.idtb_especialidade = espec.idtb_especialidade AND pesti.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados AND pesti.idtb_funcoes_ti = funcao.idtb_funcoes_ti;

-- Permissions

ALTER TABLE gestaoti.vw_pessoal_ti OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_pessoal_ti TO gestaoti;


-- gestaoti.vw_processadores source

CREATE OR REPLACE VIEW gestaoti.vw_processadores
AS SELECT fab.idtb_proc_fab,
    fab.nome AS fabricante,
    modelo.idtb_proc_modelo,
    modelo.modelo
   FROM gestaoti.tb_proc_fab fab,
    gestaoti.tb_proc_modelo modelo
  WHERE modelo.idtb_proc_fab = fab.idtb_proc_fab;

-- Permissions

ALTER TABLE gestaoti.vw_processadores OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_processadores TO gestaoti;


-- gestaoti.vw_qualificacao_clti source

CREATE OR REPLACE VIEW gestaoti.vw_qualificacao_clti
AS SELECT quali.idtb_qualificacao_clti,
    quali.idtb_lotacao_clti,
    pesti.idtb_posto_grad,
    posto.sigla AS sigla_posto_grad,
    pesti.idtb_corpo_quadro,
    corpo.sigla AS sigla_corpo_quadro,
    corpo.exibir AS exibir_corpo_quadro,
    pesti.idtb_especialidade,
    espec.sigla AS sigla_espec,
    espec.exibir AS exibir_espec,
    pesti.nome_guerra,
    pesti.nip,
    pesti.cpf,
    quali.instituicao,
    quali.tipo,
    quali.nome_curso,
    quali.meio,
    quali.situacao,
    quali.data_conclusao,
    quali.carga_horaria,
    quali.custo
   FROM gestaoti.tb_qualificacao_clti quali,
    gestaoti.tb_lotacao_clti pesti,
    gestaoti.tb_posto_grad posto,
    gestaoti.tb_corpo_quadro corpo,
    gestaoti.tb_especialidade espec
  WHERE quali.idtb_lotacao_clti = pesti.idtb_lotacao_clti AND pesti.idtb_posto_grad = posto.idtb_posto_grad AND pesti.idtb_corpo_quadro = corpo.idtb_corpo_quadro AND pesti.idtb_especialidade = espec.idtb_especialidade;

-- Permissions

ALTER TABLE gestaoti.vw_qualificacao_clti OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_qualificacao_clti TO gestaoti;


-- gestaoti.vw_qualificacao_pesti source

CREATE OR REPLACE VIEW gestaoti.vw_qualificacao_pesti
AS SELECT quali.idtb_qualificacao_ti,
    quali.idtb_pessoal_ti,
    pesti.idtb_posto_grad,
    posto.sigla AS sigla_posto_grad,
    pesti.idtb_corpo_quadro,
    corpo.sigla AS sigla_corpo_quadro,
    corpo.exibir AS exibir_corpo_quadro,
    pesti.idtb_especialidade,
    espec.sigla AS sigla_espec,
    espec.exibir AS exibir_espec,
    pesti.idtb_orgaos_apoiados,
    om.sigla AS sigla_om,
    pesti.nome_guerra,
    pesti.nip,
    pesti.cpf,
    quali.instituicao,
    quali.tipo,
    quali.nome_curso,
    quali.meio,
    quali.situacao,
    quali.data_conclusao,
    quali.carga_horaria,
    quali.custo
   FROM gestaoti.tb_qualificacao_ti quali,
    gestaoti.tb_pessoal_ti pesti,
    gestaoti.tb_posto_grad posto,
    gestaoti.tb_corpo_quadro corpo,
    gestaoti.tb_especialidade espec,
    gestaoti.tb_orgaos_apoiados om
  WHERE quali.idtb_pessoal_ti = pesti.idtb_pessoal_ti AND pesti.idtb_posto_grad = posto.idtb_posto_grad AND pesti.idtb_corpo_quadro = corpo.idtb_corpo_quadro AND pesti.idtb_especialidade = espec.idtb_especialidade AND pesti.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados;

-- Permissions

ALTER TABLE gestaoti.vw_qualificacao_pesti OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_qualificacao_pesti TO gestaoti;


-- gestaoti.vw_servidores source

CREATE OR REPLACE VIEW gestaoti.vw_servidores
AS SELECT srv.idtb_servidores,
    srv.idtb_orgaos_apoiados,
    srv.fabricante,
    srv.modelo,
    srv.nome,
    srv.idtb_proc_modelo,
    srv.clock_proc,
    srv.qtde_proc,
    srv.memoria,
    srv.armazenamento,
    srv.end_ip,
    srv.end_mac,
    srv.idtb_sor,
    srv.finalidade,
    srv.data_aquisicao,
    srv.data_garantia,
    srv.idtb_setores_orgaos,
    srv.status,
    om.sigla,
    fab.idtb_proc_fab,
    fab.nome AS proc_fab,
    modelo.modelo AS proc_modelo,
    sor.descricao,
    sor.versao,
    sor.situacao,
    setores.sigla_setor,
    setores.compartimento
   FROM gestaoti.tb_servidores srv,
    gestaoti.tb_proc_fab fab,
    gestaoti.tb_proc_modelo modelo,
    gestaoti.tb_orgaos_apoiados om,
    gestaoti.tb_setores_orgaos setores,
    gestaoti.tb_sor sor
  WHERE srv.idtb_proc_modelo = modelo.idtb_proc_modelo AND srv.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados AND srv.idtb_sor = sor.idtb_sor AND modelo.idtb_proc_fab = fab.idtb_proc_fab AND srv.idtb_setores_orgaos = setores.idtb_setores_orgaos;

-- Permissions

ALTER TABLE gestaoti.vw_servidores OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_servidores TO gestaoti;


-- gestaoti.vw_setores source

CREATE OR REPLACE VIEW gestaoti.vw_setores
AS SELECT setores.idtb_setores_orgaos,
    setores.idtb_orgaos_apoiados,
    setores.nome_setor,
    setores.sigla_setor,
    setores.cod_funcional,
    setores.compartimento,
    om.sigla AS sigla_om,
    om.indicativo AS indicativo_om
   FROM gestaoti.tb_setores_orgaos setores,
    gestaoti.tb_orgaos_apoiados om
  WHERE setores.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados;

-- Permissions

ALTER TABLE gestaoti.vw_setores OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_setores TO gestaoti;

-- gestaoti.vw_controle_internet source

CREATE OR REPLACE VIEW gestaoti.vw_controle_internet
AS SELECT internet.idtb_controle_internet,
    internet.idtb_orgaos_apoiados,
    om.sigla,
    internet.idtb_pessoal_om,
    pesom.posto_grad,
    pesom.corpo_quadro,
    pesom.exibir_corpo_quadro,
    pesom.espec,
    pesom.exibir_espec,
    pesom.nip,
    pesom.nome,
    pesom.nome_guerra,
    internet.perfis
   FROM gestaoti.tb_controle_internet internet,
    gestaoti.vw_pessoal_om pesom,
    gestaoti.tb_orgaos_apoiados om
  WHERE internet.idtb_pessoal_om = pesom.idtb_pessoal_om AND internet.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados;

-- Permissions

ALTER TABLE gestaoti.vw_controle_internet OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_controle_internet TO gestaoti;


-- REVISAR --

CREATE OR REPLACE VIEW db_clti.vw_permissoes_admin
		AS SELECT adm.idtb_permissoes_admin,
			adm.idtb_om_apoiadas,
			om.sigla,
			adm.idtb_estacoes,
			et.nome,
			adm.autorizacao
		FROM db_clti.tb_permissoes_admin adm,
			db_clti.tb_estacoes et,
			db_clti.tb_om_apoiadas om
		WHERE adm.idtb_estacoes = et.idtb_estacoes AND adm.idtb_om_apoiadas = om.idtb_om_apoiadas;