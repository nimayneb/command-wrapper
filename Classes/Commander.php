<?php namespace JBR\CommandWrapper;

use JBR\CommandWrapper\Client\Client;
use JBR\CommandWrapper\Client\Output\Result;
use JBR\CommandWrapper\System\Directory;

/**
 *
 */
abstract class Commander
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Directory
     */
    protected $workingDirectory;

    /**
     * @param Directory $workingDirectory
     */
    public function __construct(Directory $workingDirectory = null)
    {
        $this->workingDirectory = $workingDirectory;
    }

    /**
     * @param array $arguments
     *
     * @return Result
     */
    public function execute(array $arguments)
    {
        return $this->client->execute($arguments, $this->workingDirectory);
    }

    /**
     * @param string $path
     * @param bool $firstLocation
     *
     * @return string
     */
    abstract protected function locateFile($path, $firstLocation = false);
}