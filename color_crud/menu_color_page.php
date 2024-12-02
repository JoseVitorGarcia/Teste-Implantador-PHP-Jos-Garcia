<?php

require '../connection.php';
require '../classes/Color.php';  

$connection = new Connection();

$usersClass = new Color($connection->getConnection());  

$usersClass->addHexColorsDefault()

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste VersoTech</title>

  
    <link rel="stylesheet" href="../style.css">
</head>

<body>

    <div class="menu-container">

        <p>Menu de Cores</p>
        <div class="buttons-container">
            <a href="insert_color_page.php">
                <button class="button">Cadastrar</button>
            </a>
            <a href="list_color_page.php">
                <button class="button">Listar</button>
            </a>
            <a href="update_color_page.php">
                <button class="button">Atualizar</button>
            </a>
            <a href="delete_color_page.php">
                <button class="button">Remover</button>
            </a>
            <a href="../index.php">
                <button class="button">Voltar ao Menu Inicial</button>
            </a>

        </div>

      



    </div>

</body>

</html>