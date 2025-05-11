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

<style>
    .filme-card {
        cursor: pointer;
        position: relative;
        transition: transform 0.2s;
    }

    .filme-card:hover {
        transform: scale(1.02);
    }

    .filme-card.selected {
        border: 2px solid #dc3545; /* vermelho */
        box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.2);
    }

    .filme-card .overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background-color: rgba(220, 53, 69, 0.2); /* vermelho transparente */
        opacity: 0;
        transition: opacity 0.2s;
        pointer-events: none;
        border-radius: 0.5rem;
    }

    .filme-card.selected .overlay {
        opacity: 1;
    }
</style>

<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container pt-3">
        <!-- Intro -->

        <!-- Formulário para apagar filmes selecionados -->
        <form action="scripts/filmes/sc_delete_filme.php" method="post">
            <div class="row">
                <!-- Botão de apagar selecionados -->
                <div class="text-center mt-0 mb-5">
                    <button type="submit" class="btn btn-danger delite-genero">
                        <i class="fas fa-trash-alt me-1"></i> Apagar Selecionados
                    </button>
                </div>
                <?php
                $stmt = mysqli_stmt_init($link);
                $query = "SELECT id_filmes, capa, titulo, tipo FROM filmes INNER JOIN generos ON ref_generos = id_generos";

                if (mysqli_stmt_prepare($stmt, $query)) {
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $id_filmes, $capa, $titulo, $tipo);
                    while (mysqli_stmt_fetch($stmt)) {
                        echo "
                        <div class='col-md-2 mb-4'>
                        <div class='card filme-card h-100 shadow rounded position-relative' data-id='{$id_filmes}'>
                            <input type='checkbox' name='filmes[]' value='{$id_filmes}' class='form-check-input filme-checkbox d-none'>
                            <div class='overlay'></div>
                            <div class='capas-preview' style='background-image: url(\"{$capa}\"); height: 250px; background-size: cover; background-position: center;'></div>
                            <div class='card-body text-center'>
                                <h4 class='text-uppercase m-0 mt-2'>{$titulo}</h4>
                                <hr class='my-3 mx-auto' />
                                <div class='tipo-filme mb-0 small text-black-50'>{$tipo}</div>
                            </div>
                        </div>
                    </div>";
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    echo "Erro: " . mysqli_error($link);
                }
                ?>
            </div>

        </form>
    </div>
</section>

<script>
    document.querySelectorAll(".filme-card").forEach(card => {
        card.addEventListener("click", () => {
            const checkbox = card.querySelector(".filme-checkbox");
            checkbox.checked = !checkbox.checked;
            card.classList.toggle("selected", checkbox.checked);
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const deleteButton = document.querySelector('.delite-genero');
        const form = deleteButton.closest("form");

        deleteButton.addEventListener('click', function (e) {
            e.preventDefault(); // Evita o envio imediato

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
                    form.submit(); // Submete o formulário se confirmado
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Desmarcar todas as checkboxes e remover classe 'selected'
                    document.querySelectorAll(".filme-checkbox").forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    document.querySelectorAll(".filme-card").forEach(card => {
                        card.classList.remove("selected");
                    });
                }
            });
        });
    });
</script>
