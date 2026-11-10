<?php
require 'conexao.php';

try {
    $sql = "SELECT * FROM tarefas";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $lista_tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $erro) {
    echo "Erro ao buscar tarefas: " . $erro->getMessage();
}
?>

<!-- HTML "feio" apenas para estruturarmos a lógica (sua colega vai embelezar depois) -->
<h2>Minhas Tarefas</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Título</th>
        <th>Prioridade</th>
        <th>Prazo</th>
        <th>Status</th>
    </tr>
    
    <!-- O PHP começa a repetir as linhas da tabela aqui -->
    <?php foreach ($lista_tarefas as $tarefa): ?>
        <tr>
            <!-- Imprimimos o valor da coluna 'titulo' -->
            <td><?php echo $tarefa['titulo']; ?></td>
            
            <td><?php echo $tarefa['prioridade']; ?></td>
            
            <td><?php echo $tarefa['prazo']; ?></td>
            
            <!-- Imprimimos o valor da coluna 'status' -->
            <td><?php echo $tarefa['status']; ?></td>
        </tr>
    <?php endforeach; ?>
    <!-- O PHP termina a repetição aqui -->
</table>