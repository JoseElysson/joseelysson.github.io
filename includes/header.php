<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Essence Aesthetic</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css ">
</head>
<body>

<header class="site-header">
    <div class="header-container">
        <!-- Logo -->
        <a href="index.php" class="logo">
            <img src="assets/essence-logo.png" alt="Essence Aesthetic">
        </a>

        <!-- Navegação Principal -->
        <nav class="main-nav">
            <ul>
                <li><a href="index.php" class="nav-link">Início</a></li>
                <li><a href="tutoriais.php" class="nav-link">Tutoriais</a></li>
                <li><a href="produtos.php" class="nav-link">Produtos</a></li>
                <li><a href="blog.php" class="nav-link">Rotina</a></li>
                <li><a href="contato.php" class="nav-link">Contato</a></li>
            </ul>
        </nav>

        <!-- Ações do Usuário -->
        <div class="user-actions">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <!-- Perfil do Usuário -->
                <a href="pages/perfil.php" class="profile-link">
                    <img src="<?= $_SESSION['foto'] ?? 'assets/images/user-avatar.jpg' ?>" 
                         alt="Avatar" 
                         class="avatar-small"
                         onerror="this.src='assets/user-avatar.jpg'">
                    <span class="profile-text">Perfil</span>
                </a>
                <!-- Botão de Sair -->
                <a href="logout.php" class="btn btn-secondary">Sair</a>
            <?php else: ?>
                <!-- Links de Login e Cadastro -->
                <a href="login.php" class="btn btn-secondary">Entrar</a>
                <a href="cadastro.php" class="btn btn-primary">Cadastre-se</a>
            <?php endif; ?>
        </div>

        <!-- Ícone do Menu Mobile -->
        <button class="mobile-menu-toggle" aria-label="Abrir menu">
            <i class="fas fa-bars"></i>
        </button>
    </div>
</header>

<script>
// Toggle do Menu Mobile
document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav ul');

    mobileMenuToggle.addEventListener('click', () => {
        mainNav.classList.toggle('active');
        mobileMenuToggle.setAttribute('aria-expanded', mainNav.classList.contains('active'));
    });
});
</script>