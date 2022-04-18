#/bin/bash
#!/bin/bash

###
#
#Author: Lucio Alexandre Correia dos Santos 99.2429.91
#Title: SisCLTI - sisclti.sh
#
##

#Verifica execução com usuário administrador(root)
if [[ $EUID -ne 0 ]]; then

	whiptail --title "ERRO" --msgbox "Este script deve ser executado como root. 
		Cancelando a instalação. Clique em OK para continuar." 8 78
	exit 1
fi

#Executa o loading
bash loading.sh

#Solicita continuar com a instalação
if whiptail \
   --title 'SISCLTI' \
   --yesno '\n     
CONFIGURAÇÃO DO SERVIDOR WEB COM POSTGRESQL\n\n
             DESEJA CONTINUAR?' 0 0

#Continuando a configuração do servidor web
then

#Instalação dos pacotes necessários
echo "Instalando pacotes necessários..."
sleep 0.5
yum group install -y "Servidor de Web Básico"
yum -y install postgresql-server
yum -y install php php-gd php-dom php-pgsql php-mbstring

#Inicializando e habilitando os serviços
echo "Inicializando e habilitando os serviços..."
sleep 0.5
systemctl start httpd
postgresql-setup initdb
systemctl start postgresql
systemctl enable httpd
systemctl enable postgresql

#Configurando PostgreSQL
echo "Configurando PostgreSQL..."
sleep 0.5
echo "local     all     all                 trust" > /var/lib/pgsql/data/pg_hba.conf
echo "host      all     all 127.0.0.1/32    trust" >> /var/lib/pgsql/data/pg_hba.conf
echo "host      all     all ::1/128 trust" >> /var/lib/pgsql/data/pg_hba.conf
systemctl restart postgresql

#Configurando o firewall e o SELinux
echo "Configurando o firewall e o SELinux..."
sleep 0.5
firewall-cmd --add-service=http
firewall-cmd --add-service=http --permanent
firewall-cmd --add-port=443/tcp
firewall-cmd --add-port=443/tcp --permanent
sed -i "s/SELINUX=enforcing/SELINUX=disabled/g" /etc/sysconfig/selinux
sed -i "s/SELINUX=enforcing/SELINUX=disabled/g" /etc/selinux/config
setenforce 0

#Solicita senha para o usuário criado do banco de dados para o SisCLTI
while [ true ]
do
	BDPWS=$(whiptail --title "Senha para o Usuário Criado" --inputbox "Informe a senha para o usuário criado para o SisCLTI" 10 60  3>&1 1>&2 2>&3)
	exitstatus=$?
	if [ $exitstatus = 1 ]; then
		echo "Cancelado."
		exit
	fi
	BDPWS=$(echo "$BDPWS" | sed 's/ //g')
	BDPWS=$(echo $BDPWS | tr '[:upper:]' '[:lower:]')
	if [ "${#BDPWS}" -ge 5 ]; then 
		if (whiptail --title "Confirmação da Senha" --yesno "Senha do Usuário: "$BDPWS 8 78) then
    		break	
		fi
	else
		whiptail --title "ERRO" --msgbox "Senha do Usuário inválida. Clique em OK para continuar." 8 78
	fi

done

#Solicita URL/IP do SisCLTI
while [ true ]
do
	URLIP=$(whiptail --title "URL/IP do Servidor" --inputbox "Informe a URL ou End. IP do SisCLTI (SEM HTTP://)" 10 60  3>&1 1>&2 2>&3)
	exitstatus=$?
	if [ $exitstatus = 1 ]; then
		echo "Cancelado."
		exit
	fi
	URLIP=$(echo "$URLIP" | sed 's/ //g')
	URLIP=$(echo $URLIP | tr '[:upper:]' '[:lower:]')
	if [ "${#URLIP}" -ge 5 ]; then 
		if (whiptail --title "Confirmação da URL/IP" --yesno "URL/IP: "$URLIP 8 78) then
    		break	
		fi
	else
		whiptail --title "ERRO" --msgbox "URL/IP inválida. Clique em OK para continuar." 8 78
	fi

done

#Copia SisCLTI
echo "Transferindo arquivos para diretório web..."
sleep 0.5
cp -ru $PWD/ /var/www/html/sisclti
#rm -fr $PWD

#Configurações inciciais do sistema
cp /var/www/html/sisclti/class/config_default.php /var/www/html/sisclti/config/config.php
sed -i "s/localhost/$URLIP/g" /var/www/html/sisclti/db_clti_dados.sql
sed -i "s/db_passwd/$BDPWS/g" /var/www/html/sisclti/config/config.php

#Executando configuração do banco de dados PostgreSQL
echo "Executando configuração do banco de dados PostgreSQL..."
sleep 0.5
psql -c "CREATE ROLE sisclti" -U postgres
psql -c "ALTER ROLE sisclti WITH SUPERUSER INHERIT NOCREATEROLE CREATEDB LOGIN PASSWORD '$BDPWS'" -U postgres
psql -c "CREATE DATABASE db_clti WITH TEMPLATE=template0 ENCODING='UTF8' LC_COLLATE='pt_BR.UTF-8' LC_CTYPE='pt_BR.UTF-8'" -U postgres
psql -c "ALTER DATABASE db_clti OWNER TO sisclti" -U postgres
psql -c "CREATE SCHEMA db_clti" -d db_clti -U postgres
psql -c "ALTER SCHEMA db_clti OWNER TO sisclti" -d db_clti -U postgres
psql -f /var/www/html/sisclti/db_clti.sql -d db_clti -U postgres
psql -f /var/www/html/sisclti/db_clti_dados.sql -d db_clti -U postgres
psql -f /var/www/html/sisclti/db_clti_views.sql -d db_clti -U postgres

#Configurações seguras do PostgreSQL
echo "Aplicando configurações seguras do PostgreSQL..."
sleep 0.5
echo "local     all     all                 peer" > /var/lib/pgsql/data/pg_hba.conf
echo "host      all     all 127.0.0.1/32    md5" >> /var/lib/pgsql/data/pg_hba.conf
echo "host      all     all ::1/128         md5" >> /var/lib/pgsql/data/pg_hba.conf

#Reiniciando serviços
echo "Reiniciando serviços"
sleep 0.5
systemctl restart httpd
systemctl restart postgresql

#Encerrando script após configurações corretas
echo "Encerrando..."
sleep 0.5
#reboot

#Interrompendo a configuração caso selecione não no início
else
	exit
fi

