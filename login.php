<!DOCTYPE html>
<html>


<head>
    <title>Logar</title>
     <link rel="stylesheet" href="style.css">

     <style>

body{
         font-family: Arial, sans-serif;
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            line-height: 1.6;
    }

     h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }


     input[type="email"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        text-align: center;
        box-sizing: border-box;
        margin-bottom: 20px;
    }

     input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        text-align: center;
        box-sizing: border-box;
        margin-bottom: 20px;
    }

        input[type="submit"] {
            background-color: #02416D;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #013354ff;
        }

        .mensagem{
             color: #ff0d00ff;
        }

     </style>
  
</head>


<body>


    <div class="container">


        <div class="box">
            <h1>Fazer login</h1>


            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" required>

                <br><br>

                <label for="senha">Senha:</label>
                <input type="password" name="senha" required>

                <br><br>

                <input type="submit" name="login" value="Login">
            </form>

            <div class="mensagem">
                <?php  if (isset($mensagem_erro)) echo '<p>' . $mensagem_erro . '</p>'; ?>
            </div>
    <!--    -->
        </div>
        



</body>
</html>