<?php

session_start();

require_once '../config/conexao.php';

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

$cliente_id = $_SESSION['cliente_id'];

$sql = "SELECT *
        FROM reserva
        WHERE cliente_id = :cliente_id
        ORDER BY data_reserva DESC";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':cliente_id' => $cliente_id
]);

$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Minhas Reservas - SRP</title>

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

        <div class="page-header">

            <div>

                <h2>Minhas Reservas</h2>

                <p>
                    Consulte suas reservas realizadas.
                </p>

            </div>

            <a href="area_cliente.php" class="btn-secondary">
                ← Voltar
            </a>

        </div>


        <?php if (count($reservas) > 0): ?>

            <div class="cliente-reservas">

                <?php foreach ($reservas as $reserva): ?>

                    <div class="reserva-card">

                        <div class="reserva-icon">
                            📅
                        </div>


                        <div class="reserva-info">

                            <h3>
                                Reserva #<?= htmlspecialchars($reserva['id']) ?>
                            </h3>

                            <p>
                                <strong>Data:</strong>

                                <?= date(
                                    'd/m/Y',
                                    strtotime($reserva['data_reserva'])
                                ) ?>
                            </p>

                            <p>
                                <strong>Status:</strong>

                                <span class="reserva-status">
                                    <?= htmlspecialchars($reserva['status']) ?>
                                </span>
                            </p>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty">

                <div style="font-size: 40px;">
                    📅
                </div>

                <h3>
                    Você ainda não possui reservas
                </h3>

                <p>
                    Faça sua primeira reserva para aproveitar
                    o Pesqueiro Recanto Verde.
                </p>

                <br>

                <a
                    href="../reserva/cadastrar.php"
                    class="btn-primary"
                >
                    Fazer uma reserva
                </a>

            </div>

        <?php endif; ?>

    </main>

</div>

</body>

</html>