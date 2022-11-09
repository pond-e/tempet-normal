<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link href="styles/style.css" rel="stylesheet">
    <title>Temペット Login</title>
</head>

<body>
    <input type="text" name="username"><br>
    <input type="text" name="password"><br>
    <button type="button" id="btn">ログイン</button>

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