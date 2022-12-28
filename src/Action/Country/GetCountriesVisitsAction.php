<?php
declare(strict_types=1);

namespace Mougrim\VisitsService\Action\Country;

use Mougrim\VisitsService\Finder\CountryVisitsFinder;
use Mougrim\VisitsService\ResponsePreparer\JsonResponsePreparer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class GetCountriesVisitsAction
{
    public function __construct(
        private readonly CountryVisitsFinder $countryVisitsFinder,
        private readonly JsonResponsePreparer $jsonResponsePreparer,
    ) {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $responseBody = $this->countryVisitsFinder->findAll();

        return $this->jsonResponsePreparer->prepare($response, $responseBody);
    }
}
