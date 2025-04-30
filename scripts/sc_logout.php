<?php
require_once "../connections/connections.php";
?>

<?php
session_start();        // Começar ou continuar a sessão
session_unset();        // Limpar todas as variáveis de sessão
session_destroy();      // Destruir a sessão

// Redirecionar para a página de login
header("Location: ../login.php");
exit;
?>
