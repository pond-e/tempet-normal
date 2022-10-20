<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link href="styles/style.css" rel="stylesheet">
<title>Temペット リモコンの記憶</title>
</head>
<body>

<h1>記憶完了</h1>

<div class="page_change">
    <a href="remember_remote_controller.php" class="btn btn--orange">ボタン選択画面に戻る</a>
</div>

<?php
    $buffer = "none";

    $data = "none";
    if(isset($_GET['data'])){
        $data = $_GET['data'];
        print_r($data);
    }

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


        //記憶が完了するまで待つ
        while($buffer !== "success"){
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

    if($buffer === "success"){
        //echo "success!!";
    }else{
        //echo $buffer;
    }
    //print_r($buffer);
    //print('<br>');
    //print(gettype($buffer));
    //

?>


<script>
</script>

</body>
</html>
