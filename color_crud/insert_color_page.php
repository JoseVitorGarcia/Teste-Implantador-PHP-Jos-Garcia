<?php

require '../connection.php';  
require '../classes/Color.php'; 

$connection = new Connection();
$usersClass = new Color($connection->getConnection()); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $color_name = $_POST['color_name'] ?? null;
    $color_hex = $_POST['color_hex'] ?? null;

  
    if (!empty($color_name) && !empty($color_hex)) {
        if ($usersClass->insertColor($color_name, $color_hex)) {
            header("Location: menu_color_page.php");
            exit; 
        } else {
            echo "Erro ao cadastrar o usuário.";
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}

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

    <div class="container">
        <p>Cadastro de cor</p>
        <div class="wrapper">
            <form action="insert_color_page.php" method="POST">
                <input type="text" id="color_name" name="color_name" class="input-field" placeholder="Nome da Cor" required>
                
                
                 <p>Escolha sua cor aqui: </p>
                <input type="color" id="color_hex" name="color_hex" class="input-field" value="#000000" required style="width: 30%; height: 50px">

                <button class="button">Cadastrar</button>
            </form>
            <a href="menu_color_page.php">
                <button class="button">Voltar ao Menu</button>
            </a>
        </div>
    </div>

</body>

</html>
