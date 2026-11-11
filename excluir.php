<?php
require 'conexao.php';

// Remove a tarefa com base no ID recebido via URL
$id_tarefa = $_GET['id'];

try {
    $sql = "DELETE FROM tarefas WHERE id = :id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id_tarefa);
    $stmt->execute();
    
    header("Location: index.php");
    exit;
} catch (PDOException $erro) {
    echo "Erro ao excluir: " . $erro->getMessage();
}
?>