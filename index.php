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
      <form class="login-form">
        <input type="text" placeholder="username" name="username"/>
        <input type="password" placeholder="password" name="password"/>
        <button type="button" id="btn">login</button>
      </form>
    </div>
  </div>

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