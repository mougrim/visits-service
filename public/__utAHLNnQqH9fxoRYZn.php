<?php
declare(strict_types=1);

namespace Mougrim\VisitsService\public;

/**
 * @author Mougrim <rinat@mougrim.ru>
 */

use DI\ContainerBuilder;
use Mougrim\VisitsService\Handlers\HttpErrorHandler;
use Mougrim\VisitsService\Handlers\ShutdownHandler;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\ResponseEmitter;
use function register_shutdown_function;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up dependencies
$dependencies = require __DIR__ . '/../config/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app              = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Register routes
$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request              = $serverRequestCreator->createServerRequestFromGlobals();

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler    = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, false);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware = $app->addErrorMiddleware(false, true, true);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

// Run App & Emit Response
$response        = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
