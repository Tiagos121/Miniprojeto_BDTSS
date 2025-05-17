<?php
require_once "../connections/connections.php";
$link =new_db_connection();
?>
<?php
    if (isset($_POST["username"]) && isset($_POST["email"]) && isset($_POST["login"]) && isset($_POST["password"])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $login = $_POST['login'];
        $password = $_POST['password'];

        // Cria a password hash
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Query para verificar se o login ou email já existem
        $check_stmt = mysqli_stmt_init($link);
        $check_query = "SELECT id_utilizadores FROM utilizadores WHERE login = ? OR email = ?";

        if (mysqli_stmt_prepare($check_stmt, $check_query)) {
            mysqli_stmt_bind_param($check_stmt, "ss", $login, $email);
            mysqli_stmt_execute($check_stmt);
            mysqli_stmt_store_result($check_stmt);

            if (mysqli_stmt_num_rows($check_stmt) > 0) {
                // Já existe um utilizador com o mesmo login ou email
                mysqli_stmt_close($check_stmt);
                mysqli_close($link);
                header("Location: ../registo.php?msg=utilizador_existente");
                exit();
            }
            mysqli_stmt_close($check_stmt);
        } else {
            // Erro na preparação do check
            mysqli_close($link);
            header("Location: ../registo.php?msg=erro_prepare");
            exit();
        }

        // Verificar manualmente as operações
        mysqli_report(MYSQLI_REPORT_OFF);

        //Query para guardar dados de utilizador criado
        $stmt = mysqli_stmt_init($link);
        $query = "INSERT INTO utilizadores (nome, email, login, password_hash) VALUES (?,?,?,?)";

        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, 'ssss', $username, $email, $login, $password_hash);

            if (mysqli_stmt_execute($stmt)) {
                // Iniciar sessão automaticamente após registo
                session_start();

                $_SESSION["username"] = $username; // Username atribuido
                $_SESSION["role"] = 2; // Cargo padrão atribuido
                $_SESSION["id"] = mysqli_insert_id($link); // Logar automaticamente o utilizador


                header("Location: ../index.php?msg=registo_sucesso");
                exit();
            } else {
                // Erro no registo: username ou email já existem
                header("Location: ../registo.php?msg=registo_incompleto");
                exit();
            }
        } else {
            // Erro na preparação do statement
            header("Location: ../registo.php?msg=erro_prepare");
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
