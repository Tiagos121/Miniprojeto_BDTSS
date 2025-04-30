<?php
// conexão à base de dados
require_once "./connections/connections.php";
$link = new_db_connection();
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
        <!-- Intro -->        <?php
        include_once "./components/cp_intro_filmes.php";
        $link = new_db_connection();
        ?>

        <!-- Listar filmes -->
        <div class="row">
            <?php
                // código para ligar à BD e mostrar informação dinâmica

            // código para ligar à BD e mostrar informação dinâmica
            $link = new_db_connection(); // Create a new DB connection

            $stmt = mysqli_stmt_init($link); // create a prepared statement

            $query = "SELECT capa, titulo, ano, sinopse FROM filmes";

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt,$capa,$titulo, $ano, $sinopse);
                while (mysqli_stmt_fetch($stmt)) {
                    echo "<div class='col-md-4'>
                <img src='imgs/capas/$capa'>
                <h2>$titulo</h2>
                <h3>$ano</h3>
                <p>$sinopse</p>
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