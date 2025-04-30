<?php
require_once "../connections/connections.php";
?>
<?php
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);

    $query = "SELECT password_hash, ref_perfis, id_utilizadores FROM utilizadores WHERE nome LIKE ?";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $username);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $password_hash, $perfil, $id_user);

            if (mysqli_stmt_fetch($stmt)) {
                if (password_verify($password, $password_hash)) {
                    // Sessão OK
                    session_start();
                    $_SESSION["username"] = $username;
                    $_SESSION["role"] = $perfil;
                    $_SESSION["id"] = $id_user;

                    header("Location: ../index.php?msg=1"); // sucesso
                    exit();
                } else {
                    header("Location: ../login.php?msg=2"); // password errada
                    exit();
                }
            } else {
                header("Location: ../login.php?msg=3"); // username não existe
                exit();
            }
        } else {
            header("Location: ../login.php?msg=4"); // erro na execução
            exit();
        }
    } else {
        header("Location: ../login.php?msg=5"); // erro na preparação
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    header("Location: ../login.php?msg=6"); // campos em falta
    exit();
}
?>