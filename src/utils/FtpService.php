<?php

namespace Webfoto\Core\Utils;

use Webfoto\Core\Utils\Logger;

class FtpService
{

    private string $host;
    private int $port;
    private string $user;
    private string $password;
    private string $destination;

    private $connection;

    function __construct($ftpInfo)
    {
        $this->host = $ftpInfo['host'];
        $this->port = $ftpInfo['port'];
        $this->user = $ftpInfo['user'];
        $this->password = $ftpInfo['password'];
        $this->destination = $ftpInfo['destination'];
    }

    public function uploadImage(string $file): void
    {
        $this->connection = ftp_connect($this->host, $this->port);
        if (!$this->connection) {
            Logger::$logger->error('Error in connecting to ftp', [error_get_last()]);
            return;
        }

        $loginResult = ftp_login($this->connection, $this->user, $this->password);
        if (!$loginResult) {
            Logger::$logger->error('Error in login to ftp', [error_get_last()]);
            return;
        }

        $pasvResult = ftp_pasv($this->connection, true);
        if (!$pasvResult) {
            Logger::$logger->error('Error in setting passive mode', [error_get_last()]);
            return;
        }

        $sendResult = ftp_put($this->connection, $this->destination, $file, FTP_ASCII);
        if ($sendResult) {
            Logger::$logger->info('File uploaded successfully through FTP');
        } else {
            Logger::$logger->error('File NOT uploaded successfully through FTP', [error_get_last()]);
        }

        ftp_close($this->connection);
    }
}
