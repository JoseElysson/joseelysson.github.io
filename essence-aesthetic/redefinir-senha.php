<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php'; // Certifique-se que esta linha existe
require 'includes/header.php';

// Inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Restante do código...

startSessionIfNotStarted();

$mensagem = null;
$erro = null;
$token_valido = false;

$usuario_id = filter_input(INPUT_GET, 'user_id', FILTER_VALIDATE_INT);
$token = filter_input(INPUT_GET, 'token', FILTER_SANITIZE_STRING);

if ($usuario_id && $token) {
    try {
        // Verifica se o usuário existe
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
        $stmt->execute([$usuario_id]);
        
        if ($stmt->rowCount() > 0) {
            $token_valido = verificarTokenRecuperacao($pdo, $usuario_id, $token);
            
            if ($token_valido && $_SERVER['REQUEST_METHOD'] === 'POST') {
                $nova_senha = $_POST['nova_senha'];
                $confirmar_senha = $_POST['confirmar_senha'];
                
                if (strlen($nova_senha) < 6) {
                    $erro = "A senha deve ter pelo menos 6 caracteres";
                } elseif ($nova_senha !== $confirmar_senha) {
                    $erro = "As senhas não coincidem";
                } else {
                    // Atualiza a senha
                    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE id = ?");
                    $stmt->execute([$senha_hash, $usuario_id]);
                    
                    // Limpa o token
                    limparTokenRecuperacao($usuario_id);
                    
                    $mensagem = "Senha redefinida com sucesso! Você já pode fazer login com sua nova senha.";
                    $token_valido = false;
                }
            }
        } else {
            $erro = "Usuário não encontrado.";
        }
    } catch (PDOException $e) {
        $erro = "Erro ao processar sua solicitação. Por favor, tente novamente.";
        error_log("Erro na redefinição de senha: " . $e->getMessage());
    }
} else {
    $erro = "Link de redefinição inválido.";
}

if ($erro && !$token) {
    header("Location: recuperar-senha.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinir Senha - Essence Aesthetic</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <main class="auth-container">
        <div class="auth-box">
            <h1>Redefinir Senha</h1>
            
            <?php if ($mensagem): ?>
                <div class="alert alert-success"><?= htmlspecialchars($mensagem) ?></div>
                <div class="links-footer">
                    <p><a href="login.php">Voltar para o login</a></p>
                </div>
            <?php elseif ($token_valido): ?>
                <?php if ($erro): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                <?php endif; ?>
                
                <form method="post">
                    <div class="form-group">
                        <label for="nova_senha">Nova Senha</label>
                        <input type="password" id="nova_senha" name="nova_senha" class="input-field" 
                               placeholder="Digite sua nova senha (mínimo 6 caracteres)" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmar_senha">Confirmar Nova Senha</label>
                        <input type="password" id="confirmar_senha" name="confirmar_senha" class="input-field" 
                               placeholder="Confirme sua nova senha" required>
                    </div>
                    <button type="submit" class="btn-auth btn-primary-auth">Redefinir Senha</button>
                </form>
            <?php else: ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                <div class="links-footer">
                    <p><a href="recuperar-senha.php">Solicitar novo link</a></p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <?php require 'includes/footer.php'; ?>
</body>
</html>