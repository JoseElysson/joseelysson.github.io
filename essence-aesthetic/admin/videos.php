<?php
session_start();
require '../includes/header.php';
require '../includes/functions.php';

protegerAdmin();
?>

<main class="auth-container">
    <div class="auth-box">
        <h1>Vídeos para Aprendizado</h1>
        <div style="text-align:center;">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/dQw4w9WgXcQ " frameborder="0" allowfullscreen></iframe>
            <p>Como fazer make-up natural passo a passo.</p>
        </div>
    </div>
</main>

<?php require '../includes/footer.php'; ?>