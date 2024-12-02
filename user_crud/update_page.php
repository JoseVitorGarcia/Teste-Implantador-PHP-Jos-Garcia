<?php

require '../connection.php';  
require '../classes/User.php';  
$connection = new Connection();
$users = $connection->query("SELECT * FROM users");
$usersClass = new User($connection->getConnection());  


if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
  
   
    $user = $usersClass->getUserById($user_id);
  
  
    if (!$user) {
        echo "Usuário não encontrado.";
        exit;
    }
} 

if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST['confirm_update'])) {
    $user_name = $_POST['user_name'] ?? null;
    $user_email = $_POST['user_email'] ?? null;

    
    if (!empty($user_name) && !empty($user_email)) {
        
        if ($usersClass->updateUser($user_id, $user_name, $user_email)) {
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
        <p>Atualização de Usuário</p>
        <div class="wrapper">


        <?php if (isset($user)): ?>
            
            <p>Detalhes do Usuário</p>
            <form action="update_page.php?id=<?php echo $user_id; ?>" method="POST">
                <input type="text" id="user_name" name="user_name" class="input-field" placeholder="Nome" value="<?php echo htmlspecialchars($user['name']); ?>">

                <input type="text" id="user_email" name="user_email" class="input-field" placeholder="E-mail" value="<?php echo htmlspecialchars($user['email']); ?>">

                <button class="button"  name="confirm_update">Atualizar</button>
            </form>
            <a href="menu_page.php">
                <button class="button">Voltar ao Menu</button>
            </a>
         
        <?php else: ?>
            
            <p>Lista de Usuários para atualização</p>
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
                                <a href="?id=<?= htmlspecialchars($user->id); ?>">Atualizar</a>
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
    </div>
</body>

</html>
