<?php

namespace App\Controller;

use addTokenController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

//require_once __DIR__ . '/../fixtures/dataFixtures.php';
require_once __DIR__ . '/playersState.php';
require_once __DIR__ . '/../Controller/addTokenController.php';
require_once __DIR__ . '/twigInitialization.php';
require_once __DIR__ . '/debug/phpDebug.php';

global $twig;
$routes = new RouteCollection();

//Main PHP Routes
$routeName = "home";
$routes->add($routeName, new Route('/', [
    '_controller' => static function() use ($twig, $routeName) {
        return new Response($twig->render('home.twig', [
            "route_name" => $routeName,
        ]));
    }
]));

$routeName = 'play_area';
$routes->add($routeName, new Route('/play-area', [
    '_controller' => static function() use ($twig, $routeName) {
        getCurrentPlayerId();
        dataInitialization();
// Debug file
        phpDebug();
        return new Response($twig->render('play-area.twig', [
            "player_1" => $_SESSION["player1"],
            "player_2" => $_SESSION["player2"],
            "route_name" => $routeName,
        ]));
    }
]));

$routes->add('play_area_api', new Route('/api/play-area',
    ['_controller' => static function (Request $request) {
        return new \addTokenController($request)->addTokens();
    },
        [], [], '', [], ['POST']
    ]
));

$routes->add('add_previous_tokens_api', new Route('/api/add-previous-tokens', [
    '_controller' => static function (Request $request) {
        return new \addTokenController($request)->addPreviousTokens();
    },
        [], [], '', [], ['POST']
    ]
));

$routes->add('check_winner_api', new Route('/api/check-winner', [
        '_controller' => static function (Request $request) {
            return new \addTokenController($request)->sendWinnerData();
        },
        [], [], '', [], ['GET']
    ]
));

// JS Routes

$routes->add('main_js', new Route('/main.js', [
    '_controller' => static function () {
        $filePath = __DIR__ . '/../main.js';
        if (!file_exists($filePath)) {
            return new Response('main.js not found', 404);
        }
        return new Response(file_get_contents($filePath), 200, [
            'Content-Type' => 'application/javascript'
        ]);
    }
]));

$routes->add('js_modules', new Route('/js/{filename}', [
    '_controller' => static function (Request $request, $filename) {
        $filename = basename($filename);
        $filePath = __DIR__ . '/../js/' . $filename;

        if (!file_exists($filePath) || !str_ends_with($filename, '.js')) {
            return new Response('File not found: ' . $filename, 404);
        }

        return new Response(file_get_contents($filePath), 200, [
            'Content-Type' => 'application/javascript'
        ]);
    }
], ['filename' => '.+']));


$request = Request::createFromGlobals();
$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);
try {
    $parameters = $matcher->match($request->getPathInfo());
    $controller = $parameters['_controller'];
    unset($parameters['_controller'], $parameters['_route']);
    if (!empty($parameters)) {
        $response = call_user_func_array($controller, array_merge([$request], $parameters));
    } else {
        $response = $controller($request);
    }
    if (!$response instanceof Response) {
        throw new \RuntimeException('Controller must return a Response object');
    }
    $response->send();
} catch (ResourceNotFoundException $e) {
    $response = new Response('Page Not Found', 404);
    $response->send();
} catch (\Exception $e) {
    error_log('Error: ' . $e->getMessage());
    $response = new Response('Internal Server Error', 500);
    $response->send();
}

//$routes->add('fixtures', new Route('/fixtures-play', [
//    '_controller' => function () use ($twig) {
////        tokensFixturesToSend();
//
//        return new Response(
//            $twig->render('play-area-fixtures.twig', [
////                'fixtures' => $_SESSION,
//            ]));
//    }
//]));

