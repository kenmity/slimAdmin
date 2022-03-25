<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addErrorMiddleware(true, true, true);

$baseDir = __DIR__ . '/../';
$dotenv = Dotenv\Dotenv::createImmutable($baseDir);
if (file_exists($baseDir . '.env')) {
    $dotenv->load();
}
//$dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT']);
$dotenv->required(['DB_HOST', 'DB_PORT']);
echo $_ENV['DB_HOST'] ;


// Create Twig
$twig = Twig::create(__DIR__.'/../templates', ['cache' => false]);

// Add Twig-View Middleware
$app->add(TwigMiddleware::create($app, $twig));


$app->get('/', function ($request, $response, $args) {
    $view = Twig::fromRequest($request);
    return $view->render($response, 'index.html', [
//        'name' => $args['name']
        'name' => 'asd'
    ]);
})->setName('index');

// Run app
$app->run();

//
//$app->get('/', function (Request $request, Response $response, $args) {
//    $response->getBody()->write("Hello world!");
//    return $response;
//});
//
//$app->run();

//
//$container = new \DI\Container();
//
//AppFactory::setContainer($container);
//$app = AppFactory::create();
//
//$container = $app->getContainer();
//$container->set('view', function(\Psr\Container\ContainerInterface $container){
//    return new \Slim\Views\Twig('');
//});
