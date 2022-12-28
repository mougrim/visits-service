<?php
declare(strict_types=1);

namespace Mougrim\VisitsService\Command;

use Mougrim\VisitsService\Enum\Country;
use Mougrim\VisitsService\Redis\RedisKey;
use Predis\Client as RedisClient;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class SaveCountryVisitCommand
{
    public function __construct(
        private readonly RedisClient $redisClient,
    ) {
    }

    public function __invoke(Country $country): void
    {
        $this->redisClient->hincrby(RedisKey::CountriesVisits->value, $country->value, 1);
    }
}
