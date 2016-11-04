<?php
/**
 * Created by PhpStorm.
 * User: jennes
 * Date: 23.10.2016
 * Time: 21:42
 */

namespace JBR\CommandWrapper\Client\Handler;


interface ProcessHandler
{
    /**
     * @param callable $handler
     */
    public function setInitializeProcessHandler(callable $handler);

    /**
     * @param callable $handler
     */
    public function setProcessOutputHandler(callable $handler);

    /**
     * @return callable
     */
    public function getInitializeProcessHandler();

    /**
     * @return callable
     */
    public function getProcessOutputHandler();
}