<?php
require 'conexao.php';

// Atualiza os dados quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $prioridade = $_POST['prioridade'];
    $status = $_POST['status'];
    $prazo = $_POST['prazo'];

    try {
        $sql = "UPDATE tarefas SET titulo = :titulo, descricao = :descricao, prioridade = :prioridade, prazo = :prazo, status = :status WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':prioridade', $prioridade);
        $stmt->bindParam(':prazo', $prazo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        
        $stmt->execute();
        
        header("Location: index.php");
        exit;
    } catch (PDOException $erro) {
        echo "<script>alert('Erro ao atualizar tarefa.');</script>";
    }
} 
// Carrega os dados da tarefa selecionada ao abrir a página
else {
    $id_url = $_GET['id'];
    try {
        $sql = "SELECT * FROM tarefas WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id_url);
        $stmt->execute();
        $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $erro) {
        echo "Erro ao buscar tarefa.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa - Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topo">
        <div class="logo">
            <span>✓</span> Gerenciador de Tarefas
        </div>
        <nav class="menu">
            <a href="index.php" class="link-menu">Minhas tarefas</a>
            <a href="cadastrar.php" class="btn-novo">+ Nova tarefa</a>
        </nav>
    </header>

    <main class="container">
        <h1 class="titulo-pagina">Editar Tarefa</h1>

        <div class="caixa-form">
            <form action="editar.php" method="POST" id="form-cadastro" novalidate>
                
                <input type="hidden" name="id" value="<?php echo $tarefa['id']; ?>">

                <div class="campo-grupo">
                    <label for="titulo">Título da Tarefa *</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo $tarefa['titulo']; ?>" required>
                </div>

                <div class="campo-grupo">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4" maxlength="500"><?php echo $tarefa['descricao']; ?></textarea>
                </div>

                <div class="grid-form-2col">
                    <div class="campo-grupo">
                        <label for="prioridade">Prioridade *</label>
                        <select id="prioridade" name="prioridade" required>
                            <option value="Baixa" <?php echo ($tarefa['prioridade'] == 'Baixa') ? 'selected' : ''; ?>>Baixa</option>
                            <option value="Média" <?php echo ($tarefa['prioridade'] == 'Média') ? 'selected' : ''; ?>>Média</option>
                            <option value="Alta" <?php echo ($tarefa['prioridade'] == 'Alta') ? 'selected' : ''; ?>>Alta</option>
                        </select>
                    </div>

                    <div class="campo-grupo">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="Pendente" <?php echo ($tarefa['status'] == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                            <option value="Em andamento" <?php echo ($tarefa['status'] == 'Em andamento') ? 'selected' : ''; ?>>Em andamento</option>
                            <option value="Concluída" <?php echo ($tarefa['status'] == 'Concluída') ? 'selected' : ''; ?>>Concluída</option>
                        </select>
                    </div>
                </div>

                <div class="campo-grupo">
                    <label for="prazo">Data de Prazo</label>
                    <input type="date" id="prazo" name="prazo" value="<?php echo $tarefa['prazo']; ?>" required>
                </div>

                <div class="botoes-form">
                    <a href="index.php" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-salvar">Salvar Alterações</button>
                </div>
            </form>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>