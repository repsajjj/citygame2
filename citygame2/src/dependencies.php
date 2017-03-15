<?php
// DIC configuration

$container = $app->getContainer();

$container['session'] = function ($c) {
    return new \SlimSession\Helper;
};
// Register component on container
//Override the default Not Found Handler
$container['notFoundHandler'] = function ($c) {
    return function ($request, $response) use ($c) {
        //get list of pages
        $dir="/../templates/404";
        $scanned_directory = array_diff(scandir(__DIR__.$dir), array('..', '.'));
          //get random page
        $k = array_rand($scanned_directory);
        $random = $scanned_directory[$k];
          // Render index view
        return $c['view']->render($response->withStatus(404), "404.html", [
          "random" => $random
        ]);
    };
};

// Register component on container

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig(__DIR__ .'/../templates');

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['Key'] = function ($c) {
    return new \CityGame\CityGame\Models\Key($c['db']);
};

$container['Game'] = function ($c) {
    return new \CityGame\CityGame\Models\Game($c['db']);
};

$container['booking'] = function ($c) {
    return new \CityGame\CityGame\Models\Booking($c);
};

$container['session'] = function ($c) {
    return new \SlimSession\Helper;
};

$container['scores'] = function ($c) {
    return new \CityGame\CityGame\Models\Scores;
};
