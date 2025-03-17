<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "E-mail inválido!";
        exit;
    }

    // Caminho para o e-book (substitua pelo caminho real)
    $ebook_path = "ebooks/ebook.pdf";
    $ebook_nome = "Psicologia_da_Persuasão.pdf";

    // Cabeçalhos do e-mail
    $boundary = md5(time());
    $headers = "From: Seu Nome <seuemail@seudominio.com>\r\n";
    $headers .= "Reply-To: seuemail@seudominio.com\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

    // Corpo do e-mail
    $mensagem = "--$boundary\r\n";
    $mensagem .= "Content-Type: text/plain; charset=\"UTF-8\"\r\n";
    $mensagem .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $mensagem .= "Olá $nome,\n\nAqui está o seu e-book \"Psicologia da Persuasão para Negócios\".\nAproveite a leitura!\n\nAtenciosamente,\nSua Empresa\r\n";

    // Anexando o e-book
    $arquivo = file_get_contents($ebook_path);
    $arquivo_base64 = chunk_split(base64_encode($arquivo));

    $mensagem .= "--$boundary\r\n";
    $mensagem .= "Content-Type: application/pdf; name=\"$ebook_nome\"\r\n";
    $mensagem .= "Content-Disposition: attachment; filename=\"$ebook_nome\"\r\n";
    $mensagem .= "Content-Transfer-Encoding: base64\r\n\r\n";
    $mensagem .= $arquivo_base64 . "\r\n";
    $mensagem .= "--$boundary--";

    // Enviar o e-mail
    if (mail($email, "Seu E-book Gratuito!", $mensagem, $headers)) {
        echo "E-book enviado com sucesso! Verifique seu e-mail.";
    } else {
        echo "Erro ao enviar o e-mail.";
    }
} else {
    echo "Acesso negado!";
}
?>
