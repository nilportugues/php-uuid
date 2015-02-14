<?php

namespace NilPortugues\Uuid;

/**
 * Class Uuid
 * @package NilPortugues\Uuid
 */
class Uuid implements UuidInterface
{
    /**
     * When this namespace is specified, the name string is a fully-qualified domain name.
     * @link http://tools.ietf.org/html/rfc4122#appendix-C
     */
    const NAMESPACE_DNS = '6ba7b810-9dad-11d1-80b4-00c04fd430c8';

    /**
     * When this namespace is specified, the name string is a URL.
     * @link http://tools.ietf.org/html/rfc4122#appendix-C
     */
    const NAMESPACE_URL = '6ba7b811-9dad-11d1-80b4-00c04fd430c8';

    /**
     * When this namespace is specified, the name string is an ISO OID.
     * @link http://tools.ietf.org/html/rfc4122#appendix-C
     */
    const NAMESPACE_OID = '6ba7b812-9dad-11d1-80b4-00c04fd430c8';

    /**
     * When this namespace is specified, the name string is an X.500 DN in DER or a text output format.
     * @link http://tools.ietf.org/html/rfc4122#appendix-C
     */
    const NAMESPACE_X500 = '6ba7b814-9dad-11d1-80b4-00c04fd430c8';

    const UUID4 = 'uuid4';
    const UUID5 = 'uuid5';

    /**
     * @var string
     */
    private static $namespaceLess = self::UUID4;

    /**
     * @var string
     */
    private static $usesNamespace = self::UUID5;

    /**
     * @var array
     */
    private static $uuidMap = [
        self::UUID4 => '\NilPortugues\Uuid\Versions\Uuid4::create',
        self::UUID5 => '\NilPortugues\Uuid\Versions\Uuid5::create',
    ];

    /**
     * Returns an Uuid identifier.
     *
     * @param string|null $namespace
     * @param string|null $name
     *
     * @return string
     */
    public static function create($namespace = null, $name = null)
    {
        if (null === $namespace) {
            return self::createNamespacelessUuid();
        }

        return self::createNamespacedUuid($namespace, $name);
    }

    /**
     * Returns an Uuid1, Uuid3 or Uuid5 identifier.
     *
     * @return string
     */
    private static function createNamespacelessUuid()
    {
        return self::generate(self::$namespaceLess, []);
    }

    /**
     * Call a Uuid generator and returns an Uuid identifier.
     *
     * @param string $uuidKey
     * @param array  $arguments
     *
     * @return string
     */
    private static function generate($uuidKey, array $arguments)
    {
        $classAndMethod = explode('::', self::$uuidMap[$uuidKey]);

        return call_user_func_array($classAndMethod, $arguments);
    }

    /**
     * Returns an Uuid identifier using namespaces.
     *
     * @param $namespace
     * @param $name
     *
     * @return string
     */
    private static function createNamespacedUuid($namespace, $name)
    {
        return self::generate(self::$usesNamespace, [$namespace, $name]);
    }
}
