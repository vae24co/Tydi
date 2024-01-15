define SSL "C:/laragon/etc/ssl"
define ROOT "C:/laragon/www/tydi"
define LOGS "${ROOT}/_source/logs"


define TYDI "tydi.co"
<VirtualHost *:80>
    DocumentRoot "${ROOT}"
    ServerName ${TYDI}
    ServerAlias *.${TYDI}
    <Directory "${ROOT}">
        AllowOverride All
        Require all granted
    </Directory>
	ErrorLog ${LOGS}/${TYDI}-error.log
	CustomLog ${LOGS}/${TYDI}-access.log common
</VirtualHost>
<VirtualHost *:443>
    DocumentRoot "${ROOT}"
    ServerName ${TYDI}
    ServerAlias *.${TYDI}
    <Directory "${ROOT}">
        AllowOverride All
        Require all granted
    </Directory>
	ErrorLog ${LOGS}/${TYDI}-error.log
	CustomLog ${LOGS}/${TYDI}-access.log common
	SSLEngine on
	SSLCertificateFile      ${SSL}/laragon.crt
	SSLCertificateKeyFile   ${SSL}/laragon.key
</VirtualHost>


define JORE "jore.co"
<VirtualHost *:80>
	DocumentRoot "${ROOT}"
	ServerName ${JORE}
	ServerAlias *.${JORE}
	<Directory "${ROOT}">
		AllowOverride All
		Require all granted
	</Directory>
	ErrorLog ${LOGS}/${JORE}-error.log
	CustomLog ${LOGS}/${JORE}-access.log common
</VirtualHost>
<VirtualHost *:443>
	DocumentRoot "${ROOT}"
	ServerName ${JORE}
	ServerAlias *.${JORE}
	<Directory "${ROOT}">
		AllowOverride All
		Require all granted
	</Directory>
	ErrorLog ${LOGS}/${JORE}-error.log
	CustomLog ${LOGS}/${JORE}-access.log common
	SSLEngine on
	SSLCertificateFile      ${SSL}/laragon.crt
	SSLCertificateKeyFile   ${SSL}/laragon.key
</VirtualHost>


define LESL "lesl.co"
<VirtualHost *:80>
	DocumentRoot "${ROOT}"
	ServerName ${LESL}
	ServerAlias *.${LESL}
	<Directory "${ROOT}">
		AllowOverride All
		Require all granted
	</Directory>
	ErrorLog ${LOGS}/${LESL}-error.log
	CustomLog ${LOGS}/${LESL}-access.log common
</VirtualHost>
<VirtualHost *:443>
	DocumentRoot "${ROOT}"
	ServerName ${LESL}
	ServerAlias *.${LESL}
	<Directory "${ROOT}">
		AllowOverride All
		Require all granted
	</Directory>
	ErrorLog ${LOGS}/${LESL}-error.log
	CustomLog ${LOGS}/${LESL}-access.log common
	SSLEngine on
	SSLCertificateFile      ${SSL}/laragon.crt
	SSLCertificateKeyFile   ${SSL}/laragon.key
</VirtualHost>


define CANTEEN "canteen.co"
<VirtualHost *:80>
	DocumentRoot "${ROOT}"
	ServerName ${CANTEEN}
	ServerAlias *.${CANTEEN}
	<Directory "${ROOT}">
		AllowOverride All
		Require all granted
	</Directory>
	ErrorLog ${LOGS}/${CANTEEN}-error.log
	CustomLog ${LOGS}/${CANTEEN}-access.log common
</VirtualHost>
<VirtualHost *:443>
	DocumentRoot "${ROOT}"
	ServerName ${CANTEEN}
	ServerAlias *.${CANTEEN}
	<Directory "${ROOT}">
		AllowOverride All
		Require all granted
	</Directory>
	ErrorLog ${LOGS}/${CANTEEN}-error.log
	CustomLog ${LOGS}/${CANTEEN}-access.log common
	SSLEngine on
	SSLCertificateFile      ${SSL}/laragon.crt
	SSLCertificateKeyFile   ${SSL}/laragon.key
</VirtualHost>

define HAULAGE "haulage.co"
<VirtualHost *:80>
	DocumentRoot "${ROOT}"
	ServerName ${HAULAGE}
	ServerAlias *.${HAULAGE}
	<Directory "${ROOT}">
		AllowOverride All
		Require all granted
	</Directory>
	ErrorLog ${LOGS}/${HAULAGE}-error.log
	CustomLog ${LOGS}/${HAULAGE}-access.log common
</VirtualHost>
<VirtualHost *:443>
	DocumentRoot "${ROOT}"
	ServerName ${HAULAGE}
	ServerAlias *.${HAULAGE}
	<Directory "${ROOT}">
		AllowOverride All
		Require all granted
	</Directory>
	ErrorLog ${LOGS}/${HAULAGE}-error.log
	CustomLog ${LOGS}/${HAULAGE}-access.log common
	SSLEngine on
	SSLCertificateFile      ${SSL}/laragon.crt
	SSLCertificateKeyFile   ${SSL}/laragon.key
</VirtualHost>