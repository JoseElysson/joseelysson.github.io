// Atualizar horários quando data muda
document.getElementById('data').addEventListener('change', function() {
    const profissionalId = document.getElementById('profissional').value;
    const data = this.value;
    
    if (profissionalId && data) {
        fetch(`horarios_disponiveis.php?profissional_id=${profissionalId}&data=${data}`)
            .then(response => response.json())
            .then(horarios => {
                const horaSelect = document.getElementById('hora');
                horaSelect.innerHTML = '<option value="">Selecione um horário</option>';
                
                horarios.forEach(hora => {
                    const option = document.createElement('option');
                    option.value = hora;
                    option.textContent = hora;
                    horaSelect.appendChild(option);
                });
            });
    }
});

// Adicionar CSRF token a todos os formulários
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = 'csrf_token';
    csrfToken.value = '<?= bin2hex(random_bytes(32)) ?>';
    
    forms.forEach(form => form.appendChild(csrfToken.cloneNode()));
});