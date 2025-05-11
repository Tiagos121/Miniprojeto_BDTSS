        <?php
        // conexão à base de dados
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
            $stmt = mysqli_stmt_init($link); // create a prepared statement
            $query = "SELECT id_filmes, capa, titulo, tipo FROM filmes INNER JOIN generos ON ref_generos = id_generos";

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $id_filmes, $capa, $titulo, $tipo);
                while (mysqli_stmt_fetch($stmt)) {
                    echo "<div class='col-md-4 mb-md-0 pb-5'>
                    <div class='card pb-2 h-100 shadow rounded'>
                        <div class='capas-preview' style='background-image: url(\"{$capa}\");'></div>
                            <div class='card-body text-center'>
                            <h4 class='text-uppercase m-0 mt-2'>{$titulo}</h4>
                            <hr class='my-3 mx-auto' />
                            <div class='tipo-filme mb-0 small text-black-50'>{$tipo}</div>
                            <a href='filme_detail.php?id= {$id_filmes}' class='mt-2 btn btn-outline-primary'><b><i class='fas fa-plus text-primary''></i></b>+</a>
                        </div>
                    </div>
                </div>";
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: " . mysqli_error($link);
            }


            ?>
        </div>
    </div>
</section>