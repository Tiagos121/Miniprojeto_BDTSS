<?php
// Conexão à base de dados
require_once "./connections/connections.php";
$link = new_db_connection();
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
        <!-- Intro -->
        <?php
        include_once "./components/cp_intro_filmes.php";
        ?>

        <!-- Listar filmes -->
        <div class="row">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pesquisa'])) {
                $pesquisa = "%" . $_POST['pesquisa'] . "%";

                $stmt = mysqli_stmt_init($link);

                $query = "SELECT id_filmes, capa, titulo, tipo FROM filmes INNER JOIN generos ON ref_generos = id_generos WHERE titulo LIKE ? OR ano LIKE ?";

                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_bind_param($stmt, "ss", $pesquisa, $pesquisa);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $id_filmes, $capa, $titulo, $tipo);

                    $resultados = false;
                    while (mysqli_stmt_fetch($stmt)) {
                        $resultados = true;
                        echo "<div class='col-md-4 mb-md-0 pb-5'>
                            <div class='card pb-2 h-100 shadow rounded'>
                                <div class='capas-preview' style='background-image: url(\"imgs/capas/$capa\");'></div>
                                <div class='card-body text-center'>
                                    <h4 class='text-uppercase m-0 mt-2'>{$titulo}</h4>
                                    <hr class='my-3 mx-auto' />
                                    <div class='tipo-filme mb-0 small text-black-50'>{$tipo}</div>
                                    <a href='http://localhost/miniprojeto/filme_detail.php?id= {$id_filmes}' class='mt-2 btn btn-outline-primary'><b><i class='fas fa-plus text-primary''></i></b>+</a>
                                </div>
                            </div>
                        </div>";
                    }

                    // Se nenhum filme foi encontrado, exibe mensagem
                    if (!$resultados) {
                        echo "<div class='alert-warning p-4'>Nenhum filme corresponde à sua pesquisa.</div> 
                                <a class='btn btn-info mt-4 col-2' href='http://localhost/miniprojeto/filmes.php'>Voltar</a>";
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    echo "Erro na consulta: " . mysqli_error($link);
                }
            } else {
                // Se a página foi acessada sem POST
                header("Location: filmes.php");
                exit;
            }
            ?>
        </div>
    </div>
</section>
