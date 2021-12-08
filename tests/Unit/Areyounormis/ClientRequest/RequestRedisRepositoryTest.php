<?php

declare(strict_types=1);

namespace Tests\Unit\Areyounormis\ClientRequest;

use Areyounormis\ClientRequest\RequestRedisRepository;
use PHPUnit\Framework\TestCase;
use Tests\Unit\Areyounormis\Mocks\ConfigMock;
use Tests\Unit\Areyounormis\Mocks\RedisClientMock;

class RequestRedisRepositoryTest extends TestCase
{
    protected RequestRedisRepository $classUnderTest;

    public function setUp(): void
    {
        parent::setUp();

        $this->classUnderTest = new RequestRedisRepository(new RedisClientMock(), new ConfigMock());
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group request_redis_repository
     */
    public function testSaveGetHeaders(): void
    {
        $headers = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];
        $this->classUnderTest->saveHeaders($headers);

        $result = $this->classUnderTest->getHeaders();

        self::assertEquals($headers, $result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group request_redis_repository
     */
    public function testSaveGetEmptyHeaders(): void
    {
        $this->classUnderTest->saveHeaders([]);

        $result = $this->classUnderTest->getHeaders();

        self::assertEmpty($result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group request_redis_repository
     */
    public function testGetUnExistentHeaders(): void
    {
        $result = $this->classUnderTest->getHeaders();

        self::assertEmpty($result);
    }

    /**
     * @group unit
     * @group areyounormis
     * @group client_request
     * @group request_redis_repository
     */
    public function testGetDeletedHeaders(): void
    {
        $this->classUnderTest->saveHeaders(['key' => 'value']);
        $this->classUnderTest->deleteHeaders();

        $result = $this->classUnderTest->getHeaders();

        self::assertEmpty($result);
    }
}
