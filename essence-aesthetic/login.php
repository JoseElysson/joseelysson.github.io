<?php
require __DIR__ . '/includes/db.php';
require 'includes/header.php';

// Inicia a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    
    try {
        $stmt = $pdo->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Configura os dados na sessão
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['logado'] = true;
            
            // Redireciona para a página inicial
            header("Location: index.php");
            exit();
        } else {
            $erro = "Email ou senha incorretos";
        }
    } catch (PDOException $e) {
        $erro = "Erro no sistema. Por favor, tente novamente mais tarde.";
        error_log("Erro de login: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Essence Aesthetic</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <main class="auth-container">
        <div class="auth-box">
            <h1>Login</h1>
            <?php if (isset($erro)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="input-field" placeholder="Seu email" required>
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" class="input-field" placeholder="Sua senha" required>
                </div>
                <button type="submit" class="btn-auth btn-primary-auth">Entrar</button>
            </form>
            
            <div class="links-footer">
                <p>Não tem conta? <a href="cadastro.php">Cadastre-se</a></p>
                <p><a href="recuperar-senha.php">Esqueci minha senha</a></p>
            </div>
        </div>
    </main>

    <?php require 'includes/footer.php'; ?>
</body>
</html>