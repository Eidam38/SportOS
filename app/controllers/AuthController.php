<?php

    class AuthController
    {
        public function login(): void
        {
            require_once __DIR__ . '/../views/login.php';
        }

        public function signup(): void
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = trim($_POST['name'] ?? '');
                $email = trim($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';

                if ($name === '' || $email === '' || $password === '') {
                    echo "<p>Vypln vsechna pole.</p>";
                    require_once __DIR__ . '/../views/signup.php';
                    return;
                }

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $userModel = new User();
                $created = $userModel->create($name, $email, $hashedPassword);

                if ($created) {
                    echo "<p>Registrace probehla uspesne.</p>";
                    return;
                }

                echo "<p>Registrace selhala.</p>";
                return;
            }

            require_once __DIR__ . '/../views/signup.php';
        }
    }