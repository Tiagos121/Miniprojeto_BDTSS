<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once "scripts/sc_error_feedback.php";

if (!isset($_SESSION["id"])) {
    header("Location: login.php?msg=login_incompleto");
    exit();
}
?>

<!-- HTML E CSS PARA OS O MENU GERIR FILMES-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-RXf+QSDCUQs6fILh4hT5l8p6fUwKqZ8FfRJjqFJvEn+aZTj3tN2U6WKR5OWxOY9V+QnO+Jy1yCqghkCAfO3HQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="d-flex justify-content-center gap-5 flex-wrap text-center">
        <?php
            if ($_SESSION["role"] == "1") {
                echo "<a href='add_filme.php' class='btn-card bg-success text-white'>
                          <span class='fs-5 fw-bold'>Adicionar Filme</span>
                          <i class='fas fa-plus fa-2x mt-2'></i>
                      </a>";
            }
        ?>
        <a href="filmes_favoritos.php" class="btn-card bg-primary text-white">
            <span class="fs-5 fw-bold">Ver Favoritos</span>
            <i class="fas fa-star fa-2x mt-2"></i>
        </a>
        <?php
            if ($_SESSION["role"] == "1") {
                echo "<a href='delete_filme.php' class='btn-card bg-danger text-white'>
                            <span class='fs-5 fw-bold'>Eliminar Filme</span>
                            <i class='fas fa-trash-alt fa-2x mt-2'></i>
                      </a>";
            }
        ?>
    </div>
</div>

<style>
    .btn-card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-decoration: none;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        min-width: 180px;
    }

    .btn-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        text-decoration: none;
    }
</style>


