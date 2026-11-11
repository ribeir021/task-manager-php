<?php
require 'conexao.php';

try {
    $sql = "SELECT * FROM tarefas";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $lista_tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Conta o total de itens no array
    $total = count($lista_tarefas);
    
    // Contadores zerados
    $pendentes = 0;
    $em_andamento = 0;
    $concluidas = 0;

    // Passa por cada tarefa somando nos contadores certos
    foreach ($lista_tarefas as $t) {
        if ($t['status'] == 'Pendente') {
            $pendentes++;
        } elseif ($t['status'] == 'Em andamento') {
            $em_andamento++;
        } elseif ($t['status'] == 'Concluída') {
            $concluidas++;
        }
    }
} catch (PDOException $erro) {
    echo "Erro ao buscar tarefas: " . $erro->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topo">
        <div class="logo">
            <span>✓</span> Gerenciador de Tarefas
        </div>
        <nav class="menu">
            <a href="index.php" class="link-menu ativo">Minhas tarefas</a>
            <a href="cadastrar.php" class="btn-novo">+ Nova tarefa</a>
        </nav>
    </header>

    <main class="container">
        <h1 class="titulo-pagina">Minhas tarefas</h1>

        <!-- Cards de Resumo -->
        <div class="cards-grid">
            <div class="card">
                <span class="numero" id="card-total"><?php echo $total; ?></span>
                <span class="rotulo">Total</span>
            </div>
            <div class="card">
                <span class="numero" id="card-pendentes"><?php echo $pendentes; ?></span>
                <span class="rotulo">Pendentes</span>
            </div>
            <div class="card">
                <span class="numero" id="card-andamento"><?php echo $em_andamento; ?></span>
                <span class="rotulo">Em andamento</span>
            </div>
            <div class="card">
                <span class="numero" id="card-concluidas"><?php echo $concluidas; ?></span>
                <span class="rotulo">Concluídas</span>
            </div>
        </div>

        <!-- Barra de Filtros -->
        <div class="caixa-filtro">
            <form action="index.php" method="GET" class="form-filtro" id="form-filtro">
                <div class="campo-grupo">
                    <label for="filtro-busca">Buscar pelo título</label>
                    <input type="text" id="filtro-busca" name="busca" placeholder="Digite para filtrar a lista...">
                </div>
                <div class="campo-grupo">
                    <label for="filtro-status">Status</label>
                    <select id="filtro-status" name="status">
                        <option value="">Todos</option>
                        <option value="Pendente">Pendente</option>
                        <option value="Em andamento">Em andamento</option>
                        <option value="Concluído">Concluído</option>
                    </select>
                </div>
                <div class="campo-grupo">
                    <label for="filtro-prioridade">Prioridade</label>
                    <select id="filtro-prioridade" name="prioridade">
                        <option value="">Todas</option>
                        <option value="Baixa">Baixa</option>
                        <option value="Média">Média</option>
                        <option value="Alta">Alta</option>
                    </select>
                </div>
                <div class="botoes-filtro">
                    <button type="submit" class="btn-filtrar">Filtrar</button>
                    <a href="index.php" class="btn-limpar">Limpar</a>
                </div>
            </form>
        </div>

        <!-- Tabela de Listagem -->
        <section class="tabela-container">
            <table class="tabela-tarefas" id="tabela-tarefas">
                <thead>
                    <tr>
                        <th>TÍTULO</th>
                        <th>PRIORIDADE</th>
                        <th>STATUS</th>
                        <th>PRAZO</th>
                        <th>AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($lista_tarefas)): ?>
                        <tr>
                            <td colspan="5" class="sem-registros">
                                Nenhuma tarefa cadastrada até o momento. Clique em <strong>"+ Nova tarefa"</strong> para começar!
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($lista_tarefas as $tarefa): ?>
                            
                            <?php 
                            // Tratando os textos para encaixar perfeitamente nas classes CSS do frontend dela
                            $classe_prioridade = "prioridade-" . str_replace('é', 'e', strtolower($tarefa['prioridade']));
                            $classe_status = "status-" . str_replace(' ', '_', strtolower($tarefa['status']));
                            // Convertendo a data do banco (Y-m-d) para o formato brasileiro (d/m/Y)
                            $data_formatada = date('d/m/Y', strtotime($tarefa['prazo']));
                            ?>

                            <tr>
                                <td class="coluna-titulo">
                                    <strong><?php echo $tarefa['titulo']; ?></strong>
                                </td>
                                
                                <td>
                                    <span class="tag <?php echo $classe_prioridade; ?>">
                                        <?php echo $tarefa['prioridade']; ?>
                                    </span>
                                </td>
                                
                                <td>
                                    <span class="tag <?php echo $classe_status; ?>">
                                        <?php echo $tarefa['status']; ?>
                                    </span>
                                </td>
                                
                                <td><?php echo $data_formatada; ?></td>
                                
                                <td>
                                    <!-- Os seus botões com os IDs dinâmicos, mas usando as classes bonitas dela -->
                                    <a href="editar.php?id=<?php echo $tarefa['id']; ?>" class="btn-acao btn-editar">Editar</a>
                                    <a href="excluir.php?id=<?php echo $tarefa['id']; ?>" class="btn-acao btn-excluir">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>