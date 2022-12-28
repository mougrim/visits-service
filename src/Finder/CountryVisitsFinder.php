<?php
declare(strict_types=1);

namespace Mougrim\VisitsService\Finder;

use Mougrim\VisitsService\Redis\RedisKey;
use Predis\Client as RedisClient;
use function array_map;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class CountryVisitsFinder
{
    public function __construct(
        private readonly RedisClient $redisClient,
    ) {
    }

    public function findAll(): array
    {
        $result = $this->redisClient->hgetall(RedisKey::CountriesVisits->value);

        return array_map(static fn(string $visits) => (int) $visits, $result);
    }
}
