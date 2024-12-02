<?php

require '../connection.php';
require '../classes/User.php';  

$connection = new Connection();
$users = $connection->query("SELECT * FROM users");

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

        <p>Lista de Usuários</p>

        <table>
            <thead>
                <tr>
                    <th class="user-id">ID</th>
                    <th class="user-name">Nome</th>
                    <th class="user-email">Email</th>
                    <th class="user-actions">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                foreach ($users as $user) {
                    echo sprintf(
                        "<tr class='user-row'>
                            <td class='user-id'>%s</td>
                            <td class='user-name'>%s</td>
                            <td class='user-email'>%s</td>
                            <td class='user-actions'>
                                <a href='attach_color_page.php?id=%s'>Cores Vinculadas</a>
                                <a href='update_page.php?id=%s'>Editar</a>
                                <a href='delete_page.php?id=%s'>Excluir</a>
                            </td>
                        </tr>",
                        $user->id,
                        $user->name,
                        $user->email,
                        $user->id,
                        $user->id,
                        $user->id,
                    );
                }
                ?>
            </tbody>
        </table>
        <a href="menu_page.php">
            <button class="button">Voltar ao Menu</button>
        </a>
    </div>

</body>

</html>