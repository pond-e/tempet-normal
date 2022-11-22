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
        $q = 'UPDATE user_info SET power="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "power";
    }else if($data === 'cooling'){
        print("<h2>冷房ボタンをTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET cooling="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "cooling";
    }else if($data === 'dehumidification'){
        print("<h2>除湿ボタンをTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET dehumidification="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "dehumidification";
    }else if($data === 'heating'){
        print("<h2>暖房ボタンをTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET heating="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "heating";
    }else if($data === 'temperature'){
        print("<h2>温度ボタンを19℃から29℃までTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET temperature="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "temperature";
    }else if($data === 'stop_button'){
        print("<h2>停止ボタンをTemペットに向けて押してください</h2>");
        $q = 'UPDATE user_info SET stop_button="true" WHERE user="admin"';// user名のSQL injectionは無視する
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
    

    if($data !== "none"){
        // 記憶開始
        $Raspi_state_file = 'Raspi_state.txt';
        $fp = fopen($Raspi_state_file, 'wb');
        if ($fp){
            if (flock($fp, LOCK_EX)){
                if (fwrite($fp, $data) === FALSE){
                    print('ファイル書き込みに失敗しました');
                }
                flock($fp, LOCK_UN);
            }else{  
                print('ファイルロックに失敗しました');
            }
        }else{
            print('file open error');
        }
        fclose($fp);
        $data = "none";        
    }

    if(isset($_POST['conform'])){
        $Raspi_receive_file = 'Raspi_receive.txt';

        $fp_read = fopen($Raspi_receive_file, 'rb');    
        if ($fp_read){
            if (flock($fp_read, LOCK_SH)){
                while (!feof($fp_read)) {
                    $buffer = fgets($fp_read);
                }
                flock($fp_read, LOCK_UN);
            }else{
                print('ファイルロックに失敗しました');
            }
        }
        fclose($fp_read);

        if($buffer === "success"){
            print('<div class="btn--parant">
                    <a href="remember_remote_controller.php" class="btn btn--orange">ボタン選択画面に戻る</a>
                    </div>');
            $Raspi_state_file = 'Raspi_state.txt';
            $fp = fopen($Raspi_state_file, 'wb');
            if ($fp){
                if (flock($fp, LOCK_EX)){
                    if (fwrite($fp, "none") === FALSE){
                        print('ファイル書き込みに失敗しました');
                    }
                    flock($fp, LOCK_UN);
                }else{  
                    print('ファイルロックに失敗しました');
                }
            }else{
                print('file open error');
            }

            $Raspi_receive_file = 'Raspi_receive.txt';
            $fp = fopen($Raspi_receive_file, 'wb');
            if ($fp){
                if (flock($fp, LOCK_EX)){
                    if (fwrite($fp, "none") === FALSE){
                        print('ファイル書き込みに失敗しました');
                    }
                    flock($fp, LOCK_UN);
                }else{  
                    print('ファイルロックに失敗しました');
                }
            }else{
                print('file open error');
            }

        }else if($buffer === "retry"){
            print('<p>リモコンの記憶に失敗しました。もう一度お試しください</p><br>');
        }
    }

?>


<script>
</script>

</body>
</html>
