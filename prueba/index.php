<?php

require './assets/libs/phpseclib/autoload.php';

use phpseclib3\Net\SSH2;

$ssh = new SSH2('172.30.48.236');

if (!$ssh->login('root', 'Prax636$')) {
    exit('Login falló');
}

$resultado = $ssh->exec('systemctl restart accesospraxmed.service');

echo $resultado;