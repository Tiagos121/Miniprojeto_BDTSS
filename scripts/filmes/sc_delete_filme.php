<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../connections/connections.php";
$link = new_db_connection();
?>

<?php
if (isset($_POST["filmes"]) && is_array($_POST["filmes"])) {

    //Stmt's para select capa e delete filmes
    $stmt_select = mysqli_stmt_init($link);
    $stmt_delete = mysqli_stmt_init($link);

    //Querys's para select capa e delete filmes
    $query_select = "SELECT capa FROM filmes WHERE id_filmes = ?";
    $query_delete = "DELETE FROM filmes WHERE id_filmes = ?";

    if (mysqli_stmt_prepare($stmt_select, $query_select) && mysqli_stmt_prepare($stmt_delete, $query_delete)) {

        //Pada cada valor na array, associa ao parametro
        foreach ($_POST["filmes"] as $id_filme) {
            if (is_numeric($id_filme)) {

                //Garantir que o id é um valor inteiro
                $id_filme = intval($id_filme);

                // Obter o caminho da imagem
                mysqli_stmt_bind_param($stmt_select, "i", $id_filme);
                mysqli_stmt_execute($stmt_select);
                mysqli_stmt_bind_result($stmt_select, $capa_path);

                //Se tiver resultado, elimina a capa
                if (mysqli_stmt_fetch($stmt_select)) {
                    $full_path = "../../" . $capa_path; // Definir diretorio para a capa
                    if (file_exists($full_path)) {
                        unlink($full_path); // Apagar o ficheiro
                    }
                }

                //Libertar Memória devido ao foreach
                mysqli_stmt_free_result($stmt_select);

                // Eliminar o registo do filme
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
