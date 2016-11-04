<?php namespace JBR\CommandWrapper;

use JBR\CommandWrapper\Client\Handler\ProcessHandler;
use JBR\CommandWrapper\Client\ProcessClient;
use JBR\CommandWrapper\System\BinaryFile;
use JBR\CommandWrapper\System\Directory;
use JBR\CommandWrapper\System\ExceptionNotFound;

/**
 *
 */
class ProcessCommander extends Commander implements ProcessHandler
{
    /**
     * @var ProcessClient
     */
    protected $client;

    /**
     * @param string $command
     * @param Directory $workingDirectory
     */
    public function __construct($command, Directory $workingDirectory = null)
    {
        parent::__construct($workingDirectory);

        $command = BinaryFile::get($this->locateFile($command));
        $this->client = new ProcessClient($command);
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
        if (false === is_file($path)) {
            $command = 'which'; // Linux derivative

            if ('WIN' === strtoupper(substr(PHP_OS, 0, 3))) {
                $command = 'where';
            }

            $result = exec(sprintf('%s %s', $command, $path), $output, $returnValue);

            if (true === empty($result)) {
                throw new ExceptionNotFound(sprintf('The file `%s` cannot be found.', $path));
            }

            $path = $result;

            if (true === $firstLocation) {
                $path = $output[0];
            }
        }

        return $path;
    }

    /**
     * @param callable $handler
     *
     * @return void
     */
    public function setInitializeProcessHandler(callable $handler)
    {
        $this->client->setInitializeProcessHandler($handler);
    }

    /**
     * @param callable $handler
     *
     * @return void
     */
    public function setProcessOutputHandler(callable $handler)
    {
        $this->client->setProcessOutputHandler($handler);
    }

    /**
     * @return callable
     */
    public function getInitializeProcessHandler()
    {
        return $this->client->getInitializeProcessHandler();
    }

    /**
     * @return callable
     */
    public function getProcessOutputHandler()
    {
        return $this->client->getProcessOutputHandler();
    }
}