<?php
$servidor = "localhost";
$banco = "gerenciador_tarefas";
$usuario = "root";
$senha = "";

try {
    // Tenta conectar
    $conexao = new PDO("mysql:host=$servidor; dbname=$banco", $usuario, $senha);
} catch (PDOException $erro) {
    // Se der erro, cola o seu texto com a mensagem específica de dentro da caixa do erro
    echo "Falha ao conectar: " . $erro->getMessage();
}
?>