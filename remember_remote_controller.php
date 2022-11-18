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
<title>Temペット リモコンの記憶</title>
</head>
<body>

<h1>記憶するリモコンのボタンを選択</h1>
<div class="orangeEdge">
    <a href="remembering_remote_controller.php?data=power">電源</a>

    <a href="remembering_remote_controller.php?data=cooling">冷房</a>

    <a href="remembering_remote_controller.php?data=dehumidification">除湿</a>

    <a href="remembering_remote_controller.php?data=heating">暖房</a>

    <a href="remembering_remote_controller.php?data=temperature">温度</a>

    <a href="remembering_remote_controller.php?data=stop_button">停止</a>
</div>

<div class="btn--parant">
    <a href="select_pet.php" class="btn btn--orange">ペットの選択へ</a>
    <a href="index.php" class="btn btn--orange">Homeへ</a>
</div>


<script>
</script>

</body>
</html>
