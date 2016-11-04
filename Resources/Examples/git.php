<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use JBR\CommandWrapper\Client\Input\ArgumentValue;
use JBR\CommandWrapper\Client\Input\FlagSet;
use JBR\CommandWrapper\ProcessCommander;

$git = new ProcessCommander('git');
$result = $git->execute([ new ArgumentValue('checkout'), new FlagSet('orphan', 'develop') ]);

if ($result->isSuccess()) {
    echo implode("\n", $result->getOutput());
} else {
    echo implode("\n", $result->getErrorOutput());
}