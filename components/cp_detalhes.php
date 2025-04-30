<!-- Ligação BD -->
<?php
    require_once "./connections/connections.php";
    $link = new_db_connection();;
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
    <?php
    // Código para ligar à BD e mostrar informação dinâmica
    $link = new_db_connection(); // Create a new DB connection

    $stmt = mysqli_stmt_init($link); // create a prepared statement

    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        header("Location: filmes.php");
        exit;
    }

    $id_filme = $_GET['id'];

    $query = "SELECT id_filmes, titulo, capa, tipo, ano, sinopse FROM filmes INNER JOIN generos ON ref_generos = id_generos WHERE id_filmes = ?";


        if (mysqli_stmt_prepare($stmt, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $id_filme);
            mysqli_stmt_execute($stmt);

            mysqli_stmt_store_result($stmt); // Armazena os resultados para verificar se há registros

            if (mysqli_stmt_num_rows($stmt) == 0) {
                echo "<div class='alert-warning p-4'>O filme que procura não existe!</div>";
                echo " <a class='btn btn-info' href='filmes.php'>Voltar</a>";
            } else {
                mysqli_stmt_bind_result($stmt, $id_filmes,$titulo, $capa, $tipo, $ano, $sinopse);
                while (mysqli_stmt_fetch($stmt)) {
                echo " <a class='btn btn-info' href='filmes.php'>Voltar</a>";
                echo "<h1 class='pt-5 pb-3'>{$titulo}</h1> 
                <div class='row d-flex flex-row justify-content-between'> 
                    <div class='col detalhes'> 
                        <img class='img-fluid mb-3' src=\"imgs/capas/$capa\" /> 
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
                        <a class='d-block btn btn-primary mt-4' href='{url_trailer}' target='_blank'>Trailer</a> 
                        <a class='d-block btn btn-outline-primary mt-4' href='{url_imdb}' target='_blank'>IMDb</a>
                        <a class='d-block btn btn-primary mt-4' href='{url_favorito}' target='_blank'>Remover Favorito</a>
                        
                    </div> 
                </div>";
            }
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($link);
        }



        mysqli_close($link);
    ?>

    </div>
</section>
