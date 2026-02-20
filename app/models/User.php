<?php

  class User
  {
    public function create(string $name, string $email, string $password): bool
    {
        $pdo = Database::connect();

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $pdo->prepare($sql);

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}