<?php namespace JBR\CommandWrapper\Client;

use Exception;
use JBR\CommandWrapper\Client\Handler\ProcessHandler;
use JBR\CommandWrapper\Client\Output\Result;
use JBR\CommandWrapper\System\BinaryFile;
use JBR\CommandWrapper\System\Directory;
use Symfony\Component\Process\Process;

/**
 *
 */
class ProcessClient extends LocalClient implements ProcessHandler
{
    /**
     * @var callable
     */
    protected $initializeProcessHandler;

    /**
     * @var callable
     */
    protected $processOutputHandler;

    /**
     * @param BinaryFile $binary
     * @param callable $initializeProcessHandler
     * @param callable $processOutputHandler
     */
    public function __construct(BinaryFile $binary, callable $initializeProcessHandler = null, callable $processOutputHandler = null)
    {
        parent::__construct($binary);

        $this->initializeProcessHandler = $initializeProcessHandler;
        $this->processOutputHandler = $processOutputHandler;
    }

    /**
     * @param array $arguments
     * @param Directory $workingDirectory
     *
     * @return Process
     */
    protected function prepareProcess(array $arguments, Directory $workingDirectory = null) {
        $process = new Process($this->buildCommand($arguments), $workingDirectory ? $workingDirectory->getPath() : null);

        if (true === is_callable($this->initializeProcessHandler)) {
            /*
             * function (Process $process) {
             *     $process->setTimeout(3600);
             * }
             *
             */
            call_user_func($this->initializeProcessHandler, $process);
        }

        return $process;
    }

    /**
     * @param array $arguments
     * @param Directory $workingDirectory
     *
     * @return Result
     */
    public function execute(array $arguments, Directory $workingDirectory = null)
    {
        $process = $this->prepareProcess($arguments, $workingDirectory);
        $process->run($this->processOutputHandler);

        return new Result(
            $process->getExitCode(),
            Result::toArray($process->getOutput()),
            Result::toArray($process->getErrorOutput())
        );
    }

    /**
     * @param callable $handler
     *
     * @return void
     */
    public function setInitializeProcessHandler(callable $handler)
    {
        $this->initializeProcessHandler = $handler;
    }

    /**
     * @param callable $handler
     *
     * @return void
     */
    public function setProcessOutputHandler(callable $handler)
    {
        $this->processOutputHandler = $handler;
    }

    /**
     * @return callable
     */
    public function getInitializeProcessHandler()
    {
        return $this->initializeProcessHandler;
    }

    /**
     * @return callable
     */
    public function getProcessOutputHandler()
    {
        return $this->processOutputHandler;
    }

    /**
     * @param Credentials $credentials
     *
     * @return boolean
     */
    public function connect(Credentials $credentials)
    {
        throw new Exception('Not supported. You are on a local client.');
    }

    /**
     * @return boolean
     */
    public function disconnect()
    {
        throw new Exception('Not supported. You are on a local client.');
    }
}