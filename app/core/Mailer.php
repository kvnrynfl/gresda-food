<?php

class Mailer {
    public static function send($to, $subject, $message, $from = null) {
        if (!$from) {
            $from = $_ENV['MAIL_FROM'] ?? 'no-reply@gresdafood.local';
        }
        
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: Gresda Food <" . $from . ">" . "\r\n";

        // Use @ to suppress warnings if mail server is not configured locally
        return @mail($to, $subject, $message, $headers);
    }
}
