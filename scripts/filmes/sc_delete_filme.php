<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../connections/connections.php";
$link = new_db_connection();
?>

<?php
if (isset($_POST["filmes"]) && is_array($_POST["filmes"])) {

    $stmt_select = mysqli_stmt_init($link);
    $stmt_delete = mysqli_stmt_init($link);

    $query_select = "SELECT capa FROM filmes WHERE id_filmes = ?";
    $query_delete = "DELETE FROM filmes WHERE id_filmes = ?";

    if (mysqli_stmt_prepare($stmt_select, $query_select) && mysqli_stmt_prepare($stmt_delete, $query_delete)) {
        foreach ($_POST["filmes"] as $id_filme) {
            if (is_numeric($id_filme)) {
                $id_filme = intval($id_filme);

                // Obter o caminho da imagem
                mysqli_stmt_bind_param($stmt_select, "i", $id_filme);
                mysqli_stmt_execute($stmt_select);
                mysqli_stmt_bind_result($stmt_select, $capa_path);

                if (mysqli_stmt_fetch($stmt_select)) {
                    $full_path = "../../" . $capa_path;
                    if (file_exists($full_path)) {
                        unlink($full_path); // Apaga o arquivo
                    }
                }
                mysqli_stmt_free_result($stmt_select);

                // Executar o delete
                mysqli_stmt_bind_param($stmt_delete, "i", $id_filme);
                mysqli_stmt_execute($stmt_delete);
            }
        }

        mysqli_stmt_close($stmt_select);
        mysqli_stmt_close($stmt_delete);
        mysqli_close($link);

        header("Location: ../../delete_filme.php?msg=6");
        exit();
    } else {
        mysqli_close($link);
        header("Location: ../../delete_filme.php?msg=3");
        exit();
    }
} else {
    header("Location: ../../delete_filme.php?msg=3");
    exit();
}
?>
