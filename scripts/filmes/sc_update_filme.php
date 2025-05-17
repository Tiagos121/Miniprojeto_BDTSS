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

    // Verificar o foi enviada uma capa e dar update
    if (isset($_FILES['capa']) && $_FILES['capa']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../../imgs/capas/'; // Define o diretorio onde guarda a capa

        //verifica se existe diretorio, senão ele cria um novo com o mesmo caminho
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

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

        // Depois das validações
        $ext = pathinfo($_FILES['capa']['name'], PATHINFO_EXTENSION); // Obter extensão do ficheiro eniviado
        $filename = uniqid('capa_', true) . '.' . $ext; // Gerar nome unico para o ficheiro mais extensão
        $dest = $upload_dir . $filename; // destino completo do diretorio com a capa

        // Move upload temporario para o destino completo
        if (move_uploaded_file($_FILES['capa']['tmp_name'], $dest)) {

            // Apagar a capa antiga, se não for a default
            if ($capa_atual !== 'imgs/default.png') {
                // Buscar o diretorio
                $caminho_capa_antiga = __DIR__ . '/../../' . $capa_atual;
                if (file_exists($caminho_capa_antiga)) {
                    // Apagar capa antiga
                    unlink($caminho_capa_antiga);
                }
            }
            // Definir a capa nova
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
