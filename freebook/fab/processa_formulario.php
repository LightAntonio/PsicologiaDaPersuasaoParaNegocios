<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $assunto = "Seu E-book está aqui!";
    $mensagem = "Olá, $nome! \n\nAqui está o seu e-book: Psicologia da Persuasão para Negócios.\n\nAcesse no anexo.";
    $headers = "From: seuemail@seudominio.com\r\n";
    $headers .= "Reply-To: seuemail@seudominio.com\r\n";
    
    // Anexando o e-book
    $arquivo = "ebook.pdf";
    $boundary = md5(uniqid(time()));

    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    $mensagem_email = "--$boundary\r\n";
    $mensagem_email .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $mensagem_email .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $mensagem_email .= $mensagem . "\r\n\r\n";

    // Lendo o arquivo
    $arquivo_anexo = file_get_contents($arquivo);
    $arquivo_anexo = chunk_split(base64_encode($arquivo_anexo));

    $mensagem_email .= "--$boundary\r\n";
    $mensagem_email .= "Content-Type: application/pdf; name=\"$arquivo\"\r\n";
    $mensagem_email .= "Content-Disposition: attachment; filename=\"$arquivo\"\r\n";
    $mensagem_email .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $mensagem_email .= $arquivo_anexo . "\r\n\r\n";
    $mensagem_email .= "--$boundary--";

    if (mail($email, $assunto, $mensagem_email, $headers)) {
        echo "E-book enviado para seu e-mail!";
    } else {
        echo "Erro ao enviar o e-mail.";
    }
}
?>
