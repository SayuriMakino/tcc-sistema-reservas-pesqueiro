<?php

require_once '../config/conexao.php';

$sql = "SELECT * FROM cliente ORDER BY id";

$stmt = $conn->query($sql);

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clientes - SRP</title>

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

                <h1>Clientes</h1>

                <p>
                    Gerencie os clientes cadastrados no sistema.
                </p>

            </div>

            <a href="cadastrar.php" class="btn-primary">
                + Novo cliente
            </a>

        </div>

        <div class="search-box">

            <input
                type="text"
                id="buscarCliente"
                placeholder="🔍 Buscar cliente por nome..."
            >

        </div>

        <?php if (count($clientes) > 0): ?>

            <div class="clients-grid" id="listaClientes">

                <?php foreach ($clientes as $cliente): ?>

                    <div
                        class="client-card"
                        data-nome="<?= strtolower(htmlspecialchars($cliente['nome'])) ?>"
                    >

                        <div class="client-header">

                            <div class="client-avatar">

                                <?= strtoupper(substr($cliente['nome'], 0, 1)) ?>

                            </div>

                            <div>

                                <h3>
                                    <?= htmlspecialchars($cliente['nome']) ?>
                                </h3>

                            </div>

                        </div>


                        <div class="client-info">

                            <p>
                                <strong>Telefone:</strong>
                                <?= htmlspecialchars($cliente['telefone']) ?>
                            </p>

                            <p>
                                <strong>Login:</strong>
                                <?= htmlspecialchars($cliente['login']) ?>
                            </p>

                            <p>
                                <strong>ID:</strong>
                                <?= htmlspecialchars($cliente['id']) ?>
                            </p>

                        </div>


                        <div class="client-actions">

                            <a
                                href="editar.php?id=<?= $cliente['id'] ?>"
                                class="btn-edit"
                            >
                                Editar
                            </a>

                            <a
                                href="excluir.php?id=<?= $cliente['id'] ?>"
                                class="btn-delete"
                                onclick="return confirm('Tem certeza que deseja excluir este cliente?')"
                            >
                                Excluir
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty">

                <h3>Nenhum cliente cadastrado</h3>

                <p>
                    Cadastre um cliente para começar.
                </p>

                <br>

                <a href="cadastrar.php" class="btn-primary">
                    Cadastrar cliente
                </a>

            </div>

        <?php endif; ?>

    </main>

</div>

<script>

const campoBusca = document.getElementById('buscarCliente');

campoBusca.addEventListener('input', function () {

    const busca = this.value.toLowerCase();

    const cards = document.querySelectorAll('.client-card');

    cards.forEach(function (card) {

        const nome = card.getAttribute('data-nome');

        if (nome.includes(busca)) {

            card.style.display = '';

        } else {

            card.style.display = 'none';

        }

    });

});

</script>

</body>

</html>