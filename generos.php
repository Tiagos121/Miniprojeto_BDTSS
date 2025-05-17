<!-- Head -->
<?php include_once "./components/cp_head.php" ?>

<!-- Navigation -->
<?php include_once "./components/cp_navbar.php" ?>

<?php
    // Verificar se existe id e é numérico
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        include_once "./components/cp_generos_filmes.php";
    } else {
        include_once "./components/cp_lista_generos.php";
    }
?>

<!-- Rodapé -->
<?php include_once "./components/cp_footer.php" ?>