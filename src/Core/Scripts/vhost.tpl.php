<?php

return $vhostTpl = '##-- Entry start for {userDomain} --
<Directory "{documentRoot}/">
Allow From All
AllowOverride All
Order allow,deny
Options All
</Directory>
<VirtualHost {ip}:80>
        ServerName "dev.{userDomain}"
        DocumentRoot "{documentRoot}"
DocumentRoot {documentRoot}
ServerName dev.{userDomain}
CustomLog "{accessLog}" combined
ErrorLog "{errorLog}"
</VirtualHost>
##-- Entry End for {userDomain} --';