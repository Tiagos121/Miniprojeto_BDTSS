<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./connections/connections.php";
$link = new_db_connection();
?>

<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: filmes.php");
    exit;
}
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
        <?php
        $id_filme = $_GET['id'];

        $stmt = mysqli_stmt_init($link);
        $query = "SELECT id_filmes, titulo, capa, tipo, ano, sinopse, url_trailer, url_imdb FROM filmes INNER JOIN generos ON ref_generos = id_generos WHERE id_filmes = ?";

        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id_filme);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 0) {
                echo "<div class='alert-warning p-4'>O filme que procura não existe!</div>";
                echo " <a class='btn btn-info' href='filmes.php'>Voltar</a>";
            } else {
                mysqli_stmt_bind_result($stmt, $id_filmes, $titulo, $capa, $tipo, $ano, $sinopse, $url_trailer, $url_imdb);
                while (mysqli_stmt_fetch($stmt)) {
                    echo " <a class='btn btn-info' href='filmes.php'>Voltar</a>";
                    echo "<h1 class='pt-5 pb-3'>{$titulo}</h1> 
                    <div class='row d-flex flex-row justify-content-between'> 
                        <div class='col detalhes'> 
                            <img class='img-fluid mb-3' src='{$capa}' alt='Capa do filme' /> 
                        </div> 
                        <div class='col detalhes'> 
                            <h4 class='text-primary'><span class='text-black-50'>{$ano}</span> | {$tipo}</h4> 
                            <div class='card pb-2 mt-4 shadow rounded'> 
                                    <div class='card-body'> 
                                        <h4 class='text-uppercase text-primary m-0 mt-2'>Sinopse</h4> 
                                        <hr class='my-3 mx-auto' /> 
                                        <p class='tipo-filme mb-0'>{$sinopse}</p> 
                                    </div> 
                            </div> 
                            <a class='d-block btn btn-primary mt-4' href='{$url_trailer}' target='_blank'>Trailer</a> 
                            <a class='d-block btn btn-outline-primary mt-4' href='{$url_imdb}' target='_blank'>IMDb</a>";

                    if (isset($_SESSION['id']) && $_SESSION['role'] == "1") {
                        echo "<a class='d-block btn btn-warning mt-4' href='update_filme.php?id={$id_filmes}'>Editar Filme</a>";
                    }

                    //FAVORITOS E INSERIR COMENTÁRIO
                    if (isset($_SESSION["id"])) {
                        $id_user = $_SESSION["id"];

                        $stmt_fav = mysqli_stmt_init($link);
                        $query_fav = "SELECT COUNT(*) FROM filmes_favoritos WHERE ref_utilizadores = ? AND ref_filmes = ?";

                        if (mysqli_stmt_prepare($stmt_fav, $query_fav)) {
                            mysqli_stmt_bind_param($stmt_fav, "ii", $id_user, $id_filme);
                            mysqli_stmt_execute($stmt_fav);
                            mysqli_stmt_bind_result($stmt_fav, $is_favorite);
                            mysqli_stmt_fetch($stmt_fav);
                            mysqli_stmt_close($stmt_fav);

                            if ($is_favorite > 0) {
                                echo "<a class='btn btn-danger mt-4' href='scripts/favoritos/sc_delete_favorito.php?id=$id_filme'>Remover Favorito</a>";
                            } else {
                                echo "<a class='btn btn-success mt-4' href='scripts/favoritos/sc_add_favorito.php?id=$id_filme'>Adicionar aos Favoritos</a>";
                            }

                            echo "<form action='scripts/comentarios/sc_add_comentarios.php' method='post' class='mt-4'>
                                    <input type='hidden' name='id_filme' value='{$id_filme}'>
                                    <div class='mb-3'>
                                        <label for='comentario' class='form-label'>Deixa um comentário:</label>
                                        <textarea class='form-control' id='comentario' name='comentario' rows='4' required></textarea>
                                    </div>
                                    <button type='submit' class='btn btn-primary'>Enviar</button>
                                </form>";
                        }
                    } else {
                        echo "<p class='text-muted'>Faz login para comentar este filme.</p>";
                    }

                    echo "</div></div>";
                }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($link);
        }

        ?>

        <?php
            include_once "cp_comentarios.php";
        ?>

    </div>
</section>