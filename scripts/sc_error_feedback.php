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
        case "erro_dados":
            echo "<div class='alert alert-danger mt-3'>Erro: dados em falta no pedido.</div>";
            break;
        case "registo_sucesso":
            echo "<script>alert('Registo efetuado com sucesso!');</script>";
            break;
        case "filme_inserido":
            echo "<script>alert('Filme inserido com sucesso!');</script>";
            break;
        case "utilizador_existente":
            echo "<div class='alert alert-warning'>Já existe um utilizador com esse login ou email.</div>";
            break;
        case "registo_incompleto":
            echo "<p class='alert alert-warning mt-3'>Não foi possível terminar o registo. Verifica os teus dados e volta a tentar.</p>";
            break;
        case "erro_prepare":
            echo "<p class='alert alert-danger mt-3'>Erro ao preparar o pedido. Tenta novamente mais tarde.</p>";
            break;
        case "erro_execucao":
            echo "<p class='alert alert-danger mt-3'>Erro ao executar pedido.</p>";
            break;
        case "login_errado":
            echo "<p class='alert alert-warning mt-3'>Os dados de acesso não estão corretos. Volta a tentar.</p>";
            break;
        case "user_inexistente":
            echo "<p class='alert alert-warning mt-3'>O Utilizador que inseriu não existe!</p>";
            break;
        case "falha_executar_login":
            echo "<p class='alert alert-danger mt-3'>Erro na execução. Tenta novamente mais tarde.</p>";
            break;
        case "erro_sistema_login":
            echo "<p class='alert alert-danger mt-3'>Erro no sistema. Tenta novamente mais tarde.</p>";
            break;
        case "login_incompleto":
            echo "<p class='alert alert-warning mt-3'>Preenche todos os campos antes de continuar.</p>";
            break;
        case "ficheiro_grande":
            echo "<p class='alert alert-warning mt-3'>Ficheiro com tamanho superior a 2MB</p>";
            break;
        case "mime_incorreto":
            echo "<p class='alert alert-warning mt-3'>Só é permitido inserir ficheiros jpg ou png!</p>";
            break;
        case "id_invalido":
            echo "<p class='alert alert-warning mt-3'>Id inválido!</p>";
            break;
        default:
            echo "<div class='alert alert-info mt-3'>Ocorreu uma mensagem não reconhecida.</div>";
    }
}
?>

