<?php
require 'conexao.php';

// PARTE 1: SALVAR AS ALTERAÇÕES (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_form = $_POST['id'];
    $titulo_form = $_POST['titulo'];
    $descricao_form = $_POST['descricao'];
    $prioridade_form = $_POST['prioridade'];
    $status_form = $_POST['status'];
    $prazo_form = $_POST['prazo'];

    try {
        // UPDATE atualizado com a coluna descrição nova
        $sql = "UPDATE tarefas SET titulo = :titulo, descricao = :descricao, prioridade = :prioridade, prazo = :prazo, status = :status WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        
        $stmt->bindParam(':titulo', $titulo_form);
        $stmt->bindParam(':descricao', $descricao_form);
        $stmt->bindParam(':prioridade', $prioridade_form);
        $stmt->bindParam(':prazo', $prazo_form);
        $stmt->bindParam(':status', $status_form);
        $stmt->bindParam(':id', $id_form);
        
        $stmt->execute();
        
        // Redireciona de volta para a tela inicial
        header("Location: index.php");
        exit;
    } catch (PDOException $erro) {
        echo "<script>alert('Erro ao atualizar: " . $erro->getMessage() . "');</script>";
    }
} 
// PARTE 2: CARREGAR A TAREFA (GET)
else {
    $id_url = $_GET['id'];
    try {
        $sql = "SELECT * FROM tarefas WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id_url);
        $stmt->execute();
        $tarefa = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $erro) {
        echo "Erro ao buscar a tarefa: " . $erro->getMessage();
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
            <!-- Action aponta para o próprio editar.php -->
            <form action="editar.php" method="POST" id="form-cadastro" novalidate>
                
                <!-- O campo ID oculto é essencial para o UPDATE saber qual tarefa alterar -->
                <input type="hidden" name="id" value="<?php echo $tarefa['id']; ?>">

                <div class="campo-grupo">
                    <label for="titulo">Título da Tarefa *</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo $tarefa['titulo']; ?>" required>
                </div>

                <div class="campo-grupo">
                    <label for="descricao">Descrição</label>
                    <!-- Em textarea o valor vai no meio das tags -->
                    <textarea id="descricao" name="descricao" rows="4" maxlength="500"><?php echo $tarefa['descricao']; ?></textarea>
                </div>

                <div class="grid-form-2col">
                    <div class="campo-grupo">
                        <label for="prioridade">Prioridade *</label>
                        <select id="prioridade" name="prioridade" required>
                            <!-- O PHP verifica qual era a prioridade no banco e coloca 'selected' nela -->
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