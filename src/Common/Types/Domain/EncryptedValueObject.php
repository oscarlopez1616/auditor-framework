<?php
declare(strict_types=1);

namespace TheCodeFighters\Bundle\AuditorFramework\Common\Types\Domain;

use Exception;

abstract class EncryptedValueObject extends ValueObject
{
    /**
     * @var
     */
    private $key;

    /**
     * @var
     */
    private $nonce;

    /**
     * ValueObjectEncrypted constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->key = random_bytes(SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
        $this->nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
    }

    /**
     * @throws Exception
     */
    public function encrypt(): void
    {
        $vars = get_object_vars($this);
        $encryptVars = [];

        foreach ($vars as $var){
            array_push($varsEncrypted,sodium_crypto_secretbox($var, $this->nonce, $this->key));
        }
        $this->setObjectVars($this, $encryptVars);
    }

    public function decrypt(): void
    {
        $vars = get_object_vars($this);
        $deCryptVars = [];

        foreach ($vars as $var){
            array_push($varsEncrypted, sodium_crypto_secretbox_open($var, $this->nonce, $this->key));
        }

        $this->setObjectVars($this, $deCryptVars);
    }

    function setObjectVars(object $object, array $vars)
    {
        $has = get_object_vars($object);
        foreach ($has as $name => $oldValue) {
            $object->$name = isset($vars[$name]) ? $vars[$name] : NULL;
        }
    }
}
