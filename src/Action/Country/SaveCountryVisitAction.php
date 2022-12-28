<?php
declare(strict_types=1);

namespace Mougrim\VisitsService\Action\Country;

use Mougrim\VisitsService\Command\SaveCountryVisitCommand;
use Mougrim\VisitsService\Enum\Country;
use Mougrim\VisitsService\ResponsePreparer\JsonResponsePreparer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class SaveCountryVisitAction
{
    public function __construct(
        private readonly SaveCountryVisitCommand $saveCountryVisitCommand,
        private readonly JsonResponsePreparer $jsonResponsePreparer,
    ) {
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $countryCode = $request->getAttribute('countryCode');
        $country     = Country::tryFrom($countryCode);
        if (!$country) {
            throw new HttpNotFoundException($request, 'Country is not found');
        }

        $this->saveCountryVisitCommand->__invoke($country);

        $responseBody = [
            'code' => 'ok',
        ];

        return $this->jsonResponsePreparer->prepare($response, $responseBody);
    }
}
