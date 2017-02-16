<?php
namespace CredJumper;

use \Prophecy;

/**
* @covers \CredJumper\Api
* @covers \CredJumper\CredentialsRepository
*/
class ApiTest extends \PHPUnit\Framework\TestCase
{
    private $database;
    private $request;
    private $salt;
    private $api;

    public function setup()
    {
        $this->prophet = new Prophecy\Prophet;
        $this->database = $this->prophet->prophesize("\MysqliDb");
        $this->request = $this->prophet->prophesize("\Zend\Diactoros\ServerRequest");
        $this->salt = 'teststring';
    }

    public function testCanGetCredentialAdd()
    {
        $data = [
            'username' => 'TestUsername',
            'password' => 'TestPassword',
            'login_url' => 'TestLoginUrl'
        ];

        $this->database->insert(
            \Prophecy\Argument::type('string'),
            \Prophecy\Argument::type('array')
        )->willReturn(2);

        $this->request->getParsedBody(
        )->willReturn($data);

        $this->api = new Api($this->database->reveal(), $this->request->reveal(), $this->salt);
        $this->api->credentialAdd();
    }

    public function testCanGetManyCredentials()
    {
        $data = [
            [
                'id' => 1,
                'username' => 'TestUsername',
                'password' => ':V?Y?4?h,?gϔpSSvcpdv3288iX9xn',
                'login_url' => 'TestLoginUrl'
            ],
            [
                'id' => 2,
                'username' => 'TestUsername',
                'password' => ':V?Y?4?h,?gϔpSSvcpdv3288iX9xn',
                'login_url' => 'TestLoginUrl'
            ]
        ];

        $this->database->get(
            \Prophecy\Argument::type('string')
        )->willReturn($data);

        $this->api = new Api($this->database->reveal(), $this->request->reveal(), $this->salt);
        $credentials = $this->api->credentialGet();
        $this->assertEquals('TestUsername', $credentials[2]['username']);
    }
}
