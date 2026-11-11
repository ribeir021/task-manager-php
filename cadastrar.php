<?php
require 'conexao.php';

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $prioridade = $_POST['prioridade'];
    $status = $_POST['status'];
    $prazo = $_POST['prazo'];

    try {
        // Insere os dados da nova tarefa no banco de dados com segurança
        $sql = "INSERT INTO tarefas (titulo, descricao, prioridade, status, prazo) VALUES (:titulo, :descricao, :prioridade, :status, :prazo)";
        $stmt = $conexao->prepare($sql);
        
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':prioridade', $prioridade);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':prazo', $prazo);
        
        $stmt->execute();
        
        // Redireciona de volta para a página inicial
        header("Location: index.php");
        exit;
        
    } catch (PDOException $erro) {
        echo "<script>alert('Erro ao cadastrar tarefa.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Tarefa - Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topo">
        <div class="logo">
            <span>✓</span> Gerenciador de Tarefas
        </div>
        <nav class="menu">
            <a href="index.php" class="link-menu">Minhas tarefas</a>
            <a href="cadastrar.php" class="btn-novo ativo">+ Nova tarefa</a>
        </nav>
    </header>

    <main class="container">
        <h1 class="titulo-pagina">Cadastrar Nova Tarefa</h1>

        <div class="caixa-form">
            <form action="cadastrar.php" method="POST" id="form-cadastro" novalidate>
                <div class="campo-grupo">
                    <label for="titulo">Título da Tarefa *</label>
                    <input type="text" id="titulo" name="titulo" placeholder="Ex: Criar banco de dados no XAMPP">
                    <span class="msg-erro" id="erro-titulo"></span>
                </div>

                <div class="campo-grupo">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" rows="4" maxlength="500" placeholder="Insira os detalhes da tarefa..."></textarea>
                    <div class="contador-container">
                        <span id="contador-chars">0 / 500 caracteres</span>
                    </div>
                </div>

                <div class="grid-form-2col">
                    <div class="campo-grupo">
                        <label for="prioridade">Prioridade *</label>
                        <select id="prioridade" name="prioridade">
                            <option value="">Selecione...</option>
                            <option value="Baixa">Baixa</option>
                            <option value="Média">Média</option>
                            <option value="Alta">Alta</option>
                        </select>
                        <span class="msg-erro" id="erro-prioridade"></span>
                    </div>

                    <div class="campo-grupo">
                        <label for="status">Status *</label>
                        <select id="status" name="status">
                            <option value="Pendente">Pendente</option>
                            <option value="Em andamento">Em andamento</option>
                            <option value="Concluída">Concluída</option>
                        </select>
                    </div>
                </div>

                <div class="campo-grupo">
                    <label for="prazo">Data de Prazo</label>
                    <input type="date" id="prazo" name="prazo">
                </div>

                <div class="botoes-form">
                    <a href="index.php" class="btn-cancelar">Cancelar</a>
                    <button type="submit" class="btn-salvar">Salvar Tarefa</button>
                </div>
            </form>
        </div>
    </main>

    <script src="script.js"></script>
</body>
</html>