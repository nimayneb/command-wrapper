Command Wrapper
===============

Tiny Framework to build a command wrapper with process support from Symfony.

```php
use JBR\CommandWrapper\Cli\ArgumentValue;
use JBR\CommandWrapper\Cli\FlagSet;
use JBR\CommandWrapper\Commander;

$git = new Commander('git');
$result = $git->run([ new ArgumentValue('checkout'), new FlagSet('orphan', 'develop') ]);

if ($result->isSuccess()) {
    echo $result->getOutput();
} else {
    echo $result->getErrorOutput();
}
```
