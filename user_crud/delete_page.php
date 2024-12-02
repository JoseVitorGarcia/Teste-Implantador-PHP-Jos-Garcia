<?php

require '../connection.php';
require '../classes/User.php'; 

$connection = new Connection();
$users = $connection->query("SELECT * FROM users");
$usersClass = new User($connection->getConnection()); 

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $user = $usersClass->getUserById($user_id);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_delete'])) {
    $user_id = $_POST['user_id'];

    if ($usersClass->deleteUser($user_id)) {
        header("Location: menu_page.php");
        exit;
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

        <?php if (isset($user)): ?>
           
            <p>Detalhes do Usuário</p>
            <ul>
                <li><strong>ID:</strong> <?= htmlspecialchars($user_id); ?></li>
                <li><strong>Nome:</strong> <?= htmlspecialchars($user['name']); ?></li>
                <li><strong>Email:</strong> <?= htmlspecialchars($user['email']); ?></li>
            </ul>
            <form method="POST">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id); ?>">
                <button type="submit" name="confirm_delete" class="button">Excluir Usuário</button>
            </form>
            <a href="menu_page.php">
                <button class="button">Voltar ao Menu</button>
            </a>
        <?php else: ?>
            
            <p>Lista de Usuários para remoção</p>
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
                    <?php foreach ($users as $user): ?>
                        <tr class="user-row">
                            <td class="user-id"><?= htmlspecialchars($user->id); ?></td>
                            <td class="user-name"><?= htmlspecialchars($user->name); ?></td>
                            <td class="user-email"><?= htmlspecialchars($user->email); ?></td>
                            <td class="user-actions">
                                <a href="?id=<?= htmlspecialchars($user->id); ?>">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="menu_page.php">
                <button class="button">Voltar ao Menu</button>
            </a>
        <?php endif; ?>

    </div>

</body>

</html>
