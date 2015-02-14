<?php

namespace NilPortugues\Uuid;

/**
 * Interface UuidInterface
 * @package NilPortugues\Uuid
 */
interface UuidInterface
{
    /**
     * @param  null   $namespace
     * @param  null   $name
     * @return string
     */
    public static function create($namespace = null, $name = null);
}
