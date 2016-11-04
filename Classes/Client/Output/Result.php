<?php namespace JBR\CommandWrapper\Client\Output;

/**
 *
 */
class Result
{
    const EXIT_OKAY = 0;

    /**
     * @var integer
     */
    private $exitCode;

    /**
     * @var array
     */
    private $output;

    /**
     * @var array
     */
    private $errorOutput;

    /**
     * @param integer $exitCode
     * @param array  $output
     * @param array  $errorOutput
     */
    public function __construct($exitCode = self::EXIT_OKAY, array $output = null, array $errorOutput = null)
    {
        $this->exitCode = $exitCode;
        $this->output = $output;
        $this->errorOutput = $errorOutput;
    }

    /**
     * @return bool
     */
    public function isSuccess()
    {
        return ($this->exitCode === self::EXIT_OKAY);
    }

    /**
     * @return integer
     */
    public function getExitCode()
    {
        return $this->exitCode;
    }

    /**
     * @return array
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @return array
     */
    public function getErrorOutput()
    {
        return $this->errorOutput;
    }

    /**
     * @param string $subject
     *
     * @return array
     */
    static public function toArray($subject)
    {
        return array_filter(explode("\n", $subject));
    }
}