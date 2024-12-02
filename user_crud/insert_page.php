<?php

require '../connection.php';  
require '../classes/User.php'; 

$connection = new Connection();
$usersClass = new User($connection->getConnection()); 


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $user_name = $_POST['user_name'] ?? null;
    $user_email = $_POST['user_email'] ?? null;

  
    if (!empty($user_name) && !empty($user_email)) {
        if ($usersClass->insertUser( $user_name, $user_email)) {
            header("Location: menu_page.php");
            exit; 
        } 
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
        <p>Cadastro de usuário</p>
        <div class="wrapper">
            <form action="insert_page.php" method="POST">
                <input type="text" id="user_name" name="user_name" class="input-field" placeholder="Nome">


                <input type="text" id="user_email" name="user_email" class="input-field" placeholder="E-mail">

                <button class="button">Cadastrar</button>
            </form>
            <a href="menu_page.php">
                <button class="button">Voltar ao Menu</button>
            </a>
        </div>
    </div>

</body>

</html>