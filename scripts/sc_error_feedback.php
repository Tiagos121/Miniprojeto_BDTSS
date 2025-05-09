<?php
function error_feedback($code) {
    if (!$code) return;

    switch ((string)$code) {
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
        case "editado_sucesso":
            echo "<div class='text-success mt-4 mb-0'>&#10551; Género atualizado com sucesso! &#10550;</div>";
            break;
        case "erro_tamanho":
            echo "<div class='alert alert-warning mt-3'>Erro: o nome do género tem de ter pelo menos 3 caracteres.</div>";
            break;
        case "erro_query":
            echo "<div class='alert alert-danger mt-3'>Erro ao atualizar o género na base de dados.</div>";
            break;
        case "erro_prepare":
            echo "<div class='alert alert-danger mt-3'>Erro ao preparar a query.</div>";
            break;
        case "erro_dados":
            echo "<div class='alert alert-danger mt-3'>Erro: dados em falta no pedido.</div>";
            break;
        default:
            echo "<div class='alert alert-info mt-3'>Ocorreu uma mensagem não reconhecida.</div>";
    }
}
?>

