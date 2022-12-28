<?php
declare(strict_types=1);

namespace Mougrim\VisitsService\ResponsePreparer;

use Psr\Http\Message\ResponseInterface as Response;
use function json_encode;
use const JSON_THROW_ON_ERROR;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */
class JsonResponsePreparer
{
    public function prepare(Response $response, array $responseBody): Response
    {
        $response
            ->getBody()
            ->write(json_encode($responseBody, JSON_THROW_ON_ERROR));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
