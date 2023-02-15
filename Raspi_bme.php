<?php
    $data = "none";
    if(isset($_POST['data'])){
        $data = $_POST['data'];
    }
    if($data !== "none"){
        $db = new SQLite3('./tempet.db');
        $stmt = $db->prepare('UPDATE user_info SET temperature=:data');
        $stmt->bindValue(':data', $data, SQLITE3_TEXT);
        $result = $stmt->execute();
        $db->close();
        $data = "none";
    }
?>