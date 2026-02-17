<?php

  require_once __DIR__ . '/../core/Router.php';
  require_once __DIR__ . '/../app/controllers/HomeController.php';
  require_once __DIR__ . '/../app/controllers/AuthController.php';
  require_once __DIR__ . '/../app/controllers/ProfileController.php';

  $router = new Router();

  $router->get('/home', function () {
        $controller = new HomeController();
        $controller->index();
  });

  $router->get('/login', function () {
        $controller = new AuthController();
        $controller->login();
  });

  $router->get('/profile', function () {
        $controller = new ProfileController();
        $controller->index();
  });

  $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
