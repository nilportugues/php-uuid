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
        $this->assertInternalType('string', Uuid::create());
    }

    /**
     * @test
     */
    public function itShouldReturnUuidWithNamespace()
    {
        $this->assertEquals(
            'c7b797bc-792d-5202-b0df-544f5dbd8ffc',
            Uuid::create(Uuid::NAMESPACE_DNS, 'nilportugues.com')
        );
    }

    /**
     * @test
     */
    public function itShouldThrowInvalidArgumentExceptionWhenNamespaceIsInvalid()
    {
        $this->setExpectedException('\InvalidArgumentException');
        Uuid::create('aaa', 'nilportugues.com');
    }
}
