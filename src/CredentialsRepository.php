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
    private $salt;

    const IV_LEN = 16;
    const ENC_METHOD = 'aes-256-ctr';

    public function __construct(\MysqliDb $database, string $salt)
    {
        $this->database = $database;
        $this->salt = $salt;
    }

    private function encryptPassword(string $password) : string
    {
        $iv = random_bytes(self::IV_LEN);
        return urlencode($iv.openssl_encrypt($password, self::ENC_METHOD, $this->salt, 0, $iv));
    }

    private function decryptPassword(string $password) : string
    {
        $password = urldecode($password);
        $iv = substr($password, 0, self::IV_LEN);
        return openssl_decrypt(substr($password, self::IV_LEN), self::ENC_METHOD, $this->salt, 0, $iv);
    }

    private function hasRequiredFields(array $data) : void
    {
        $required = ['username', 'password', 'login_url'];
        $diff = array_diff($required, array_keys($data));
        if (!empty($diff)) {
            throw new \InvalidArgumentException('Credential is missing required fields.');
        }
    }

    public function get() : array
    {
        $return = [];
        $credentials = $this->database->get('credentials');
        foreach ($credentials as $credential) {
            $cred = new Credential($credential['username'], $this->decryptPassword($credential['password']), $credential['login_url']);
            $return[$credential['id']] = $cred->toArray();
        }
        return $return;
    }

    public function getById(int $id) : Credential
    {
        $this->database->where('id', $id);
        $credential = $this->database->getOne('credentials');
        return new Credential($credential['username'], $this->decryptPassword($credential['password']), $credential['login_url']);
    }

    public function add(array $data) : void
    {
        $this->hasRequiredFields($data);
        $data['password'] = $this->encryptPassword($data['password']);
        if (!is_int($this->database->insert('credentials', $data))) {
            throw new \Exception('New Credential could not be saved.');
        }
    }
}
