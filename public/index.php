<?php
/**
* Front Controller aplikace
* 
* Jediný vstupní bod aplikace (redirect z .htaccess).
* Inicializuje prostředí, načítá závislosti,
* definuje routy a předává request routeru.
*/

/**
* Načte proměnné z .env souboru do $_ENV a systémového prostředí.
*
* @param string $path Absolutní cesta k .env souboru
*/
function loadEnv(string $path): void 
{
      if (!file_exists($path)) {
            return;
      }

      $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

      foreach ($lines as $line) {
            $line = trim($line);

            // Ignoruje prázdné řádky a komentáře
            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            [$key, $value] = array_map('trim', explode('=', $line, 2));
            $_ENV[$key] = $value;
            putenv("$key=$value");
      }
}

// Inicializace prostředí
loadEnv(__DIR__ . '/../.env');

/* 
*  Načtení core tříd a controllerů

* require_once → zajistí, že se soubor načte pouze jednou
* __DIR__ → absolutní cesta k aktuálnímu souboru
*/
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../app/controllers/HomeController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ProfileController.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/models/User.php';


// Definice aplikačních rout
$router = new Router();

// Hlavní stránka
$router->get('/home', function () {
      $controller = new HomeController(); // Vytvoření instance controlleru
      $controller->index(); // Volání metody index, která zobrazí hlavní stránku
});

// Přihlášení
$router->get('/login', function () {
      $controller = new AuthController();
      $controller->login();
});

// Registrace (GET = formulář, POST = odeslání formuláře)
$router->get('/signup', function () {
      $controller = new AuthController();
      $controller->signup();
});

$router->post('/signup', function () {
      $controller = new AuthController();
      $controller->signup();
});

// Profil uživatele
$router->get('/profile', function () {
      $controller = new ProfileController();
      $controller->index();
});

/*
* Zpracování HTTP requestu
*
* Určí HTTP metodu (GET, POST, ...)
* Získá aktuální URI
* Router vyhledá odpovídající route a spustí její callback
*/
$router->dispatch(
      $_SERVER['REQUEST_METHOD'], 
      $_SERVER['REQUEST_URI']
      );