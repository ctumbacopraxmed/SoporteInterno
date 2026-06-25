<?php
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/assets/libs/phpseclib/autoload.php';

use phpseclib3\Net\SSH2;
use phpseclib3\Exception\UnableToConnectException;

class SSHController
{

    public function __construct() {}

    public function execute($ip, $user, $port, $password, $command)
    {
        try {
            $ssh = new SSH2($ip, $port ?? 22);
            if (!$ssh->login($user, $password)) {
                return [
                    'success' => false,
                    'exit_code' => -1,
                    'output' => '',
                    'message' => 'No se pudo logear con el servidor'
                ];
            }
            $output = $ssh->exec($command . ' 2>&1');
            return [
                'success' => true,
                'exit_code' => $ssh->getExitStatus(),
                'output' => trim($output),
                'message' => ''
            ];
        } catch (UnableToConnectException $e) {
            return [
                'success' => false,
                'exit_code' => -1,
                'output' => '',
                'message' => 'No se pudo conectar al servidor: ' . $e->getMessage()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'exit_code' => -1,
                'output' => '',
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}
