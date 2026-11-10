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
            <a href="cadastro.php" class="btn-novo ativo">+ Nova tarefa</a>
        </nav>
    </header>

    <main class="container">
        <h1 class="titulo-pagina">Cadastrar Nova Tarefa</h1>

        <div class="caixa-form">
            <form action="salvar.php" method="POST" id="form-cadastro" novalidate>
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
                            <option value="Concluído">Concluído</option>
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