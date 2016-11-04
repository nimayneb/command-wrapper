<?php namespace JBR\CommandWrapper\System;

/**
 *
 */
class BinaryFile extends File
{
    /**
     * @param string $path
     *
     * @throws ExceptionNotFound
     * @throws ExceptionPermissionDenied
     * @return BinaryFile
     */
    public static function get($path)
    {
        if (false === is_file($path)) {
            throw new ExceptionNotFound(sprintf('The file `%s` does not exist.', $path));
        }

        if (false === is_executable($path)) {
            throw new ExceptionPermissionDenied(sprintf('The file `%s` is not executable.', $path));
        }

        return new self($path);
    }

    /**
     * @param string $path
     * @param string $content
     *
     * @throws ExceptionAlreadyExists
     * @throws ExceptionPermissionDenied
     * @return File
     */
    public static function create($path, $content)
    {
        if (true === is_file($path)) {
            throw new ExceptionAlreadyExists(sprintf('The file `%s` already exists.', $path));
        }

        if (false === is_executable($path)) {
            throw new ExceptionPermissionDenied(sprintf('The file `%s` is not executable.', $path));
        }

        return parent::create($path, $content);
    }
}