<?php

/**
 * Model User
 * 
 * Tato třída reprezentuje práci s tabulkou "users" v databázi.
 * 
 * V MVC architektuře:
 * - Model komunikuje s databází
 * - Controller volá metody modelu
 * - Model neřeší HTML ani výstup
 */
class User
{   
    /**
     * Vytvoří nového uživatele v databázi.
     *
     * @param string $name     Jméno uživatele
     * @param string $email    Email uživatele
     * @param string $password Heslo (mělo by být zahashované před uložením)
     * 
     * @return bool Vrací true při úspěšném vložení, jinak false
     */
    public function create(string $name, string $email, string $password): bool
    {   
        // Získání PDO připojení (Singleton z třídy Database)
        $pdo = Database::connect();

        /**
         * SQL dotaz s pojmenovanými parametry (:name, :email, :password)
         * 
         * Používáme prepared statement kvůli:
         * - bezpečnosti (ochrana proti SQL injection)
         * - oddělení dat od SQL struktury
         */
        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        // Příprava SQL dotazu
        $stmt = $pdo->prepare($sql);

        /**
        * execute():
        * - naváže skutečné hodnoty na parametry
        * - provede dotaz
        * 
        * Vrací:
        * - true pokud byl dotaz úspěšný
        * - false při selhání
        */
        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}