<section class="sec-filmes pb-5" id="lista-filmes">
    <div class="container px-lg-5 pt-3">
        <div class="row">
            <h1>Entrar</h1>

            <div class="col-8">
                <p class="text-black-60 text-left pb-4">
                    Se já estás registado no nosso website...
                    <br />
                    <a href="login.php">Entra!</a>
                </p>
            </div>

            <?php
            if (isset($_GET["msg"])) {
                switch ($_GET["msg"]) {
                    case 1:
                        echo "<script>alert('Registo efetuado com sucesso!');</script>";
                        break;
                    case 2:
                        echo "<p class='text-danger'>Não foi possível terminar o registo. Verifica os teus dados e volta a tentar.</p>";
                        break;
                    case 3:
                        echo "<p class='text-danger'>Erro ao preparar o pedido. Tenta novamente mais tarde.</p>";
                        break;
                }
            }
            ?>

        <form class="col-6" action="./scripts/sc_registo.php" method="POST" class="was-validated">
            <h1>Introduz os teus dados</h1>
            <div class="mb-3 mt-3">
                <label for="uname" class="form-label">Name:</label>
                <input type="text" class="form-control" id="username"
                       placeholder="Enter name" name="username" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="uname" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email"
                       placeholder="Enter email" name="email" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3 mt-3">
                <label for="uname" class="form-label">Login:</label>
                <input type="text" class="form-control" id="login"
                       placeholder="Enter login" name="login" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password"
                       placeholder="Enter password" name="password" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</section>
