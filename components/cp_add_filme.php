<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "./connections/connections.php";
$link = new_db_connection();
?>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-0">
        <?php
        include_once "cp_intro_add_filme.php";
        // Mostrar feedback AQUI
        require_once "scripts/sc_error_feedback.php";
        if (isset($_GET["msg"])) {
            error_feedback($_GET["msg"]);
        }
        ?>
        <form class="col-6 was-validated" action="scripts/filmes/sc_add_filme.php"
              method="post" enctype="multipart/form-data">
            <div class="mb-3 mt-3">
                <label for="uname" class="form-label">Título:*</label>
                <input type="text" class="form-control" id="titulo" value=""
                       name="titulo" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="uname" class="form-label">Sinopse:*</label>
                <textarea class="form-control" id="sinopse" value=""
                          name="sinopse" rows="5" required></textarea>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="uname" class="form-label">Ano:*</label>
                <input type="number" class="form-control" id="ano" value=""
                       name="ano" min="1900" max="2099"
                       step="1" value="2023" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="genero" class="form-label">Género:</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="">Escolha um género</option>
                    <?php

                    $stmt = mysqli_stmt_init($link);
                    $query = "SELECT id_generos, tipo FROM generos ORDER BY tipo";

                    if (mysqli_stmt_prepare($stmt, $query)) {
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $id_genero, $tipo);

                        while (mysqli_stmt_fetch($stmt)) {
                            echo "<option value='$id_genero'>$tipo</option>";
                        }

                        mysqli_stmt_close($stmt);
                    }

                    mysqli_close($link);
                    ?>
                </select>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="uname" class="form-label">URL IMDB:</label>
                <input type="url" class="form-control" id="url_imdb" value=""
                       name="url_imdb">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="uname" class="form-label">URL Trailer:</label>
                <input type="url" class="form-control" id="url_trailer" value=""
                       name="url_trailer">
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <!-- Capa do filme -->
            <div class="col-12 mb-3">
                <label for="capa" class="form-label">Capa do Filme (jpg/png):</label>
                <input type="file"
                       class="form-control"
                       id="capa"
                       name="capa"
                       accept="image/jpeg,image/png">
                <div class="invalid-feedback">
                    Por favor, envie uma imagem (jpg ou png).
                </div>
            </div>

            <!-- Preview da capa-->
            <div class="col-12 mb-3 text-center">
                <img id="preview" src="" alt="Preview" style="max-width:200px; display:none; border:1px solid #ccc; padding:4px;">
            </div>
            <button type="submit" class="btn btn-primary">Inserir</button>
        </form>
    </div>
</section>


<!-- Script JS para mostrar o preview -->
<script>
    document.getElementById('capa').addEventListener('change', function(e) {
        const file = e.target.files[0], img = document.getElementById('preview');
        if (!file) return img.style.display = 'none';
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
    });
</script>
