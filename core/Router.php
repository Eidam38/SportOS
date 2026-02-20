<?php

/*
ROUTER – Řízení HTTP requestů

Router slouží jako centrální komponenta aplikace, 
která mapuje URL adresy na konkrétní logiku (handlers).
Odpovědnosti:
- registrace rout
- vyhodnocení HTTP requestu
- spuštění správné akce
*/
class Router
{   

    /*
    Pole registrovaných rout
    
    Struktura:
    [ 
    'GET' => ['/home' => callable,'/login' => callable],
    'POST' => ['/submit' => callable]
    ]
    */
    private array $routes = [];

    
    /*
    Registrace GET routy
    
    @param string   $path    URL cesta (/home, /login, ...)
    @param callable $handler Funkce, která se vykoná při shodě
    
    Ukládáme handler do pole $routes podle HTTP metody.
    */    
    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    /*
    Zpracování HTTP requestu
    
    @param string $method HTTP metoda (GET, POST, ...)
    @param string $uri    Celá request URI
    
    Logika:
    1. Z URI získáme čistou cestu
    2. Najdeme odpovídající routu
    3. Spustíme handler
    4. Pokud routa neexistuje → 404
    */
    public function dispatch(string $method, string $uri): void
    {
        /*
        Extrakce cesty z URI
        
        Např: /profile?id=5 → /profile
        Ignorujeme query parametry.
        */
        $path = parse_url($uri, PHP_URL_PATH);

        /*
        Kontrola existence routy
        
        Ověříme:
        - existenci HTTP metody
        - existenci konkrétní cesty
        */
        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path]; // Získání uloženého handleru
            $handler(); // Spuštění handleru (callback funkce)
            return;
        }

        /*
        Fallback – 404 Not Found

        Pokud nebyla nalezena odpovídající routa.
        */
        http_response_code(404);
        echo "404 - Stranka nenalezena";
    }
}