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


/*-- gestaoti.vw_mapainfra source

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
GRANT ALL ON TABLE gestaoti.vw_mapainfra TO gestaoti;*/


-- gestaoti.vw_pessoal_ti source

CREATE OR REPLACE VIEW gestaoti.vw_pessoal_ti
AS SELECT pesti.idtb_pessoal_ti,
    pesti.idtb_orgaos_apoiados,
    apoiados.sigla AS sigla_apoiados,
    pesti.cpf,
    pesti.nome,
    pesti.nome_guerra,
    pesti.correio_eletronico,
    pesti.idtb_funcoes_ti,
    funcao.descricao AS desc_funcao,
    funcao.sigla AS sigla_funcao,
    pesti.status
   FROM gestaoti.tb_pessoal_ti pesti,
    gestaoti.tb_orgaos_apoiados apoiados,
    gestaoti.tb_funcoes_ti funcao
  WHERE pesti.idtb_orgaos_apoiados = apoiados.idtb_orgaos_apoiados AND pesti.idtb_funcoes_ti = funcao.idtb_funcoes_ti;

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
    srv.status,
    om.sigla,
    fab.idtb_proc_fab,
    fab.nome AS proc_fab,
    modelo.modelo AS proc_modelo,
    sor.descricao,
    sor.versao,
    sor.situacao
   FROM gestaoti.tb_servidores srv,
    gestaoti.tb_proc_fab fab,
    gestaoti.tb_proc_modelo modelo,
    gestaoti.tb_orgaos_apoiados om,
    gestaoti.tb_sor sor
  WHERE srv.idtb_proc_modelo = modelo.idtb_proc_modelo AND srv.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados AND srv.idtb_sor = sor.idtb_sor AND modelo.idtb_proc_fab = fab.idtb_proc_fab;

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
    om.sigla AS sigla_om
   FROM gestaoti.tb_setores_orgaos setores,
    gestaoti.tb_orgaos_apoiados om
  WHERE setores.idtb_orgaos_apoiados = om.idtb_orgaos_apoiados;

-- Permissions

ALTER TABLE gestaoti.vw_setores OWNER TO gestaoti;
GRANT ALL ON TABLE gestaoti.vw_setores TO gestaoti;