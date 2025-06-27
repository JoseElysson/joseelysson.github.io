<?php
require __DIR__ . '/includes/db.php';
require 'includes/header.php';

// Inicia a sessão se não estiver iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Variável para mensagens de erro
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitiza e valida os dados de entrada
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'] ?? null;

    // Validações básicas
    if (empty($nome) || empty($email) || empty($senha)) {
        $erro = "Todos os campos são obrigatórios!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "E-mail inválido!";
    } elseif (strlen($senha) < 6) {
        $erro = "A senha deve ter pelo menos 6 caracteres!";
    } elseif ($senha !== $confirmar_senha) {
        $erro = "As senhas não coincidem!";
    } else {
        // Hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        
        try {
            // Verifica se o e-mail já existe
            $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->rowCount() > 0) {
                $erro = "Este e-mail já está cadastrado!";
            } else {
                // Insere o novo usuário
                $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
                $stmt->execute([$nome, $email, $senhaHash]);
                
                // Obtém o ID do novo usuário
                $usuarioId = $pdo->lastInsertId();
                
                // Configura os dados na sessão
                $_SESSION['usuario_id'] = $usuarioId;
                $_SESSION['usuario_nome'] = $nome;
                $_SESSION['usuario_email'] = $email;
                $_SESSION['logado'] = true;
                
                // Redireciona para a página inicial
                header('Location: index.php');
                exit();
            }
        } catch (PDOException $e) {
            $erro = "Erro ao cadastrar. Por favor, tente novamente.";
            error_log("Erro no cadastro: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Essence Aesthetic</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <main class="auth-container">
        <div class="auth-box">
            <h1>Cadastre-se</h1>
            
            <?php if ($erro): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label for="nome">Nome Completo</label>
                    <input type="text" id="nome" name="nome" class="input-field" 
                           placeholder="Seu nome completo" required
                           value="<?= isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="input-field" 
                           placeholder="Seu email" required
                           value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                </div>
                <div class="form-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" name="senha" class="input-field" 
                           placeholder="Crie uma senha (mínimo 6 caracteres)" required>
                </div>
                <div class="form-group">
                    <label for="confirmar_senha">Confirmar Senha</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" class="input-field" 
                           placeholder="Confirme sua senha" required>
                </div>
                <button type="submit" class="btn-auth btn-primary-auth">Criar Conta</button>
            </form>
            
            <div class="links-footer">
                <p>Já tem conta? <a href="login.php">Faça login</a></p>
            </div>
        </div>
    </main>

    <?php require 'includes/footer.php'; ?>
</body>
</html>