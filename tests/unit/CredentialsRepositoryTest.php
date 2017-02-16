<?php
namespace CredJumper;

use \Prophecy;

/**
* @covers \CredJumper\CredentialsRepository
*/
class CredentialsRepositoryTest extends \PHPUnit\Framework\TestCase
{
    private $prophet;
    private $salt;

    public function setup()
    {
        $this->prophet = new Prophecy\Prophet;
        $this->salt = 'testSalttestSalt';
        $this->mysql = $this->prophet->prophesize("\MysqliDb");
    }

    public function testCanInstantiate()
    {
        $repository = new CredentialsRepository($this->mysql->reveal(), $this->salt);
        $this->assertInstanceOf(CredentialsRepository::class, $repository);
    }

    public function testCanGetMany()
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
        $this->mysql->get(
            \Prophecy\Argument::type('string')
        )->willReturn($data);

        $repository = new CredentialsRepository($this->mysql->reveal(), $this->salt);
        $credentials = $repository->get();
        $this->assertEquals('TestUsername', $credentials[2]['username']);
    }

    public function testCanGetById()
    {
        $data = [
            'username' => 'TestUsername',
            'password' => 'z%89o%D3%0E%BA5U%EF%86%09%7E%F9f8%14G1ZkLpa8DnkItTI3',
            'login_url' => 'TestLoginUrl'
        ];

        $this->mysql->where(
            \Prophecy\Argument::type('string'),
            \Prophecy\Argument::type('int')
        )->willReturn(true);

        $this->mysql->getOne(
            \Prophecy\Argument::type('string')
        )->willReturn($data);

        $repository = new CredentialsRepository($this->mysql->reveal(), $this->salt);
        $credential = $repository->getById(1);
        $this->assertInstanceOf(Credential::class, $credential);
    }

    public function testCanCreateNew()
    {
        $data = [
            'username' => 'TestUsername',
            'password' => 'TestPassword',
            'login_url' => 'TestLoginUrl'
        ];

        $this->mysql->insert(
            \Prophecy\Argument::type('string'),
            \Prophecy\Argument::type('array')
        )->willReturn(2);

        $repository = new CredentialsRepository($this->mysql->reveal(), $this->salt);
        $repository->add($data);
    }

    public function testMissingRequiredFields()
    {
        $data = [];

        $this->mysql->insert(
            \Prophecy\Argument::type('string'),
            \Prophecy\Argument::type('array')
        )->willReturn(false);

        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage('Credential is missing required fields.');

        $repository = new CredentialsRepository($this->mysql->reveal(), $this->salt);
        $repository->add($data);
    }

    public function testCanNotCreateNew()
    {
        $data = [
            'username' => 'TestUsername',
            'password' => 'TestPassword',
            'login_url' => 'TestLoginUrl'
        ];

        $this->mysql->insert(
            \Prophecy\Argument::type('string'),
            \Prophecy\Argument::type('array')
        )->willReturn(false);

        $this->expectException('\Exception');
        $this->expectExceptionMessage('New Credential could not be saved.');

        $repository = new CredentialsRepository($this->mysql->reveal(), $this->salt);
        $repository->add($data);
    }
}
