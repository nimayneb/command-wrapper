<?php namespace JBR\CommandWrapper\Client\Input;

/**
 *
 */
class ShorthandFlag extends Flag
{
    /**
     * @return string
     */
    public function getArgument()
    {
        return sprintf('-%s', $this->argument);
    }
}