<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php?redirect=agendamento');
    exit();
}

// Caminho absoluto para db.php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/header.php';

// Processar formulário de agendamento
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servico_id = filter_input(INPUT_POST, 'servico', FILTER_VALIDATE_INT);
    $profissional_id = filter_input(INPUT_POST, 'profissional', FILTER_VALIDATE_INT);
    $data = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_STRING);
    $hora = filter_input(INPUT_POST, 'hora', FILTER_SANITIZE_STRING);
    $observacoes = filter_input(INPUT_POST, 'observacoes', FILTER_SANITIZE_STRING);
    
    if ($servico_id && $profissional_id && $data && $hora) {
        $data_agendamento = "$data $hora:00";
        
        try {
            $stmt = $pdo->prepare("INSERT INTO agendamentos (usuario_id, servico_id, profissional_id, data_agendamento, observacoes) 
                                  VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_SESSION['usuario_id'], $servico_id, $profissional_id, $data_agendamento, $observacoes]);
            
            header('Location: perfil.php?agendamento=sucesso');
            exit();
        } catch (PDOException $e) {
            $erro = "Erro ao agendar: " . $e->getMessage();
        }
    } else {
        $erro = "Preencha todos os campos obrigatórios";
    }
}

$servicos = $pdo->query("SELECT * FROM servicos")->fetchAll();
$profissionais = $pdo->query("SELECT * FROM profissionais")->fetchAll();
?>

<main class="agendamento-page">
    <div class="container">
        <h1>Agendar Serviço</h1>
        
        <form method="post" class="agendamento-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="servico">Serviço</label>
                    <select id="servico" name="servico" class="form-control" required>
                        <option value="">Selecione um serviço</option>
                        <?php foreach ($servicos as $servico): ?>
                            <option value="<?= $servico['id'] ?>"><?= htmlspecialchars($servico['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="profissional">Profissional</label>
                    <select id="profissional" name="profissional" class="form-control" required>
                        <option value="">Selecione um profissional</option>
                        <?php foreach ($profissionais as $profissional): ?>
                            <option value="<?= $profissional['id'] ?>">
                                <?= htmlspecialchars($profissional['nome']) ?> - <?= $profissional['especialidade'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="data">Data</label>
                    <input type="date" id="data" name="data" class="form-control" min="<?= date('Y-m-d') ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="hora">Hora</label>
                    <select id="hora" name="hora" class="form-control" required>
                        <option value="">Selecione um horário</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label for="observacoes">Observações</label>
                <textarea id="observacoes" name="observacoes" class="form-control" rows="3"></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Confirmar Agendamento</button>
        </form>
    </div>
</main>

<script>
document.getElementById('profissional').addEventListener('change', function() {
    const profissionalId = this.value;
    const dataInput = document.getElementById('data');

    if (profissionalId && dataInput.value) {
        fetch(`horarios_disponiveis.php?profissional_id=${profissionalId}&data=${dataInput.value}`)
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
</script>

<?php require 'includes/footer.php'; ?>