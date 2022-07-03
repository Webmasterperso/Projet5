<?php
session_start();
//$id_session = session_id();

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use App\Controllers\Control as controleur;
use App\Models\Modeloeuvres;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/..");
$dotenv->load();
$uri = $_SERVER["REQUEST_URI"];
$uri1 = substr($uri,1);
//echo 'uri : '.$uri.'</br>';



$basePath= "";

$app = AppFactory::create();

$app->get('/[{nomPage}]', function (Request $request, Response $response, $args) {
	return renderPage(new controleur($args), $response);
});
$app->get('/{nomPage}/{categorieid}[/{idOeuvre}]', function (Request $request, Response $response, $args) {
	return renderPage(new controleur($args), $response);
});

$app->post('/[{nomPage}]', function (Request $request, Response $response, $args) {
	// die(var_dump($args));
	$dataform = (array)$request->getParsedBody();
	//die(var_dump($dataform));
		return renderPage(new controleur($args, $dataform), $response);
});

$app->post('/api/panier', function (Request $request, Response $response, $args) {

	$content = json_decode(file_get_contents("php://input"), true);
	$model = new Modeloeuvres();
	$payload = json_encode($model->getOeuvresIntoCart($content["data"]));

	$response->getBody()->write($payload);
	return $response
		->withHeader('Content-Type', 'application/json');
});


$app->run();

function renderPage($ctrl,Response $response ){
	
	global $app;
	global $basePath;
	$loader = new \Twig\Loader\FilesystemLoader('../src/templates');
	$twig = new \Twig\Environment($loader, [
		'cache' => false, //'../var/cache',
		'debug' => true,
		"autoescape" => false,
	]);
	$twig->addFilter(new \Twig\TwigFilter('html_entity_decode', 'html_entity_decode'));
	$twig->addExtension(new \Twig\Extension\DebugExtension);

	$html =  $twig->render($ctrl->template, [
		"base" => $basePath,
		"a_variable" => $ctrl->titre,
		"a_alerte"  => $ctrl->alerte,
		"data"=>$ctrl->data,
		"data1" => $ctrl->data1,
		"datacat" =>$ctrl->datacat,
		"rangcat"=>$ctrl->rangcat,
		"rangprix" => $ctrl->rangprix,
		"datauser"=> $ctrl->datauser,
		"dataartiste" => $ctrl->dataartiste,
		"dataactualite" => $ctrl->dataactualite,
		"session"=>$ctrl->session,
		"datacommand"=> $ctrl->datacommand,
		"listcommand"=> $ctrl->listcommand,
		"adressexpedition"=> $ctrl->adressexpedition,
		"adressfacturation" => $ctrl->adressfacturation,
		"paypalId"=>$ctrl->paypalId
	]);
	$response->getBody()->write($html);

	return $response;
}
?>