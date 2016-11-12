<?php
/**
 * Created by PhpStorm.
 * User: jennes
 * Date: 23.10.2016
 * Time: 21:42
 */

namespace JBR\CommandWrapper\Client\Handler;


use Closure;

interface SecureShellHandler
{
    /**
     * @param Closure $handler
     */
    public function setInitializeSecureShellHandler(Closure $handler);

    /**
     * @param Closure $handler
     */
    public function setSecureShellOutputHandler(Closure $handler);

    /**
     * @return Closure
     */
    public function getInitializeSecureShellHandler();

    /**
     * @return Closure
     */
    public function getSecureShellOutputHandler();
}