<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 2/14/15
 * Time: 11:05 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Uuid\Versions;

use NilPortugues\Uuid\UuidInterface;

/**
 * Class Uuid4
 * @package NilPortugues\Uuid\Versions
 */
class Uuid4 extends AbstractUuid implements UuidInterface
{
    /**
     * @param string|null $namespace
     * @param string|null $name
     *
     * @return string
     */
    public static function create($namespace = null, $name = null)
    {
        $bytes = self::generateBytes(16);
        $hex   = bin2hex($bytes);

        return self::toString(self::uuidFromHashedName($hex, 4));
    }

    /**
     * Generates random bytes for use in version 4 UUIDs
     *
     * @param int $length
     *
     * @return string
     */
    private static function generateBytes($length)
    {
        $bytes = '';
        for ($i = 1; $i <= $length; $i++) {
            $bytes = chr(mt_rand(0, 255)) . $bytes;
        }

        return $bytes;
    }
}
