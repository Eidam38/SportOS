<?php
/* 
Tento soubor funguje jako front controller aplikace.
Každý HTTP request projde právě sem (díky .htaccess).

Zde:
- načítáme konfiguraci (.env)
- načítáme potřebné třídy (core + controllers)
- definujeme routy
- spouštíme router a zpracováváme request
*/

function loadEnv(string $path): void 
{
      if (!file_exists($path)) {
          return;
      }

      $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

      foreach ($lines as $line) {
          $line = trim($line);

          if ($line === '' || str_starts_with($line, '#')) {
              continue;
          }

          [$key, $value] = array_map('trim', explode('=', $line, 2));
          $_ENV[$key] = $value;
          putenv("$key=$value");
      }
}

loadEnv(__DIR__ . '/../.env');

/* 
Načtení závislostí (core + controllers) 

require_once → zajistí, že se soubor načte pouze jednou
__DIR__ → absolutní cesta k aktuálnímu souboru
*/
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ProfileController.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/models/User.php';

$router = new Router();

/*
Route: /home
Akce: Zobrazí hlavní stránku
*/
$router->get('/home', function () {
      $controller = new HomeController(); // Vytvoření instance controlleru
      $controller->index(); // Volání metody index, která zobrazí hlavní stránku
});

/*
| Route: /login
| Akce: Zobrazí login stránku
*/
$router->get('/login', function () {
      $controller = new AuthController();
      $controller->login();
});

$router->get('/signup', function () {
      $controller = new AuthController();
      $controller->signup();
});

$router->post('/signup', function () {
      $controller = new AuthController();
      $controller->signup();
});

/*
| Route: /profile
| Akce: Zobrazí profil uživatele
*/
$router->get('/profile', function () {
      $controller = new ProfileController();
      $controller->index();
});

/*
Zpracování requestu

dispatch() → hlavní vstup routeru
REQUEST_METHOD → GET / POST / PUT / DELETE
REQUEST_URI    → aktuální URL

Router:
- najde odpovídající routu
- vykoná callback
*/
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
