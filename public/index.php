<?php
session_start();

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controllers\Control as controleur;

require __DIR__ . '/../vendor/autoload.php';

$uri = $_SERVER["REQUEST_URI"];
$uri = substr($uri,1);
//echo 'uri : '.$uri.'</br>';


//echo'<a href="/Mes oeuvres">Mes oeuvres</a></li>';




$app = AppFactory::create();

//$app->get('/users/{action}', function (Request $request, Response $response, $args) {
	//return renderPage(new controleur($args), $response);
//});

$app->get('/[{nomPage}]', function (Request $request, Response $response, $args) {
	return renderPage(new controleur($args), $response);
});
$app->get('/{nomPage}/{categorieid}[/{idOeuvre}]', function (Request $request, Response $response, $args) {
	return renderPage(new controleur($args), $response);
});



$app->post('/[{nomPage}]', function (Request $request, Response $response, $args) {
	//die(var_dump($args));
	$dataform = (array)$request->getParsedBody();
	//die(var_dump($dataform));
	//$response->getBody()->write('Create user');
	return renderPage(new controleur($args, $dataform), $response);
});


/*
$app->post('/connect', function (Request $request, Response $response, $args) {
	//die(var_dump($args));
	$datauser = (array)$request->getParsedBody();
	die(var_dump($datauser));
	//$response->getBody()->write('Create user');
	return renderPage(new controleur($args, $datauser), $response);
});
*/


$app->run();

function renderPage($ctrl,Response $response ){
	
	global $app;
	$loader = new \Twig\Loader\FilesystemLoader('../src/templates');
	$twig = new \Twig\Environment($loader, [
		'cache' => '../var/cache',
		'debug' => true,
		"autoescape" => false,
	]);
	$twig->addFilter(new \Twig\TwigFilter('html_entity_decode', 'html_entity_decode'));
	$twig->addExtension(new \Twig\Extension\DebugExtension);

	$html =  $twig->render($ctrl->template, [
		"a_variable" => $ctrl->titre,
		"a_alerte"  => $ctrl->alerte,
		"data"=>$ctrl->data,
		"data1" => $ctrl->data1,
		"datacat" =>$ctrl->datacat,
		"rang"=>$ctrl->rang,
		"datauser"=> $ctrl->datauser,
		"dataartiste" => $ctrl->dataartiste,
		"dataactualite" => $ctrl->dataactualite,
		"session"=>$ctrl->session]);
	$response->getBody()->write($html);

	return $response;
}
?>