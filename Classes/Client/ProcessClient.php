<?php namespace JBR\CommandWrapper\Client;

use Closure;
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
     * @var Closure
     */
    protected $initializeProcessHandler;

    /**
     * @var Closure
     */
    protected $processOutputHandler;

    /**
     * @param BinaryFile $binary
     * @param Closure $initializeProcessHandler
     * @param Closure $processOutputHandler
     */
    public function __construct(BinaryFile $binary, Closure $initializeProcessHandler = null, Closure $processOutputHandler = null)
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

        if (true === $this->initializeProcessHandler instanceof Closure) {
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
     * @param Closure $handler
     *
     * @return void
     */
    public function setInitializeProcessHandler(Closure $handler)
    {
        $this->initializeProcessHandler = $handler;
    }

    /**
     * @param Closure $handler
     *
     * @return void
     */
    public function setProcessOutputHandler(Closure $handler)
    {
        $this->processOutputHandler = $handler;
    }

    /**
     * @return Closure
     */
    public function getInitializeProcessHandler()
    {
        return $this->initializeProcessHandler;
    }

    /**
     * @return Closure
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