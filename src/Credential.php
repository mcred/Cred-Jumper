<?php
namespace CredJumper;

/**
 * The Credential Objects and Methods
 *
 * @author     Derek Smart <derek@grindaga.com>
 */
class Credential
{
    private $username;
    private $password;
    private $login_url;

    public function __construct(string $username, string $password, string $login_url)
    {
        $this->username = $username;
        $this->password = $password;
        $this->login_url = $login_url;
    }

    public function getUsername() : string
    {
        return $this->username;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function getLoginUrl() : string
    {
        return $this->login_url;
    }
}
