<?php namespace JBR\CommandWrapper\Client\Input;

/**
 *
 */
class ShorthandFlagSet extends FlagSet
{
    /**
     * @return string
     */
    public function getArgument()
    {
        return sprintf('-%s%s%s', $this->argument, (true === $this->equalSeparator)?'=':' ', $this->value);
    }
}