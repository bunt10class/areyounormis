<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\ClientRequest;

use Areyounormis\ClientRequest\RequestRedisRepository;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Mocks\RedisClientMock;

class RequestRedisRepositoryTest extends TestCase
{
    protected RequestRedisRepository $classUnderTest;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new RequestRedisRepository(new RedisClientMock());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group request_redis_repository
     */
    public function testSaveGetHeaders(): void
    {
        $headers = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $this->classUnderTest->saveHeaders($headers);

        self::assertEquals($headers, $this->classUnderTest->getHeaders());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group request_redis_repository
     */
    public function testSaveGetEmptyHeaders(): void
    {
        $this->classUnderTest->saveHeaders([]);

        self::assertEmpty($this->classUnderTest->getHeaders());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group request_redis_repository
     */
    public function testGetUnExistentHeaders(): void
    {
        $result = $this->classUnderTest->getHeaders();

        self::assertNull($result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group request_redis_repository
     */
    public function testGetDeletedHeaders(): void
    {
        $this->classUnderTest->saveHeaders(['key' => 'value']);
        $this->classUnderTest->deleteHeaders();

        self::assertNull($this->classUnderTest->getHeaders());
    }
}
