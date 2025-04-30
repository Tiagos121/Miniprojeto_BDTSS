<?php
require_once "../../connections/connections.php";
$link = new_db_connection();
?>

<?php
if (isset($_POST["genero"]) && !empty(trim($_POST["genero"]))) {
    $genero = trim($_POST["genero"]);

    // Validação: mínimo 3 caracteres
    if (strlen($genero) < 3) {
        header("Location: ../../generos.php?msg=7"); // Mensagem para género curto
        exit();
    }

    $stmt = mysqli_stmt_init($link);
    $query = "INSERT INTO generos (tipo) VALUES (?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, "s", $genero);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../../generos.php?msg=1"); // Sucesso
            exit();
        } else {
            header("Location: ../../generos.php?msg=2"); // Erro ao executar
            exit();
        }
    } else {
        header("Location: ../../generos.php?msg=3"); // Erro na preparação
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    header("Location: ../../generos.php?msg=4"); // Campo vazio
    exit();
}
?>

