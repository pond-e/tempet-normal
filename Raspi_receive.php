<?php
    $data = "none";
    if(isset($_POST['state'])){
        $data = $_POST['state'];
    }
    if($data !== "none"){
        $db = new SQLite3('./tempet.db');
        $stmt = $db->prepare('UPDATE user_info SET receive=:data');
        $stmt->bindValue(':data', $data, SQLITE3_TEXT);
        $result = $stmt->execute();
        $db->close();
        $data = "none";
    }
?>