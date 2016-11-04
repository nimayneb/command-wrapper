<?php namespace JBR\CommandWrapper\Client;

use Exception;
use JBR\CommandWrapper\Client\Input\Argument;
use JBR\CommandWrapper\Client\Output\Result;
use JBR\CommandWrapper\System\Directory;
use JBR\CommandWrapper\System\File;

/**
 *
 */
abstract class RemoteClient implements Client
{
    /**
     * @var string
     */
    protected $binary;

    /**
     * @param string $binary
     */
    public function __construct($binary)
    {
        $this->binary = $binary;
    }

    /**
     * @param array $arguments
     *
     * @throws Exception
     * @return string
     */
    protected function buildCommand(array $arguments)
    {
        $commandLine = [];
        foreach ($arguments as $argument /** @var Argument $argument */) {
            if (false === $argument instanceof Argument) {
                throw new Exception(sprintf('Argument has no interface `%s`', Argument::class));
            }

            $commandLine[] = escapeshellarg($argument->getArgument());
        }

        return $this->binary . ' ' . implode(' ', $commandLine);
    }
}