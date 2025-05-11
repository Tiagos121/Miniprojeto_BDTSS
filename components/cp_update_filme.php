<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-0">
        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        include_once "cp_intro_add_filme.php";
        require_once "./connections/connections.php";

        // Verifica se o ID do filme está na URL
        if (!isset($_GET["id"])) {
            echo "<div class='alert alert-danger'>ID do filme não foi fornecido.</div>";
            exit;
        }

        $id_filme = intval($_GET["id"]);

        $link = new_db_connection();
        $stmt = mysqli_stmt_init($link);
        $query = "SELECT titulo, sinopse, ano, ref_generos, url_imdb, url_trailer, capa FROM filmes WHERE id_filmes = ?";

        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, "i", $id_filme);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $titulo, $sinopse, $ano, $genero, $url_imdb, $url_trailer, $capa);

        if (!mysqli_stmt_fetch($stmt)) {
            echo "<div class='alert alert-warning'>Filme não encontrado.</div>";
            exit;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($link);
        ?>

        <form class="col-6 was-validated" action="scripts/filmes/sc_update_filme.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_filme" value="<?= $id_filme ?>">

            <div class="mb-3 mt-3">
                <label class="form-label">Título:*</label>
                <input type="text" class="form-control" name="titulo" value="<?= htmlspecialchars($titulo) ?>" required>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">Sinopse:*</label>
                <textarea class="form-control" name="sinopse" rows="5" required><?= htmlspecialchars($sinopse) ?></textarea>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">Ano:*</label>
                <input type="number" class="form-control" name="ano" min="1900" max="2099" value="<?= $ano ?>" required>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">Género:</label>
                <select class="form-select" name="genero" required>
                    <option value="">Escolha um género</option>
                    <?php
                    $link = new_db_connection();
                    $stmt = mysqli_stmt_init($link);
                    $query = "SELECT id_generos, tipo FROM generos ORDER BY tipo";

                    mysqli_stmt_prepare($stmt, $query);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $id_genero, $tipo);

                    while (mysqli_stmt_fetch($stmt)) {
                        if ($genero == $id_genero) {
                            echo "<option value='$id_genero' selected>$tipo</option>";
                        } else {
                            echo "<option value='$id_genero'>$tipo</option>";
                        }
                    }

                    mysqli_stmt_close($stmt);
                    mysqli_close($link);
                    ?>
                </select>
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">URL IMDB:</label>
                <input type="url" class="form-control" name="url_imdb" value="<?= htmlspecialchars($url_imdb) ?>">
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">URL Trailer:</label>
                <input type="url" class="form-control" name="url_trailer" value="<?= htmlspecialchars($url_trailer) ?>">
            </div>

            <div class="mb-3 mt-3">
                <label class="form-label">Capa do Filme (jpg/png):</label>
                <input type="file" class="form-control" name="capa" id="capa" accept="image/jpeg,image/png">
            </div>

            <!-- Mostra a capa atual -->
            <div class="mb-3 text-center">
                <?php
                if ($capa != "") {
                    echo "<p>Capa atual:</p>";
                    echo "<img id='preview' src='{$capa}' alt='Capa atual' style='max-width:200px; border:1px solid #ccc; padding:4px;'>";
                } else {
                    echo "<img id='preview' style='display:none; max-width:200px;'>";
                }
                ?>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar Filme</button>
        </form>
    </div>
</section>

<script>
    document.getElementById('capa').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const img = document.getElementById('preview');

        if (!file) {
            img.style.display = 'none';
            return;
        }

        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
    });
</script>
