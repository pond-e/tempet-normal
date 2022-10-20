<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link href="styles/style.css" rel="stylesheet">
<title>Temペット リモコンの記憶</title>
</head>
<body>

<h1>記憶するリモコンのボタンを選択</h1>
<?php
    $buffer = "none";

    $data = "none";
    $db = new SQLite3('./tempet.db', SQLITE3_OPEN_READWRITE);

    if(isset($_POST['power'])){
        $q = 'UPDATE user_info SET power="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "power";
    }else if(isset($_POST['cooling'])){
        $q = 'UPDATE user_info SET cooling="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "cooling";
    }else if(isset($_POST['dehumidification'])){
        $q = 'UPDATE user_info SET dehumidification="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "dehumidification";
    }else if(isset($_POST['heating'])){
        $q = 'UPDATE user_info SET heating="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "heating";
    }else if(isset($_POST['temperature'])){
        $q = 'UPDATE user_info SET temperature="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "temperature";
    }else if(isset($_POST['stop'])){
        $q = 'UPDATE user_info SET stop="true" WHERE user="admin"';// user名のSQL injectionは無視する
        $db->exec($q);
        $data = "stop";
    }
    $db->close();

    //$db = new SQLite3('./tempet.db');
    //$stmt = $db->prepare('UPDATE tempet SET "dog"=:dog "cat"=:cat "bird"=:bird "rabbit"=:rabbit WHERE "user_name"=:user_name');
    //$stmt->bindValue(':dog', $dog, SQLITE3_INTEGER);
    //$stmt->bindValue(':cat', $cat, SQLITE3_INTEGER);
    //$stmt->bindValue(':bird', $bird, SQLITE3_INTEGER);
    //$stmt->bindValue(':rabbit', $rabbit, SQLITE3_INTEGER);
    //$stmt->bindValue(':user_name', $user_name, SQLITE3_TEXT);
    //$result = $stmt->execute();
    //$db->close();

    if($data !== "none"){
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

    if($buffer === "success"){
        //echo "success!!";
    }else{
        //echo $buffer;
    }
    //print_r($buffer);
    //print('<br>');
    //print(gettype($buffer));
    //
    function readData(){
        //print('hoge<br>');
        
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
    }

?>
<div class="remote_controller_button">
    <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
    <a href="remembering_remote_controller.php?data='power'" class="btn btn--yellow btn--cubic">電源</a>

    <a href="remembering_remote_controller.php?data='cooling'" class="btn btn--yellow btn--cubic">冷房</a>

    <a href="remembering_remote_controller.php?data='dehumidification'" class="btn btn--yellow btn--cubic">除湿</a>

    <a href="remembering_remote_controller.php?data='heating'" class="btn btn--yellow btn--cubic">暖房</a>

    <a href="remembering_remote_controller.php?data='temperature'" class="btn btn--yellow btn--cubic">温度</a>

    <a href="remembering_remote_controller.php?data='stop'" class="btn btn--yellow btn--cubic">停止</a>
    </form>
</div>

<div class="page_change">
    <a href="select_pet.php" class="btn btn--orange">ペットの選択へ</a>
    <a href="index.php" class="btn btn--orange">Homeへ</a>
</div>


<script>
</script>

</body>
</html>
