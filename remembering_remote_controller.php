<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link href="styles/style.css" rel="stylesheet">
<title>Temペット リモコンの記憶</title>
</head>
<body>

<h1>記憶フェーズ</h1>
<div class="remote_controller_button">
    <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
    <input type=submit class="btn btn--yellow btn--cubic" value="記憶が完了したか確認する" name="conform">
    </form>
</div>


<?php
    $buffer = "none";

    $data = "none";
    if(isset($_GET['data'])){
        $data = $_GET['data'];
        print_r($data);
    }

    $db = new SQLite3('./tempet.db', SQLITE3_OPEN_READWRITE);
    if($data === 'power'){
        $q = 'UPDATE user_info SET power="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "power";
    }else if($data === 'cooling'){
        $q = 'UPDATE user_info SET cooling="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "cooling";
    }else if($data === 'dehumidification'){
        $q = 'UPDATE user_info SET dehumidification="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "dehumidification";
    }else if($data === 'heating'){
        $q = 'UPDATE user_info SET heating="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "heating";
    }else if($data === 'temperature'){
        $q = 'UPDATE user_info SET temperature="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "temperature";
    }else if($data === 'stop'){
        $q = 'UPDATE user_info SET stop="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "stop";
    }
    $db->close();

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

        // 記憶終了
        $Raspi_state_file = 'Raspi_state.txt';
        $fp = fopen($Raspi_state_file, 'wb');
        if ($fp){
            if (flock($fp, LOCK_EX)){
                if (fwrite($fp, "stop") === FALSE){
                    print('ファイル書き込みに失敗しました');
                }
                flock($fp, LOCK_UN);
            }else{  
                print('ファイルロックに失敗しました');
            }
        }else{
            print('file open error');
        }

        
    }

    if(isset($_POST['conform'])){
        $Raspi_receive_file = 'Raspi_receive.txt';

        $fp_read = fopen($Raspi_receive_file, 'rb');    
        if ($fp_read){
            //print('2<br>');
            if (flock($fp_read, LOCK_SH)){
                //print('3<br>');
                while (!feof($fp_read)) {
                    $buffer = fgets($fp_read);
                    //print($buffer.'<br>');
                }
                //print('4<br>');
                flock($fp_read, LOCK_UN);
            }else{
                print('ファイルロックに失敗しました');
            }
        }
        fclose($fp_read);

        if($buffer === "success"){
            print('<div class="page_change">
                    <a href="remember_remote_controller.php" class="btn btn--orange">ボタン選択画面に戻る</a>
                    </div>');
            $Raspi_state_file = 'Raspi_receive.txt';
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
        }
    }

?>


<script>
</script>

</body>
</html>
