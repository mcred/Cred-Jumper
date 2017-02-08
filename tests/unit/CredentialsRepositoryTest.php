<?php
namespace CredJumper;

use \Prophecy;

/**
* @covers \CredJumper\CredentialsRepository
*/
class CredentialsRepositoryTest extends \PHPUnit\Framework\TestCase
{
    public function setup()
    {
        $this->prophet = new Prophecy\Prophet;
        $this->mysql = $this->prophet->prophesize("\MysqliDb");
    }

    public function testCanInstantiate()
    {
        $repository = new CredentialsRepository($this->mysql->reveal());
        $this->assertInstanceOf(CredentialsRepository::class, $repository);
    }

    public function testCanGetMany()
    {
        $data = [
            [
                'id' => 1,
                'username' => 'TestUsername',
                'password' => 'TestPassword',
                'login_url' => 'TestLoginUrl'
            ],
            [
                'id' => 2,
                'username' => 'TestUsername',
                'password' => 'TestPassword',
                'login_url' => 'TestLoginUrl'
            ]
        ];
        $this->mysql->get(
            \Prophecy\Argument::type('string')
        )->willReturn($data);

        $repository = new CredentialsRepository($this->mysql->reveal());
        $credentials = $repository->get();
        $this->assertInstanceOf(Credential::class, $credentials[2]);
    }

    public function testCanGetById()
    {
        $data = [
            'username' => 'TestUsername',
            'password' => 'TestPassword',
            'login_url' => 'TestLoginUrl'
        ];

        $this->mysql->where(
            \Prophecy\Argument::type('string'),
            \Prophecy\Argument::type('int')
        )->willReturn(true);

        $this->mysql->getOne(
            \Prophecy\Argument::type('string')
        )->willReturn($data);

        $repository = new CredentialsRepository($this->mysql->reveal());
        $credential = $repository->getById(1);
        $this->assertInstanceOf(Credential::class, $credential);
    }
}