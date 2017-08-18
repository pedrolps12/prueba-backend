<?php

namespace App;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require __DIR__ . '/../vendor/autoload.php';

$config['displayErrorDetails'] = true;
$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['view'] = new \Slim\Views\PhpRenderer("../templates/");



$app->get('/', function (Request $request, Response $response) {
    $developers = getData();
    $response = $this->view->render($response, "developer.phtml", ["developers" => $developers, "router" => $this->router]);
    return $response;
});

$app->get('/search', function (Request $request, Response $response) {
    $search = $request->getQueryParam("email");
    $developers = getData();
    $developersearch = [];
    foreach ($developers as $developer) {
        if (preg_match("/".$search."/", $developer['email'])) {
            array_push($developersearch, $developer);
        }
    }
    return json_encode($developersearch);
});

$app->get('/problem1', function (Request $request, Response $response) {
    $input1 = $request->getQueryParam("value");
    $change = new ChangeString();
    return $change->build($input1);
});

$app->get('/problem2', function (Request $request, Response $response) {
    $input2 = explode(",", $request->getQueryParam("value"));
    $change = new CompleteRange();
    return implode(",", $change->build($input2));
});
$app->get('/problem3', function (Request $request, Response $response) {
    $input3 = $request->getQueryParam("value");
    $change = new ClearPar();
    return $change->build($input3);
});

$app->get('/service', function (Request $request, Response $response) {
    $min=0;
    $max=0;
    if ($xml = simplexml_load_file("../data/service.xml")) {
        foreach ($xml->salary as $values) {
            $min = $values->min;
            $max = $values->max;
        }
    }
    $developers = getData();
    $developersearch = [];
    foreach ($developers as $developer) {
        if (str_replace(",", "", substr($developer['salary'], 1)) >= $min && substr($developer['salary'], 1) <= $max) {
            array_push($developersearch, $developer);
        }
    }
    $response = $this->view->render($response, "developer.phtml", ["developers" => $developersearch, "router" => $this->router]);
    return $response;
});



$app->get('/developer/{id}', function (Request $request, Response $response, $args) {
    $developer_id = $args['id'];

    $developers = getData();
    $developerdetail = [];
    foreach ($developers as $developer) {
        if ($developer["id"] == $developer_id) {
            $developerdetail = $developer;
        }
    }
    $response = $this->view->render($response, "developerdetail.phtml", ["developerdetail" => $developerdetail]);
    return $response;
})->setName('developer-detail');

function getData()
{
    $content = @file_get_contents("../data/employees.json");
    if ($content === false) {
        return null;
    }
    return json_decode($content, true);
}

$app->run();
