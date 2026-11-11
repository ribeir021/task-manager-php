# Gerenciador de Tarefas (Task Manager)

Projeto desenvolvido para a disciplina de Desenvolvimento Web (ARA0062). Trata-se de um sistema completo de gerenciamento de tarefas (CRUD) construído com PHP, MySQL, HTML, CSS e JavaScript.

## 🛠️ Tecnologias Utilizadas
* **Backend:** PHP (persistência com PDO e Prepared Statements)
* **Banco de Dados:** MySQL
* **Frontend:** HTML5, CSS3 e JavaScript Vanilla

## 📌 Funcionalidades
* **Cadastro de Tarefas:** Adição de novas tarefas com título, descrição, prioridade, status e prazo.
* **Listagem e Dashboard:** Exibição dinâmica das tarefas com contadores de totais, pendentes, em andamento e concluídas.
* **Edição e Exclusão:** Atualização e remoção de registros no banco de dados.
* **Filtros Dinâmicos:** Busca por título, status e prioridade processada diretamente no backend (com persistência dos campos via `GET`).
* **Validação Client-Side:** Validação de campos obrigatórios e contador de caracteres via JavaScript.

## 🚀 Como Executar o Projeto
1. Certifique-se de ter um ambiente com Apache e MySQL (como o XAMPP).
2. Clone o repositório na pasta do servidor web (ex: `htdocs/task-manager-php`).
3. Importe a estrutura do banco de dados executando o arquivo `banco.sql` no phpMyAdmin ou CLI do MySQL.
4. Se necessário, ajuste os dados de acesso ao banco em `conexao.php`.
5. Acesse `http://localhost/task-manager-php` no seu navegador.

## 📁 Estrutura de Arquivos
* `banco.sql` - Script de criação do banco de dados e da tabela `tarefas`.
* `conexao.php` - Conexão PDO com o MySQL.
* `index.php` - Página principal com listagem, contadores e formulário de filtros.
* `cadastrar.php` - Formulário e lógica de inserção de novas tarefas.
* `editar.php` - Formulário e lógica de alteração de tarefas existentes.
* `excluir.php` - Processamento da remoção de tarefas.
* `style.css` - Estilização completa da aplicação.
* `script.js` - Validações e interações no frontend.