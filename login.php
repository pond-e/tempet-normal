<?php

require_once __DIR__ . '/session_auth.php';
require_unlogined_session();

// 事前に生成したユーザごとのパスワードハッシュの配列
$hashes = [
    'admin' => '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918',
];

// ユーザから受け取ったユーザ名とパスワード
$username = filter_input(INPUT_POST, 'username');
$password = filter_input(INPUT_POST, 'password');

// POSTメソッドのときのみ実行
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        validate_token(filter_input(INPUT_POST, 'token')) &&
        hash('sha256', $username) === $hashes[$password]
    ) {
        // 認証が成功したとき
        // セッションIDの追跡を防ぐ
        session_regenerate_id(true);
        // ユーザ名をセット
        $_SESSION['username'] = $username;
        // ログイン完了後に / に遷移
        header('Location: /');
        exit;
    }
    // 認証が失敗したとき
    // 「403 Forbidden」
    http_response_code(403);
}

header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link href="styles/login.css" rel="stylesheet">
    <title>Temペット Login</title>
</head>

<body>
    
  <div class="login-page">
    <div class="form">
      <form method="post" class="login-form" action="">
        <input type="text" placeholder="username" name="username"/>
        <input type="password" placeholder="password" name="password"/>
        <input type="hidden" name="token" value="<?=h(generate_token())?>">
        <button type="submit" id="btn">login</button>
      </form>
    </div>
  </div>
  <?php if (http_response_code() === 403): ?>
  <p style="color: red;">ユーザ名またはパスワードが違います</p>
  <?php endif; ?>

  <script>
      function btnClick(){
          location.href = `./start.php?username=${username[0].value}&password=${password[0].value}`;
      }

      const username = document.getElementsByName("username");
      const password = document.getElementsByName("password");
        
      const login_button = document.getElementById('btn');
      login_button.onclick = btnClick;
  </script>

</body>
</html>