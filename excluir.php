<?php
require 'conexao.php';

// Pega o ID que veio na URL
$id_tarefa = $_GET['id'];

try {
    // O comando SQL com o apelido de segurança (:id)
    $sql = "DELETE FROM tarefas WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    
    $stmt->bindParam(':id', $id_tarefa);
    $stmt->execute();
    
    header("Location: index.php");
    
} catch (PDOException $erro) {
    echo "Erro ao excluir: " . $erro->getMessage();
}
?>