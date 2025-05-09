<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once "../../connections/connections.php";
    $link = new_db_connection();
?>

<?php
    // 1. Verificar se está autenticado e se o id do filme foi passado corretamente
    if (!isset($_SESSION['id']) || !isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header("Location: ../../login.php");
        exit();
    }

    $id_user  = $_SESSION['id'];
    $id_filme = (int) $_GET['id'];

    $stmt = mysqli_stmt_init($link);
    $query_check = "SELECT 1 FROM filmes_favoritos WHERE ref_utilizadores = ? AND ref_filmes = ?";
    if (mysqli_stmt_prepare($stmt, $query_check)) {
        mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_filme);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // 3. Se existir, apagar
            mysqli_stmt_close($stmt);

            $stmt = mysqli_stmt_init($link);
            $query_delete = "DELETE FROM filmes_favoritos WHERE ref_utilizadores = ? AND ref_filmes = ?";

            if (mysqli_stmt_prepare($stmt, $query_delete)) {
                mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_filme);
                mysqli_stmt_execute($stmt);
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);

    header("Location: ../../filme_detail.php?id={$id_filme}");
    exit();
?>