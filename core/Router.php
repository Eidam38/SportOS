<?php

  class Router
  {
      private array $routes = [];

      public function get(string $path, callable $handler): void
      {
          $this->routes['GET'][$path] = $handler;
      }

      public function dispatch(string $method, string $uri): void
      {
          $path = parse_url($uri, PHP_URL_PATH);

          if (isset($this->routes[$method][$path])) {
              $handler = $this->routes[$method][$path];
              $handler();
              return;
          }

          http_response_code(404);
          echo "404 - Stranka nenalezena";
      }
  }