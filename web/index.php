<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require_once __DIR__.'/../vendor/autoload.php';

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

$app->get('/', function () use ($app) {
    return $app['twig']->render('index.html.twig', array('hi' => true));
});

$app->post('/', function(Request $request) use ($app) {
    $hi = (bool) $request->get('hi', false);
    $raw_sql = $request->get('raw_sql', '');
    $cooked_sql = SqlFormatter::format($raw_sql, $hi);
    return $app['twig']->render('index.html.twig', array('cooked_sql' => $cooked_sql, 'raw_sql' => $raw_sql, 'hi' => $hi));
});

// definitions

$app->run();