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
    if(isset($_POST['power'])){
        $data = "power";
    }else if(isset($_POST['cooling'])){
        $data = "cooling";
    }else if(isset($_POST['dehumidification'])){
        $data = "dehumidification";
    }else if(isset($_POST['heating'])){
        $data = "heating";
    }else if(isset($_POST['temperature'])){
        $data = "temperature";
    }else if(isset($_POST['stop'])){
        $data = "stop";
    }

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
    <input type="submit" value="電源" name="power" class="btn btn--yellow btn--cubic">
    <input type="submit" value="冷房" name="cooling" class="btn btn--yellow btn--cubic">
    <input type="submit" value="除湿" name="dehumidification" class="btn btn--yellow btn--cubic">
    <input type="submit" value="暖房" name="heating" class="btn btn--yellow btn--cubic">
    <input type="submit" value="温度" name="temperature" class="btn btn--yellow btn--cubic">
    <input type="submit" value="停止" name="stop" class="btn btn--yellow btn--cubic">
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
