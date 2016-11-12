<?php
/**
 * Created by PhpStorm.
 * User: jennes
 * Date: 23.10.2016
 * Time: 21:42
 */

namespace JBR\CommandWrapper\Client\Handler;


use Closure;

interface ProcessHandler
{
    /**
     * @param Closure $handler
     */
    public function setInitializeProcessHandler(Closure $handler);

    /**
     * @param Closure $handler
     */
    public function setProcessOutputHandler(Closure $handler);

    /**
     * @return Closure
     */
    public function getInitializeProcessHandler();

    /**
     * @return Closure
     */
    public function getProcessOutputHandler();
}