<?php 
// Verifica se a sessão já está ativa antes de iniciar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require __DIR__ . '/../includes/functions.php';
require __DIR__ . '/../includes/db.php';

if (!usuarioLogado()) {
    redirecionar('login.php');
}

try {
    $stmt = $pdo->prepare("SELECT nome, email, foto, data_cadastro FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario) {
        throw new Exception("Usuário não encontrado");
    }
    
    $_SESSION['usuario_nome'] = htmlspecialchars($usuario['nome'], ENT_QUOTES, 'UTF-8');
    $_SESSION['usuario_email'] = filter_var($usuario['email'], FILTER_SANITIZE_EMAIL);
    $_SESSION['foto'] = !empty($usuario['foto']) ? 
        filter_var($usuario['foto'], FILTER_SANITIZE_URL) : 
        '../assets/user-avatar.jpg';
    $_SESSION['data_cadastro'] = $usuario['data_cadastro'];
    
} catch (Exception $e) {
    error_log("Erro ao carregar perfil: " . $e->getMessage());
    $_SESSION['erro'] = "Ocorreu um erro ao carregar seu perfil. Por favor, tente novamente.";
    redirecionar('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil | Essence Aesthetic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #007BFF;
            --secondary-color: #f8f9fa;
            --dark-color: #343a40;
            --light-color: #ffffff;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .profile-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 2rem;
        }
        
        .profile-card {
            background: var(--light-color);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            padding: 2rem;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--light-color);
            box-shadow: var(--shadow);
            margin: 0 auto 1.5rem;
            display: block;
        }
        
        .edit-avatar-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: var(--primary-color);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .edit-avatar-btn:hover {
            transform: scale(1.1);
            background: #007BFF;
        }
        
        .avatar-container {
            position: relative;
            width: fit-content;
            margin: 0 auto;
        }
        
        .profile-name {
            font-size: 2rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .profile-email {
            color: #6c757d;
            font-size: 1.1rem;
        }
        
        .info-card {
            background: var(--secondary-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
        }
        
        .info-title {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }
        
        .info-value {
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        .info-icon {
            background: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 1.5rem;
        }
        
        .btn-edit {
            background: var(--primary-color);
            border: none;
            padding: 0.8rem 2rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        .btn-edit:hover {
            background: #007BFF;
        }
        
        .btn-logout {
            background: transparent;
            border: 1px solid #dc3545;
            color: #dc3545;
            padding: 0.8rem 2rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        .btn-logout:hover {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-card">
            <!-- Cabeçalho com foto e nome -->
            <div class="profile-header">
                <div class="avatar-container">
                    <img src="<?= htmlspecialchars($_SESSION['foto'], ENT_QUOTES, 'UTF-8') ?>" 
                         alt="Foto de perfil" 
                         class="profile-avatar"
                         onerror="this.src='../assets/user-avatar.jpg'">
                    <a href="editar-perfil.php" class="edit-avatar-btn">
                        <i class="fas fa-camera"></i>
                    </a>
                </div>
                <h1 class="profile-name"><?= htmlspecialchars($_SESSION['usuario_nome'], ENT_QUOTES, 'UTF-8') ?></h1>
                <div class="profile-email"><?= htmlspecialchars($_SESSION['usuario_email'], ENT_QUOTES, 'UTF-8') ?></div>
            </div>
            
            <!-- Informações do perfil -->
            <div class="row">
                <div class="col-md-6">
                    <div class="info-card d-flex align-items-center">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <div class="info-title">Email</div>
                            <div class="info-value"><?= htmlspecialchars($_SESSION['usuario_email'], ENT_QUOTES, 'UTF-8') ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="info-card d-flex align-items-center">
                        <div class="info-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div>
                            <div class="info-title">Membro desde</div>
                            <div class="info-value"><?= date('d/m/Y', strtotime($_SESSION['data_cadastro'])) ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Botões de ação -->
            <div class="d-flex justify-content-center gap-3 mt-4">
                <a href="editar-perfil.php" class="btn btn-edit text-white">
                    <i class="fas fa-user-edit me-2"></i>Editar Perfil
                </a>
                <a href="../index.php" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt me-2"></i>Sair
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>