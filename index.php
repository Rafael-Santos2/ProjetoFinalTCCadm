<?php
// Redireciona para a página administrativa
// Usa caminho absoluto para evitar problemas
$base_url = getenv('BASE_URL') ?: 'https://projetofinaltccadm-production.up.railway.app';
header('Location: ' . $base_url . '/admin/index.php');
exit;