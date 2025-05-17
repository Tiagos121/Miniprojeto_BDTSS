<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../connections/connections.php";
$link = new_db_connection();
?>

<?php
    // Vericar Sessão
    if (!isset($_SESSION["id"])) {
        header("Location: ../../login.php?msg=erro_sessao");
        exit();
    }
    $id_utilizador = $_SESSION["id"];


if (isset($_POST["titulo"], $_POST["sinopse"], $_POST["ano"], $_POST["genero"], $_POST["url_imdb"], $_POST["url_trailer"])) {
    $titulo = $_POST['titulo'];
    $sinopse = $_POST['sinopse'];
    $ano = $_POST['ano'];

    // Tratar de verificar o valor inteiro no POST do genero
    $genero_id = (int) $_POST["genero"];
    if ($genero_id <= 0) {
        // não veio género válido
        header("Location: ../../add_filme.php?msg=genero_invalido");
        exit();
    }

    // Tratar campos opcionais (URL'S)
    if (!empty($_POST['url_imdb'])) {
        $url_imdb = $_POST['url_imdb'];
    } else {
        $url_imdb = null;
    }

    if (!empty($_POST['url_trailer'])) {
        $url_trailer = $_POST['url_trailer'];
    } else {
        $url_trailer = null;
    }


    // Tratar upload de capa
    $upload_dir = __DIR__ . '/../../imgs/capas/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    // default
    $capa = 'imgs/default.png';

    if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {

        // Validar tamanho ficheiro (2MB)
        if ($_FILES['capa']['size'] > 2 * 1024 * 1024) {
            header("Location: ../../add_filme.php?msg=ficheiro_grande");
            exit();
        }

        // Validar MIME real
        $finfo = new finfo(FILEINFO_MIME_TYPE);  // Dizer que quero só o mime puro
        $mime  = $finfo->file($_FILES['capa']['tmp_name']); // Análise do ficheiro

        //Define extensões permitidas e aplica-as
        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
        ];
        // Verificar se o mime é igual à extensão indicada
        if (!isset($allowed[$mime])) {
            header("Location: ../../add_filme.php?msg=mime_incorreto");
            exit();
        }

        //Depois das validações
        $ext = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('capa_', true) . '.' . $ext;
        $dest = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['capa']['tmp_name'], $dest)) {
            $capa = 'imgs/capas/' . $filename;
        } else {
            error_log("Falha a mover capa: " . print_r($_FILES['capa'], true));
        }
    }
    // Fim do upload capa




    // Query para inserir dados
    $stmt_insert = mysqli_stmt_init($link);
    $query_insert = "INSERT INTO filmes (titulo, capa, sinopse, ano, ref_generos, url_imdb, url_trailer, ref_utilizadores) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if (mysqli_stmt_prepare($stmt_insert, $query_insert)) {
        mysqli_stmt_bind_param($stmt_insert, 'sssisssi', $titulo, $capa, $sinopse, $ano, $genero_id, $url_imdb, $url_trailer, $id_utilizador);

        if (mysqli_stmt_execute($stmt_insert)) {
            // Sucesso
            header("Location: ../../filmes.php?msg=filme_inserido");
        } else {
            // Erro na execução
            header("Location: ../../add_filme.php?msg=erro_execucao");
        }

        mysqli_stmt_close($stmt_insert);
    } else {
        // Erro na preparação
        header("Location: ../../add_filme.php?msg=erro_prepare");
    }

    mysqli_close($link);
} else {
    header("Location: ../../add_filme.php?msg=erro_dados");
}
?>