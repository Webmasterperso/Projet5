<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controllers\Control as controleur;

require __DIR__ . '/../vendor/autoload.php';

$uri = $_SERVER["REQUEST_URI"];
$uri = substr($uri, 1);
echo $uri;


echo '<a href="/Mes oeuvres">Mes oeuvres</a></li>';

$loader = new \Twig\Loader\FilesystemLoader('../src/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => '../var/cache',
    'debug' => true,
    "autoescape" => false,
]);
$twig->addFilter(new \Twig\TwigFilter('html_entity_decode', 'html_entity_decode'));
$twig->addExtension(new \Twig\Extension\DebugExtension);


    $app = AppFactory::create();
    $app->get('/{nompage}', function (Request $request, Response $response, $args) {
        $ctrl = new controleur($args["nompage"]);
        $response->getBody()->write($ctrl->afficheoeuvres());
        return $response;
    });

    $app->run();

