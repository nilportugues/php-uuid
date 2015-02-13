<?php

namespace Tests\NilPortugues\Uuid;

use NilPortugues\Uuid\Uuid;
/**
 * Class UuidTest
 * @package Tests\NilPortugues\Uuid\Uuid
 */
class UuidTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itShouldReturnAUuidWithoutUsingNamespace()
    {
        $this->assertNotEmpty(Uuid::create());
    }

    /**
     * @test
     */
    public function itShouldReturnUuidWithNamespace()
    {
        $this->assertNotEmpty(Uuid::create(Uuid::NAMESPACE_DNS, 'nilportugues.com'));
    }
}
