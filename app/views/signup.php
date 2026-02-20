<?php require_once __DIR__ . '/partials/header.php'; ?>
<?php require_once __DIR__ . '/partials/navbar.php'; ?>

<h1>Signup</h1>

<form method="POST" action="/signup">
    <div>
        <label for="name">Jmeno</label>
        <input type="text" id="name" name="name" required>
    </div>

    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>

    <div>
        <label for="password">Heslo</label>
        <input type="password" id="password" name="password" required>
    </div>

    <button type="submit">Registrovat</button>
</form>

<?php require_once __DIR__ . '/partials/footer.php'; ?>