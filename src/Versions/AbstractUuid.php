<?php
/**
 * Author: Nil Portugués Calderó <contact@nilportugues.com>
 * Date: 2/14/15
 * Time: 11:09 AM
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace NilPortugues\Uuid\Versions;

/**
 * Class AbstractUuid
 * @package NilPortugues\Uuid\Versions
 */
abstract class AbstractUuid
{
    const TIME_LOW                  = 'time_low';
    const TIME_MID                  = 'time_mid';
    const TIME_HI_AND_VERSION       = 'time_hi_and_version';
    const CLOCK_SEQ_HI_AND_RESERVED = 'clock_seq_hi_and_reserved';
    const CLOCK_SEQ_LOW             = 'clock_seq_low';
    const NODE                      = 'node';

    /**
     * Returns a version 3 or 5 UUID based on the hash (md5 or sha1) of a
     * namespace identifier (which is a UUID) and a name (which is a string)
     *
     * @param string $hash    The hash to use when creating the UUID
     * @param int    $version The UUID version to be generated
     *
     * @return array
     */
    protected static function uuidFromHashedName($hash, $version)
    {
        // Set the version number
        $timeHi = hexdec(substr($hash, 12, 4)) & 0x0fff;
        $timeHi &= ~(0xf000);
        $timeHi |= $version << 12;

        // Set the variant to RFC 4122
        $clockSeqHi = hexdec(substr($hash, 16, 2)) & 0x3f;
        $clockSeqHi &= ~(0xc0);
        $clockSeqHi |= 0x80;

        return [
            self::TIME_LOW                  => substr($hash, 0, 8),
            self::TIME_MID                  => substr($hash, 8, 4),
            self::TIME_HI_AND_VERSION       => sprintf('%04x', $timeHi),
            self::CLOCK_SEQ_HI_AND_RESERVED => sprintf('%02x', $clockSeqHi),
            self::CLOCK_SEQ_LOW             => substr($hash, 18, 2),
            self::NODE                      => substr($hash, 20, 12),
        ];
    }

    /**
     * Converts this UUID into a string representation
     *
     * @param array $fields
     *
     * @return string
     */
    protected static function toString(array $fields)
    {
        return vsprintf(
            '%08s-%04s-%04s-%02s%02s-%012s',
            $fields
        );
    }
}
