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
<title>Temペット ペットの選択</title>
</head>
<body>

<h1>ペットの選択</h1>
<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
<div class="example2"><!-- ToDo:他人がこのアドレスにPOSTしても何もできないようにする -->
    <input type="checkbox" id="1" name="select_pet[]" value="dog"><label for="1">犬</label>
    <input type="checkbox" id="2" name="select_pet[]" value="cat"><label for="2">猫</label>
    <input type="checkbox" id="3" name="select_pet[]" value="bird"><label for="3">鳥</label>
    <input type="checkbox" id="4" name="select_pet[]" value="rabbit"><label for="4">兎</label>
</div>
<div class="submit_button_parent"><input type="submit" value="保存" id="save" class="submit_button"></div>
</form>

<a href="index.php" class="btn btn--orange">Homeへ</a>

<?php
    $dog = false;
    $cat = false;
    $bird = false;
    $rabbit = false;

    if (isset($_POST['select_pet']) && is_array($_POST['select_pet'])) {
        $select_pet = $_POST['select_pet'];

        $data = "";
        for($i = 0; $i < count($select_pet); $i++){
            $data .= $select_pet[$i];
        }

        $db = new SQLite3('./tempet.db');
        $stmt = $db->prepare('UPDATE user_info SET selected_pet=:data');
        $stmt->bindValue(':data', $data, SQLITE3_TEXT);
        $result = $stmt->execute();
        $db->close();

        for($i=0; $i<count($select_pet); $i++){
            if($select_pet[$i] === "dog"){
                $dog = true;
            }else if($select_pet[$i] === "cat"){
                $cat = true;
            }else if($select_pet[$i] === "bird"){
                $bird = true;
            }else if($select_pet[$i] === "rabbit"){
                $rabbit = true;
            }
        }
    }
?>

<?php
    //ペットが選んであるときのみ表示
    if($dog || $cat || $bird || $rabbit){
        print('<a href="remember_remote_controller.php" class="btn btn--orange">次へ進む</a>');
    }
?>
</div>

<script>
</script>

</body>
</html>
