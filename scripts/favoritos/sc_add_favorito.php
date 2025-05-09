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

// 2. Estabelecer ligação e preparar statement
$stmt = mysqli_stmt_init($link);

// 3. Verificar que ainda não existe esse favorito
$query_check = "SELECT 1 FROM filmes_favoritos WHERE ref_utilizadores = ? AND ref_filmes = ?";
if (mysqli_stmt_prepare($stmt, $query_check)) {
    mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_filme);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) === 0) {
        // 4. Se não existe, insere
        mysqli_stmt_close($stmt);
        $stmt = mysqli_stmt_init($link);

        $query_insert = "INSERT INTO filmes_favoritos (ref_utilizadores, ref_filmes)VALUES (?, ?)";
        if (mysqli_stmt_prepare($stmt, $query_insert)) {
            mysqli_stmt_bind_param($stmt, "ii", $id_user, $id_filme);
            mysqli_stmt_execute($stmt);
        }
    }
}

// 5. Fechar e redirecionar de volta ao detalhe
mysqli_stmt_close($stmt);
mysqli_close($link);

header("Location: ../../filme_detail.php?id={$id_filme}");
exit();
?>