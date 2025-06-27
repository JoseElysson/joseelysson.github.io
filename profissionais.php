<?php require 'includes/header.php'; ?>
<main>
    <section class="hero">
        <div class="container">
            <h1>Nossos Profissionais</h1>
            <p>Conheça nossa equipe especializada e pronta para atender você.</p>
        </div>
    </section>

    <section class="team-section" style="padding: 60px 0; background-color: #e9f0ff;">
        <div class="container">
            <div class="team-member">
                <img src="assets/images/user-avatar.jpg" alt="Profissional 1" width="100" style="border-radius: 50%; margin-bottom: 15px;">
                <h3>Carla Silva</h3>
                <p><strong>Especialidade:</strong> Estética Facial</p>
                <p>Cref: SP12345678</p>
            </div>
            <div class="team-member">
                <img src="assets/images/user-avatar.jpg" alt="Profissional 2" width="100" style="border-radius: 50%; margin-bottom: 15px;">
                <h3>Joana Oliveira</h3>
                <p><strong>Especialidade:</strong> Maquiagem e Design</p>
                <p>Cref: SP87654321</p>
            </div>
            <div class="team-member">
                <img src="assets/images/user-avatar.jpg" alt="Profissional 3" width="100" style="border-radius: 50%; margin-bottom: 15px;">
                <h3>Rafael Costa</h3>
                <p><strong>Especialidade:</strong> Massagem Corporal</p>
                <p>Cref: SP11223344</p>
            </div>
        </div>
    </section>
</main>

<style>
.team-section .team-member {
    background: white;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    text-align: center;
    transition: transform 0.3s ease;
}
.team-section .team-member:hover {
    transform: translateY(-5px);
}
.team-section .team-member h3 {
    color: #007BFF;
    margin-top: 10px;
}
.team-section .team-member p {
    font-size: 0.9rem;
}
</style>

<?php require 'includes/footer.php'; ?>