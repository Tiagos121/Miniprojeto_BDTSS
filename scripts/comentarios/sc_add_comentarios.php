<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../connections/connections.php";
$link = new_db_connection();
?>

<?php
if (isset($_POST["comentario"], $_POST["id_filme"]) && isset($_SESSION["id"])) {
    $comentario = trim($_POST["comentario"]);
    $id_filme = $_POST["id_filme"];
    $id_user = $_SESSION["id"];


    $stmt = mysqli_stmt_init($link);
    $query = "INSERT INTO comentarios (comentario, ref_filmes, ref_utilizadores) VALUES (?,?,?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "sii", $comentario, $id_filme, $id_user);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../../filme_detail.php?id=$id_filme");
            exit;
        } else {
            header("Location: ../../filme_detail.php?id=$id_filme&msg=erro_execucao");
            exit;
        }
    } else {
        header("Location: ../../filme_detail.php?id=$id_filme&msg=erro_prepare");
        exit;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    header("Location: ../../filmes.php?msg=erro_dados");
    exit;
}
?>
