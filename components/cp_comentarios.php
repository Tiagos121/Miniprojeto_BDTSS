    <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        require_once "./connections/connections.php";
        $link = new_db_connection();

    ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.21.0/dist/sweetalert2.min.css" rel="stylesheet">

<?php

    $stmt_com = mysqli_stmt_init($link);
    $query_com = "SELECT id_comentarios, comentario, comentarios.data_insercao, nome, id_utilizadores FROM comentarios INNER JOIN utilizadores ON ref_utilizadores = id_utilizadores WHERE ref_filmes = ? ORDER BY comentarios.data_insercao DESC";

    if (mysqli_stmt_prepare($stmt_com, $query_com)) {
        mysqli_stmt_bind_param($stmt_com, "i", $id_filme);
        mysqli_stmt_execute($stmt_com);
        mysqli_stmt_bind_result($stmt_com, $id_comentarios, $comentario, $data_insercao, $nome_utilizador, $autor_id);

        echo "<div class='mt-5'><h3>Comentários</h3>";

        $tem_comentarios = false;
        while (mysqli_stmt_fetch($stmt_com)) {
            $tem_comentarios = true;
            echo "<div class='mb-3 p-3 border rounded'>";
            echo "<p><strong>$nome_utilizador</strong> | $data_insercao</p>";
            echo "<p>$comentario</p>";

            if (isset($_SESSION["id"])) {
                $id_user = $_SESSION["id"];
                $is_admin = ($_SESSION["role"] == 1);

                //SE O UTILIZADOR FOR AUTOR DO COMENTARIO OU ADMIN (DELITE)
                if ($id_user == $autor_id || $is_admin) {
                    echo "<div class='mt-2'>";
                    echo "<a href='scripts/comentarios/sc_delete_comentarios.php?id_comentario={$id_comentarios}&id_filme={$id_filme}' class='delite-comentario btn btn-danger btn-sm me-2'>Eliminar</a>";
                }

                //SÓ O AUTOR DO COMENTARIO CONSEGUE EDITAR
                if ($id_user == $autor_id) {
                    echo "<a href='update_comentario.php?id=$id_comentarios' class='btn btn-warning btn-sm'>Editar</a>";
                }


                if ($id_user == $autor_id || $is_admin) {
                    echo "</div>";
                }
            }

            echo "</div>";
        }

        //OUTRA FORMA DE VERIFICAR O NUMERO DE RESULTADOS
        if (!$tem_comentarios) {
            echo "<p class='text-muted'>Ainda não há comentários.</p>";
        }

        echo "</div>";
        mysqli_stmt_close($stmt_com);
    }

    mysqli_close($link);
?>

    <!--Sweet alert-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deletes = document.querySelectorAll('.delite-comentario');

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

