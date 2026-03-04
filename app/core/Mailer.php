<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Mailer Service
 * 
 * Supports two drivers:
 * - 'smtp': Sends real emails via PHPMailer/SMTP
 * - 'log': Logs emails to storage/logs/mail.log (development)
 * 
 * Includes branded HTML email templates for:
 * - Email verification (OTP)
 * - Password reset
 */
class Mailer
{
    private static $driver;

    /**
     * Get the mail driver from environment
     */
    private static function getDriver()
    {
        if (self::$driver === null) {
            self::$driver = $_ENV['MAIL_DRIVER'] ?? 'log';
        }
        return self::$driver;
    }

    /**
     * Send an email
     */
    public static function send($to, $subject, $htmlBody)
    {
        if (self::getDriver() === 'log') {
            return self::logEmail($to, $subject, $htmlBody);
        }

        return self::sendSmtp($to, $subject, $htmlBody);
    }

    /**
     * Send email via SMTP using PHPMailer
     */
    private static function sendSmtp($to, $subject, $htmlBody)
    {
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = $_ENV['MAIL_HOST'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['MAIL_USERNAME'] ?? '';
            $mail->Password   = $_ENV['MAIL_PASSWORD'] ?? '';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = (int)($_ENV['MAIL_PORT'] ?? 587);
            $mail->CharSet    = 'UTF-8';

            $mail->setFrom(
                $_ENV['MAIL_FROM'] ?? 'no-reply@gresdafood.com',
                $_ENV['MAIL_FROM_NAME'] ?? 'Gresda Food'
            );
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $htmlBody;
            $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>', '<br />'], "\n", $htmlBody));

            return $mail->send();
        } catch (Exception $e) {
            error_log("Mailer Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Log email to file (development mode)
     */
    private static function logEmail($to, $subject, $htmlBody)
    {
        $logDir = defined('STORAGE_PATH') ? STORAGE_PATH . '/logs' : __DIR__ . '/../../storage/logs';
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0755, true);
        }

        $logFile = $logDir . '/mail.log';
        $timestamp = date('Y-m-d H:i:s');
        $separator = str_repeat('=', 70);

        $logEntry = "{$separator}\n"
            . "Date: {$timestamp}\n"
            . "To: {$to}\n"
            . "Subject: {$subject}\n"
            . "{$separator}\n"
            . strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>', '</div>', '</td>', '</th>'], "\n", $htmlBody))
            . "\n{$separator}\n\n";

        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);

        return true;
    }

    // ─── Email Templates ────────────────────────────────────────────

    /**
     * Send OTP verification email
     */
    public static function sendVerificationOtp($to, $userName, $otpCode)
    {
        $subject = 'Kode Verifikasi Akun — Gresda Food';
        $body = self::buildOtpTemplate($userName, $otpCode);
        return self::send($to, $subject, $body);
    }

    /**
     * Send password reset link
     */
    public static function sendPasswordReset($to, $userName, $resetUrl)
    {
        $subject = 'Reset Kata Sandi — Gresda Food';
        $body = self::buildResetTemplate($userName, $resetUrl);
        return self::send($to, $subject, $body);
    }

    // ─── Premium Email Templates ────────────────────────────────────

    /**
     * Get the shared email header HTML
     */
    private static function getEmailHeader()
    {
        return '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:\'Inter\',\'Segoe UI\',Arial,sans-serif;-webkit-font-smoothing:antialiased;">
<div style="max-width:600px;margin:0 auto;padding:32px 16px;">
    <!-- Header -->
    <div style="background:linear-gradient(135deg,#0891b2 0%,#06b6d4 50%,#22d3ee 100%);border-radius:20px 20px 0 0;padding:36px 32px;text-align:center;">
        <div style="margin-bottom:8px;">
            <span style="font-size:28px;font-weight:900;font-style:italic;letter-spacing:-1px;color:#06b6d4;">GRESDA</span>
            <span style="font-size:28px;font-weight:900;font-style:italic;letter-spacing:-1px;color:#ffffff;"> FOOD</span>
        </div>
        <div style="width:40px;height:3px;background:rgba(255,255,255,0.4);border-radius:2px;margin:12px auto 8px;"></div>
        <p style="color:rgba(255,255,255,0.85);margin:0;font-size:13px;letter-spacing:1px;text-transform:uppercase;">Premium Culinary Experience</p>
    </div>';
    }

    /**
     * Get the shared email footer HTML
     */
    private static function getEmailFooter()
    {
        $year = date('Y');
        return '
    <!-- Footer -->
    <div style="text-align:center;padding:24px 16px;">
        <p style="color:#94a3b8;font-size:12px;margin:0 0 4px;line-height:1.6;">
            Email ini dikirim secara otomatis oleh sistem Gresda Food.
        </p>
        <p style="color:#94a3b8;font-size:12px;margin:0;line-height:1.6;">
            &copy; ' . $year . ' Gresda Food &amp; Beverage. All rights reserved.
        </p>
    </div>
</div>
</body>
</html>';
    }

    /**
     * Build OTP verification email template
     */
    private static function buildOtpTemplate($userName, $otpCode)
    {
        $digits = str_split($otpCode);
        $otpHtml = '';
        foreach ($digits as $digit) {
            $otpHtml .= '<td style="width:48px;height:56px;background:linear-gradient(135deg,#f0fdfa,#ecfeff);border:2px solid #06b6d4;border-radius:12px;text-align:center;font-size:28px;font-weight:800;color:#0e7490;letter-spacing:2px;font-family:\'Inter\',monospace;">' . $digit . '</td>
            <td style="width:8px;"></td>';
        }

        return self::getEmailHeader() . '

    <!-- Body -->
    <div style="background:#ffffff;padding:40px 32px 36px;border-radius:0 0 20px 20px;box-shadow:0 4px 24px rgba(0,0,0,0.06);">
        <!-- Icon -->
        <div style="text-align:center;margin-bottom:24px;">
            <div style="display:inline-block;width:64px;height:64px;background:linear-gradient(135deg,#ecfeff,#cffafe);border-radius:16px;line-height:64px;font-size:28px;">
                🔐
            </div>
        </div>

        <h2 style="color:#1e293b;margin:0 0 8px;font-size:22px;font-weight:700;text-align:center;">Verifikasi Email Anda</h2>
        <p style="color:#64748b;text-align:center;margin:0 0 28px;font-size:14px;line-height:1.6;">
            Halo <strong style="color:#0e7490;">' . htmlspecialchars($userName) . '</strong>, gunakan kode OTP berikut untuk memverifikasi alamat email Anda.
        </p>

        <!-- OTP Code -->
        <div style="text-align:center;margin:0 0 28px;">
            <table cellpadding="0" cellspacing="0" border="0" style="margin:0 auto;">
                <tr>
                    ' . $otpHtml . '
                </tr>
            </table>
        </div>

        <!-- Info Box -->
        <div style="background:linear-gradient(135deg,#f0fdfa,#ecfeff);border:1px solid #a5f3fc;border-radius:12px;padding:16px 20px;margin:0 0 24px;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td style="width:24px;vertical-align:top;padding-top:2px;">⏱️</td>
                    <td style="padding-left:12px;">
                        <p style="color:#0e7490;font-size:13px;font-weight:600;margin:0 0 4px;">Kode berlaku selama 10 menit</p>
                        <p style="color:#64748b;font-size:12px;margin:0;line-height:1.5;">Jangan bagikan kode ini kepada siapa pun termasuk pihak yang mengaku dari Gresda Food.</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Divider -->
        <div style="border-top:1px solid #e2e8f0;margin:24px 0;"></div>

        <p style="color:#94a3b8;font-size:12px;text-align:center;margin:0;line-height:1.6;">
            Jika Anda tidak merasa mendaftar di Gresda Food, abaikan email ini. Akun tidak akan dibuat tanpa verifikasi.
        </p>
    </div>' . self::getEmailFooter();
    }

    /**
     * Build password reset email template
     */
    private static function buildResetTemplate($userName, $resetUrl)
    {
        return self::getEmailHeader() . '

    <!-- Body -->
    <div style="background:#ffffff;padding:40px 32px 36px;border-radius:0 0 20px 20px;box-shadow:0 4px 24px rgba(0,0,0,0.06);">
        <!-- Icon -->
        <div style="text-align:center;margin-bottom:24px;">
            <div style="display:inline-block;width:64px;height:64px;background:linear-gradient(135deg,#fff7ed,#ffedd5);border-radius:16px;line-height:64px;font-size:28px;">
                🔑
            </div>
        </div>

        <h2 style="color:#1e293b;margin:0 0 8px;font-size:22px;font-weight:700;text-align:center;">Reset Kata Sandi</h2>
        <p style="color:#64748b;text-align:center;margin:0 0 28px;font-size:14px;line-height:1.6;">
            Halo <strong style="color:#0e7490;">' . htmlspecialchars($userName) . '</strong>, kami menerima permintaan untuk mereset kata sandi akun Gresda Food Anda.
        </p>

        <!-- Action Button -->
        <div style="text-align:center;margin:0 0 28px;">
            <a href="' . htmlspecialchars($resetUrl) . '" 
               style="display:inline-block;background:linear-gradient(135deg,#0891b2,#06b6d4);color:#ffffff;text-decoration:none;padding:16px 48px;border-radius:12px;font-size:16px;font-weight:700;box-shadow:0 4px 16px rgba(6,182,212,0.35);letter-spacing:0.3px;">
                Reset Kata Sandi
            </a>
        </div>

        <!-- Info Box -->
        <div style="background:linear-gradient(135deg,#fff7ed,#fffbeb);border:1px solid #fed7aa;border-radius:12px;padding:16px 20px;margin:0 0 24px;">
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td style="width:24px;vertical-align:top;padding-top:2px;">⚠️</td>
                    <td style="padding-left:12px;">
                        <p style="color:#92400e;font-size:13px;font-weight:600;margin:0 0 4px;">Link berlaku selama 1 jam</p>
                        <p style="color:#64748b;font-size:12px;margin:0;line-height:1.5;">Jika Anda tidak meminta reset kata sandi, abaikan email ini — akun Anda tetap aman.</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Divider -->
        <div style="border-top:1px solid #e2e8f0;margin:24px 0;"></div>

        <p style="color:#94a3b8;font-size:12px;text-align:center;margin:0 0 8px;line-height:1.6;">
            Jika tombol tidak berfungsi, salin URL berikut ke browser Anda:
        </p>
        <p style="text-align:center;margin:0;">
            <a href="' . htmlspecialchars($resetUrl) . '" style="color:#0891b2;font-size:12px;word-break:break-all;line-height:1.6;">' . htmlspecialchars($resetUrl) . '</a>
        </p>
    </div>' . self::getEmailFooter();
    }
}
