<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 2/14/15
 * Time: 11:04 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Uuid\Versions;

use NilPortugues\Uuid\UuidInterface;

/**
 * Class Uuid5
 * @package NilPortugues\Uuid\Versions
 */
class Uuid5 extends AbstractUuid implements UuidInterface
{
    /**
     * The nil UUID is special form of UUID that is specified to have all 128 bits set to zero.
     * @link http://tools.ietf.org/html/rfc4122#section-4.1.7
     */
    const NIL = '00000000-0000-0000-0000-000000000000';

    /**
     * Regular expression pattern for matching a valid UUID of any variant.
     */
    const VALID_PATTERN = '^[0-9A-Fa-f]{8}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{4}-[0-9A-Fa-f]{12}$';

    /**
     * @param string|null $namespace
     * @param string|null $name
     *
     * @return string
     */
    public static function create($namespace = null, $name = null)
    {
        $fields = [
            self::TIME_LOW                  => '00000000',
            self::TIME_MID                  => '0000',
            self::TIME_HI_AND_VERSION       => '0000',
            self::CLOCK_SEQ_HI_AND_RESERVED => '00',
            self::CLOCK_SEQ_LOW             => '00',
            self::NODE                      => '000000000000',
        ];

        if (!($namespace instanceof Uuid5)) {
            $fields = self::fromString($namespace);
        }

        $hash = sha1(self::getBytes($fields) . $name);

        return self::toString(self::uuidFromHashedName($hash, 5));
    }

    /**
     * Creates a UUID from the string standard representation as described
     * in the toString() method.
     *
     * @param string $name A string that specifies a UUID
     *
     * @return array
     * @throws \InvalidArgumentException If the $name isn't a valid UUID
     */
    private static function fromString($name)
    {
        $components = self::calculateComponents($name);

        $nameParsed = implode('-', $components);
        if (!self::isValid($nameParsed)) {
            throw new \InvalidArgumentException('Invalid UUID string: ' . $name);
        }

        return [
            self::TIME_LOW                  => sprintf('%08s', $components[0]),
            self::TIME_MID                  => sprintf('%04s', $components[1]),
            self::TIME_HI_AND_VERSION       => sprintf('%04s', $components[2]),
            self::CLOCK_SEQ_HI_AND_RESERVED => sprintf('%02s', substr($components[3], 0, 2)),
            self::CLOCK_SEQ_LOW             => sprintf('%02s', substr($components[3], 2)),
            self::NODE                      => sprintf('%012s', $components[4]),
        ];
    }

    /**
     * We have stripped out the dashes and are breaking up the string using
     * substr(). In this way, we can accept a full hex value that doesn't
     * contain dashes.
     * @param $name
     *
     * @return array
     */
    private static function calculateComponents($name)
    {
        $nameParsed = str_replace(['urn:', 'uuid:', '{', '}', '-'], '', $name);

        $components = [
            substr($nameParsed, 0, 8),
            substr($nameParsed, 8, 4),
            substr($nameParsed, 12, 4),
            substr($nameParsed, 16, 4),
            substr($nameParsed, 20),
        ];
        return $components;
    }

    /**
     * Check if a string is a valid uuid
     *
     * @param string $uuid The uuid to test
     *
     * @return boolean
     */
    private static function isValid($uuid)
    {
        $uuid = str_replace(['urn:', 'uuid:', '{', '}'], '', $uuid);

        if (0 == preg_match('/' . self::VALID_PATTERN . '/', $uuid)) {
            return false;
        }

        return true;
    }

    /**
     * Returns the UUID as a 16-byte string (containing the six integer fields
     * in big-endian byte order)
     *
     * @param array $fields
     *
     * @return string
     */
    private static function getBytes(array $fields)
    {
        $bytes = '';
        foreach (range(-2, -32, 2) as $step) {
            $bytes = chr(hexdec(substr(self::getHex($fields), $step, 2))) . $bytes;
        }

        return $bytes;
    }

    /**
     * Returns the hexadecimal value of the UUID
     *
     * @param array $fields
     *
     * @return string
     */
    private static function getHex(array $fields)
    {
        return str_replace('-', '', static::toString($fields));
    }
}
