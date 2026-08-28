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

    <title>Clientes - Vale Verde</title>

    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

    <div class="layout">

        <!-- =====================================================
         SIDEBAR
         ===================================================== -->

        <aside class="sidebar">

            <!-- LOGO -->

            <div class="logo">

                <div class="logo-icon">
                    ≋
                </div>

                <div class="logo-text">

                    <strong>Vale Verde</strong>

                    <span>Painel Admin</span>

                </div>

            </div>


            <!-- MENU -->

            <nav class="menu">

                <a href="../admin/dashboard.php" class="menu-item">

                    <i class="fa-solid fa-grip"></i>

                    <span>Dashboard</span>

                </a>


                <a href="../reserva/listar.php" class="menu-item">

                    <i class="fa-regular fa-calendar-check"></i>

                    <span>Reservas</span>

                </a>


                <a href="listar.php" class="menu-item active">

                    <i class="fa-solid fa-users"></i>

                    <span>Clientes</span>

                </a>


                <a href="#" class="menu-item">

                    <i class="fa-solid fa-dollar-sign"></i>

                    <span>Valores</span>

                </a>


                <a href="#" class="menu-item">

                    <i class="fa-solid fa-gear"></i>

                    <span>Configurações</span>

                </a>

            </nav>


            <!-- ADMINISTRADOR -->

            <div class="admin-area">

                <div class="admin-avatar">
                    ♙
                </div>

                <div class="admin-info">

                    <strong>Administrador</strong>

                    <span>Administrador</span>

                </div>

                <a
                    href="../admin/logout.php"
                    class="logout"
                    title="Sair">
                    ⇥
                </a>

            </div>

        </aside>


        <!-- =====================================================
         CONTEÚDO
         ===================================================== -->

        <main class="content">

            <!-- CABEÇALHO -->

            <div class="page-header">

                <div>

                    <h1>Clientes</h1>

                    <p>
                        Gerencie os clientes cadastrados no sistema.
                    </p>

                </div>


                <a
                    href="cadastrar.php"
                    class="btn-primary">
                    + Novo cliente
                </a>

            </div>


            <!-- BUSCA -->

            <div class="search-box">

                <input
                    type="text"
                    id="buscarCliente"
                    placeholder="🔍 Buscar cliente por nome...">

            </div>


            <!-- LISTA DE CLIENTES -->

            <?php if (count($clientes) > 0): ?>

                <div
                    class="clients-grid"
                    id="listaClientes">

                    <?php foreach ($clientes as $cliente): ?>

                        <div
                            class="client-card"
                            data-nome="<?= strtolower(htmlspecialchars($cliente['nome'])) ?>">

                            <!-- CABEÇALHO DO CLIENTE -->

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


                            <!-- INFORMAÇÕES -->

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


                            <!-- AÇÕES -->

                            <div class="client-actions">

                                <a
                                    href="editar.php?id=<?= $cliente['id'] ?>"
                                    class="btn-edit">
                                    Editar
                                </a>


                                <a
                                    href="excluir.php?id=<?= $cliente['id'] ?>"
                                    class="btn-delete"
                                    onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                    Excluir
                                </a>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>


            <?php else: ?>

                <!-- NENHUM CLIENTE -->

                <div class="empty">

                    <h3>Nenhum cliente cadastrado</h3>

                    <p>
                        Cadastre um cliente para começar.
                    </p>

                    <br>

                    <a
                        href="cadastrar.php"
                        class="btn-primary">
                        Cadastrar cliente
                    </a>

                </div>

            <?php endif; ?>

        </main>

    </div>


    <!-- =====================================================
     BUSCA DE CLIENTES
     ===================================================== -->

    <script>
        const campoBusca = document.getElementById('buscarCliente');

        campoBusca.addEventListener('input', function() {

            const busca = this.value.toLowerCase();

            const cards = document.querySelectorAll('.client-card');

            cards.forEach(function(card) {

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