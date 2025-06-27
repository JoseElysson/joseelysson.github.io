<?php
// includes/config.php

// Controle de sessão seguro
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Definição de constantes para caminhos
define('BASE_PATH', __DIR__ . '/..');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/essence-aesthetic');
define('ASSETS_URL', BASE_URL . '/assets');
?>