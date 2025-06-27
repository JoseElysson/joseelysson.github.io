<?php require 'includes/header.php'; ?>
<main>
    <!-- Hero Section -->
    <section class="hero spaced-section">
        <div class="container text-center fade-in">
            <h1>Minha Lista de Exercícios</h1>
            <p class="subtitle">Crie, gerencie e personalize sua rotina de exercícios.</p>
            <p class="description">Adicione, edite ou remova itens, incluindo duração e categorias coloridas.</p>
        </div>
    </section>

    <!-- Criar Novo Item -->
    <section class="create-section spaced-section" style="padding: 4rem 0;">
        <div class="container">
            <div class="create-box card">
                <h2 class="section-title"><i class="fas fa-plus-circle"></i> Adicionar Novo Item</h2>
                <form id="add-item-form" class="flex-form">
                    <input type="text" id="new-item" placeholder="Ex.: Alongamento matinal..." required />
                    <input type="number" id="duration" placeholder="Duração (min)" min="1" required />
                    <select id="category-color" required>
                        <option value="" disabled selected>Selecione uma categoria</option>
                        <option value="blue">Saúde Física (Azul)</option>
                        <option value="green">Meditação (Verde)</option>
                        <option value="orange">Autocuidado (Laranja)</option>
                        <option value="purple">Rotina Matinal (Roxo)</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Lista de Exercícios -->
    <section class="exercise-list spaced-section" style="padding: 4rem 0;">
        <div class="container">
            <div class="section-header">
                <h2><i class="fas fa-list-check"></i> Minha Lista de Exercícios</h2>
                <p>Gerencie sua rotina de forma prática e eficiente.</p>
            </div>

            <div id="exercise-list-container">
                <!-- Itens serão renderizados aqui dinamicamente -->
            </div>
        </div>
    </section>
</main>

<!-- Script para Funcionalidade da Lista -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('add-item-form');
    const input = document.getElementById('new-item');
    const durationInput = document.getElementById('duration');
    const categorySelect = document.getElementById('category-color');
    const container = document.getElementById('exercise-list-container');

    // Função para renderizar a lista
    function renderList() {
        const items = JSON.parse(localStorage.getItem('exerciseList')) || [];
        container.innerHTML = '';
        if (items.length === 0) {
            container.innerHTML = '<p class="empty-message">Sua lista está vazia. Adicione novos itens!</p>';
            return;
        }
        items.forEach((item, index) => {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('list-item', 'card', 'fade-in-up');
            itemDiv.innerHTML = `
                <div class="item-content">
                    <div class="item-icon" style="background-color: var(--${item.category}-light); color: var(--${item.category});">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="item-text">
                        <h4>${item.name}</h4>
                        <p class="item-duration"><i class="fas fa-clock"></i> ${item.duration} min</p>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="edit-btn" data-index="${index}"><i class="fas fa-edit"></i></button>
                    <button class="delete-btn" data-index="${index}"><i class="fas fa-trash-alt"></i></button>
                </div>
            `;
            container.appendChild(itemDiv);
        });
    }

    // Adicionar novo item
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const newItem = input.value.trim();
        const duration = durationInput.value.trim();
        const category = categorySelect.value;

        if (!newItem || !duration || !category) return;

        const items = JSON.parse(localStorage.getItem('exerciseList')) || [];
        items.push({ name: newItem, duration, category });
        localStorage.setItem('exerciseList', JSON.stringify(items));
        input.value = '';
        durationInput.value = '';
        categorySelect.value = '';
        renderList();
    });

    // Editar item
    container.addEventListener('click', (e) => {
        if (e.target.closest('.edit-btn')) {
            const index = e.target.closest('.edit-btn').getAttribute('data-index');
            const items = JSON.parse(localStorage.getItem('exerciseList')) || [];
            const updatedItem = prompt('Editar nome:', items[index].name);
            const updatedDuration = prompt('Editar duração (min):', items[index].duration);
            if (updatedItem !== null && updatedDuration !== null) {
                items[index].name = updatedItem.trim();
                items[index].duration = updatedDuration.trim();
                localStorage.setItem('exerciseList', JSON.stringify(items));
                renderList();
            }
        }
    });

    // Excluir item
    container.addEventListener('click', (e) => {
        if (e.target.closest('.delete-btn')) {
            const index = e.target.closest('.delete-btn').getAttribute('data-index');
            const items = JSON.parse(localStorage.getItem('exerciseList')) || [];
            items.splice(index, 1);
            localStorage.setItem('exerciseList', JSON.stringify(items));
            renderList();
        }
    });

    // Renderizar lista ao carregar a página
    renderList();
});
</script>

<?php require 'includes/footer.php'; ?>