<?php

class User
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

   
    public function getUserById($user_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT name, email FROM users WHERE id = :id");
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); 
        } catch (PDOException $e) {
            echo "Erro ao buscar usuário: " . $e->getMessage();
            return false;
        }
    }

    public function getAllUsers()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users");

            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            echo "Erro ao buscar usuário: " . $e->getMessage();
            return false;
        }
    }

    public function insertUser($user_name, $user_email)
    {
        try {


            $query = "INSERT INTO users (name, email) VALUES (:name, :email)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);


           
            if ($stmt->execute()) {
                return true;
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o usuário: " . $e->getMessage();
            return false;
        }
    }




    public function deleteUser($user_id)
    {
        try {


            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $user_id, PDO::PARAM_STR);



            
            if ($stmt->execute()) {
                return true;;
            }
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o usuário: " . $e->getMessage();
            return false;
        }
    }



    public function updateUser($user_id, $user_name, $user_email)
    {
        try {
            $query = "UPDATE users SET name = :name, email = :email WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', $user_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $user_email, PDO::PARAM_STR);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

            
            if ($stmt->execute()) {
                return true;
            } else {
                return false; 
            }
        } catch (PDOException $e) {
            echo "Erro ao atualizar o usuário: " . $e->getMessage();
            return false;
        }
    }
}

?>