<?php include_once "./components/cp_head.php" ?>

<?php include_once "./components/cp_navbar.php" ?>

    <!-- Conteúdo dinâmico -->
<?php
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    include_once "./components/cp_generos_filmes.php";
} else {
    include_once "./components/cp_lista_generos.php";
}
?>

<?php include_once "./components/cp_footer.php" ?>