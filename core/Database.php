<?php

/**
* Třída Database
* 
* Slouží k vytvoření a správě připojení k databázi.
* 
* Používá princip "Singleton", což znamená:
* - během běhu aplikace existuje pouze jedno připojení k databázi
* - zbytečně se nevytváří více spojení (lepší výkon)
*/
class Database
{   
    /**
     * Statická proměnná uchovávající PDO připojení.
     * 
     * ?PDO znamená:
     * - může obsahovat objekt typu PDO
     * - nebo hodnotu null (pokud ještě není připojeno)
     */
    private static ?PDO $connection = null;

    /**
     * Metoda connect()
     * 
     * Vrací aktivní PDO připojení k databázi.
     * Pokud připojení ještě neexistuje, vytvoří ho.
     * 
     * @return PDO
     */
    public static function connect(): PDO
    {   
        // Pokud ještě nebylo vytvořeno připojení
        if (self::$connection === null) {
            // Název služby "db" odpovídá názvu databázového kontejneru v Dockeru
            $host = 'db';
            // Načtení přístupových údajů z .env souboru
            // Pokud proměnná neexistuje, použije se výchozí hodnota
            $dbName = $_ENV['MYSQL_DATABASE'] ?? 'sportos_db';
            $user = $_ENV['MYSQL_USER'] ?? 'sportos_app';
            $password = $_ENV['MYSQL_PASSWORD'] ?? '';

            /**
             * DSN (Data Source Name)
             * 
             * Určuje:
             * - typ databáze (mysql)
             * - host
             * - název databáze
             * - kódování znaků (utf8mb4 podporuje i emoji)
             */
            $dsn = "mysql:host={$host};dbname={$dbName};charset=utf8mb4";

            /**
             * Vytvoření nového PDO objektu (připojení k DB)
             * 
             * PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
             * → při chybě se vyhodí výjimka (lepší pro ladění)
             * 
             * PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
             * → data se vrací jako asociativní pole:
             *   ['id' => 1, 'name' => 'Adam']
             * místo číselných indexů
             */
            self::$connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        // Vrátí existující (nebo nově vytvořené) připojení
        return self::$connection;
    }
}