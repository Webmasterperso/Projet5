<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controllers\Control as controleur;
//use App\Models\Modeloeuvres as modeloeuvres;

require __DIR__ . '/../projet5masson/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('../src/templates');
$twig = new \Twig\Environment($loader, [
	'cache' => '../var/cache',
]);


    //echo $twig->render('templateinit.twig', array(
     //   'moteur_name' => 'Twig'
    //));


$app = AppFactory::create();

/*$app->get('/', function (Request $request, Response $response, $args) {
	$response->getBody()->write("Hello the world!");
	return $response;
});

$app->get('/test/{machin}', function (Request $request, Response $response, $args) {
	$ctrl = new test($args["machin"]);
	$response->getBody()->write($ctrl->affiche());
	return $response;
});
*/
$app->get('/{nompage}', function (Request $request, Response $response, $args) {
	$ctrl = new controleur($args["nompage"]);
	$response->getBody()->write($ctrl->affiche());
	return $response;
});

$app->run();


?>