-- Cria o banco de dados se ele não existir
CREATE DATABASE gerenciador_tarefas;

-- Avisa ao MySQL que os comandos a seguir devem ser executados dentro deste banco
USE gerenciador_tarefas;

-- Cria a tabela 'tarefas' com suas respectivas colunas
CREATE TABLE tarefas (
    -- id: Número inteiro, se preenche sozinho (AUTO_INCREMENT) e é o identificador único da tarefa (PRIMARY KEY)
    id INT AUTO_INCREMENT PRIMARY KEY,
    
    -- titulo: Texto curto de até 255 caracteres. Obrigatório (NOT NULL)
    titulo VARCHAR(255) NOT NULL,
    
    -- descricao: Texto longo. Opcional (não tem NOT NULL, então aceita ficar vazio)
    descricao TEXT,
    
    -- prioridade: Só aceita essas 3 palavras exatas. Obrigatório (NOT NULL)
    prioridade ENUM('Baixa', 'Média', 'Alta') NOT NULL,
    
    -- prazo: Guarda uma data (ano-mês-dia). Obrigatório (NOT NULL)
    prazo DATE NOT NULL,
    
    -- status: Só aceita essas 3 opções. Se o PHP não enviar nada, o padrão (DEFAULT) será 'Pendente'
    status ENUM('Pendente', 'Em andamento', 'Concluída') DEFAULT 'Pendente',
    
    -- criado_em: Guarda data e hora. Preenche automaticamente com a hora do servidor se nada for enviado
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);