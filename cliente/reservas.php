
<?php

session_start();

if (!isset($_SESSION['cliente_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../config/conexao.php';

$clienteId = $_SESSION['cliente_id'];
$nome = $_SESSION['cliente_nome'];

$sql = "
    SELECT id, data_reserva, status
    FROM reserva
    WHERE cliente_id = :cliente_id
    ORDER BY data_reserva DESC
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':cliente_id' => $clienteId
]);

$reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Minhas Reservas - Vale Verde</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="cliente-page">

    <header class="cliente-header">

        <div class="cliente-logo">

            <span><i class="bi bi-water"></i></span>

            <div>

                <h1>Vale Verde</h1>

                <p>Painel do Cliente</p>

            </div>

        </div>

        <a href="area_cliente.php" class="cliente-sair">
            Voltar
        </a>

    </header>

    <main class="cliente-content">

        <div class="cliente-welcome">

            <h2>Minhas Reservas</h2>

            <p>
                Olá, <?= htmlspecialchars($nome) ?>!
                Consulte suas reservas realizadas.
            </p>

        </div>

        <div class="cliente-card">

            <h3>Reservas realizadas</h3>

            <?php if (count($reservas) > 0): ?>

                <div class="table-responsive">

                    <table class="table">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Data</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($reservas as $reserva): ?>

                                <tr>

                                    <td>
                                        <?= htmlspecialchars($reserva['id']) ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            'd/m/Y',
                                            strtotime($reserva['data_reserva'])
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($reserva['status']) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <p>
                    Você ainda não possui reservas.
                </p>

                <a
                    href="../reserva/cadastrar.php"
                    class="cliente-button"
                >
                    Fazer minha primeira reserva
                </a>

            <?php endif; ?>

        </div>

    </main>

</div>

</body>

</html>