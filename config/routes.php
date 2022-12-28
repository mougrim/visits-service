<?php

declare(strict_types=1);

use Mougrim\VisitsService\Action\Country\GetCountriesVisitsAction;
use Mougrim\VisitsService\Action\Country\SaveCountryVisitAction;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->group('/country', function (Group $group) {
        $group->get('', GetCountriesVisitsAction::class);
        $group->post('/{countryCode}', SaveCountryVisitAction::class);
    });
};
