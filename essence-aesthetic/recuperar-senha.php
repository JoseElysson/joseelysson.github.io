<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php'; // Certifique-se que está incluído
require 'includes/header.php';

// Inicia a sessão antes de qualquer saída
startSessionIfNotStarted();

$mensagem = null;
$erro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Por favor, insira um e-mail válido";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id, nome FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($usuario = $stmt->fetch()) {
                $token = gerarTokenRecuperacao($pdo, $usuario['id']);
                $link = "https://".$_SERVER['HTTP_HOST']."/redefinir-senha.php?user_id={$usuario['id']}&token=$token";

                // Configuração do PHPMailer
                $mail = new PHPMailer(true);
                
                try {
                    // Configurações do servidor SMTP (substitua com seus dados)
                    $mail->isSMTP();
                    $mail->Host = 'smtp.seuprovedor.com'; // Ex: smtp.gmail.com
                    $mail->SMTPAuth = true;
                    $mail->Username = 'seuemail@seusite.com'; // Seu e-mail
                    $mail->Password = 'suasenha'; // Sua senha
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Ou ENCRYPTION_SMTPS
                    $mail->Port = 587; // 465 para SSL

                    // Remetente e destinatário
                    $mail->setFrom('nao-responda@seusite.com', 'Essence Aesthetic');
                    $mail->addAddress($usuario['email'], $usuario['nome']);

                    // Conteúdo do e-mail
                    $mail->isHTML(true);
                    $mail->Subject = 'Recuperação de Senha - Essence Aesthetic';
                    $mail->Body = "
                        <h1>Olá {$usuario['nome']},</h1>
                        <p>Recebemos uma solicitação para redefinir sua senha.</p>
                        <p>Clique no link abaixo para continuar:</p>
                        <p><a href='$link' style='padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Redefinir Senha</a></p>
                        <p>O link expirará em 1 hora.</p>
                        <p>Caso não tenha solicitado esta alteração, ignore este e-mail.</p>
                    ";
                    $mail->AltBody = "Olá {$usuario['nome']},\n\nClique no link para redefinir sua senha:\n$link\n\nO link expira em 1 hora.";

                    $mail->send();
                    $mensagem = "Enviamos um e-mail com instruções para redefinir sua senha.";
                    
                } catch (Exception $e) {
                    error_log("Erro ao enviar email: " . $mail->ErrorInfo);
                    
                    // Modo desenvolvimento - mostra o link
                    if (in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1'])) {
                        $mensagem = "Erro ao enviar e-mail. Em produção, verifique as configurações SMTP.<br>"
                                  . "Link de desenvolvimento: <a href='$link'>$link</a>";
                    } else {
                        $erro = "Erro ao enviar e-mail. Por favor, tente novamente mais tarde.";
                    }
                }
            } else {
                // Mesma mensagem para e-mail existente ou não (por segurança)
                $mensagem = "Se o e-mail existir em nosso sistema, você receberá um link de recuperação.";
            }
        } catch (PDOException $e) {
            $erro = "Erro ao processar sua solicitação. Por favor, tente novamente.";
            error_log("Erro na recuperação de senha: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha - Essence Aesthetic</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <main class="auth-container">
        <div class="auth-box">
            <h1>Recuperar Senha</h1>
            
            <?php if ($mensagem): ?>
                <div class="alert alert-success"><?= htmlspecialchars($mensagem) ?></div>
            <?php endif; ?>
            
            <?php if ($erro): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="input-field" 
                           placeholder="Seu email cadastrado" required>
                </div>
                <button type="submit" class="btn-auth btn-primary-auth">Enviar Link</button>
            </form>
            
            <div class="links-footer">
                <p>Lembrou sua senha? <a href="login.php">Faça login</a></p>
            </div>
        </div>
    </main>

    <?php require 'includes/footer.php'; ?>
</body>
</html>