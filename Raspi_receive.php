<?php
    $data = "none";
    if(isset($_POST['state'])){
        $data = $_POST['state'];
    }
    if($data !== "none"){
        $Raspi_state_file = 'Raspi_receive.txt';

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
?>