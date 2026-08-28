<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

$nomeAdmin = $_SESSION["admin_nome"];

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Pesqueiro Recanto Verde</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

    <div class="dashboard">

        <aside class="sidebar">

            <div class="logo">

                <div class="logo-icon">
                    <i class="bi bi-water"></i>
                </div>

                <div>
                    <strong>Vale Verde</strong>
                    <span>Painel Admin</span>
                </div>

            </div>


            <nav class="menu">

                <a href="dashboard.php" class="menu-item active">

                    <i class="bi bi-grid"></i>

                    <span>Dashboard</span>

                </a>


                <a href="../reserva/listar.php" class="menu-item">

                    <i class="bi bi-calendar-check"></i>

                    <span>Reservas</span>

                </a>


                <a href="../cliente/listar.php" class="menu-item">

                    <i class="bi bi-people"></i>

                    <span>Clientes</span>

                </a>


                <a href="#" class="menu-item">

                    <i class="bi bi-currency-dollar"></i>

                    <span>Valores</span>

                </a>


                <a href="alterar_senha.php" class="menu-item">

                    <i class="bi bi-gear"></i>

                    <span>Configurações</span>

                </a>

            </nav>


            <div class="admin-area">

                <div class="admin-avatar">

                    <i class="bi bi-person"></i>

                </div>


                <div class="admin-info">

                    <strong>
                        <?= htmlspecialchars($nomeAdmin) ?>
                    </strong>

                    <span>Administrador</span>

                </div>


                <a href="logout.php" class="logout">

                    <i class="bi bi-box-arrow-right"></i>

                </a>

            </div>

        </aside>

        <main class="main-content">


            <div class="page-header">

                <div>

                    <h1>Dashboard</h1>

                    <p>
                        Visão geral do Pesqueiro Recanto Verde
                    </p>

                </div>

            </div>

            <div class="cards">


                <div class="card-dashboard">

                    <div class="card-icon">

                        <i class="bi bi-calendar-check"></i>

                    </div>

                    <div>

                        <span>Total de Reservas</span>

                        <h2>24</h2>

                        <small class="positive">

                            <i class="bi bi-arrow-up"></i>

                            8% este mês

                        </small>

                    </div>

                </div>



                <div class="card-dashboard">

                    <div class="card-icon">

                        <i class="bi bi-people"></i>

                    </div>

                    <div>

                        <span>Clientes</span>

                        <h2>38</h2>

                        <small>

                            Clientes cadastrados

                        </small>

                    </div>

                </div>



                <div class="card-dashboard">

                    <div class="card-icon">

                        <i class="bi bi-calendar-event"></i>

                    </div>

                    <div>

                        <span>Reservas Pendentes</span>

                        <h2>7</h2>

                        <small>

                            Aguardando confirmação

                        </small>

                    </div>

                </div>



                <div class="card-dashboard">

                    <div class="card-icon">

                        <i class="bi bi-calendar2-check"></i>

                    </div>

                    <div>

                        <span>Reservas Confirmadas</span>

                        <h2>17</h2>

                        <small>

                            Este mês

                        </small>

                    </div>

                </div>


            </div>


            <div class="dashboard-grid">

                <div class="panel">


                    <div class="panel-header">

                        <div>

                            <h3>Reservas Recentes</h3>

                            <span>
                                Últimas reservas realizadas
                            </span>

                        </div>

                    </div>


                    <div class="table-responsive">

                        <table class="table">

                            <thead>

                                <tr>

                                    <th>Cliente</th>

                                    <th>Data</th>

                                    <th>Status</th>

                                </tr>

                            </thead>


                            <tbody>


                                <tr>

                                    <td>João Silva</td>

                                    <td>28/08/2026</td>

                                    <td>

                                        <span class="status confirmed">
                                            Confirmada
                                        </span>

                                    </td>

                                </tr>


                                <tr>

                                    <td>Maria Oliveira</td>

                                    <td>30/08/2026</td>

                                    <td>

                                        <span class="status pending">
                                            Pendente
                                        </span>

                                    </td>

                                </tr>


                                <tr>

                                    <td>Pedro Santos</td>

                                    <td>02/09/2026</td>

                                    <td>

                                        <span class="status confirmed">
                                            Confirmada
                                        </span>

                                    </td>

                                </tr>


                                <tr>

                                    <td>Ana Costa</td>

                                    <td>05/09/2026</td>

                                    <td>

                                        <span class="status confirmed">
                                            Confirmada
                                        </span>

                                    </td>

                                </tr>


                            </tbody>

                        </table>

                    </div>


                </div>



                <!-- RESUMO -->

                <div class="panel">


                    <div class="panel-header">

                        <div>

                            <h3>Resumo</h3>

                            <span>
                                Informações do sistema
                            </span>

                        </div>

                    </div>


                    <div class="distribution">


                        <div class="distribution-item">

                            <div class="distribution-title">

                                <span>Reservas confirmadas</span>

                                <strong>71%</strong>

                            </div>


                            <div class="progress">

                                <div
                                    class="progress-bar"
                                    style="width: 71%"></div>

                            </div>

                        </div>



                        <div class="distribution-item">

                            <div class="distribution-title">

                                <span>Reservas pendentes</span>

                                <strong>29%</strong>

                            </div>


                            <div class="progress">

                                <div
                                    class="progress-bar"
                                    style="width: 29%"></div>

                            </div>

                        </div>


                    </div>


                    <div class="mini-cards">


                        <div>

                            <span>Clientes</span>

                            <strong>38</strong>

                        </div>


                        <div>

                            <span>Reservas</span>

                            <strong>24</strong>

                        </div>


                    </div>


                </div>


            </div>


        </main>

    </div>

</body>

</html>