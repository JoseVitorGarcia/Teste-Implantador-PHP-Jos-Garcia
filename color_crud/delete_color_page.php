<?php

require '../connection.php';
require '../classes/Color.php'; 

$connection = new Connection();
$users = $connection->query("SELECT * FROM colors");
$usersClass = new Color($connection->getConnection()); 

if (isset($_GET['id'])) {
    $color_id = $_GET['id'];
    $color = $usersClass->getColorById($color_id); 
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    $color_id = $_POST['color_id']; 

    if ($usersClass->deleteColor($color_id)) {
        header("Location: menu_color_page.php");
        exit;
    } else {
        echo "Erro ao excluir a cor.";
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

        <?php if (isset($color)): ?>
           
            <p>Detalhes da Cor</p>
            <table>
                <thead>
                    <tr>
                        <th class="user-id">ID</th>
                        <th class="user-name">Nome</th>
                        <th class="user-color">Cor</th>
                        <th class="user-actions">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="user-row">
                        <td class="user-id"><?= htmlspecialchars($color_id); ?></td>
                        <td class="user-name"><?= htmlspecialchars($color['name']); ?></td>
                        <td class="user-color">
                            <div
                                style="width: 30px; height: 30px; background-color: <?= htmlspecialchars($color['hex']); ?>; border: 1px solid">
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>

           
            <form method="POST">
                <input type="hidden" name="color_id" value="<?= htmlspecialchars($color_id); ?>">
                <button type="submit" name="confirm_delete" class="button">Excluir Cor</button>
            </form>
            <a href="menu_color_page.php">
                <button class="button">Voltar ao Menu</button>
            </a>
        <?php else: ?>
          
            <p>Lista de Cores para remoção</p>
            <table>
                <thead>
                    <tr>
                        <th class="user-id">ID</th>
                        <th class="user-name">Nome</th>
                        <th class="user-color">Cor</th>
                        <th class="user-actions">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $color): ?>
                        <tr class="user-row">
                            <td class="user-id"><?= htmlspecialchars($color->id); ?></td>
                            <td class="user-name"><?= htmlspecialchars($color->name); ?></td>
                            <td class="user-color">
                                <div
                                    style="width: 30px; height: 30px; background-color: <?= htmlspecialchars($color->hex); ?>; border: 1px solid">
                                </div>
                            </td>
                            <td class="user-actions">
                                <a href="?id=<?= htmlspecialchars($color->id); ?>">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="menu_color_page.php">
                <button class="button">Voltar ao Menu</button>
            </a>
        <?php endif; ?>

    </div>

</body>

</html>