<?php
    $data = "none";
    if(isset($_POST['data'])){
        $data = $_POST['data'];
    }
    if($data !== "none"){
        $Raspi_state_file = 'Raspi_bme.txt';

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