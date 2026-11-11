<?php
require 'conexao.php';

try {
    // Configuração da consulta com filtros dinâmicos via URL
    $sql = "SELECT * FROM tarefas WHERE 1=1";
    $parametros = [];

    if (!empty($_GET['busca'])) {
        $sql .= " AND titulo LIKE :busca";
        $parametros[':busca'] = '%' . $_GET['busca'] . '%';
    }

    if (!empty($_GET['status'])) {
        $sql .= " AND status = :status";
        $parametros[':status'] = $_GET['status'];
    }

    if (!empty($_GET['prioridade'])) {
        $sql .= " AND prioridade = :prioridade";
        $parametros[':prioridade'] = $_GET['prioridade'];
    }

    $stmt = $conexao->prepare($sql);
    $stmt->execute($parametros);
    $lista_tarefas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Contadores para o painel de resumo
    $total = count($lista_tarefas);
    $pendentes = 0;
    $em_andamento = 0;
    $concluidas = 0;

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

        <div class="caixa-filtro">
            <form action="index.php" method="GET" class="form-filtro" id="form-filtro">
                <div class="campo-grupo">
                    <label for="filtro-busca">Buscar pelo título</label>
                    <input type="text" id="filtro-busca" name="busca" placeholder="Digite para filtrar a lista..." 
                           value="<?php echo isset($_GET['busca']) ? $_GET['busca'] : ''; ?>">
                </div>
                
                <div class="campo-grupo">
                    <label for="filtro-status">Status</label>
                    <select id="filtro-status" name="status">
                        <option value="">Todos</option>
                        <option value="Pendente" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Pendente') ? 'selected' : ''; ?>>Pendente</option>
                        <option value="Em andamento" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Em andamento') ? 'selected' : ''; ?>>Em andamento</option>
                        <option value="Concluída" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Concluída') ? 'selected' : ''; ?>>Concluída</option>
                    </select>
                </div>
                
                <div class="campo-grupo">
                    <label for="filtro-prioridade">Prioridade</label>
                    <select id="filtro-prioridade" name="prioridade">
                        <option value="">Todas</option>
                        <option value="Baixa" <?php echo (isset($_GET['prioridade']) && $_GET['prioridade'] == 'Baixa') ? 'selected' : ''; ?>>Baixa</option>
                        <option value="Média" <?php echo (isset($_GET['prioridade']) && $_GET['prioridade'] == 'Média') ? 'selected' : ''; ?>>Média</option>
                        <option value="Alta" <?php echo (isset($_GET['prioridade']) && $_GET['prioridade'] == 'Alta') ? 'selected' : ''; ?>>Alta</option>
                    </select>
                </div>
                
                <div class="botoes-filtro">
                    <button type="submit" class="btn-filtrar">Filtrar</button>
                    <a href="index.php" class="btn-limpar">Limpar</a>
                </div>
            </form>
        </div>

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
                            $classe_prioridade = "prioridade-" . str_replace('é', 'e', strtolower($tarefa['prioridade']));
                            $classe_status = "status-" . str_replace(' ', '_', strtolower($tarefa['status']));
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