<?php
declare(strict_types=1);

namespace Mougrim\VisitsService\Redis;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
enum RedisKey: string
{
    case CountriesVisits = 'countries:visits';
}
