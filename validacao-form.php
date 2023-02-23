<?php
// Define variáveis para os campos do formulário
$nome = $email = $mensagem = "";
$nome_err = $email_err = $mensagem_err = "";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Valida o campo "Nome"
  if (empty($_POST["name"])) {
    $nome_err = "Campo obrigatório";
  } else {
    $nome = test_input($_POST["name"]);
    // Verifica se o nome contém apenas letras e espaços
    if (!preg_match("/^[a-zA-Z ]*$/", $nome)) {
      $nome_err = "Somente letras e espaços são permitidos";
    }
  }

  // Valida o campo "Email"
  if (empty($_POST["email"])) {
    $email_err = "Campo obrigatório";
  } else {
    $email = test_input($_POST["email"]);
    // Verifica se o email é válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Formato de email inválido";
    }
  }

  // Valida o campo "Mensagem"
  if (empty($_POST["message"])) {
    $mensagem_err = "Campo obrigatório";
  } else {
    $mensagem = test_input($_POST["message"]);
  }

  // Se não houver erros, envia o email
  if (empty($nome_err) && empty($email_err) && empty($mensagem_err)) {
    // Envia o email
    $destinatario = "devvitorlopesdematos@gmail.com";
    $assunto = "Novo formulário enviado";
    $corpo = "Nome: $nome\nEmail: $email\nMensagem: $mensagem";
    $headers = "From: $email";

    if (mail($destinatario, $assunto, $corpo, $headers)) {
      // Redireciona o usuário para uma página de confirmação
      header("Location: obrigado.html");
      exit();
    } else {
      // Exibe uma mensagem de erro caso ocorra um problema ao enviar o email
      echo "Ocorreu um erro ao enviar o email. Por favor, tente novamente mais tarde.";
    }
  }
}

// Função para limpar e validar os dados do formulário
function test_input($dados) {
  $dados = trim($dados);
  $dados = stripslashes($dados);
  $dados = htmlspecialchars($dados);
  return $dados;
}
?>
