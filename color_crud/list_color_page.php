<?php

require '../connection.php';
require '../classes/User.php'; 

$connection = new Connection();
$users = $connection->query("SELECT * FROM colors");


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

        <p>Lista de Cores</p>

        <table>
            <thead>
                <tr>
                    <th class="user-id">ID</th>
                    <th class="user-name">Nome</th>
                    <th class="user-email">Cor</th>
                    <th class="user-actions">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
               
                foreach ($users as $color) {
                    echo sprintf(
                        "<tr class='user-row'>
                            <td class='user-id'>%s</td>
                            <td class='user-name'>%s</td>
                            <td class='user-email'>
                            <div style='width: 30px; height: 30px; background-color: %s; border: 1px solid'></div>

                            
                            </td>
                            <td class='user-actions'>
                                
                                <a href='update_color_page.php?id=%s'>Editar</a>
                                <a href='delete_color_page.php?id=%s'>Excluir</a>
                            </td>
                        </tr>",
                        $color->id,
                        $color->name,
                        $color->hex,
                        $color->id,
                        $color->id,
                    );
                }
                ?>
            </tbody>
        </table>
        <a href="menu_color_page.php">
            <button class="button">Voltar ao Menu</button>
        </a>
    </div>

</body>

</html>