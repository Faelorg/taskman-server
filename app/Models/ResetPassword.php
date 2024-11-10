<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Notifications\Notifiable;
use App\Models\Company;

class ResetPassword extends Model
{
    use HasFactory;
    use HasFactory;
    use Notifiable;
    protected $fillable = ['id_reset','email'];
    public $timestamps=false;
    protected $appends = ['email'];
    protected $primaryKey = 'id_reset';

    public function resetPassword($email,$code_invite) {
        $id_company = User::where('email', $email)->get()->first();
        $company = Company::find($id_company)->first();
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        try {
        $mail->Mailer = 'smtp';
        $mail->Host = 'ssl://'.$company->smtpserver;
        $mail->SMTPAuth = true;
        $mail->SMTPOptions = array (
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true)
        );
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Username   = $company->smtpsender;
        $mail->Password   = $company->smtppassword;
        $mail->Port       = $company->smtpport;
        $mail->setFrom($company->smtpsender);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Востановление';
        $mail->Body = ' Ссылка на востановление пароля '.$company->name.' <br><a href="http://localhost:5173/auth/'.$code_invite.'/reset">Востановить пароль</a>';
        $mail->send();
        echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
