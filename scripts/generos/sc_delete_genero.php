<?php
require_once "../../connections/connections.php";
$link = new_db_connection();
?>

<?php
session_start();

// Verifica se recebeu um ID válido
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id_genero = $_GET["id"];
    $link = new_db_connection();

    // Verifica se o género está associado a filmes
    $stmt_check = mysqli_stmt_init($link);
    $query_check = "SELECT COUNT(*) FROM filmes WHERE ref_generos = ?";

    if (mysqli_stmt_prepare($stmt_check, $query_check)) {
        mysqli_stmt_bind_param($stmt_check, "i", $id_genero);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_bind_result($stmt_check, $total);
        mysqli_stmt_fetch($stmt_check);
        mysqli_stmt_close($stmt_check);

        if ($total > 0) {
            // Não pode apagar se estiver associado a filmes
            mysqli_close($link);
            header("Location: ../../generos.php?msg=5"); // género com dependências
            exit();
        }

        // Continua com o DELETE
        $stmt = mysqli_stmt_init($link);
        $query = "DELETE FROM generos WHERE id_generos = ?";

        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id_genero);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: ../../generos.php?msg=6"); // sucesso
            } else {
                header("Location: ../../generos.php?msg=2"); // erro ao apagar
            }

            mysqli_stmt_close($stmt);
        } else {
            header("Location: ../../generos.php?msg=3"); // erro na preparação
        }

        mysqli_close($link);
    } else {
        header("Location: ../../generos.php?msg=3"); // erro na preparação
        exit();
    }
} else {
    header("Location: ../../generos.php?msg=4"); // ID inválido
    exit();
}
?>
