<?php
/**
 * Arquivo: includes/functions.php
 * Funções utilitárias para o sistema Essence Aesthetic
 */

/**
 * Redireciona para uma URL específica
 * @param string $url URL para redirecionamento
 */
function redirecionar(string $url): void {
    header("Location: " . filter_var($url, FILTER_SANITIZE_URL));
    exit;
}

/**
 * Exibe uma mensagem estilizada
 * @param string $tipo Tipo da mensagem (success, error, warning, info)
 * @param string $mensagem Conteúdo da mensagem
 */
function exibirMensagem(string $tipo, string $mensagem): void {
    $tiposPermitidos = ['success', 'error', 'warning', 'info'];
    $tipo = in_array($tipo, $tiposPermitidos) ? $tipo : 'info';
    
    echo '<div class="alert alert-' . htmlspecialchars($tipo) . '">' . 
         htmlspecialchars($mensagem) . '</div>';
}

/**
 * Formata um valor como moeda brasileira
 * @param float $valor Valor a ser formatado
 * @return string Valor formatado
 */
function formatarMoeda(float $valor): string {
    return "R$ " . number_format($valor, 2, ",", ".");
}

/**
 * Faz upload de uma foto de perfil com validações
 * @param string $fileInputName Nome do campo do formulário
 * @param string $destino Pasta de destino (padrão: assets/images/profile/)
 * @return string|false Retorna o caminho ou mensagem de erro
 */
/**
 * Faz upload de uma foto de perfil com validações
 * @param string $fileInputName Nome do campo do formulário
 * @param string $destino Pasta de destino (padrão: assets/images/profile/)
 * @return string|false Retorna o caminho ou mensagem de erro
 */
function uploadFotoPerfil(string $fileInputName, string $destino = 'assets/images/profile/'): string|false {
    // Verifica se o arquivo foi enviado (corrigido)
    if (!isset($_FILES[$fileInputName])) {
        return false;
    }

    $file = $_FILES[$fileInputName];

    // Verifica erros de upload
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "Erro no upload: " . $file['error'];
    }

    // Valida o tamanho (máximo 2MB)
    if ($file['size'] > 2097152) {
        return "O arquivo deve ter no máximo 2MB";
    }

    // Valida a extensão
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];
    $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    if (!in_array($extensao, $extensoesPermitidas)) {
        return "Extensão não permitida. Use JPG, PNG ou GIF.";
    }

    // Valida o tipo MIME real
    $mime = mime_content_type($file['tmp_name']);
    $mimesPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    
    if (!in_array($mime, $mimesPermitidos)) {
        return "Tipo de arquivo inválido.";
    }

    // Gera nome único para o arquivo
    $nomeUnico = uniqid() . '_' . bin2hex(random_bytes(8)) . '.' . $extensao;
    $caminhoCompleto = $destino . $nomeUnico;

    // Cria o diretório se não existir
    if (!is_dir($destino)) {
        mkdir($destino, 0755, true);
    }

    // Move o arquivo
    if (!move_uploaded_file($file['tmp_name'], $caminhoCompleto)) {
        return "Erro ao salvar o arquivo.";
    }

    return $caminhoCompleto;
}

/**
 * Inicia a sessão com configurações seguras
 */
function startSessionIfNotStarted(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start([
            'name' => 'ESSENCE_SESSION',
            'cookie_lifetime' => 86400, // 1 dia
            'cookie_secure' => isset($_SERVER['HTTPS']),
            'cookie_httponly' => true,
            'cookie_samesite' => 'Strict',
            'use_strict_mode' => true,
            'use_only_cookies' => 1
        ]);
    }
}

/**
 * Gera token para recuperação de senha
 * @param PDO $pdo Conexão com o banco
 * @param int $usuario_id ID do usuário
 * @return string Token gerado
 */
function gerarTokenRecuperacao(PDO $pdo, int $usuario_id): string {
    startSessionIfNotStarted();
    
    $token = bin2hex(random_bytes(32));
    $expiracao = date('Y-m-d H:i:s', strtotime('+1 hour'));
    
    $_SESSION['tokens_recuperacao'][$usuario_id] = [
        'token' => $token,
        'expiracao' => $expiracao
    ];
    
    return $token;
}

/**
 * Verifica se um token de recuperação é válido
 * @param PDO $pdo Conexão com o banco
 * @param int $usuario_id ID do usuário
 * @param string $token Token a ser verificado
 * @return bool True se válido, False caso contrário
 */
function verificarTokenRecuperacao(PDO $pdo, int $usuario_id, string $token): bool {
    startSessionIfNotStarted();
    
    if (!isset($_SESSION['tokens_recuperacao'][$usuario_id])) {
        return false;
    }
    
    $dados_token = $_SESSION['tokens_recuperacao'][$usuario_id];
    
    return ($dados_token['token'] === $token && 
            strtotime($dados_token['expiracao']) > time());
}

/**
 * Remove token de recuperação
 * @param int $usuario_id ID do usuário
 */
function limparTokenRecuperacao(int $usuario_id): void {
    startSessionIfNotStarted();
    unset($_SESSION['tokens_recuperacao'][$usuario_id]);
}

/**
 * Verifica e retorna dados do usuário logado
 * @return array|false Array com dados do usuário ou False se não logado
 */
function usuarioLogado(): array|false {
    startSessionIfNotStarted();
    
    if (!isset($_SESSION['usuario_id'])) {
        return false;
    }
    
    return [
        'id' => $_SESSION['usuario_id'],
        'nome' => $_SESSION['usuario_nome'] ?? 'Não informado',
        'email' => $_SESSION['usuario_email'] ?? 'Não informado',
        'foto' => $_SESSION['usuario_foto'] ?? 'assets/user-avatar.jpg',
        'data_cadastro' => $_SESSION['usuario_data_cadastro'] ?? 'Não disponível',
        'nivel_acesso' => $_SESSION['usuario_nivel_acesso'] ?? 1
    ];
}

/**
 * Verifica nível de acesso do usuário
 * @param int $nivelRequerido Nível mínimo requerido
 * @return bool True se autorizado, False caso contrário
 */
function verificarAcesso(int $nivelRequerido = 1): bool {
    $usuario = usuarioLogado();
    return ($usuario && ($usuario['nivel_acesso'] >= $nivelRequerido));
}

/**
 * Formata data para exibição amigável
 * @param string $data Data no formato Y-m-d
 * @return string Data formatada (ex: "15 de Janeiro de 2023")
 */
function formatarData(string $data): string {
    $meses = [
        1 => 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
        'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
    ];
    
    $timestamp = strtotime($data);
    return date('d', $timestamp) . ' de ' . 
           $meses[date('n', $timestamp)] . ' de ' . 
           date('Y', $timestamp);
}

/**
 * Gera HTML seguro para exibição
 * @param string $texto Texto a ser sanitizado
 * @return string Texto seguro para exibição HTML
 */
function sanitizarHTML(string $texto): string {
    return htmlspecialchars($texto, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Converte texto para URL amigável
 * @param string $texto Texto a ser convertido
 * @return string Texto em formato URL amigável
 */
function slugify(string $texto): string {
    $texto = preg_replace('~[^\pL\d]+~u', '-', $texto);
    $texto = iconv('utf-8', 'us-ascii//TRANSLIT', $texto);
    $texto = preg_replace('~[^-\w]+~', '', $texto);
    $texto = trim($texto, '-');
    $texto = preg_replace('~-+~', '-', $texto);
    $texto = strtolower($texto);
    
    return $texto ?: 'n-a';
}
?>