<?php
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

namespace JBR\CommandWrapper\Client;

use JBR\CommandWrapper\System\File;

interface Credentials
{
    /**
     * @param mixed $client
     *
     * @return boolean
     */
    public function connect($client);

    /**
     * @return File
     */
    public function getPrivateKey();

    /**
     * @param File $privateKey
     *
     * @return void
     */
    public function setPrivateKey(File $privateKey);

    /**
     * @return File
     */
    public function getPublicKey();

    /**
     * @param File $publicKey
     *
     * @return void
     */
    public function setPublicKey(File $publicKey);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $password
     *
     * @return void
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $username
     *
     * @return void
     */
    public function setUsername($username);

    /**
     * @return integer
     */
    public function getPort();

    /**
     * @return string
     */
    public function getHost();
}