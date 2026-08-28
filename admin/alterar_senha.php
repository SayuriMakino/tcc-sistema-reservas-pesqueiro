<?php

session_start();

if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit;
}

require_once '../config/conexao.php';

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $senhaAtual = $_POST['senha_atual'] ?? '';
    $novaSenha = $_POST['nova_senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';

    if (
        empty($senhaAtual) ||
        empty($novaSenha) ||
        empty($confirmarSenha)
    ) {

        $mensagem = "Preencha todos os campos.";
        $tipoMensagem = "erro";

    }

    elseif (strlen($novaSenha) < 8) {

        $mensagem = "A nova senha deve ter pelo menos 8 caracteres.";
        $tipoMensagem = "erro";

    }

    elseif ($novaSenha !== $confirmarSenha) {

        $mensagem = "A confirmação da nova senha não corresponde.";
        $tipoMensagem = "erro";

    }

    else {

        $sql = "SELECT * FROM administrador WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':id' => $_SESSION['admin_id']
        ]);

        $administrador = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$administrador) {

            $mensagem = "Administrador não encontrado.";
            $tipoMensagem = "erro";

        }

        elseif (!password_verify($senhaAtual, $administrador['senha'])) {

            $mensagem = "A senha atual está incorreta.";
            $tipoMensagem = "erro";

        }

        else {

            $novaSenhaHash = password_hash(
                $novaSenha,
                PASSWORD_DEFAULT
            );

            $sql = "UPDATE administrador
                    SET senha = :senha
                    WHERE id = :id";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':senha' => $novaSenhaHash,
                ':id' => $_SESSION['admin_id']
            ]);

            $mensagem = "Senha alterada com sucesso!";
            $tipoMensagem = "sucesso";

        }

    }

}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Configurações - Pesqueiro Recanto Verde</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link rel="stylesheet" href="../css/dashboardStyle.css">

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

            <a href="dashboard.php" class="menu-item">

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


            <a href="alterar_senha.php" class="menu-item active">

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
                    <?= htmlspecialchars($_SESSION['admin_nome']) ?>
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

                <h1>Configurações</h1>

                <p>
                    Gerencie as configurações da sua conta.
                </p>

            </div>

        </div>


        <div class="settings-card">

            <div class="settings-header">

                <div class="settings-icon">

                    <i class="bi bi-lock"></i>

                </div>

                <div>

                    <h2>Alterar senha</h2>

                    <p>
                        Atualize a senha de acesso do administrador.
                    </p>

                </div>

            </div>


            <?php if (!empty($mensagem)): ?>

                <div class="auth-message <?= $tipoMensagem ?>">

                    <?= htmlspecialchars($mensagem) ?>

                </div>

            <?php endif; ?>


            <form method="POST" class="settings-form">


                <div class="form-group">

                    <label for="senha_atual">
                        Senha atual
                    </label>

                    <input
                        type="password"
                        id="senha_atual"
                        name="senha_atual"
                        placeholder="Digite sua senha atual"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="nova_senha">
                        Nova senha
                    </label>

                    <input
                        type="password"
                        id="nova_senha"
                        name="nova_senha"
                        placeholder="Mínimo 8 caracteres"
                        minlength="8"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="confirmar_senha">
                        Confirmar nova senha
                    </label>

                    <input
                        type="password"
                        id="confirmar_senha"
                        name="confirmar_senha"
                        placeholder="Digite novamente a nova senha"
                        minlength="8"
                        required
                    >

                </div>


                <div class="settings-actions">

                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        <i class="bi bi-check-lg"></i>
                        Alterar senha
                    </button>

                </div>


            </form>

        </div>


    </main>

</div>

</body>

</html>