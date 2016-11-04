<?php namespace JBR\CommandWrapper\Client\Input;

/**
 *
 */
class Flag extends ArgumentValue
{
    /**
     * @return string
     */
    public function getArgument()
    {
        return sprintf('--%s', $this->argument);
    }
}