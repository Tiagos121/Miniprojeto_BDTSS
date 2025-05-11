<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    require_once "../../connections/connections.php";
?>

<?php
    // Verifica se existe sessão
    if (!isset($_SESSION["id"])) {
        header("Location: ../../login.php?msg=erro_sessao");
        exit();
    }
    $id_utilizador = $_SESSION["id"];

    // Verifica se veio o ID do filme
    if (!isset($_POST["id_filme"]) || !is_numeric($_POST["id_filme"])) {
        header("Location: ../../filmes.php?msg=id_invalido");
        exit();
    }

    $id_filmes = intval($_POST["id_filme"]);

    // Campos obrigatórios (já estão marcados como required no formulário)
    $titulo = $_POST['titulo'];
    $sinopse = $_POST['sinopse'];
    $ano = $_POST['ano'];
    $genero_id = (int) $_POST["genero"];

    // Campos opcionais
    $url_imdb = !empty($_POST['url_imdb']) ? $_POST['url_imdb'] : null;
    $url_trailer = !empty($_POST['url_trailer']) ? $_POST['url_trailer'] : null;

    // Obter capa atual (caso o utilizador não envie nova imagem)
    $link = new_db_connection();
    $stmt = mysqli_stmt_init($link);
    $query_select_capa = "SELECT capa FROM filmes WHERE id_filmes = ?";

    mysqli_stmt_prepare($stmt, $query_select_capa);
    mysqli_stmt_bind_param($stmt, "i", $id_filmes);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $capa_atual);

    if (!mysqli_stmt_fetch($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        header("Location: ../../filmes.php?msg=filme_nao_encontrado");
        exit();
    }
    mysqli_stmt_close($stmt);

    // Por defeito mantém a capa atual
    $capa = $capa_atual;

    // Processar nova capa (se enviada)
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../../imgs/capas/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $ext = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('capa_', true) . '.' . $ext;
        $dest = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['capa']['tmp_name'], $dest)) {
            // Apagar a capa antiga, se não for a default
            if ($capa_atual !== 'imgs/default.png') {
                $caminho_capa_antiga = __DIR__ . '/../../' . $capa_atual;
                if (file_exists($caminho_capa_antiga)) {
                    unlink($caminho_capa_antiga);
                }
            }

            $capa = 'imgs/capas/' . $filename;
        }
    }

    // Atualizar os dados
    $stmt_update = mysqli_stmt_init($link);
    $query_update = "UPDATE filmes SET titulo = ?, capa = ?, sinopse = ?, ano = ?, ref_generos = ?, url_imdb = ?, url_trailer = ?, ref_utilizadores = ? WHERE id_filmes = ?";

    if (mysqli_stmt_prepare($stmt_update, $query_update)) {
        mysqli_stmt_bind_param($stmt_update, 'sssisssii', $titulo, $capa, $sinopse, $ano, $genero_id, $url_imdb, $url_trailer, $id_utilizador, $id_filmes);

        if (mysqli_stmt_execute($stmt_update)) {
            header("Location: ../../filme_detail.php?id={$id_filmes}&msg=filme_atualizado");
        } else {
            header("Location: ../../filme.php?msg=erro_execucao");
        }

        mysqli_stmt_close($stmt_update);
    } else {
        header("Location: ../../filme.php?msg=erro_prepare");
    }

    mysqli_close($link);
?>
