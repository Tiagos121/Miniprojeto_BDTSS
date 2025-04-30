<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-5"> <!-- alterado de pt-3 para pt-5 para dar espaço abaixo da navbar -->
        <div class="row">

            <?php


            $titulo_genero = "Géneros";
            $descricao = "Os géneros de filmes indianos que temos para ti.<br />Escolhe um!";


            if (isset($_GET['id'])) {
                $id_generos = $_GET['id'];

                $stmt_nome = mysqli_stmt_init($link);
                $query_nome = "SELECT tipo FROM generos WHERE id_generos = ?";

                if (mysqli_stmt_prepare($stmt_nome, $query_nome)) {
                    mysqli_stmt_bind_param($stmt_nome, 'i', $id_generos);
                    mysqli_stmt_execute($stmt_nome);
                    mysqli_stmt_bind_result($stmt_nome, $tipo);
                    if (mysqli_stmt_fetch($stmt_nome)) {
                        $titulo_genero = $tipo;
                        $descricao = "Todos os filmes deste género<br />Escolhe um!";
                        echo "            <div class='col-12'>
                                                <h1 class='mb-2'>$titulo_genero </h1>
                                                <p class='text-black-60'>$descricao</p>
                                         </div>";
                    }
                    mysqli_stmt_close($stmt_nome);
                }
            }


            ?>


            <?php
            require_once "./connections/connections.php";
            $link = new_db_connection();

            $id_generos = $_GET['id'];
            $stmt = mysqli_stmt_init($link);
            $query = "SELECT id_filmes, capa, titulo, tipo FROM filmes INNER JOIN generos ON id_generos = ref_generos WHERE id_generos = ?";

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_bind_param($stmt, 'i', $id_generos);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $id_filmes, $capa, $titulo, $tipo);

                $tem_filmes = false;
                while (mysqli_stmt_fetch($stmt)) {
                    $tem_filmes = true;
                    echo "
                    <div class='col-md-4 mb-5'>
                        <div class='card h-100 shadow rounded'>
                            <div class='capas-preview' style='background-image: url(\"imgs/capas/$capa\")'></div>
                            <div class='card-body text-center'>
                                <h4 class='text-uppercase m-0 mt-2'>{$titulo}</h4>
                                <hr class='my-3 mx-auto' />
                                <div class='tipo-filme mb-0 small text-black-50'>{$tipo}</div>
                                <a href='./filme_detail.php?id={$id_filmes}' class='mt-2 btn btn-outline-primary'>
                                    <b><i class='fas fa-plus text-primary'></i></b>
                                </a>
                            </div>
                        </div>
                    </div>";
                }

                if (!$tem_filmes) {
                    echo "<div class='col-12'><h3 class='text-muted'>Ainda não temos filmes deste género.</h3></div>";
                }

                mysqli_stmt_close($stmt);
            }

            mysqli_close($link);
            ?>
        </div>
    </div>
</section>
