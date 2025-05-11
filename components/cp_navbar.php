<?php
// código para ligar à BD e mostrar informação dinâmica
require_once "./connections/connections.php";
$link = new_db_connection();
?>

<?php
session_start(); // TEM DE estar no topo
?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top shadow" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">Top Indian Movies</a>

        <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="filmes.php">Filmes</a></li>
                <li class="nav-item"><a class="nav-link" href="generos.php">Géneros</a></li>
                <?php
                    if (isset($_SESSION["id"])) {
                        echo "<li class='nav-item'><a class='nav-link' href='gerir_filmes.php'>Gerir Filmes</a></li>";
                    }
                ?>

                <?php
                if (isset($_SESSION["username"])) {
                    // Se a sessão estiver ativa, mostrar o nome do utilizador e link para logout
                    echo "<li class='nav-item'>
                            <a class='nav-link' href='logout.php'>
                                <i class='fa-regular fa-user'></i> " . htmlspecialchars($_SESSION["username"]) . "
                            </a>
                          </li>";
                } else {
                    // Se não houver sessão, mostrar link para login
                    echo "<li class='nav-item'>
                            <a class='nav-link' href='login.php'>
                                <i class='fa-regular fa-user'></i> Entrar
                            </a>
                          </li>";
                }
                ?>

                
            </ul>
        </div>
    </div>
</nav>
