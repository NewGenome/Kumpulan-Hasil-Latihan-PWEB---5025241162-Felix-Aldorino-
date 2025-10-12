<?php
if (!empty($_POST['name']) && !empty($_POST['email'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = nl2br(htmlspecialchars($_POST['message']));

    $to = "crisisgear0@gmail.com";
    $subject = "Latihan AJAX Contact Form Email";
    $body = "<p>Pesan baru dari <b>$name</b>:</p><p>$message</p>";

    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: <$email>\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "<span style='color:green; font-weight:bold;'>Terima kasih telah menghubungi kami, kami akan segera membalas Anda.</span>";
    } else {
        echo "<span style='color:red; font-weight:bold;'>Maaf, pengiriman pesan gagal.</span>";
    }
} else {
    echo "<span style='color:red; font-weight:bold;'>Lengkapi semua kolom!</span>";
}
?>
