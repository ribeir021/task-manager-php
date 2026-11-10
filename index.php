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

<h2>Minhas Tarefas</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Título</th>
        <th>Prioridade</th>
        <th>Prazo</th>
        <th>Status</th>
    </tr>

    <?php foreach ($lista_tarefas as $tarefa): ?>
        <tr>
            <td><?php echo $tarefa['titulo']; ?></td>
            
            <td><?php echo $tarefa['prioridade']; ?></td>
            
            <td><?php echo $tarefa['prazo']; ?></td>
            
            <td><?php echo $tarefa['status']; ?></td>

            <td><a href="excluir.php?id=<?php echo $tarefa['id']; ?>">Excluir</a></td>
            <td><a href="editar.php?id=<?php echo $tarefa['id']; ?>">Editar</a></td>
 
        </tr>
    <?php endforeach; ?>
</table>