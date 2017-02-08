<?php
namespace CredJumper;

/**
 * The CredentialsRepository Objects and Methods
 *
 * @author     Derek Smart <derek@grindaga.com>
 */
class CredentialsRepository
{
    private $database;

    public function __construct(\MysqliDb $database)
    {
        $this->database = $database;
    }

    public function get() : array
    {
        $return = [];
        $credentials = $this->database->get('credentials');
        foreach ($credentials as $credential) {
            $return[$credential['id']] = new Credential($credential['username'], $credential['password'], $credential['login_url']);
        }
        return $return;
    }

    public function getById(int $id) : Credential
    {
        $this->database->where('id', $id);
        $credential = $this->database->getOne('credentials');
        return new Credential($credential['username'], $credential['password'], $credential['login_url']);
    }
}
