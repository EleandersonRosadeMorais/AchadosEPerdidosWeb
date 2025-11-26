<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Header</title>

    <style>
        header {
            overflow: hidden;
            background-color: #02416D;
            padding: 20px 10px;
            color: #ffffff;
            text-align: center;

        }

        header a {
            color: black;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            border-radius: 4px;
            color: #ffffff;
            font-size: 20px;
            font-weight: bold;
        }

        nav {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        header a:hover {
            background-color: #ddd;
            color: black;
        }

      
    </style>

</head>

<body>
    <header>
        <h1>Bem-vindo ao Meu Site</h1>
        <nav>
            <a href="index.php">Início</a>
            <a href="index.php">Gerenciamento</a>
            <a href="index.php">Procurar</a>
            <a href="sobre.php">Sobre</a>
        </nav>
    </header>
    <main>