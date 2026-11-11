-- Cria o banco de dados e seleciona para uso
CREATE DATABASE IF NOT EXISTS gerenciador_tarefas;
USE gerenciador_tarefas;

-- Tabela principal para armazenamento das tarefas
CREATE TABLE tarefas {
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descricao TEXT,
    prioridade ENUM('Baixa', 'Média', 'Alta') NOT NULL,
    prazo DATE NOT NULL,
    status ENUM('Pendente', 'Em andamento', 'Concluída') DEFAULT 'Pendente',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
};