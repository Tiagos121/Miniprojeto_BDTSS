<?php
require_once "./connections/connections.php";
require_once "./scripts/sc_error_feedback.php";
$link = new_db_connection();
?>


<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-5"> <!-- alterado de pt-3 para pt-5 para dar espaço abaixo da navbar -->
        <div class="row">

                    <h1>Géneros</h1>
                    <div class="col-8">
                        <p class="text-black-60 text-left pb-4">Todos os filmes deste género <br>
                            Escolhe um!</p>
                    </div>


            <?php
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            $link = new_db_connection();

            $stmt = mysqli_stmt_init($link);
            $query = "SELECT id_generos, tipo FROM generos";

            if (mysqli_stmt_prepare($stmt, $query)) {
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $id_generos, $tipo);

                while (mysqli_stmt_fetch($stmt)) {
                    echo "<h3>";
                    echo "<a href='generos.php?id=$id_generos'>$tipo</a>";

                    // Só se for admin é que aparece o "editar" e o "x"
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
                        echo " <a href='update_genero.php?id=$id_generos' class='text-danger' >(editar)</a>";
                        echo " <a href='scripts/generos/sc_delete_genero.php?id=$id_generos'  class='text-dark' onclick=\"return confirm('Tens a certeza que queres apagar este género?');\">(x)</a>";
                    }

                    echo "</h3>";
                }


                mysqli_stmt_close($stmt);
            }

            mysqli_close($link);
            ?>
        </div>
        <?php
        if (isset($_GET["msg"])) {
            error_feedback($_GET["msg"]);
        }

        if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
            include_once "cp_add_generos.php";
        }
        ?>
    </div>
</section>
