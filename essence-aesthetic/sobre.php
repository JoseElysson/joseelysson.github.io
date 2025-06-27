<?php require 'includes/header.php'; ?>
<main>
    <!-- Hero Section -->
    <section class="hero" style="background: linear-gradient(rgba(0, 0, 0, 0.6), url('assets/images/hero-tutorials.jpg'); background-size: cover; background-position: center;">
        <div class="container">
            <h1>Tutoriais Essenciais</h1>
            <p class="hero-subtitle">Aprenda com a Essence Aesthetic</p>
        </div>
    </section>

    <!-- Categorias de Tutoriais -->
    <section class="categories-section" style="padding: 40px 0;">
        <div class="container">
            <div class="category-tabs">
                <button class="tab-btn active" data-category="beleza">Beleza</button>
                <button class="tab-btn" data-category="academia">Academia</button>
                <button class="tab-btn" data-category="cuidados">Cuidados Pessoais</button>
            </div>
        </div>
    </section>

    <!-- Tutoriais de Beleza -->
    <section class="tutorials-section category-section active" id="beleza" style="padding: 60px 0;">
        <div class="container">
            <h2 class="section-title"><i class="fas fa-spa"></i> Tutoriais de Beleza</h2>
            
            <div class="video-grid">
                <!-- Tutorial 1 -->
                <div class="video-card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/VIDEO_BELEZA_1" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Rotina Completa de Skincare</h3>
                    <p class="video-duration">15 min</p>
                    <p class="video-desc">Aprenda a rotina matinal perfeita para sua pele</p>
                </div>
                
                <!-- Tutorial 2 -->
                <div class="video-card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/VIDEO_BELEZA_2" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Maquiagem Natural Profissional</h3>
                    <p class="video-duration">22 min</p>
                    <p class="video-desc">Técnicas para um make perfeito no dia a dia</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tutoriais de Academia -->
    <section class="tutorials-section category-section" id="academia" style="padding: 60px 0; display: none;">
        <div class="container">
            <h2 class="section-title"><i class="fas fa-dumbbell"></i> Tutoriais de Academia</h2>
            
            <div class="video-grid">
                <!-- Tutorial 1 -->
                <div class="video-card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/VIDEO_ACADEMIA_1" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Treino Completo para Iniciantes</h3>
                    <p class="video-duration">28 min</p>
                    <p class="video-desc">Exercícios fundamentais com orientação profissional</p>
                </div>
                
                <!-- Tutorial 2 -->
                <div class="video-card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/VIDEO_ACADEMIA_2" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Alongamentos Pós-Treino</h3>
                    <p class="video-duration">12 min</p>
                    <p class="video-desc">Sequência essencial para evitar lesões</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tutoriais de Cuidados Pessoais -->
    <section class="tutorials-section category-section" id="cuidados" style="padding: 60px 0; display: none;">
        <div class="container">
            <h2 class="section-title"><i class="fas fa-heart"></i> Cuidados Pessoais</h2>
            
            <div class="video-grid">
                <!-- Tutorial 1 -->
                <div class="video-card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/VIDEO_CUIDADOS_1" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Rotina Noturna de Autocuidado</h3>
                    <p class="video-duration">18 min</p>
                    <p class="video-desc">Rituais para relaxamento e bem-estar</p>
                </div>
                
                <!-- Tutorial 2 -->
                <div class="video-card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/VIDEO_CUIDADOS_2" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Meditação Guiada para Iniciantes</h3>
                    <p class="video-duration">15 min</p>
                    <p class="video-desc">Técnicas simples para reduzir o estresse</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require 'includes/footer.php'; ?>

<style>
/* Estilos Gerais */
.hero-subtitle {
    font-size: 1.5rem;
    margin-top: 15px;
    font-weight: 300;
    color: #fff;
}

.section-title {
    color: #ff6b6b;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    font-size: 1.5em;
}

/* Abas de Categorias */
.category-tabs {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 30px;
}

.tab-btn {
    padding: 12px 25px;
    background: #f0f0f0;
    border: none;
    border-radius: 30px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tab-btn.active {
    background: #ff6b6b;
    color: white;
}

/* Grid de Vídeos */
.video-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.video-card {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
}

.video-card:hover {
    transform: translateY(-5px);
}

.video-container {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 */
    height: 0;
    overflow: hidden;
    background: #000;
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.video-card h3 {
    padding: 15px 20px 5px;
    font-size: 1.2rem;
    color: #333;
}

.video-duration {
    padding: 0 20px;
    color: #ff6b6b;
    font-weight: 600;
    font-size: 0.9rem;
}

.video-desc {
    padding: 0 20px 20px;
    color: #666;
    font-size: 0.95rem;
}

/* Responsividade */
@media (max-width: 768px) {
    .category-tabs {
        flex-wrap: wrap;
    }
    
    .tab-btn {
        padding: 10px 15px;
        font-size: 0.9rem;
    }
    
    .video-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
// Controle das abas
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // Remove classe active de todos os botões
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        // Adiciona classe active ao botão clicado
        btn.classList.add('active');
        
        // Esconde todas as seções
        document.querySelectorAll('.category-section').forEach(section => {
            section.style.display = 'none';
        });
        
        // Mostra apenas a seção correspondente
        const category = btn.getAttribute('data-category');
        document.getElementById(category).style.display = 'block';
    });
});
</script>