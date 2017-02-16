<?php
namespace CredJumper;

/**
 * The Api Objects and Methods
 *
 * @author     Derek Smart <derek@grindaga.com>
 */
class Api
{
    private $database;
    private $request;
    private $salt;

    public function __construct(
        \MysqliDb $database,
        \Zend\Diactoros\ServerRequest $request,
        string $salt
    ) {
        $this->database = $database;
        $this->request = $request;
        $this->salt = $salt;
    }

    public function credentialGet()
    {
        $repo = new CredentialsRepository($this->database, $this->salt);
        return $repo->get();
    }

    public function credentialAdd()
    {
        $repo = new CredentialsRepository($this->database, $this->salt);
        return $repo->add($this->request->getParsedBody());
    }
}
