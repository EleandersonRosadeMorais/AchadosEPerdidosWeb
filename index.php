<?php 
require __DIR__.'../achadoseperdidosweb/api_composer/vendor/autoload.php';
use Kreait\Firebase\Factory;

$factory = (new Factory())->withDatabaseUri('');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
body{
    background-color: #f8f8ec;
    margin: 0;
}


</style>

<body>

<?php
    include 'templates/cabecalho.php';
    ?>



 

    
</body>
</html>