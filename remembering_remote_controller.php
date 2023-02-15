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
<title>Temペット リモコンの記憶</title>
</head>
<body>

<h1>記憶フェーズ</h1>

<?php
    $buffer = "none";

    $data = "none";
    if(isset($_GET['data'])){
        $data = $_GET['data'];
    }

    $db = new SQLite3('./tempet.db', SQLITE3_OPEN_READWRITE);
    if($data === 'power'){
        print("<h2>電源ボタンをTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET state="power" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "power";
    }else if($data === 'cooling'){
        print("<h2>冷房ボタンをTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET state="cooling" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "cooling";
    }else if($data === 'dehumidification'){
        print("<h2>除湿ボタンをTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET state="dehumidification" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "dehumidification";
    }else if($data === 'heating'){
        print("<h2>暖房ボタンをTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET state="heating" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "heating";
    }else if($data === 'temperature'){
        print("<h2>温度ボタンを19℃から29℃までTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET state="temperature" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "temperature";
    }else if($data === 'stop_button'){
        print("<h2>停止ボタンをTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET state="stop_button" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "stop_button";
    }
    $db->close();
?>

<div class="btn--parant">
    <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
    <input type=submit class="submit_button" value="記憶が完了したか確認する" name="conform">
    </form>
</div>


<?php
    if(isset($_POST['conform'])){
        $db  = new SQLite3('./tempet.db');
        $results = $db->query('SELECT receive FROM user_info');
        while ($row = $results->fetchArray()) {
            $buffer = $row[0];
        }
        $db->close();

        if($buffer === "success"){
            print('<div class="btn--parant">
                    <a href="remember_remote_controller.php" class="btn btn--orange">ボタン選択画面に戻る</a>
                    </div>');
            $db = new SQLite3('./tempet.db');
            $db->exec('UPDATE user_info SET state="none"');
            $db->close();

            $db = new SQLite3('./tempet.db');
            $db->exec('UPDATE user_info SET receive="none"');
            $db->close();

        }else if($buffer === "retry"){
            print('<p>リモコンの記憶に失敗しました。もう一度お試しください</p><br>');
        }
    }

?>


<script>
</script>

</body>
</html>
