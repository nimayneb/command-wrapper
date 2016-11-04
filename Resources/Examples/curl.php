<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use JBR\CommandWrapper\Client\Credentials;
use JBR\CommandWrapper\Client\Input\ArgumentValue;
use JBR\CommandWrapper\Client\SecureShellCredentials;
use JBR\CommandWrapper\Commander;
use JBR\CommandWrapper\SecureShellCommander;

class Curl
{

    /**
     * @var Commander
     */
    protected $commander;

    /**
     * Curl constructor.
     *
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->commander = new SecureShellCommander('curl');
        $this->commander->connect($credentials);
    }

    /**
     * @param string $search
     * @param string $searchDomain
     *
     * @return string
     */
    public function getSearchResultFrom($search, $searchDomain)
    {
        $search = sprintf('https://%s/?q=%s', $searchDomain, urlencode($search));
        $result = $this->commander->execute([ new ArgumentValue($search) ]);

        $output = null;
        if (true === $result->isSuccess()) {
            $output = implode("\n", $result->getOutput());
        }

        return $output;
    }
}

$credentials = new SecureShellCredentials('localhost');
$credentials->setUsername('');
$credentials->setPassword('');

$curl = new Curl($credentials);
$result = $curl->getSearchResultFrom('haircut', 'duckduckgo.com');
echo $result;