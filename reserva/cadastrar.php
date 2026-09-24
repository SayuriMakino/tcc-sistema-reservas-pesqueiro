
<?php

session_start();

if (!isset($_SESSION['cliente_id'])) {
    header("Location: ../cliente/login.php");
    exit;
}

require_once '../config/conexao.php';

$clienteId = $_SESSION['cliente_id'];
$mensagem = '';
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dataReserva = $_POST['data_reserva'] ?? '';

    if (empty($dataReserva)) {

        $erro = "Selecione uma data para a reserva.";

    } elseif ($dataReserva < date('Y-m-d')) {

        $erro = "Não é possível reservar uma data passada.";

    } else {

        try {

            $sqlVerificar = "
                SELECT COUNT(*)
                FROM reserva
                WHERE cliente_id = :cliente_id
                AND data_reserva = :data_reserva
                AND status <> 'Cancelada'
            ";

            $stmtVerificar = $conn->prepare($sqlVerificar);

            $stmtVerificar->execute([
                ':cliente_id' => $clienteId,
                ':data_reserva' => $dataReserva
            ]);

            $existeReserva = $stmtVerificar->fetchColumn();

            if ($existeReserva > 0) {

                $erro = "Você já possui uma reserva para essa data.";

            } else {

                $sql = "
                    INSERT INTO reserva
                    (data_reserva, status, cliente_id)
                    VALUES (:data_reserva, :status, :cliente_id)
                ";

                $stmt = $conn->prepare($sql);

                $stmt->execute([
                    ':data_reserva' => $dataReserva,
                    ':status' => 'Pendente',
                    ':cliente_id' => $clienteId
                ]);

                $mensagem = "Reserva realizada com sucesso!";

            }

        } catch (PDOException $e) {

            $erro = "Erro ao realizar a reserva.";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Nova Reserva - Vale Verde</title>

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

        <a href="../cliente/area_cliente.php" class="cliente-sair">
            Voltar
        </a>

    </header>

    <main class="cliente-content">

        <div class="cliente-welcome">

            <h2>Nova Reserva</h2>

            <p>
                Escolha uma data para realizar sua reserva.
            </p>

        </div>

        <?php if (!empty($mensagem)): ?>

            <div class="alert-success">
                <?= htmlspecialchars($mensagem) ?>

            </div>

        <?php endif; ?>

        <?php if (!empty($erro)): ?>

            <div class="alert-error">
                <?= htmlspecialchars($erro) ?>

            </div>

        <?php endif; ?>

        <div class="cliente-card">

            <div class="cliente-card-icon">
                <i class="bi bi-calendar-plus"></i>
            </div>

            <h3>Realizar Reserva</h3>

            <form method="POST">

                <div class="form-group">

                    <label for="data_reserva">
                        Data da Reserva
                    </label>

                    <input
                        type="date"
                        name="data_reserva"
                        id="data_reserva"
                        min="<?= date('Y-m-d') ?>"
                        required
                    >

                </div>

                <button type="submit" class="cliente-button">
                    Confirmar Reserva
                </button>

            </form>

        </div>

    </main>

</div>

</body>

</html>