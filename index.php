<?php

require_once __DIR__ . '/session_auth.php';
require_logined_session();

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

<?php
print("<h1>ようこそ,".$_SESSION['username']."さん</h1>");
?>

<?php
print('<a href="./select_pet.php" class="btn btn--orange">リモコン設定</a>');

$Raspi_bme_file = 'Raspi_bme.txt';
$fp = fopen($Raspi_bme_file, 'rb');
if ($fp){
    if (flock($fp, LOCK_SH)){
        while (!feof($fp)) {
            $buffer = fgets($fp);
        }

        flock($fp, LOCK_UN);
    }else{
        print('ファイルロックに失敗しました');
    }
}
fclose($fp);

print('<h2>現在の室温は'.$buffer.'℃です</h2>');
?>

<a href="/logout.php?token=<?=h(generate_token())?>">logout</a>

<script>
</script>

</body>
</html>
