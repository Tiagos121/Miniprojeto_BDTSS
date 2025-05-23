<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./connections/connections.php";
require_once "./scripts/sc_error_feedback.php";
$link = new_db_connection();
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.all.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.min.css" rel="stylesheet">



<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-5">
        <div class="row">

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
                    echo "<h3>";
                    echo "<a href='generos.php?id=$id_generos'>$tipo</a>";

                    // Só se for admin é que aparece o "editar" e o "x"
                    if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
                        echo " <a href='update_genero.php?id=$id_generos' class='text-danger' >(editar)</a>";
                        echo " <a href='scripts/generos/sc_delete_genero.php?id=$id_generos' class='delite-genero text-dark'>(x)</a>";
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

<!--Sweet alert-->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deletes = document.querySelectorAll('.delite-genero');

        deletes.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Tens a certeza?",
                    text: "Tu não vais conseguir reverter isto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Sim, apagar!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // redireciona para o script de delete
                        window.location.href = link.href;
                    }
                });
            });
        });
    });
</script>
