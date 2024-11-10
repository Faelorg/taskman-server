<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Illuminate\Notifications\Notifiable;
use App\Models\Company;

class Invite extends Model
{
    use HasFactory;
    use Notifiable;
    protected $fillable = ['id_invite','id_company','email'];
    public $timestamps=false;
    protected $appends = ['email'];
    protected $primaryKey = 'id_invite';


    public function sendInvite($id_company,$email,$code_invite) {
        $company = Company::find($id_company);
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
        $mail->Subject = 'Приглашение';
        $mail->Body = 'Вас пригласили в компанию '.$company->name.' <br><a href="'.env("CLIENT_HOST",null).'auth/'.$code_invite.'/register">Принять приглашение</a>';
        $mail->send();
        echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
