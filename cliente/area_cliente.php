<?php

session_start();

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$nome = $_SESSION['cliente_nome'];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Área do Cliente - SRP</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="cliente-page">

    <header class="cliente-header">

        <div class="cliente-logo">

            <span>🎣</span>

            <div>
                <h1>Pesqueiro Recanto Verde</h1>
                <p>Sistema de Reservas</p>
            </div>

        </div>

        <a href="logout.php" class="cliente-sair">
            Sair
        </a>

    </header>

    <main class="cliente-content">

        <div class="cliente-welcome">

            <h2>
                Olá, <?= htmlspecialchars($nome) ?>! 👋
            </h2>

            <p>
                Bem-vindo à sua área de cliente.
            </p>

        </div>

        <div class="cliente-cards">

            <div class="cliente-card">

                <div class="cliente-card-icon">
                    📋
                </div>

                <h3>Minhas Reservas</h3>

                <p>
                    Visualize suas reservas realizadas
                    no pesqueiro.
                </p>

                <a href="reservas.php" class="cliente-button">
                    Ver minhas reservas
                </a>

            </div>

            <div class="cliente-card">

                <div class="cliente-card-icon">
                    📅
                </div>

                <h3>Nova Reserva</h3>

                <p>
                    Escolha uma data disponível
                    e faça sua reserva.
                </p>

                <a href="../reserva/cadastrar.php" class="cliente-button">
                    Fazer reserva
                </a>

            </div>

            <div class="cliente-card">

                <div class="cliente-card-icon">
                    🗓️
                </div>

                <h3>Disponibilidade</h3>

                <p>
                    Consulte as datas disponíveis
                    para reserva.
                </p>

                <a href="../disponibilidade/listar.php" class="cliente-button">
                    Consultar datas
                </a>

            </div>

        </div>

    </main>

</div>

</body>

</html>