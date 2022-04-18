<?php
/**
*** 99242991 | Lúcio ALEXANDRE Correia dos Santos
**/

/* Classe de interação com o PostgreSQL */
require_once "class/pgsql.class.php";
require_once "class/constantes.inc.php";
$pg = new PgSql();
$url = $pg->getCol("SELECT valor FROM db_clti.tb_config WHERE parametro='URL'");

/* Verifica Sessão de Login Ativa */
/*if (!isLoggedIn()){
    header("Location: login_clti.php");
}

if (isset($_SESSION['user_name'])){
	$perfil = $_SESSION['perfil']; 
	if ($perfil == 'TEC_CLTI'){*/

echo"

<!doctype html>
<html lang=\"pt_BR\">
  <head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <meta name=\"description\" content=\"Sistema Integrado para Centros Locais de Tecnologia da Informação\">
    <meta name=\"author\" content=\"99242991 Lúcio ALEXANDRE Correia dos Santos\">

    <title>...::: SisCLTI :::...</title>

    <link href=\"$url/css/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- Dashboard CSS  -->
    <link href=\"$url/css/dashboard.css\" rel=\"stylesheet\">

    <!-- ForValidation CSS  -->
    <link href=\"$url/css/form-validation.css\" rel=\"stylesheet\">

    <!-- Stylesheet CSS -->
    <link href=\"$url/css/stylesheet.css\" rel=\"stylesheet\">

  </head>

  <body>
  <div class=\"alert alert-primary\" role=\"alert\">Verificando atualizações...</div>";

$versao = $pg->getCol("SELECT valor FROM db_clti.tb_config WHERE parametro='VERSAO' ");

if ($versao == '1.5.1'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Eq. Conectividade. Aguarde...</div>";
	$pg->exec("ALTER TABLE db_clti.tb_conectividade ADD status varchar NULL;");
	$pg->exec("DROP VIEW db_clti.vw_conectividade;");
	$pg->exec("CREATE OR REPLACE VIEW db_clti.vw_conectividade
	AS SELECT conec.idtb_conectividade,
		conec.idtb_om_apoiadas,
		conec.fabricante,
		conec.modelo,
		conec.nome,
		conec.qtde_portas,
		conec.idtb_om_setores,
		conec.end_ip,
		conec.data_aquisicao,
		conec.data_garantia,
		conec.status,
		om.sigla,
		setores.sigla_setor,
		setores.compartimento
	   FROM db_clti.tb_conectividade conec,
		db_clti.tb_om_setores setores,
		db_clti.tb_om_apoiadas om
	  WHERE conec.idtb_om_apoiadas = om.idtb_om_apoiadas AND conec.idtb_om_setores = setores.idtb_om_setores;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Controle de Internet. Aguarde...</div>";
	$pg->exec("ALTER TABLE db_clti.tb_controle_internet ADD status varchar NULL;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Controle de USB Habilitado. Aguarde...</div>";		
	$pg->exec("ALTER TABLE db_clti.tb_controle_usb ADD status varchar NULL;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Controle de Funções do SiGDEM. Aguarde...</div>";
	$pg->exec("ALTER TABLE db_clti.tb_funcoes_sigdem ADD status varchar NULL;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.2' WHERE parametro='VERSAO' ");
	
	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.2. Aguarde...</div>
	<meta http-equiv=\"refresh\" content=\"5\">";
}

elseif ($versao == '1.5.2'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Usuários da OM. Aguarde...</div>";
	$pg->exec("ALTER TABLE db_clti.tb_pessoal_om ADD foradaareati varchar NULL;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Permissões de Administrador. Aguarde...</div>";
	$pg->exec("CREATE TABLE db_clti.tb_permissoes_admin (
		idtb_permissoes_admin serial NOT NULL,
		idtb_om_apoiadas int4 NOT NULL,
		idtb_estacoes int4 NOT NULL,
		autorizacao varchar(255) NOT NULL,
		CONSTRAINT tb_permissoes_admin_pkey PRIMARY KEY (idtb_permissoes_admin),
		CONSTRAINT tb_permissoes_admin_fk FOREIGN KEY (idtb_estacoes) REFERENCES db_clti.tb_estacoes(idtb_estacoes),
		CONSTRAINT tb_permissoes_admin_fk1 FOREIGN KEY (idtb_om_apoiadas) REFERENCES db_clti.tb_om_apoiadas(idtb_om_apoiadas)
	);
	COMMENT ON TABLE db_clti.tb_permissoes_admin IS 'Tabela contendo ET com Permissões de Administrador';");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Aplicativos não Padronizados. Aguarde...</div>";
	$pg->exec("CREATE TABLE db_clti.tb_nao_padronizados (
		idtb_nao_padronizados serial NOT NULL,
		idtb_om_apoiadas int4 NOT NULL,
		idtb_estacoes int4 NOT NULL,
		autorizacao varchar(255) NOT NULL,
		CONSTRAINT tb_nao_padronizados_pkey PRIMARY KEY (idtb_nao_padronizados),
		CONSTRAINT tb_nao_padronizados_fk FOREIGN KEY (idtb_estacoes) REFERENCES db_clti.tb_estacoes(idtb_estacoes),
		CONSTRAINT tb_nao_padronizados_fk1 FOREIGN KEY (idtb_om_apoiadas) REFERENCES db_clti.tb_om_apoiadas(idtb_om_apoiadas)
	);
	COMMENT ON TABLE db_clti.tb_nao_padronizados IS 'Tabela contendo ET com Aplicativos não Padronizados';");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.3' WHERE parametro='VERSAO' ");
	
	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.3.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";
}

elseif ($versao == '1.5.3'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando PAD SIC/TIC. Aguarde...</div>";
	$pg->exec("CREATE TABLE db_clti.tb_pad_sic_tic (
		idtb_pad_sic_tic serial NOT NULL,
		idtb_om_apoiadas int4 NOT NULL,
		ano_base int4 NOT NULL,
		data_assinatura date NOT NULL,
		data_revisao date NULL,
		status VARCHAR NOT NULL,
		CONSTRAINT tb_pad_sic_tic_pkey PRIMARY KEY (idtb_pad_sic_tic),
		CONSTRAINT tb_pad_sic_tic_fk1 FOREIGN KEY (idtb_om_apoiadas) REFERENCES db_clti.tb_om_apoiadas(idtb_om_apoiadas)
	);
	COMMENT ON TABLE db_clti.tb_pad_sic_tic IS 'Tabela contendo PAD SIC/TIC';");

	$pg->exec("CREATE TABLE db_clti.tb_temas_pad_sic_tic (
		idtb_temas_pad_sic_tic serial NOT NULL,
		idtb_pad_sic_tic int4 NOT NULL,
		tema VARCHAR NOT NULL,
		status VARCHAR NOT NULL,
		justificativa VARCHAR NULL,
		CONSTRAINT tb_temas_pad_sic_tic_pkey PRIMARY KEY (idtb_temas_pad_sic_tic),
		CONSTRAINT tb_temas_pad_sic_tic_fk1 FOREIGN KEY (idtb_pad_sic_tic) REFERENCES db_clti.tb_pad_sic_tic(idtb_pad_sic_tic)
	);
	COMMENT ON TABLE db_clti.tb_pad_sic_tic IS 'Tabela contendo Temas do PAD SIC/TIC';");

	$pg->exec("CREATE TABLE db_clti.tb_ade_pad_sic_tic (
		idtb_ade_pad_sic_tic serial NOT NULL,
		idtb_pad_sic_tic int4 NOT NULL,
		idtb_pessoal_om int4 NOT NULL,
		CONSTRAINT tb_ade_pad_sic_tic_pkey PRIMARY KEY (idtb_ade_pad_sic_tic),
		CONSTRAINT tb_ade_pad_sic_tic_fk1 FOREIGN KEY (idtb_pad_sic_tic) REFERENCES db_clti.tb_pad_sic_tic(idtb_pad_sic_tic),
		CONSTRAINT tb_ade_pad_sic_tic_fk2 FOREIGN KEY (idtb_pessoal_om) REFERENCES db_clti.tb_pessoal_om(idtb_pessoal_om)
	);
	COMMENT ON TABLE db_clti.tb_pad_sic_tic IS 'Tabela contendo Participantes dos Adestramentos do PAD SIC/TIC';");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.4' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.4.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";
}

elseif ($versao == '1.5.4'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Pessoal da OM. Aguarde...</div>";

	$pg->exec("DROP VIEW db_clti.vw_controle_internet;");

	$pg->exec("DROP VIEW db_clti.vw_pessoal_om;");

	$pg->exec("CREATE OR REPLACE VIEW db_clti.vw_pessoal_om
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
		  AND pesom.idtb_especialidade = espec.idtb_especialidade AND pesom.idtb_om_apoiadas = om.idtb_om_apoiadas;");

	$pg->exec("CREATE OR REPLACE VIEW db_clti.vw_controle_internet
	AS SELECT internet.idtb_controle_internet,
		internet.idtb_om_apoiadas,
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
	   FROM db_clti.tb_controle_internet internet,
		db_clti.vw_pessoal_om pesom,
		db_clti.tb_om_apoiadas om
	  WHERE internet.idtb_pessoal_om = pesom.idtb_pessoal_om AND internet.idtb_om_apoiadas = om.idtb_om_apoiadas;");
		  	
	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.5' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.5.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";
}

elseif ($versao == '1.5.5'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando Controle de Adestramentos. Aguarde...</div>";
	$pg->exec("ALTER TABLE db_clti.tb_temas_pad_sic_tic ADD data_ade date NULL;");
	$pg->exec("ALTER TABLE db_clti.tb_ade_pad_sic_tic RENAME COLUMN idtb_pad_sic_tic TO idtb_temas_pad_sic_tic;");
	$pg->exec("ALTER TABLE db_clti.tb_ade_pad_sic_tic ADD CONSTRAINT tb_ade_pad_sic_tic_fk FOREIGN KEY (idtb_temas_pad_sic_tic) REFERENCES db_clti.tb_temas_pad_sic_tic(idtb_temas_pad_sic_tic);");
	$pg->exec("ALTER TABLE db_clti.tb_ade_pad_sic_tic DROP CONSTRAINT tb_ade_pad_sic_tic_fk1;");


	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.6' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.6.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";
}

elseif ($versao == '1.5.6'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando controle de aplicativos não padronizados. 
		Aguarde...</div>";
	$pg->exec("ALTER TABLE db_clti.tb_nao_padronizados ADD soft_autorizados varchar NULL; ");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.7' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.7.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.7'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";
	$pg->exec("CREATE OR REPLACE VIEW db_clti.vw_permissoes_admin
		AS SELECT adm.idtb_permissoes_admin,
			adm.idtb_om_apoiadas,
			om.sigla,
			adm.idtb_estacoes,
			et.nome,
			adm.autorizacao
		FROM db_clti.tb_permissoes_admin adm,
			db_clti.tb_estacoes et,
			db_clti.tb_om_apoiadas om
		WHERE adm.idtb_estacoes = et.idtb_estacoes AND adm.idtb_om_apoiadas = om.idtb_om_apoiadas;");
	
	$pg->exec("CREATE OR REPLACE VIEW db_clti.vw_nao_padronizados
		AS SELECT naopad.idtb_nao_padronizados,
			naopad.idtb_om_apoiadas,
			om.sigla,
			naopad.idtb_estacoes,
			et.nome,
			naopad.autorizacao,
			naopad.soft_autorizados
		FROM db_clti.tb_nao_padronizados naopad,
			db_clti.tb_estacoes et,
			db_clti.tb_om_apoiadas om
		WHERE naopad.idtb_estacoes = et.idtb_estacoes AND naopad.idtb_om_apoiadas = om.idtb_om_apoiadas;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.8' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.8.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.8'){

	$pg->exec("CREATE TABLE db_clti.tb_soft_padronizados (
		idtb_soft_padronizados serial NOT NULL,
		categoria varchar(255) NOT NULL,
		software varchar(255) NOT NULL,
		status varchar(255) NOT NULL,
		CONSTRAINT tb_soft_padronizados_pkey PRIMARY KEY (idtb_soft_padronizados)
	);
	COMMENT ON TABLE db_clti.tb_soft_padronizados IS 'Tabela contendo Softwares Padronizados';");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.9' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.9.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.9'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";
	$pg->exec("DROP VIEW db_clti.vw_funcoes_sigdem");

	$pg->exec("CREATE OR REPLACE VIEW db_clti.vw_funcoes_sigdem
		AS SELECT funcsigdem.idtb_funcoes_sigdem,
			funcsigdem.idtb_om_apoiadas,
			om.sigla AS sigla_om,
			funcsigdem.descricao,
			funcsigdem.sigla,
			funcsigdem.idtb_pessoal_om,
			posto_grad.sigla AS posto_grad,
			corpo_quadro.sigla AS corpo_quadro,
			corpo_quadro.exibir AS exibir_corpo_quadro,
			espec.sigla AS espec,
			espec.exibir AS exibir_espec,
			pesom.nome_guerra
		FROM db_clti.tb_funcoes_sigdem funcsigdem,
			db_clti.tb_pessoal_om pesom,
			db_clti.tb_posto_grad posto_grad,
			db_clti.tb_corpo_quadro corpo_quadro,
			db_clti.tb_especialidade espec,
			db_clti.tb_om_apoiadas om
		WHERE funcsigdem.idtb_om_apoiadas = om.idtb_om_apoiadas AND funcsigdem.idtb_pessoal_om = pesom.idtb_pessoal_om 
		AND pesom.idtb_posto_grad = posto_grad.idtb_posto_grad AND pesom.idtb_corpo_quadro = corpo_quadro.idtb_corpo_quadro 
		AND pesom.idtb_especialidade = espec.idtb_especialidade; ");
	
	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.10' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.10.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.10'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";
	$pg->exec("CREATE TABLE db_clti.tb_dias_troca (
		idtb_dias_troca serial NOT NULL,
		id_usuario int4 NOT NULL,
		dias_troca int4 NOT NULL,
		CONSTRAINT tb_dias_troca_pkey PRIMARY KEY (idtb_dias_troca)
	);
	COMMENT ON TABLE db_clti.tb_dias_troca IS 'Tabela contendo Dias para Troca de Senha';");

	$row = $pg->getColValues("SELECT idtb_pessoal_ti FROM db_clti.tb_pessoal_ti");
	foreach ($row as $value){
		$row = $pg->exec("INSERT INTO db_clti.tb_dias_troca (id_usuario,dias_troca) VALUES ($value,60) ");
	}

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.11' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.11.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.11'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";
	$pg->exec("CREATE TABLE db_clti.tb_dias_troca_clti (
		idtb_dias_troca_clti serial NOT NULL,
		id_usuario int4 NOT NULL,
		dias_troca int4 NOT NULL,
		CONSTRAINT tb_dias_troca_clti_pkey PRIMARY KEY (idtb_dias_troca_clti)
	);
	COMMENT ON TABLE db_clti.tb_dias_troca IS 'Tabela contendo Dias para Troca de Senha do CLTI';");	

	$row = $pg->getColValues("SELECT idtb_lotacao_clti FROM db_clti.tb_lotacao_clti");
	foreach ($row as $value){
		$row = $pg->exec("INSERT INTO db_clti.tb_dias_troca_clti (id_usuario,dias_troca) VALUES ($value,60) ");
	}

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.12' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.12.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.12'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";
	$pg->exec("CREATE TABLE db_clti.tb_rel_servico (
		idtb_rel_servico serial NOT NULL,
		sup_sai_servico varchar(255) NOT NULL,
		sup_entra_servico varchar(255) NOT NULL,
		num_rel int4 NOT NULL,
		data_entra_servico date NOT NULL,
		data_sai_servico date NOT NULL,
		cel_funcional varchar(255),
		sit_servidores varchar(255),
		sit_backup varchar(255),
		status varchar(255),
		CONSTRAINT tb_rel_servico_pkey PRIMARY KEY (idtb_rel_servico),
		CONSTRAINT tb_rel_servico_unique UNIQUE (num_rel)
	);
	COMMENT ON TABLE db_clti.tb_rel_servico IS 'Tabela contendo Relatórios de Serviço do CLTI';");

	$pg->exec("CREATE TABLE db_clti.tb_rel_servico_ocorrencias (
		idtb_rel_servico_ocorrencias serial NOT NULL,
		num_rel int4 NOT NULL,
		ocorrencia text NOT NULL,
		CONSTRAINT tb_rel_servico_ocorrencias_pkey PRIMARY KEY (idtb_rel_servico_ocorrencias),
		CONSTRAINT tb_rel_servico_ocorrencias_fk1 FOREIGN KEY (num_rel) REFERENCES db_clti.tb_rel_servico(num_rel)
	);
	COMMENT ON TABLE db_clti.tb_rel_servico_ocorrencias IS 'Tabela contendo Ocorrências do Serviço do CLTI';");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.13' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.13.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.13'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";

	$pg->exec("CREATE TABLE db_clti.tb_numerador (
		idtb_numerador serial NOT NULL,
		parametro varchar(255) NOT NULL,
		prox_num int4 NOT NULL,
		CONSTRAINT tb_numerador_pkey PRIMARY KEY (idtb_numerador)
	);
	COMMENT ON TABLE db_clti.tb_rel_servico_ocorrencias IS 'Tabela contendo Números de Documentos';");

	$pg->exec("INSERT INTO db_clti.tb_numerador (parametro,prox_num) VALUES ('RelServico',1);");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.14' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.14.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";
}

elseif ($versao == '1.5.14'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";

	$pg->exec("DROP TABLE db_clti.tb_rel_servico CASCADE");
	$pg->exec("DROP TABLE db_clti.tb_rel_servico_ocorrencias CASCADE");

	$pg->exec("CREATE TABLE db_clti.tb_rel_servico (
		idtb_rel_servico serial NOT NULL,
		sup_sai_servico int4 NOT NULL,
		sup_entra_servico int4 NOT NULL,
		num_rel int4 NOT NULL,
		data_entra_servico date NOT NULL,
		data_sai_servico date NOT NULL,
		cel_funcional varchar(255),
		sit_servidores varchar(255),
		sit_backup varchar(255),
		status varchar(255),
		CONSTRAINT tb_rel_servico_pkey PRIMARY KEY (idtb_rel_servico),
		CONSTRAINT tb_rel_servico_unique UNIQUE (num_rel),
		CONSTRAINT tb_rel_servico_fkey1 FOREIGN KEY (sup_sai_servico) REFERENCES db_clti.tb_lotacao_clti(idtb_lotacao_clti),
		CONSTRAINT tb_rel_servico_fkey2 FOREIGN KEY (sup_entra_servico) REFERENCES db_clti.tb_lotacao_clti(idtb_lotacao_clti)
	);
	COMMENT ON TABLE db_clti.tb_rel_servico IS 'Tabela contendo Relatórios de Serviço do CLTI';");

	$pg->exec("CREATE TABLE db_clti.tb_rel_servico_ocorrencias (
		idtb_rel_servico_ocorrencias serial NOT NULL,
		num_rel int4 NOT NULL,
		ocorrencia text NOT NULL,
		CONSTRAINT tb_rel_servico_ocorrencias_pkey PRIMARY KEY (idtb_rel_servico_ocorrencias),
		CONSTRAINT tb_rel_servico_ocorrencias_fk1 FOREIGN KEY (num_rel) REFERENCES db_clti.tb_rel_servico(num_rel)
	);
	COMMENT ON TABLE db_clti.tb_rel_servico_ocorrencias IS 'Tabela contendo Ocorrências do Serviço do CLTI';");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.15' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.15.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.15'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";

	$pg->exec("ALTER TABLE db_clti.tb_lotacao_clti ADD idtb_funcoes_clti int4 NULL;");
	$pg->exec("ALTER TABLE db_clti.tb_rel_servico_ocorrencias ADD status varchar(255) NULL;");
	
	$pg->exec("CREATE TABLE db_clti.tb_funcoes_clti (
		idtb_funcoes_clti serial NOT NULL,
		sigla varchar(255) NOT NULL,
		descricao varchar(255) NOT NULL,
		CONSTRAINT tb_funcoes_clti_pkey PRIMARY KEY (idtb_funcoes_clti)
	);
	COMMENT ON TABLE db_clti.tb_funcoes_clti IS 'Tabela contendo Funções do CLTI';");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.16' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.16.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";
}

elseif ($versao == '1.5.16'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";

	$pg->exec("ALTER TABLE db_clti.tb_funcoes_clti ADD requerida varchar(3) NULL;");

	$pg->exec("INSERT INTO db_clti.tb_funcoes_clti (sigla,descricao,requerida) VALUES 
		('Enc.CLTI','Encarregado do CLTI','Sim'),
		('Aprov.Rel.Sv','Aprovação de Relatórios de Serviço','Sim'),
		('Sup.Sv.','Supervisor de Serviço','Sim') ");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.17' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.17.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.17'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";

	$pg->exec("ALTER TABLE db_clti.tb_lotacao_clti ADD tarefa varchar(25) NULL;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.18' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.18.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.18'){

	echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";

	$pg->exec("CREATE TABLE db_clti.tb_rel_servico_log (
		idtb_rel_servico_log serial NOT NULL,
		idtb_lotacao_clti int4 NOT NULL,
		num_rel int4 NOT NULL,
		cod_aut varchar(256) NOT NULL,
		data_hora timestamp NOT NULL,
		CONSTRAINT tb_rel_servico_log_pkey PRIMARY KEY (idtb_rel_servico_log),
		CONSTRAINT tb_rel_servico_log_fk1 FOREIGN KEY (num_rel) REFERENCES db_clti.tb_rel_servico(num_rel)
	);
	COMMENT ON TABLE db_clti.tb_rel_servico_log IS 'Tabela contendo Log de Aprovação do Relatório de Serviço';");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.19' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.19.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";

}

elseif ($versao == '1.5.19'){

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema está atualizado, Versão 1.5.19.</div>
	<meta http-equiv=\"refresh\" content=\"5;url=$url\">";

	/**echo "<div class=\"alert alert-primary\" role=\"alert\">Atualizando banco de dados. Aguarde...</div>";

	$pg->exec("CREATE TABLE db_clti.tb_rel_sv_v2 (
		idtb_rel_servico serial NOT NULL,
		sup_sai_servico int4 NOT NULL,
		sup_entra_servico int4 NOT NULL,
		num_rel int4 NOT NULL,
		data_entra_servico date NOT NULL,
		data_sai_servico date NOT NULL,
		cel_funcional varchar(255),
		sit_servidores varchar(255),
		sit_backup varchar(255),
		status varchar(255),
		CONSTRAINT tb_rel_sv_v2_pkey PRIMARY KEY (idtb_rel_servico),
		CONSTRAINT tb_rel_sv_v2_unique UNIQUE (num_rel),
		CONSTRAINT tb_rel_sv_v2_fkey1 FOREIGN KEY (sup_sai_servico) REFERENCES db_clti.tb_lotacao_clti(idtb_lotacao_clti),
		CONSTRAINT tb_rel_sv_v2_fkey2 FOREIGN KEY (sup_entra_servico) REFERENCES db_clti.tb_lotacao_clti(idtb_lotacao_clti)
	);
	COMMENT ON TABLE db_clti.tb_rel_sv_v2 IS 'Tabela contendo Relatórios de Serviço do CLTI Versão 2';");

	$pg->exec("CREATE TABLE db_clti.tb_rel_sv_v2_ocorrencias (
		idtb_rel_servico_ocorrencias serial NOT NULL,
		num_rel int4 NOT NULL,
		ocorrencia text NOT NULL,
		CONSTRAINT tb_rel_sv_v2_ocorrencias_pkey PRIMARY KEY (idtb_rel_servico_ocorrencias),
		CONSTRAINT tb_rel_sv_v2_ocorrencias_fk1 FOREIGN KEY (num_rel) REFERENCES db_clti.tb_rel_servico(num_rel)
	);
	COMMENT ON TABLE db_clti.tb_rel_sv_v2_ocorrencias IS 'Tabela contendo Ocorrências do Serviço do CLTI';");

	$pg->exec("CREATE TABLE db_clti.tb_gw_om (
		idtb_gw_om serial NOT NULL,
		idtb_om_apoiadas int4 NOT NULL,
		ip_gw varchar(15) NOT NULL,
		status varchar(255),
		qtde_vrf int4,
		CONSTRAINT tb_gw_om_pkey PRIMARY KEY (idtb_rel_servico_ocorrencias),
		CONSTRAINT tb_gw_om_fk1 FOREIGN KEY (idtb_om_apoiadas) REFERENCES db_clti.tb_om_apoiadas(idtb_om_apoiadas)
	);
	COMMENT ON TABLE db_clti.tb_gw_om IS 'Tabela contendo status do Gateway das OM Apoiadas';");

	$pg->exec("DROP VIEW db_clti.vw_pessoal_clti");

	$pg->exec("CREATE OR REPLACE VIEW db_clti.vw_pessoal_clti
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
			clti.tarefa,
			clti.status
		FROM db_clti.tb_lotacao_clti clti,
			db_clti.tb_posto_grad posto,
			db_clti.tb_corpo_quadro corpo,
			db_clti.tb_especialidade espec
		WHERE clti.idtb_posto_grad = posto.idtb_posto_grad AND clti.idtb_corpo_quadro = corpo.idtb_corpo_quadro 
			AND clti.idtb_especialidade = espec.idtb_especialidade;");

	echo "<div class=\"alert alert-primary\" role=\"alert\">Registrando nova versão. Aguarde...</div>";
	$pg->exec("UPDATE db_clti.tb_config SET valor = '1.5.20' WHERE parametro='VERSAO' ");

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema foi atualizado, Versão 1.5.20.</div>
	<meta http-equiv=\"refresh\" content=\"5\">";
	
	
	
	*/

}

/**elseif ($versao == '1.5.20'){

	echo "<div class=\"alert alert-success\" role=\"alert\">Seu sistema está atualizado, Versão 1.5.20.</div>
	<meta http-equiv=\"refresh\" content=\"5;url=$url\">";

}*/

else{
	echo "<div class=\"alert alert-primary\" role=\"alert\">Verifique sua instalação!</div>";
}

/** Encerrando Verifica Sessão de Login Ativa */
/*	}
}*/

?>