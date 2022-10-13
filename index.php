<?php

require_once __DIR__ . '/functions.php';
$username = require_basic_auth();

header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link href="styles/style.css" rel="stylesheet">
<title>Temペット Home</title>
</head>
<body>

<h1>ようこそ,<?=h($username)?>さん</h1>

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
