<?php
// Impede acesso direto à pasta uploads
header('HTTP/1.0 403 Forbidden');
die('Acesso negado');
?>
