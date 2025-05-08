<?php
require_once "./connections/connections.php";
$link = new_db_connection();
?>

<?php
if (isset($_GET["id"])) {
    $id_genero = $_GET["id"];

    $stmt = mysqli_stmt_init($link);
    $query = "SELECT tipo FROM generos WHERE id_generos = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $id_genero);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $tipo);

            if (!mysqli_stmt_fetch($stmt)) {
                header("Location: generos.php");
                exit();
            }

            $_SESSION["id_genero"] = $id_genero;

        } else {
            echo "Erro: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
} else {
    header("Location: generos.php");
    exit();
}
?>

<?php include_once "components/cp_intro_update_genero.php"; ?>

        <section class="sec-filmes pb-4 pt-5" id="update-genero">
            <div class="container px-lg-5 pt-3">
        <div class="row">
            <form class="col-6" action="scripts/generos/sc_update_genero.php" method="post">
                <div class="mb-3 mt-3">
                    <label for="genero" class="form-label">Editar género:</label>
                    <input type="text" class="form-control" id="genero"
                           value="<?= htmlspecialchars($tipo) ?>" name="genero"
                           required>
                </div>
                <input type="hidden" name="id_genero" value="<?= $id_genero ?>">
                <button type="submit" class="btn btn-primary">Guardar alterações</button>
            </form>
        </div>
    </div>
</section>

