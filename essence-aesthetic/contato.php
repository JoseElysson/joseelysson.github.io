<?php require 'includes/header.php'; ?>
<main>
    <section class="hero">
        <div class="container">
            <h1>Fale Conosco</h1>
            <p>Precisa de ajuda? Entre em contato conosco!</p>
        </div>
    </section>

    <section class="contact-section" style="padding: 60px 0;">
        <div class="container">
            <div class="contact-info" style="margin-bottom: 40px;">
                <p><strong>Endereço:</strong> Rua das Flores, 123 - São Paulo, SP</p>
                <p><strong>Telefone:</strong> (11) 98765-4321</p>
                <p><strong>Email:</strong> contato@essence.com.br</p>
            </div>

            <form action="#" method="post" class="contact-form">
                <input type="text" name="nome" placeholder="Seu nome" required>
                <input type="email" name="email" placeholder="Seu email" required>
                <textarea name="mensagem" rows="5" placeholder="Sua mensagem..." required></textarea>
                <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
            </form>
        </div>
    </section>
</main>

<style>
.contact-form input,
.contact-form textarea {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>

<?php require 'includes/footer.php'; ?>