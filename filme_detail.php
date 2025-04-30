<!-- Ligação BD -->
    <?php
        require_once "./connections/connections.php";
        $link = new_db_connection();;
    ?>

<!-- Ligação Head -->
    <?php
        require_once "./components/cp_head.php";
        $link = new_db_connection();;
    ?>


<!-- Ligação NavBar -->
    <?php
        require_once "./components/cp_navbar.php";
        $link = new_db_connection();;
    ?>


<!-- Ligação Detalhes -->
    <?php
        require_once "./components/cp_detalhes.php";
        $link = new_db_connection();;


    ?>


<!-- Ligação Footer -->
    <?php
        require_once "./components/cp_footer.php";
        $link = new_db_connection();;
    ?>