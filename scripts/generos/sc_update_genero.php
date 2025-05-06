<?php
require_once("../../connections/connections.php");
$link = new_db_connection();

if (isset($_POST["id_genero"]) && isset($_POST["genero"])) {
    $id = $_POST["id_genero"];
    $genero = trim($_POST["genero"]);

    if (strlen($genero) < 3) {
        header("Location: ../../update_genero.php?id=$id&msg=erro_tamanho");
        exit();
    }

    $stmt = mysqli_stmt_init($link);
    $query = "UPDATE generos SET tipo = ? WHERE id_generos = ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "si", $genero, $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../../generos.php?msg=atualizado");
        } else {
            header("Location: ../../update_genero.php?id=$id&msg=erro_execucao");
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
} else {
    header("Location: ../../generos.php?msg=erro_dados");
}