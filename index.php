<?php

require_once __DIR__ . '/session_auth.php';
require_logined_session();

header('Content-Type: text/html; charset=UTF-8');

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="styles/style.css" rel="stylesheet">
<link href="styles/button.css" rel="stylesheet">
<link href="styles/remember_button.css" rel="stylesheet">
<link href="styles/select_pet_button.css" rel="stylesheet">
<link href="styles/submit_button.css" rel="stylesheet">
<title>Temペット Home</title>
</head>
<body>

<?php
print("<h1>ようこそ,".$_SESSION['username']."さん</h1>");
?>

<?php
print('<div class="btn--parant"><a href="./select_pet.php" class="btn btn--orange">リモコン設定</a></div>');

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

<div class="btn--parant"><a href="./logout.php?token=<?=h(generate_token())?>" class="btn btn--orange">logout</a></div>

<script>
</script>

</body>
</html>
