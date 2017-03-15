<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("homepage");
    // Render index view
    return $this->view->render($response, 'index.phtml', $args);
})->setName('home');

$app->get('/login', function ($request, $response, $args) {
    // Sample log message
    // vising pages you should not see will redirct you here and destroy your current session
    $this->session::destroy();
    $this->logger->info("showing login page");
    // Render index view
    return $this->view->render($response, 'login.phtml', $args);
})->setName('login');

$app->post('/login', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info(" 'post /login' login procesed");
    $key=new CityGame\CityGame\Models\Key($this->session);
    //$login->create($request->getParsedBody());   //create a login object (has keytype and sesion ID)
    $key->setkey($request->getParsedBody()["key"]);
    $this->logger->debug("key is $key->key");

    switch ($key->getType()) {
        case "logout":
        $this->session->destroy;
        return $this->view->render($response, 'login.phtml', $args);
        break;
        case "master":
        case "player":
        $this->session->set('key', $key->getkey());
        return $response->withRedirect($this->router->pathFor($key->getType()));
    }
    if ($key->getType()=="master") { // invalid key
        $this->session->destroy;
        return $this->view->render($response, 'login.phtml', $args);
    } else {
        $this->session->set('key', $key->getkey());
        return $response->withRedirect($this->router->pathFor($keytype));
    }
});

$app->get('/booking', function ($request, $response, $args) {
    // Sample log message
    $booking = $this->booking;
    $booked = $booking->getBookedDate();

    $this->logger->info("showing booking page");

    // Render index view
    return $this->view->render($response, 'booking.phtml', ['booked'=> $booked]);
})->setName('booking');

$app->post('/booking', function ($request, $response) {
    $this->logger->info("wow, someone booked a citygame");
    $booking = $this->booking;
    $booking->create($request->getParsedBody()); //--> booking aanmaken

    try {
        $booking->validate();
        $booking->freeDate();
        $booking->infoCheck();
        $booking->save();
        $this->logger->info("booking succesfull 😃");
        return $response->withRedirect($this->router->pathFor('home'));
    } catch (\Exception $e) {
        $this->logger->info("but he failed... why?");
        $error=$e->getMessage();
        echo '<script type="text/javascript">alert("'.$error.'");</script>';
        return $this->view->render($response, 'booking.phtml', $request->getParsedBody());
    }
})->setName('booking');

$app->get('/scores', function ($request, $response, $args) {
    $scores =$this->scores;
    return $this->view->render($response, 'scores.phtml', ['scores'=> $scores]);
})->setName('scores');

$app->get('/logout', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("welp, that session is gone, someone logged out");
    $key=new CityGame\CityGame\Models\Key($this->session);
    $this->session::destroy();
    return $response->withRedirect($this->router->pathFor('home'));
})->setName('logout');

$app->get('/controlpanel', function ($request, $response, $args) {
    // Sample log message
    $key=new CityGame\CityGame\Models\Key($this->session);
    if ($key->isValid()) {
        if ($key->getType()=="master") {
            $this->logger->info("showing cpannel page");
          //  $region="Oostende";
            $file="public/api/weather.json";
            $url= "http://api.openweathermap.org/data/2.5/forecast/weather?q=Oostende&units=metric&APPID=066c280cce061f0927f4eb1310b4a25c";
            $caching=new CityGame\CityGame\Models\Caching($file, $url);
          //  $caching.update($file, $url);//updates the wheater.json in the public folder
            $dir="./../public/uploaded_files";
            $scanned_directory = array_diff(scandir(__DIR__.$dir), array('..', '.'));
        // Render index view
        return $this->view->render($response, 'controlpanel.phtml', [
            "key" => $key,
            "img" => $scanned_directory
        ]);
        } else {
            $this->logger->warning("invalid key used to see controlpanel");
            return $response->withRedirect($this->router->pathFor('login'));
        }
    } else {
        $this->logger->warning("no key used to see controlpanel");

        return $response->withRedirect($this->router->pathFor('login'));
    }
})->setName('master');

$app->get('/upload', function ($request, $response, $args) {
    // Sample log message
    $key=new CityGame\CityGame\Models\Key($this->session);
    if ($key->isValid()) {
        if ($key->getType()=="player") {
            $this->logger->info("showing upload page");
        // Render index view
        return $this->view->render($response, 'partials/upload.phtml', [
            "key" => $key
        ]);
        } else {
            $this->logger->warning("invalid key used to see uploader");
            return $response->withRedirect($this->router->pathFor('login'));
        }
    } else {
        $this->logger->warning("no key used to see uploader");

        return $response->withRedirect($this->router->pathFor('login'));
    }
})->setName('player');

$app->post('/upload', function ($request, $response, $args) {
    $files = $request->getUploadedFiles();
    if (empty($files['newfile'])) {
        throw new Exception('Expected a newfile');
    }

    $newfile = $files['newfile'];
    if ($newfile->getError() === UPLOAD_ERR_OK) {
        $uploadFileName = $newfile->getClientFilename();
        $newfile->moveTo("public/uploaded_files/$uploadFileName");
        return $response->withRedirect($this->router->pathFor('home'));
    }
});

$app->get('/404', function ($request, $response, $args) {
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
})->setName('404');

$app->get('/test', function ($request, $response, $args) {
    // Sample log message

    $input=json_decode(file_get_contents("./testschenario.json"), true);//lel, typo in filename
    //var_dump($input);
    //var_dump(new CityGame\CityGame\Models\scenario($input));
    $scenario= new CityGame\CityGame\Models\scenario($input);
    $out=$scenario->print();
    var_dump($out);
    // Render index view
    return $this->view->render($response, 'empty.phtml', $args);
})->setName('test');
