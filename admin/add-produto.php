<?php
session_start();
require '../includes/header.php';
require '../includes/functions.php';

protegerAdmin();

$sucesso = $erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $preco = str_replace(',', '.', $_POST['preco']);
    $local_loja = trim($_POST['local_loja']);

    if (!$nome || !$preco || !$local_loja) {
        $erro = "Todos os campos são obrigatórios.";
    } else {
        if (cadastrarProduto($nome, $preco, $local_loja)) {
            $sucesso = "Produto adicionado com sucesso!";
        } else {
            $erro = "Erro ao salvar produto.";
        }
    }
}
?>

<main class="auth-container">
    <div class="auth-box">
        <h1>Adicionar Produto</h1>
        
        <?php if ($erro) exibirMensagem('error', $erro); ?>
        <?php if ($sucesso) exibirMensagem('success', $sucesso); ?>

        <form method="post">
            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" id="nome" name="nome" class="input-field" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="text" id="preco" name="preco" class="input-field" placeholder="Ex: 99,99" required>
            </div>
            <div class="form-group">
                <label for="local_loja">Local da Loja</label>
                <input type="text" id="local_loja" name="local_loja" class="input-field" required>
            </div>
            <button type="submit" class="btn-auth btn-primary-auth">Salvar Produto</button>
        </form>
    </div>
</main>

<?php require '../includes/footer.php'; ?>