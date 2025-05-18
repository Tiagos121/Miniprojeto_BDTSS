<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../connections/connections.php";
$link = new_db_connection();
?>

<?php
if (isset($_GET["id_comentario"], $_GET["id_filme"]) && isset($_SESSION["id"])) {
    $id_comentario = intval($_GET["id_comentario"]);
    $id_filme     = intval($_GET["id_filme"]);


    $stmt = mysqli_stmt_init($link);
    $query = "DELETE FROM comentarios WHERE id_comentarios = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $id_comentario);

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
