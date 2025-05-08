<?php
require_once "../../connections/connections.php";
$link = new_db_connection();
?>

<?php
if (isset($_POST["id_genero"], $_POST["genero"])) {
    $id = $_POST["id_genero"];
    $tipo = trim($_POST["genero"]);

    if (strlen($tipo) < 3) {
        header("Location: ../../update_genero.php?id=$id&msg=erro_tamanho");
        exit();
    }

    $stmt = mysqli_stmt_init($link);
    $query = "UPDATE generos SET tipo = ? WHERE id_generos = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "si", $tipo, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../../generos.php?msg=editado_sucesso");
        } else {
            header("Location: ../../update_genero.php?id=$id&msg=erro_query");
        }
    } else {
        header("Location: ../../update_genero.php?id=$id&msg=erro_prepare");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    header("Location: ../../generos.php?msg=erro_dados");
}
?>
