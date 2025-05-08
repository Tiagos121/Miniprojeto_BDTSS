<?php
function error_feedbsck($code) {
    switch ($code) {
        case "1":
            echo "<p class='text-success mt-4 mb-0'>&#9998; Género adicionado com sucesso. &#9998;</p>";
            break;
        case "2":
            echo "<p class='text-danger mt-4 mb-0'>&#10008; Erro ao inserir o género. &#10008;</p>";
            break;
        case "3":
            echo "<p class='text-danger mt-4 mb-0'>&#10008; Erro na preparação da inserção. &#10008;</p>";
            break;
        case "4":
            echo "<p class='text-warning mt-4 mb-0'>&#9888; Campo de género está vazio. &#9888;</p>";
            break;
        case "5":
            echo "<p class='text-warning mt-4 mb-0'>&#9888; Não é possível apagar: o género está associado a filmes. &#9888;</p>";
            break;
        case "6":
            echo "<p class='text-success mt-4 mb-0'>&#9988; Género apagado com sucesso. &#9988;</p>";
            break;
        case "7":
            echo "<p class='text-warning mt-4 mb-0'>&#9888; O género deve ter no mínimo 3 caracteres. &#9888;</p>";
            break;
        case "33":
            echo "ss";
        break;
        case "editado_sucesso":
            echo "<div class='alert alert-success'>Género atualizado com sucesso!</div>";
            break;
    }
}
