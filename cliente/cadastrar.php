<?php

require_once '../config/conexao.php';

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = trim($_POST['nome'] ?? '');
    $sobrenome = trim($_POST['sobrenome'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    // junta nome e sobrenome
    $nomeCompleto = $nome . ' ' . $sobrenome;

    if (
        empty($nome) ||
        empty($sobrenome) ||
        empty($telefone) ||
        empty($login) ||
        empty($senha)
    ) {

        $mensagem = "Preencha todos os campos.";
        $tipoMensagem = "erro";

    } elseif (strlen($senha) < 8) {

        $mensagem = "A senha deve ter no mínimo 8 caracteres.";
        $tipoMensagem = "erro";

    } else {

        $sql = "SELECT id FROM cliente WHERE login = :login";

        $stmt = $conn->prepare($sql);

        $stmt->execute([
            ':login' => $login
        ]);

        if ($stmt->fetch()) {

            $mensagem = "Este e-mail já está cadastrado.";
            $tipoMensagem = "erro";

        } else {

            $sql = "INSERT INTO cliente
                    (nome, telefone, login, senha)
                    VALUES
                    (:nome, :telefone, :login, :senha)";

            $stmt = $conn->prepare($sql);

            $stmt->execute([
                ':nome' => $nomeCompleto,
                ':telefone' => $telefone,
                ':login' => $login,
                ':senha' => $senha
            ]);

            $mensagem = "Conta criada com sucesso!";
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

    <title>Criar conta - SRP</title>

    <link rel="stylesheet" href="../css/style.css">

</head>

<body>

<div class="auth-page">

    <section class="auth-left">

        <div class="auth-left-content">

            <div class="auth-logo">

                <div class="auth-logo-icon">
                    🎣
                </div>

                <h1>Pesqueiro Recanto Verde</h1>

                <p>
                    Reserve sua experiência de pesca online,
                    gerencie suas visitas e aproveite ao máximo
                    nosso pesqueiro.
                </p>

            </div>


            <div class="auth-benefits">

                <div class="benefit-card">

                    <div class="benefit-icon">📅</div>

                    <h3>Reservas Online</h3>

                    <p>
                        Reserve sua visita de forma rápida
                        e prática.
                    </p>

                </div>


                <div class="benefit-card">

                    <div class="benefit-icon">📋</div>

                    <h3>Histórico</h3>

                    <p>
                        Consulte suas reservas anteriores
                        facilmente.
                    </p>

                </div>


                <div class="benefit-card">

                    <div class="benefit-icon">💬</div>

                    <h3>Suporte</h3>

                    <p>
                        Tenha acesso às informações
                        do pesqueiro.
                    </p>

                </div>


                <div class="benefit-card">

                    <div class="benefit-icon">⭐</div>

                    <h3>Benefícios</h3>

                    <p>
                        Aproveite todos os recursos
                        disponíveis.
                    </p>

                </div>

            </div>

        </div>

    </section>

    <section class="auth-right">

        <div class="auth-form-container">

            <a href="login.php" class="auth-back">
                ← Voltar ao login
            </a>


            <h2>Criar conta</h2>

            <p class="auth-subtitle">
                Cadastre-se para começar a reservar.
            </p>


            <?php if ($mensagem): ?>

                <div class="auth-message <?= $tipoMensagem ?>">

                    <?= htmlspecialchars($mensagem) ?>

                </div>

            <?php endif; ?>


            <form method="POST" class="auth-form">

                <div class="auth-row">

                    <div class="auth-group">

                        <label for="nome">
                            Nome
                        </label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            placeholder="João"
                            value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                            required
                        >

                    </div>


                    <div class="auth-group">

                        <label for="sobrenome">
                            Sobrenome
                        </label>

                        <input
                            type="text"
                            id="sobrenome"
                            name="sobrenome"
                            placeholder="Silva"
                            value="<?= htmlspecialchars($_POST['sobrenome'] ?? '') ?>"
                            required
                        >

                    </div>

                </div>


                <div class="auth-group">

                    <label for="login">
                        E-mail
                    </label>

                    <input
                        type="email"
                        id="login"
                        name="login"
                        placeholder="seu@email.com"
                        value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"
                        required
                    >

                </div>


                <div class="auth-group">

                    <label for="telefone">
                        Telefone
                    </label>

                    <input
                        type="text"
                        id="telefone"
                        name="telefone"
                        placeholder="(67) 99999-9999"
                        value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>"
                        required
                    >

                </div>


                <div class="auth-group">

                    <label for="senha">
                        Senha
                    </label>

                    <div class="password-container">

                        <input
                            type="password"
                            id="senha"
                            name="senha"
                            placeholder="Mínimo 8 caracteres"
                            minlength="8"
                            required
                        >

                        <span class="password-icon">
                            ◉
                        </span>

                    </div>

                </div>


                <button type="submit" class="auth-button">
                    Criar Conta
                </button>

            </form>


            <div class="auth-footer">

                Já tem uma conta?

                <a href="login.php">
                    Entrar
                </a>

            </div>

        </div>

    </section>

</div>

</body>

</html>