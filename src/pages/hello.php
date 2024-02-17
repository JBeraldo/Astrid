<!-- example.com/src/pages/hello.php -->
Hello <?= htmlspecialchars($name ?? 'World', ENT_QUOTES, 'UTF-8') ?>