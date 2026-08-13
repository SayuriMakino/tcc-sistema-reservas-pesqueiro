<?php

require_once '../config/conexao.php';

if (!isset($_GET['id'])) {
    die("Cliente não informado.");
}

$id = $_GET['id'];

$mensagem = "";
$tipoMensagem = "";


$sql = "SELECT * FROM cliente WHERE id = :id";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    die("Cliente não encontrado.");
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome']);
    $telefone = trim($_POST['telefone']);
    $login = trim($_POST['login']);
    $senha = trim($_POST['senha']);

    if (
        empty($nome) ||
        empty($telefone) ||
        empty($login) ||
        empty($senha)
    ) {

        $mensagem = "Preencha todos os campos.";
        $tipoMensagem = "erro";

    } else {

        $sql = "SELECT id
                FROM cliente
                WHERE login = :login
                AND id <> :id";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':login' => $login,
            ':id' => $id
        ]);

        if ($stmt->fetch()) {

            $mensagem = "Este login já está cadastrado.";
            $tipoMensagem = "erro";

        } else {

            $sql = "UPDATE cliente
                    SET nome = :nome,
                        telefone = :telefone,
                        login = :login,
                        senha = :senha
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':nome' => $nome,
                ':telefone' => $telefone,
                ':login' => $login,
                ':senha' => $senha,
                ':id' => $id
            ]);

            header("Location: listar.php");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Cliente - SRP</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <div class="logo">

            <h2>Pesqueiro</h2>

            <p>Sistema de Reservas</p>

        </div>

        <ul class="menu">

            <li>
                <a href="../admin/dashboard.php">
                    Dashboard
                </a>
            </li>

            <li>
                <a href="../reserva/listar.php">
                    Reservas
                </a>
            </li>

            <li>
                <a href="listar.php" class="active">
                    Clientes
                </a>
            </li>

            <li>
                <a href="#">
                    Disponibilidade
                </a>
            </li>

            <li>
                <a href="#">
                    Relatórios
                </a>
            </li>

        </ul>

    </aside>

    <main class="content">

        <div class="page-header">

            <div>

                <h1>Editar Cliente</h1>

                <p>
                    Altere os dados do cliente cadastrado.
                </p>

            </div>

        </div>


        <div class="form-card">

            <?php if ($mensagem): ?>

                <div class="message <?= $tipoMensagem ?>">

                    <?= htmlspecialchars($mensagem) ?>

                </div>

            <?php endif; ?>


            <form method="POST">

                <div class="form-group">

                    <label for="nome">
                        Nome
                    </label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="<?= htmlspecialchars($cliente['nome']) ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="telefone">
                        Telefone
                    </label>

                    <input
                        type="text"
                        id="telefone"
                        name="telefone"
                        value="<?= htmlspecialchars($cliente['telefone']) ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="login">
                        Login
                    </label>

                    <input
                        type="text"
                        id="login"
                        name="login"
                        value="<?= htmlspecialchars($cliente['login']) ?>"
                        required
                    >

                </div>

                <div class="form-group">

                    <label for="senha">
                        Senha
                    </label>

                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        value="<?= htmlspecialchars($cliente['senha']) ?>"
                        required
                    >

                </div>

                <div class="form-actions">

                    <a
                        href="listar.php"
                        class="btn-secondary"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        Salvar alterações
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

</body>

</html>