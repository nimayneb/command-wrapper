<?php
/**
 * Created by PhpStorm.
 * User: jennes
 * Date: 23.10.2016
 * Time: 21:42
 */

namespace JBR\CommandWrapper\Client\Handler;


interface SecureShellHandler
{
    /**
     * @param callable $handler
     */
    public function setInitializeSecureShellHandler(callable $handler);

    /**
     * @param callable $handler
     */
    public function setSecureShellOutputHandler(callable $handler);

    /**
     * @return callable
     */
    public function getInitializeSecureShellHandler();

    /**
     * @return callable
     */
    public function getSecureShellOutputHandler();
}