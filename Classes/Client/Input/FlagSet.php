<?php namespace JBR\CommandWrapper\Client\Input;

/**
 *
 */
class FlagSet extends ArgumentValue
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @var boolean
     */
    protected $equalSeparator;

    /**
     * @param string $argument
     * @param string $value
     * @param bool $equalSeparator
     */
    public function __construct($argument, $value, $equalSeparator = false)
    {
        parent::__construct($argument);

        $this->value = $value;
        $this->equalSeparator = $equalSeparator;
    }

    /**
     * @return string
     */
    public function getArgument()
    {
        return sprintf('-%s%s%s', $this->argument, (true === $this->equalSeparator)?'=':' ', $this->value);
    }
}