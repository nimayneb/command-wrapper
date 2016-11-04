<?php namespace JBR\CommandWrapper\System;

/**
 *
 */
class Directory
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    protected function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param string $path
     *
     * @throws ExceptionNotFound
     * @return Directory
     */
    public static function get($path)
    {
        if (false === is_file($path)) {
            throw new ExceptionNotFound(sprintf('The directory `%s` does not exist.', $path));
        }

        return new self($path);
    }

    /**
     * @param string $path
     * @param int $permissions
     *
     * @throws ExceptionAlreadyExists
     * @throws ExceptionPermissionDenied
     * @return Directory
     */
    public static function create($path, $permissions = 0770)
    {
        if (true === is_dir($path)) {
            throw new ExceptionAlreadyExists(sprintf('The directory `%s` already exists.', $path));
        }

        $result = mkdir($path, $permissions, true);

        if ((false === $result) || (false === is_dir($path))) {
            throw new ExceptionPermissionDenied(error_get_last()['message'], error_get_last()['type']);
        }

        return new self($path);
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}