<!DOCTYPE html>
<html>


<head>
    <title>Logar</title>
    <link rel="stylesheet" href="style.css">




</head>


<body>


    <div class="box">


        <form method="POST">

            <h1>Fazer login</h1>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <br><br>

            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>

            <br><br>

            <input type="submit" name="login" value="Login">
        </form>

        <div class="mensagem">
            <?php if (isset($mensagem_erro)) echo '<p>' . $mensagem_erro . '</p>'; ?>
        </div>

    </div>


</body>

</html>