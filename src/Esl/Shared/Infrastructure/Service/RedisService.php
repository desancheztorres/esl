<?php

declare(strict_types=1);

namespace Arcmedia\Esl\Shared\Infrastructure\Service;

use Predis\Client;

final class RedisService
{
    private Client $redis;

    public function __construct(
        private readonly string $redisHost,
        private readonly int $redisPort,
    ) {
        $this->init();
    }

    public function redis(): Client
    {
        return $this->redis;
    }

    private function init()
    {
        $this->redis = new Client([
            'scheme' => 'tcp',
            'host' => $this->redisHost,
            'port' => $this->redisPort
        ]);
    }
}
