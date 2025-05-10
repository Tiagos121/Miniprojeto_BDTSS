<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-0">
        <?php
        include_once "components/cp_intro_add_filme.php";
        require_once "./scripts/sc_error_feedback.php";
        $link = new_db_connection();
        ?>
        <form class="col-6" action="scripts/filmes/sc_add_filme.php"
              method="post" class="was-validated">
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
                <label for="uname" class="form-label">Género:</label>
                <select class="form-select" id="genero" name="genero" required>
                    <option value="">Escolha um género</option>
                    <option value="x">Género X</option>
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
            <button type="submit" class="btn btn-primary">Inserir</button>
        </form>
    </div>
</section>