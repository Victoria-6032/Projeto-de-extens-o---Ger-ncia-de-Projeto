<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faça seu Login</title>
    <link rel="stylesheet" href="CSS/login.css">
    <script src="/JS/script.js" defer></script>
</head>
<body>




    <div class="container">
        <h1>Login</h1>
        <form action="testeLogin.php" method="post">
            <label for="username">Usuário:</label>
            <input type="text" class="username" id="username" name="username" required placeholder="Digite aqui seu Usuário">
            
            <label for="password">Senha:</label>
            <input type="password" class="password" id="password" name="password" required placeholder="Digite aqui sua Senha">
            
            <input class="input-submit" type="submit" name="submit"></input>
        </form>
        
    </div>
</body>
</html>