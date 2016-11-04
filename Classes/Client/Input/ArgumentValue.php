<?php namespace JBR\CommandWrapper\Client\Input;

/**
 *
 */
class ArgumentValue implements Argument
{
    /**
     * @var string
     */
    protected $argument;

    /**
     * @param string $argument
     */
    public function __construct($argument)
    {
        $this->argument = $argument;
    }

    /**
     * @return string
     */
    public function getArgument()
    {
        return $this->argument;
    }
}