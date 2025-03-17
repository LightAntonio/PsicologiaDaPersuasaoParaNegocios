<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Simples verificação para evitar múltiplos downloads
    if (!empty($email)) {
        header("Location: ebook.pdf"); // Redireciona para o e-book
        exit();
    } else {
        echo "Preencha os campos corretamente.";
    }
}
?>
