<?php namespace JBR\CommandWrapper\Client;

/************************************************************************************
 * Copyright (c) 2016, Jan Runte
 * All rights reserved.
 *
 * Redistributionv and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions  of source code must retain the above copyright notice,  this
 * list of conditions and the following disclaimer.
 *
 * 2. Redistributions  in  binary  form  must  reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation and/or
 * other materials provided with the distribution.
 *
 * THIS  SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY  EXPRESS OR IMPLIED WARRANTIES,  INCLUDING, BUT NOT LIMITED TO, THE  IMPLIED
 * WARRANTIES  OF  MERCHANTABILITY  AND   FITNESS  FOR  A  PARTICULAR  PURPOSE  ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY  DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL  DAMAGES
 * (INCLUDING,  BUT  NOT LIMITED TO,  PROCUREMENT OF SUBSTITUTE GOODS  OR  SERVICES;
 * LOSS  OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND  ON
 * ANY  THEORY  OF  LIABILITY,  WHETHER  IN  CONTRACT,  STRICT  LIABILITY,  OR TORT
 * (INCLUDING  NEGLIGENCE OR OTHERWISE)  ARISING IN ANY WAY OUT OF THE USE OF  THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 ************************************************************************************/

use JBR\CommandWrapper\System\File;
use phpseclib\Crypt\RSA;
use phpseclib\Net\SSH2;

/**
 *
 */
class SecureShellCredentials implements Credentials
{
    const PORT_SECURE_SHELL = 22;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var File
     */
    protected $publicKey = null;

    /**
     * @var File
     */
    protected $privateKey = null;

    /**
     *
     */
    public function __construct($host, $port = self::PORT_SECURE_SHELL)
    {
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @param SSH2 $client
     *
     * @return boolean
     */
    public function connect($client)
    {
        $client->port = $this->port;
        $client->host = $this->host;

        if (false === $client->login($this->username, $this->providePassword())) {
            throw new ExceptionNotConnected(
                sprintf('Cannot authenticating to `%s` with username `%s`', $this->host, $this->username)
            );
        }

        return true;
    }

    /**
     * @return string|RSA
     */
    protected function providePassword()
    {
        $password = $this->password;

        if (false === empty($this->privateKey)) {
            $rsa = new RSA();
            $rsa->setPassword($this->password);
            $rsa->loadKey($this->loadKeyFile($this->privateKey));

            $password = $rsa;
        }

        return $password;
    }

    /**
     * @param File $file
     *
     * @return string
     */
    protected function loadKeyFile(File $file)
    {
        return file_get_contents($file->getPath());
    }

    /**
     * @return File
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param File $privateKey
     *
     * @return void
     */
    public function setPrivateKey(File $privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @return File
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param File $publicKey
     *
     * @return void
     */
    public function setPublicKey(File $publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }
}