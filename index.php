<?php require 'includes/header.php'; ?>
<main>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-content fade-in">
            <h1>Bem-vindo à Essence Aesthetic Store</h1>
            <p class="subtitle">Produtos que realçam sua beleza natural</p>
            <p class="description">Descubra nossos produtos de alta qualidade para cuidados pessoais, maquiagem e academia.</p>
            <div class="hero-buttons">
                <a href="produtos.php" class="btn btn-primary">Ver Produtos</a>
                <a href="tutoriais.php" class="btn btn-outline">Aprenda com Nossos Tutoriais</a>
            </div>
        </div>
    </section>

     <!-- Featured Products -->
    <section class="products-section" id="produtos">
        <div class="container section-padding">
            <div class="section-header">
                <h2>Nossos Produtos</h2>
                <p>Explore nossa linha de produtos estéticos e funcionais</p>
            </div>

            <div class="grid-3">
                <!-- Produto 1 - Academia -->
                <div class="product-card card">
                    <div class="service-icon">
                        <i class="fas fa-dumbbell"></i>
                    </div>
                    <h3>Whey 100% Hd Chocolate 900G, Black Skull</h3>
                    <p>Ideal para recuperação muscular após o treino.</p>
                    <a href="produtos.php?id=1" class="btn btn-outline">Saiba Mais</a>
                </div>

                <!-- Produto 2 - Beleza -->
                <div class="product-card card">
                    <div class="service-icon">
                        <i class="fas fa-spa"></i>
                    </div>
                    <h3>Base Matte PAYOT Alta Cobertura 2-30 ml</h3>
                    <p>Acabamento natural e durabilidade de até 12 horas.</p>
                    <a href="produtos.php?id=1" class="btn btn-outline">Saiba Mais</a>
                </div>

                <!-- Produto 3 - Cuidados Pessoais -->
                <div class="product-card card">
                    <div class="service-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Neutrogena Hidratante Facial Matte 3 em 1 Face Care Intensive, 100g</h3>
                    <p>Inclui: óleo corporal, máscara facial e esfoliante suave.</p>
                    <a href="produtos.php?id=1" class="btn btn-outline">Saiba Mais</a>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="produtos.php" class="btn btn-primary">Ver Todos os Produtos</a>
            </div>
        </div>
    </section>

    <!-- Recent Tutorials -->
    <section class="tutorials-section spaced-section" id="tutoriais">
        <div class="container section-padding">
            <div class="section-header">
                <h2>Tutoriais Recentes</h2>
                <p>Aprenda com nossos especialistas</p>
            </div>

            <div class="video-grid">
                <!-- Tutorial 1 -->
                <div class="video-card card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/klXpO-fP7Gw " frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Rotina Completa de Skincare</h3>
                    <p class="video-meta">Beleza • 5:37 min</p>
                </div>

                <!-- Tutorial 2 -->
                <div class="video-card card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/8-w2YaCiEFk " frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Treino Full Body para Iniciantes</h3>
                    <p class="video-meta">Academia • 4:54 min</p>
                </div>

                <!-- Tutorial 3 -->
                <div class="video-card card">
                    <div class="video-container">
                        <iframe src="https://www.youtube.com/embed/PdFZhN2ayvo " frameborder="0" allowfullscreen></iframe>
                    </div>
                    <h3>Ritual Matinal de Bem-estar</h3>
                    <p class="video-meta">Bem-estar • 9:24 min</p>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="tutoriais.php" class="btn btn-secondary">Ver Todos os Tutoriais</a>
            </div>
        </div>
    </section>

        <!-- Benefícios -->
        <section class="benefits-section spaced-section" id="beneficios">
        <div class="container">
            <div class="section-header">
            <h2>Por Que Escolher Nosso Site?</h2>
            <p>Vantagens exclusivas para você</p>
            </div>

            <div class="grid-3">
            <div class="benefit-card card">
                <div class="benefit-icon"><i class="fas fa-thumbs-up"></i></div>
                <h3>Qualidade Garantida</h3>
                <p>Produtos de marcas confiáveis e comprovadas</p>
            </div>

            <div class="benefit-card card">
                <div class="benefit-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Compras Seguras</h3>
                <p>Sua segurança é nossa prioridade. Compra 100% protegida.</p>
            </div>

            <div class="benefit-card card">
                <div class="benefit-icon"><i class="fas fa-gift"></i></div>
                <h3>Promoções Exclusivas</h3>
                <p>Descontos especiais para usuários cadastrados</p>
            </div>
            </div>
        </div>
        </section>

    <!-- Call to Action -->
    <section class="cta-section spaced-section" id="comprar">
        <div class="container cta-box">
            <h2>Pronto para Transformar Sua Beleza?</h2>
            <p class="cta-text">Confira nossa loja online e compre os melhores produtos para você</p>
            <div class="cta-buttons">
                <a href="produtos.php" class="btn btn-light">Ir para a Loja</a>
                <a href="contato.php" class="btn btn-outline-light">Fale Conosco</a>
            </div>
        </div>
    </section>
</main>
<?php require 'includes/footer.php'; ?>