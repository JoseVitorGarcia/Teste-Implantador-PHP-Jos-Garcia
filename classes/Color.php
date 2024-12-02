<?php

class Color
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function addHexColorsDefault()
    {
        try {
            
            $stmt = $this->conn->prepare("PRAGMA table_info(colors);");
            $stmt->execute();
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

           
            $columnExists = false;
            foreach ($columns as $column) {
                if ($column['name'] === 'hex') {
                    $columnExists = true;
                    break;
                }
            }

           
            if (!$columnExists) {
                $stmt = $this->conn->prepare("ALTER TABLE colors ADD COLUMN hex VARCHAR(100) NOT NULL DEFAULT '#FFFFFF';");
                $stmt->execute();
            }

          
            $updateStmt = $this->conn->prepare("UPDATE colors
            SET hex = CASE
                WHEN name = 'Blue' THEN '#0000FF'
                WHEN name = 'Red' THEN '#FF0000'
                WHEN name = 'Yellow' THEN '#FFFF00'
                WHEN name = 'Green' THEN '#008000'
                ELSE hex 
            END;");
            $updateStmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Erro ao adicionar a coluna ou atualizar valores: " . $e->getMessage();
            return false;
        }
    }


    public function getColorById($color_id)
    {
        try {
            $stmt = $this->conn->prepare("SELECT name, hex FROM colors WHERE id = :id");
            $stmt->bindParam(':id', $color_id, PDO::PARAM_INT);
            $stmt->execute();
            $color= $stmt->fetch(PDO::FETCH_ASSOC);
           
            return $color;
        } catch (PDOException $e) {
            echo "Erro ao buscar usuário: " . $e->getMessage();
            return false;
        }
    }

    public function insertColor($color_name, $color_hex)
    {
        try {
            $query = "INSERT INTO colors (name, hex) VALUES (:name, :hex)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', $color_name, PDO::PARAM_STR);
            $stmt->bindParam(':hex', $color_hex, PDO::PARAM_STR);

            
            if ($stmt->execute()) {
                return true; 
            }
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o usuário: " . $e->getMessage();
            return false;
        }
    }

    public function updateColor($color_id, $color_name, $color_hex)
    {
        try {
            $query = "UPDATE colors SET name = :name, hex = :hex WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':name', $color_name, PDO::PARAM_STR);
            $stmt->bindParam(':hex', $color_hex, PDO::PARAM_STR);
            $stmt->bindParam(':id', $color_id, PDO::PARAM_INT);

          
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


    public function deleteColor($color_id)
    {
        try {


            $query = "DELETE FROM colors WHERE id = :id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $color_id, PDO::PARAM_INT);



            if ($stmt->execute()) {
                return true;
                
            }

            $stmt = $this->conn->prepare("DELETE FROM user_colors WHERE color_id = :id");
            $stmt->bindParam(':id', $color_id, PDO::PARAM_STR);
            $stmt->execute();

        } catch (PDOException $e) {
            echo "Erro ao cadastrar o usuário: " . $e->getMessage();
            return false;
        }
    }

    public function insertColorToUser($user_id, $color_id)
    {
        try {
            $query = "INSERT INTO user_colors (user_id, color_id) VALUES (:user_id, :color_id)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':color_id', $color_id, PDO::PARAM_STR);

            
            if ($stmt->execute()) {
                return true; 
            }
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o usuário: " . $e->getMessage();
            return false;
        }
    }


    public function deleteColorToUser($user_id, $color_id)
    {
        try {
            $query = "DELETE FROM user_colors WHERE color_id = :color_id AND user_id = :user_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
            $stmt->bindParam(':color_id', $color_id, PDO::PARAM_STR);



           
            if ($stmt->execute()) {
                return true;
                
            }
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o usuário: " . $e->getMessage();
            return false;
        }
    }


}