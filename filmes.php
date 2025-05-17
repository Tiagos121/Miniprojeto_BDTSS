<!-- Head -->
<?php include_once "./components/cp_head.php" ?>

<!-- Navigation-->
<?php include_once "./components/cp_navbar.php" ?>

<!-- Filmes -->
<?php
// Verificar se existe id e é numérico
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pesquisa'])) {
    include_once "./components/cp_filmes_resultados.php";
} else {
    include_once "./components/cp_lista_filmes_v3.php";
}
?>

<!-- Rodapé -->
<?php include_once "./components/cp_footer.php" ?>