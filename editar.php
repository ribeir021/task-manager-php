<?php
require 'conexao.php';

// PARTE 1: O MOTOR DE SALVAR (Se o formulário foi enviado via POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_form = $_POST['id'];
    $titulo_form = $_POST['titulo'];
    $prioridade_form = $_POST['prioridade'];
    $prazo_form = $_POST['prazo'];
    $status_form = $_POST['status'];

    try {
        $sql = "UPDATE tarefas SET titulo = :titulo, prioridade = :prioridade, prazo = :prazo, status = :status WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        
        $stmt->bindParam(':titulo', $titulo_form);
        $stmt->bindParam(':prioridade', $prioridade_form);
        $stmt->bindParam(':prazo', $prazo_form);
        $stmt->bindParam(':status', $status_form);
        $stmt->bindParam(':id', $id_form);
        
        $stmt->execute();
        header("Location: index.php");
        exit; // Para a execução aqui para garantir o redirecionamento
    } catch (PDOException $erro) {
        echo "Erro ao atualizar: " . $erro->getMessage();
    }
} 
// PARTE 2: O MOTOR DE CARREGAR (Se o usuário apenas acessou a página via GET)
else {
    $id_url = $_GET['id'];
    
    try {
        $sql = "SELECT * FROM tarefas WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id_url);
        $stmt->execute();
        
        // Em vez de fetchAll (que traz uma lista), usamos fetch() porque é só UMA tarefa
        $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);
        
    } catch (PDOException $erro) {
        echo "Erro ao buscar a tarefa: " . $erro->getMessage();
    }
}
?>

<!-- PARTE 3: O FORMULÁRIO PRÉ-PREENCHIDO -->
<h2>Editar Tarefa</h2>
<form method="POST" action="editar.php">
    <!-- Campo oculto (hidden) para enviar o ID sem o usuário ver/alterar -->
    <input type="hidden" name="id" value="<?php echo $tarefa['id']; ?>">
    
    <label>Título:</label>
    <input type="text" name="titulo" value="<?php echo $tarefa['titulo']; ?>"><br><br>
    
    <label>Prioridade (Digite: Baixa, Média ou Alta):</label>
    <!-- ESCREVA AQUI: Coloque o atributo value com o PHP para imprimir a prioridade -->
    <input type="text" name="prioridade" value="<?php echo $tarefa['prioridade']; ?>"><br><br>
    
    <label>Prazo:</label>
    <!-- ESCREVA AQUI: Coloque o atributo value com o PHP para imprimir o prazo -->
    <input type="date" name="prazo" value="<?php echo $tarefa['prazo']; ?>"><br><br>

    <label>Status (Digite: Pendente ou Concluída):</label>
    <!-- ESCREVA AQUI: Coloque o atributo value com o PHP para imprimir o status -->
    <input type="text" name="status" value="<?php echo $tarefa['status']; ?>"><br><br>
    
    <button type="submit">Salvar Alterações</button>
</form>