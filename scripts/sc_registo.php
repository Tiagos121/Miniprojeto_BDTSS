<?php
require_once "../connections/connections.php";
$link =new_db_connection();
?>
<?php
if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Cria a password hash
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    mysqli_report(MYSQLI_REPORT_OFF);
    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);

    $query = "INSERT INTO utilizadores (nome, email, login, password_hash) VALUES (?,?,?,?)";

    if (mysqli_stmt_prepare($stmt, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssss', $username, $email, $login, $password_hash);

        if (mysqli_stmt_execute($stmt)) {
            // Iniciar sessão automaticamente após registo
            session_start();

            $_SESSION["username"] = $username;
            $_SESSION["role"] = 2; // ou outro valor se tiveres perfis
            $_SESSION["id"] = mysqli_insert_id($link);

            // Redirecionar para a homepage com msg de sucesso
            header("Location: ../index.php?msg=1");
            exit();
        } else {
            // Erro no registo: username ou email já existem
            header("Location: ../registo.php?msg=2");
            exit();
        }
    } else {
        // Erro na preparação do statement
        header("Location: ../registo.php?msg=3");
        exit();
    }

    mysqli_stmt_close($stmt);
    mysqli_close($link);
} else {
    // Campos por preencher
    header("Location: ../registo.php?msg=4");
    exit();
}
?>
