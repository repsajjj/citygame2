<?php

$app->add(new \Slim\Middleware\Session([
    'name' => 'user_session',
    'autorefresh' => false,
    'lifetime' => '6 hours'
]));


$app->add(function ($request, $response, $next) {
    $key = new \CityGame\CityGame\Models\Key($this->session);
    if ($key->isValid()) {
        $view = $this->get('view');
        $view->offsetSet('key', $key);
    }
    return $next($request, $response);
});
