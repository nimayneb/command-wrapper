<?php namespace JBR\CommandWrapper\System;

/**
 *
 */
class File
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
     * @return File
     */
    public static function get($path)
    {
        if (false === is_file($path)) {
            throw new ExceptionNotFound(sprintf('The file `%s` does not exist.', $path));
        }

        return new self($path);
    }

    /**
     * @param string $path
     * @param string $content
     * @param int $permissions
     *
     * @throws ExceptionAlreadyExists
     * @throws ExceptionPermissionDenied
     * @throws ExceptionUnknown
     * @return File
     */
    public static function create($path, $content, $permissions = 0770)
    {
        if (true === is_file($path)) {
            throw new ExceptionAlreadyExists(sprintf('The file `%s` already exists.', $path));
        }

        $result = file_put_contents($path, $content);

        if ((false === $result) || (false === is_file($path))) {
            $contentLength = strlen($content);

            if ((false !== $contentLength) && ($contentLength !== $contentLength)) {
                throw new ExceptionUnknown(error_get_last()['message'], error_get_last()['type']);
            } else {
                throw new ExceptionPermissionDenied(sprintf('The file `%s` could not be written completely.'));
            }
        }

        $result = chmod($path, $permissions);

        if (false === $result) {
            throw new ExceptionPermissionDenied(sprintf('The file `%s` could not be written completely.'));
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