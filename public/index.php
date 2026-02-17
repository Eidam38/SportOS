<?php

  require_once __DIR__ . '/../core/Router.php';

  $router = new Router();

  $router->get('/home', function () {
      echo "<h1>Home</h1>";
  });

  $router->get('/login', function () {
      echo "<h1>Login</h1>";
  });

  $router->get('/profile', function () {
      echo "<h1>Profile</h1>";
  });

  $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
