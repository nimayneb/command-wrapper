<?php namespace JBR\CommandWrapper;

use Closure;
use JBR\CommandWrapper\Client\Credentials;
use JBR\CommandWrapper\Client\Handler\SecureShellHandler;
use JBR\CommandWrapper\Client\Input\ArgumentValue;
use JBR\CommandWrapper\Client\SecureShellClient;
use JBR\CommandWrapper\Client\SecureShellCredentials;
use JBR\CommandWrapper\System\Directory;
use JBR\CommandWrapper\System\ExceptionNotFound;

/**
 *
 */
class SecureShellCommander extends Commander implements SecureShellHandler
{
    /**
     * @var SecureShellClient
     */
    protected $client;

    /**
     * @var Credentials
     */
    protected $credentials;

    /**
     * @var string
     */
    protected $command;

    /**
     * @param string $command
     * @param Directory $workingDirectory
     */
    public function __construct($command, Directory $workingDirectory = null)
    {
        parent::__construct($workingDirectory);
        $this->command = $command;
    }

    /**
     * @param SecureShellCredentials $credentials
     *
     * @return boolean
     */
    public function connect(Credentials $credentials)
    {
        $this->credentials = $credentials;
        $this->client = new SecureShellClient($this->locateFile($this->command));
        $this->client->connect($credentials);
    }

    /**
     * @return boolean
     */
    public function disconnect()
    {
        return $this->client->disconnect();
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        $this->disconnect();
    }

    /**
     * @param string $path
     * @param bool $firstLocation
     *
     * @return string
     * @throws ExceptionNotFound
     */
    protected function locateFile($path, $firstLocation = false)
    {
        $this->client = new SecureShellClient('file');
        $this->client->connect($this->credentials);
        $result = $this->client->execute([ new ArgumentValue($path) ]);
        $this->client->disconnect();

        if ((true === $result->isSuccess()) && (0 < strpos($result->getOutput()[0], 'cannot open'))) {
            $this->client = new SecureShellClient('which');
            $this->client->connect($this->credentials);

            $result = $this->client->execute([ new ArgumentValue($path) ]);
            $this->client->disconnect();

            if (false === $result->isSuccess()) {
                throw new ExceptionNotFound(sprintf('The file `%s` cannot be found.', $path));
            }

            $output = $result->getOutput();
            $path = $output[count($output) - 1];

            if (true === $firstLocation) {
                $path = $output[0];
            }
        }

        return $path;
    }

    /**
     * @param Closure $handler
     *
     * @return void
     */
    public function setInitializeSecureShellHandler(Closure $handler)
    {
        $this->client->setInitializeSecureShellHandler($handler);
    }

    /**
     * @param Closure $handler
     *
     * @return void
     */
    public function setSecureShellOutputHandler(Closure $handler)
    {
        $this->client->setSecureShellOutputHandler($handler);
    }

    /**
     * @return Closure
     */
    public function getInitializeSecureShellHandler()
    {
        return $this->client->getInitializeSecureShellHandler();
    }

    /**
     * @return Closure
     */
    public function getSecureShellOutputHandler()
    {
        return $this->client->getSecureShellOutputHandler();
    }
}