<?php
require_once "./connections/connections.php";
$link = new_db_connection();
?>


<section class="sec-filmes pb-5" id="lista-generos">
    <div class="container px-lg-5 pt-3">
        <section class="sec-filmes pb-5" id="lista-filmes">
            <div class="container px-lg-5 pt-3">

                    <h1>Géneros</h1>
                    <div class="col-8">
                        <p class="text-black-60 text-left pb-4">Todos os filmes deste género <br>
                            Escolhe um!</p>
                    </div>


            <?php
            $stmt = mysqli_stmt_init($link);
            $query = "SELECT id_generos, tipo FROM generos";

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $id_generos, $tipo);

                while (mysqli_stmt_fetch($stmt)) {
                    echo "<h3><a href='generos.php?id=$id_generos'>$tipo</a></h3>";
                }

                mysqli_stmt_close($stmt);
            }

            mysqli_close($link);
            ?>
        </div>
    </div>
</section>
