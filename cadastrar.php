<?php
require 'conexao.php';

// O if verifica se o usuário realmente clicou no botão do formulário (método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Pegando os dados dinâmicos do formulário em vez de usar texto fixo:
    $titulo_form = $_POST['titulo'];
    
    $prioridade_form = $_POST['prioridade'];
    
    $prazo_form = $_POST['prazo'];
    

    try {
        $sql = "INSERT INTO tarefas (titulo, prioridade, prazo) VALUES (:titulo, :prioridade, :prazo)";
        $stmt = $conexao->prepare($sql);
        
        $stmt->bindParam(':titulo', $titulo_form);
        $stmt->bindParam(':prioridade', $prioridade_form);
        $stmt->bindParam(':prazo', $prazo_form);
        
        $stmt->execute();
        
        echo "<p style='color: green;'>Tarefa cadastrada com sucesso pelo formulário!</p>";
        
    } catch (PDOException $erro) {
        echo "<p style='color: red;'>Erro ao cadastrar: " . $erro->getMessage() . "</p>";
    }
}
?>

<!-- Formulário HTML "feio mas funcional" para testar o seu backend -->
<form method="POST" action="cadastrar.php">
    <label>Título:</label>
    <input type="text" name="titulo" required><br><br>
    
    <label>Prioridade:</label>
    <select name="prioridade">
        <option value="Baixa">Baixa</option>
        <option value="Média">Média</option>
        <option value="Alta">Alta</option>
    </select><br><br>
    
    <label>Prazo:</label>
    <input type="date" name="prazo" required><br><br>
    
    <button type="submit">Salvar Tarefa Dinâmica</button>
</form>