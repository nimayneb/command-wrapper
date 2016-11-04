<?php namespace JBR\CommandWrapper\Client;

use Exception;
use JBR\CommandWrapper\Client\Input\Argument;
use JBR\CommandWrapper\System\BinaryFile;

/**
 *
 */
abstract class LocalClient implements Client
{
    /**
     * @var BinaryFile
     */
    protected $binary;

    /**
     * @param BinaryFile $binary
     */
    public function __construct(BinaryFile $binary)
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

        return $this->binary->getPath() . ' ' . implode(' ', $commandLine);
    }
}