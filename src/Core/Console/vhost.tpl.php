<?php

return $vhostTpl = '##-- Entry start for {userDomain} --

<VirtualHost {ip}:80>
        ServerName "dev.{userDomain}"
        DocumentRoot "{documentRoot}"
DocumentRoot {documentRoot}
ServerName dev.{userDomain}
CustomLog "{accessLog}" combined
ErrorLog "{errorLog}"

<Directory "{documentRoot}/">
        Require all granted
        AllowOverride All
        Options All
</Directory>

</VirtualHost>

##-- Entry end for {userDomain} --';