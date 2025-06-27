<?php
session_start();
require '../includes/header.php';
require '../includes/functions.php';

protegerAdmin();

$produtos = listarProdutos();
?>

<main class="auth-container">
    <div class="auth-box">
        <h1>Produtos Cadastrados</h1>
        <a href="add-produto.php" class="btn btn-primary-auth" style="margin-bottom: 20px;">+ Adicionar Produto</a>
        <table style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Loja</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= $produto['id'] ?></td>
                    <td><?= htmlspecialchars($produto['nome']) ?></td>
                    <td><?= formatarMoeda($produto['preco']) ?></td>
                    <td><?= htmlspecialchars($produto['local_loja']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require '../includes/footer.php'; ?>