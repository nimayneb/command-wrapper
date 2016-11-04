<?php namespace JBR\CommandWrapper\Client;

use JBR\CommandWrapper\Client\Handler\SecureShellHandler;
use JBR\CommandWrapper\Client\Output\Result;
use JBR\CommandWrapper\System\Directory;
use phpseclib\Net\SSH2;
use Symfony\Component\Process\Process;

/**
 *
 */
class SecureShellClient extends RemoteClient implements SecureShellHandler
{
    /**
     * @var SSH2
     */
    protected $client;

    /**
     * @var callable
     */
    protected $secureShellOutputHandler;

    /**
     * @var callable
     */
    protected $initializeSecureShellHandler;

    /**
     * @param string $binary
     * @param SecureShellCredentials $credentials
     */
    public function __construct($binary)
    {
        parent::__construct($binary);
    }

    /**
     * @param Credentials $credentials
     *
     * @return boolean
     */
    public function connect(Credentials $credentials)
    {
        $this->client = new SSH2($credentials->getHost(), $credentials->getPort());

        if (true === is_callable($this->initializeSecureShellHandler)) {
            /*
             * function (SSH2 $shell) {
             *     $shell->setTimeout(3600);
             * }
             *
             */
            call_user_func($this->initializeSecureShellHandler, $this->client);
        }

        if (false === $credentials->connect($this->client)) {
            return false;
        }

        return true;
    }

    /**
     * @param array $arguments
     * @param Directory $workingDirectory
     *
     * @return Result
     */
    public function execute(array $arguments, Directory $workingDirectory = null)
    {
        $output = $this->client->exec($this->buildCommand($arguments), $this->secureShellOutputHandler);
        $exitCode = $this->client->getExitStatus();
        $errorOutput = $this->client->getStdError();

        return new Result($exitCode, Result::toArray($output), Result::toArray($errorOutput));
    }

    /**
     * @return boolean
     */
    public function disconnect()
    {
        return $this->client->_disconnect(0);
    }

    /**
     * @return callable
     */
    public function getSecureShellOutputHandler()
    {
        return $this->secureShellOutputHandler;
    }

    /**
     * @param callable $handler
     *
     * @return void
     */
    public function setSecureShellOutputHandler(callable $handler)
    {
        $this->secureShellOutputHandler = $handler;
    }

    /**
     * @return callable
     */
    public function getInitializeSecureShellHandler()
    {
        return $this->initializeSecureShellHandler;
    }

    /**
     * @param callable $handler
     *
     * @return void
     */
    public function setInitializeSecureShellHandler(callable $handler)
    {
        $this->initializeSecureShellHandler = $handler;
    }
}