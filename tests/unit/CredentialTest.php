<?php
namespace CredJumper;

/**
* @covers \CredJumper\Credential
*/
class CredentialTest extends \PHPUnit\Framework\TestCase
{
    public function testHasUsername()
    {
        $credential = new Credential('username', 'password', 'https://someurl.com');
        $this->assertEquals('username', $credential->getUsername());
    }

    public function testHasPassword()
    {
        $credential = new Credential('username', 'password', 'https://someurl.com');
        $this->assertEquals('password', $credential->getPassword());
    }

    public function testHasLoginUrl()
    {
        $credential = new Credential('username', 'password', 'https://someurl.com');
        $this->assertEquals('https://someurl.com', $credential->getLoginUrl());
    }

    public function testToArray()
    {
        $credential = new Credential('username', 'password', 'https://someurl.com');
        $credentialArray = $credential->toArray();
        $this->assertEquals('username', $credentialArray['username']);
    }
}
