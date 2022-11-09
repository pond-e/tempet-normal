<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link href="styles/style.css" rel="stylesheet">
<title>Temペット Home</title>
</head>
<body>

<?php
function require_basic_auth()
{
    // 事前に生成したユーザごとのパスワードハッシュの配列
    $hashes = [
        'admin' => '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918',
    ];

    if (
        !(isset($_GET['username'], $_GET['password']) &&
        hash('sha256', $_GET['username']) === $hashes[$_GET['password']])
    ) {
        exit('ユーザー名、もしくはパスワードを間違えています');
    }

    // 認証が成功したときはユーザ名を返す
    return $_GET['username'];
}

$username = require_basic_auth();
?>

<?php
print("<h1>ようこそ,".$username."さん</h1>");
?>

<a href="./select_pet.php" class="btn btn--orange">リモコン設定</a>

<?php
    #print_r($_SERVER['PHP_AUTH_USER']);
    #print("<br>");
    #print_r($_SERVER['PHP_AUTH_PW']);
?>

<script>
</script>

</body>
</html>
