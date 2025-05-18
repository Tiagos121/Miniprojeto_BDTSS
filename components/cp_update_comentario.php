<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "./connections/connections.php";
$link = new_db_connection();
?>

<?php
if (!isset($_SESSION["id"])) {
    header("Location: ../login.php?msg=login_incompleto");
    exit;
}

//Pegarid do comentario
if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $id_comentario = intval($_GET["id"]);
} else {
    header("Location: ../update_comentario.php?msg=erro_dados");
    exit;
}

//Buscar id do filme pelo comentario
$stmt_filme = mysqli_stmt_init($link);
$query_filme = "SELECT ref_filmes FROM comentarios WHERE id_comentarios = ?";
if (mysqli_stmt_prepare($stmt_filme, $query_filme)) {
    mysqli_stmt_bind_param($stmt_filme, "i", $id_comentario);
    mysqli_stmt_execute($stmt_filme);
    mysqli_stmt_bind_result($stmt_filme, $id_filme);
    mysqli_stmt_fetch($stmt_filme);
    mysqli_stmt_close($stmt_filme);
} else {
    $id_filme = null;
}

//Query do do comentario
$stmt = mysqli_stmt_init($link);
$query = "SELECT comentario, ref_utilizadores FROM comentarios WHERE id_comentarios = ?";
if (mysqli_stmt_prepare($stmt, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $id_comentario);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $comentario, $autor_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
} else {
    header("Location: ../update_comentario.php?id={$id_comentario}&msg=erro_prepare");
    exit;
}
?>

<section class="sec-filmes pb-5" id="lista-generos">
    <div class="container px-lg-5 pt-3">
        <section class="sec-filmes pt-5" id="lista-generos">
            <div class="container px-lg-5 pt-5">
                <form action="scripts/comentarios/sc_update_comentarios.php" method="post">
                    <input type="hidden" name="id_comentario" value="<?= htmlspecialchars($id_comentario) ?>">
                    <input type="hidden" name="id_filme"      value="<?= htmlspecialchars($id_filme) ?>">
                    <div class="mb-3">
                        <label for="comentario" class="form-label">Comentário</label>
                        <textarea class="form-control" id="comentario" name="comentario" rows="4" required><?= htmlspecialchars($comentario) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Atualizar</button>
                    <a  href="filme_detail.php?id=<?= $id_filme ?>" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </section>
    </div>
</section>