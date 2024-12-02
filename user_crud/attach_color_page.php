<?php
require '../connection.php'; 
require '../classes/Color.php'; 
require '../classes/User.php'; 

$connection = new Connection();
$usersClass = new Color($connection->getConnection());
$userClass = new User($connection->getConnection());

$users = $connection->query("SELECT * FROM colors");

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $user = $userClass->getUserById($user_id);

    if (!$user) {
        echo "Usuário não encontrado.";
        exit;
    }

   
    $query = "SELECT color_id FROM user_colors WHERE user_id = :user_id";
    $stmt = $connection->getConnection()->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $colorsN = [];

    
    $userColors = $stmt->fetchAll(PDO::FETCH_ASSOC);


    foreach ($userColors as $value) {
        
        $color = $usersClass->getColorById($value['color_id']);

        
        if ($color) {
            $colorsN[] = $color; 
        }
    }


}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_attach'])) {
    $color_id = $_POST['color'];

   
    if ($usersClass->insertColorToUser($user_id, $color_id)) {
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
    <title>Seleção de Cores</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .color-box {
            width: 30px;
            height: 30px;
            display: inline-block;
            margin: 5px;
            border: 1px solid #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="attach_color_page.php?id=<?= htmlspecialchars($user_id); ?>" method="POST">
            <label for="colors">Escolha uma cor para adicionar ao usuário
                <?= htmlspecialchars($user['name']); ?>:</label>
            <select id="colors" name="color" class="input-color">
                <?php foreach ($users as $color): ?>
                    <option value="<?= htmlspecialchars($color->id); ?>">
                        <?= htmlspecialchars($color->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <h3>Usuário <?= htmlspecialchars($user['name']); ?> já possui as cores:</h3>
            <?php if (isset($colorsN) && count($colorsN) > 0): ?>
                <div>
                  
                    <?php foreach ($colorsN as $userColor): ?>
                        <div
                            style="width: 30px; height: 30px; background-color: <?= htmlspecialchars($userColor['hex']); ?>; display: inline-block; margin: 5px;">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>Usuário ainda não possui cores associadas.</p>
            <?php endif; ?>




            <form method="POST">
                <input type="hidden" name="color_id" value="<?= htmlspecialchars($color_id); ?>">
                <button type="submit" name="confirm_attach" class="button">Atualizar</button>
            </form>

            <div style="width: 100%;">

                <a href="unattach_color_page.php?id=<?= htmlspecialchars($user_id); ?>" style="width:100%">
                    <button class="button">Desvincular cores</button>
                </a>
                <a href="menu_page.php" style="width:100%">
                    <button class="button">Voltar ao Menu</button>
                </a>
            </div>
        </form>


    </div>
</body>

</html>