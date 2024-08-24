<?php
session_start();

try {
    $dbh = new PDO('mysql:host=mysql;dbname=kyototech', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['body'], $_POST['csrf_token'])) {
    if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $body = trim($_POST['body']);
        
        if (!empty($body)) {
            try {
                $insert_sth = $dbh->prepare("INSERT INTO hogehoge (text) VALUES (:body)");
                $insert_sth->execute([':body' => $body]);
                header("HTTP/1.1 302 Found");
                header("Location: ./enshu1.php");
                exit();
            } catch (PDOException $e) {
                die('Insert query failed: ' . htmlspecialchars($e->getMessage()));
            }
        } else {
            die('Content cannot be empty.');
        }
    } else {
        die('Invalid CSRF token.');
    }
}

try {
    $select_sth = $dbh->prepare('SELECT * FROM hogehoge ORDER BY created_at DESC');
    $select_sth->execute();
} catch (PDOException $e) {
    die('Select query failed: ' . htmlspecialchars($e->getMessage()));
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Form</title>
    <link rel="stylesheet" href="./styles.css">
</head>
<body>
    <form method="POST" action="./home.php">
        <textarea name="body"></textarea>
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
        <button type="submit">送信</button>
    </form>

    <hr style="margin: 3em 0;"></hr>

    <?php foreach ($select_sth as $row): ?>
        <dl>
            <dt>送信日時</dt>
            <dd><?= htmlspecialchars($row['created_at']) ?></dd>
            <dt>送信内容</dt>
            <dd><?= nl2br(htmlspecialchars($row['text'])) ?></dd>
        </dl>
    <?php endforeach ?>
</body>
</html>
