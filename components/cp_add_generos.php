<?php
// Conexão à base de dados
require_once "./connections/connections.php";
$link = new_db_connection();
?>

<div class="row">
    <form class="col-6" action="scripts/generos/sc_add_generos.php" method="post" class="was-validated">
        <div class="mb-3 mt-3">
            <label for="uname" class="form-label">Adicionar um
                género:</label>
            <input type="text" class="form-control" id="genero"
                   placeholder="Introduzir o género" name="genero"
                   required>
            <div class="valid-feedback">Valid.</div>
            <div class="invalid-feedback">Please fill out this
                field.</div>
        </div>
        <button type="submit" class="btn btn-primary">Adicionar</button>
    </form>
</div>