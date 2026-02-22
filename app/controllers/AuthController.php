<?php

/**
 * Controller AuthController
 * 
 * Tento controller zpracovává:
 * - přihlášení uživatele
 * - registraci uživatele
 * 
 * V MVC architektuře:
 * - Controller přijímá HTTP request
 * - zpracovává data (validace, logika)
 * - komunikuje s Modelem
 * - rozhoduje, jaký View se zobrazí
 */
class AuthController
{
    /**
     * Zobrazí přihlašovací formulář.
     * 
     * Neobsahuje logiku přihlášení (zatím jen vykreslení view).
     */
    public function login(): void
    {
        require_once __DIR__ . '/../views/login.php';
    }

    /**
     * Zpracování registrace uživatele.
     * 
     * - GET  → zobrazí registrační formulář
     * - POST → zpracuje odeslaná data
     */
    public function signup(): void
    {
        // Pokud byl formulář odeslán metodou POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /**
             * Načtení dat z formuláře.
             * $_POST obsahuje data odeslaná formulářem.
             * 
             * Operátor ?? zajistí, že pokud hodnota neexistuje,
             * použije se prázdný řetězec.
             */
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            /**
             * Jednoduchá validace:
             * kontrola, zda jsou všechna pole vyplněna.
             */
            if ($name === '' || $email === '' || $password === '') {
                echo "<p>Vypln vsechna pole.</p>";
                require_once __DIR__ . '/../views/signup.php';
                return; // Ukončí další vykonávání metody
            }

            /**
             * Zahashování hesla před uložením do databáze.
             * 
             * password_hash():
             * - vytvoří bezpečný hash hesla
             * - používá moderní algoritmus (např. bcrypt)
             * - chrání uživatele i při úniku databáze
             */
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            try {
                $userModel = new User();
                $created = $userModel->create($name, $email, $hashedPassword);

                if ($created) {
                    header('Location: /login');
                    exit;
                }

                echo "<p>Registrace selhala.</p>";
                return;
            } catch (PDOException $e) {
                if ((int)$e->getCode() === 23000) {
                    echo "<p>Email uz existuje.</p>";
                    require_once __DIR__ . '/../views/signup.php';
                    return;
                }

                echo "<p>Nastala chyba pri registraci.</p>";
                return;
            }
        }
        // Pokud je request typu GET → zobrazí registrační formulář
        require_once __DIR__ . '/../views/signup.php';
    }
}