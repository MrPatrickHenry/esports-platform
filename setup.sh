#ServerUpgrade
echo "Initialsing system ..."
yes | yum install epel-release
rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
yum-config-manager --enable remi-php73
yes | yum --enablerepo=remi-php73 install php-xml php-soap php-xmlrpc php-mbstring php-json php-gd php-mcrypt
yes | yum install unzip
php -v
chmod -R gu+w storage && chmod -R guo+w storage && chmod 777 -R * && chown apache:apache -R *
cp -a httpd.conf /etc/httpd/conf/httpd.conf
cp -a .env.example .env
wget https://dl.google.com/cloudsql/cloud_sql_proxy.linux.amd64 -O cloud_sql_proxy
chmod +x cloud_sql_proxy
./cloud_sql_proxy -instances=leaguevalvr:us-central1:valappvr=tcp:3306 \
                  -credential_file=leaguevalvr-d394f1a3b3e6.json &

echo "system is ready! go be awesome"
