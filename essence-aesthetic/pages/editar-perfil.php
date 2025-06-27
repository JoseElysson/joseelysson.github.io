<?php
// pages/editar-perfil.php
require '../config.php';

// Define o título da página
$pageTitle = 'Editar Perfil | Essence Aesthetic';

require __DIR__ . '/../includes/functions.php';
require __DIR__ . '/../includes/db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ' . BASE_URL . '/login.php');
    exit;
}

$mensagem = '';

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Atualizar dados básicos
    if (isset($_POST['atualizar_dados'])) {
        $novo_nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING));
        $novo_email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

        if ($novo_nome && filter_var($novo_email, FILTER_VALIDATE_EMAIL)) {
            try {
                $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ? WHERE id = ?");
                $stmt->execute([$novo_nome, $novo_email, $_SESSION['usuario_id']]);
                
                $_SESSION['usuario_nome'] = $novo_nome;
                $_SESSION['usuario_email'] = $novo_email;
                $_SESSION['sucesso'] = "Dados atualizados com sucesso!";
                header('Location: ' . BASE_URL . '/pages/perfil.php');
                exit;
            } catch (PDOException $e) {
                $mensagem = "Erro ao atualizar dados: " . $e->getMessage();
            }
        } else {
            $mensagem = "Nome ou email inválido.";
        }
    }

    // Upload de foto
    if (isset($_POST['atualizar_foto']) && isset($_FILES['foto'])) {
        $diretorio = BASE_PATH . '/assets/images/profile/';
        
        // Verifica se o diretório existe, se não, cria
        if (!file_exists($diretorio)) {
            mkdir($diretorio, 0755, true);
        }
        
        $nomeArquivo = uniqid() . '_' . basename($_FILES['foto']['name']);
        $caminhoCompleto = $diretorio . $nomeArquivo;
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
        $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        if (in_array($extensao, $extensoesPermitidas)) {
            if ($_FILES['foto']['size'] > 5000000) { // 5MB máximo
                $mensagem = "O arquivo é muito grande. Tamanho máximo permitido: 5MB.";
            } elseif (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoCompleto)) {
                // Atualiza no banco de dados
                $caminhoRelativo = 'assets/images/profile/' . $nomeArquivo;
                $stmt = $pdo->prepare("UPDATE usuarios SET foto = ? WHERE id = ?");
                $stmt->execute([$caminhoRelativo, $_SESSION['usuario_id']]);
                
                $_SESSION['foto'] = $caminhoRelativo;
                $_SESSION['sucesso'] = "Foto atualizada com sucesso!";
                header('Location: ' . BASE_URL . '/pages/perfil.php');
                exit;
            } else {
                $mensagem = "Erro ao fazer upload da foto.";
            }
        } else {
            $mensagem = "Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
        }
    }
}
?>

<style>
/* ==================== */
/* RESET E BASE */
/* ==================== */
*,
*::before,
*::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

html {
  scroll-behavior: smooth;
  font-size: 16px;
}

body {
  font-family: 'Segoe UI', sans-serif;
  line-height: 1.6;
  color: #333;
  background-color: #f8f9fa;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  padding-top: 2rem;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.card {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.card-header {
  background: #fff;
  border-bottom: 1px solid #eee;
  padding: 1.5rem;
  text-align: center;
}

.card-body {
  padding: 2rem;
}

.form-label {
  font-weight: 600;
  color: #444;
}

.form-control {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  transition: border-color 0.3s ease;
}

.form-control:focus {
  border-color: #007bff;
  outline: none;
  box-shadow: 0 0 0 4px rgba(0, 123, 255, 0.1);
}

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.btn-primary {
  background-color: #007bff;
  color: #fff;
  border: none;
}

.btn-primary:hover {
  background-color: #0056b3;
  transform: translateY(-2px);
}

.btn-outline-primary {
  background: transparent;
  border: 1px solid #007bff;
  color: #007bff;
}

.btn-outline-primary:hover {
  background-color: #007bff;
  color: #fff;
}

.alert {
  padding: 1rem;
  border-radius: 8px;
  margin-bottom: 1.5rem;
}

.alert-warning {
  background-color: #fff3cd;
  color: #856404;
  border: 1px solid #ffeeba;
}

hr {
  border: 0;
  height: 1px;
  background: #eee;
  margin: 2rem 0;
}

.d-grid {
  display: grid;
}

/* Responsive Design */
@media (max-width: 768px) {
  .card {
    border-radius: 10px;
  }

  .form-control {
    font-size: 0.9rem;
  }

  .btn {
    font-size: 0.9rem;
  }
}
</style>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-0">
                    <h1 class="h4 mb-0 text-center">Editar Perfil</h1>
                </div>
                <div class="card-body">
                    <?php if ($mensagem): ?>
                        <div class="alert alert-warning"><?= htmlspecialchars($mensagem) ?></div>
                    <?php endif; ?>

                    <!-- Formulário de dados -->
                    <form method="post" class="mb-4">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" name="nome" id="nome" class="form-control" 
                                   value="<?= htmlspecialchars($_SESSION['usuario_nome'] ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                   value="<?= htmlspecialchars($_SESSION['usuario_email'] ?? '') ?>" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="atualizar_dados" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar Dados
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <!-- Upload de foto -->
                    <form method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto de Perfil</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" required>
                            <div class="form-text">Formatos aceitos: JPG, PNG, GIF (Máx. 5MB)</div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="atualizar_foto" class="btn btn-outline-primary">
                                <i class="fas fa-camera me-2"></i>Atualizar Foto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>