<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Administrador</title>
     <link rel="stylesheet" href="style.css">
</head>
<body>


<div class="box2">



    <form method="POST">

        <h1>Registrar administrador</h1>

        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>
        
        <br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>

        <br><br>

        <label for="cpf">Cpf:</label>
        <input type="text" name="cpf" required>

        <br><br>

        <input type="submit" value="Registrar">

        <a href="adm/gerenciar_itens.php" class="btn-voltar2">Retornar</a>

    </form>
    </div>
    
</body>
</html>