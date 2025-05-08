<?php
require_once "./connections/connections.php";
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
            switch ((string)$_GET["msg"]) {
                case "1":
                    echo "<p class='text-success mt-4 mb-0'>&#9998; Género adicionado com sucesso. &#9998;</p>";
                    break;
                case "2":
                    echo "<p class='text-danger mt-4 mb-0'>&#10008; Erro ao inserir o género. &#10008;</p>";
                    break;
                case "3":
                    echo "<p class='text-danger mt-4 mb-0'>&#10008; Erro na preparação da inserção. &#10008;</p>";
                    break;
                case "4":
                    echo "<p class='text-warning mt-4 mb-0'>&#9888; Campo de género está vazio. &#9888;</p>";
                    break;
                case "5":
                    echo "<p class='text-warning mt-4 mb-0'>&#9888; Não é possível apagar: o género está associado a filmes. &#9888;</p>";
                    break;
                case "6":
                    echo "<p class='text-success mt-4 mb-0'>&#9988; Género apagado com sucesso. &#9988;</p>";
                    break;
                case "7":
                    echo "<p class='text-warning mt-4 mb-0'>&#9888; O género deve ter no mínimo 3 caracteres. &#9888;</p>";
                    break;
                case "editado_sucesso":
                    echo "<div class='alert alert-success'>Género atualizado com sucesso!</div>";
                    break;
                case "erro_tamanho":
                    echo "<p class='text-warning mt-4 mb-0'>Erro: o nome do género tem de ter pelo menos 3 caracteres.</p>";
                    break;
                case "erro_query":
                    echo "<div class='alert alert-danger'>Erro ao atualizar o género na base de dados.</div>";
                    break;
                case "erro_prepare":
                    echo "<div class='alert alert-danger'>Erro ao preparar a query.</div>";
                    break;
                case "erro_dados":
                    echo "<div class='alert alert-danger'>Erro: dados em falta no pedido.</div>";
                    break;
                default:
                    echo "<div class='alert alert-info'>Mensagem não reconhecida.</div>";
            }
        }

        if (isset($_SESSION['role']) && $_SESSION['role'] == 1) {
            include_once "cp_add_generos.php";
        }
        ?>
    </div>
</section>
