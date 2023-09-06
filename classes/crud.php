<?php

include_once('conexao/conexao.php');

$db = new Database();

class Series{
    private $conn;
    private $table_name = "series";

    public function __construct($db){
        $this->conn = $db;
    }

        // Função para criar um registro de série com base nos valores fornecidos
    public function create($postValues){
        $nome = $postValues['nome'];
        $genero = $postValues['genero'];
        $temporadas = $postValues['temporadas'];
        $episodios = $postValues['episodios']; 
        $ano = $postValues['ano'];
        
        // Verifique se os campos estão preenchido corretamente para executar
        if (empty($nome) || empty($genero) || empty($temporadas) || empty($episodios) || empty($ano)) {
            return false;
        }
    
        // Resto do código para inserir esses valores no banco de dados

        $query = "INSERT INTO ". $this->table_name. " (nome, genero, temporadas, episodios, ano) VALUES(?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $genero);
        $stmt->bindParam(3, $temporadas);
        $stmt->bindParam(4, $episodios);
        $stmt->bindParam(5, $ano);

        $stmt->execute(); // Execute a inserção aqui

        if ($stmt->rowCount() > 0) {
            // Inserção sucedida
            return true;
        } else {
            // Inserção mal-sucedida
            return false;
        }
    
    }

    

    //função para ler os registros
    public function read(){
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    //funcao atualizar os registros
    public function update($postValues){
        $id = $postValues['id'];
        $nome = $postValues['nome'];
        $genero = $postValues['genero'];
        $temporadas = $postValues['temporadas'];
        $episodios = $postValues['episodios'];
        $ano = $postValues['ano'];

        // Verifique se os campos estão preenchido corretamente para executar
        if (empty($id) || empty($nome) || empty($genero) || empty($temporadas) || empty($episodios) || empty($ano)) {
            return false;
        }

        $query = "UPDATE " . $this->table_name . " SET nome = ?, genero = ?, temporadas = ?, episodios = ?, ano = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $genero);
        $stmt->bindParam(3, $temporadas);
        $stmt->bindParam(4, $episodios);
        $stmt->bindParam(5, $ano);
        $stmt->bindParam(6, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Construir a consulta no SQL
    public function readOne($id){
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Construir a consulta SQL de "deletar""
    public function delete($id){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


}
?>
