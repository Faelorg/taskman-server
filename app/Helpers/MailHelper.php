<?php

namespace App\Helpers;

use App\Setting;
use APP\Models\Company.php

class MailHelper
{

    public static function setMailConfig($company){

        $mailConfig = [
            'transport' => 'smtp',
            'url'=>$company['smtp_provider']
            'host' => $company['smtp_host'],
            'port' => $company['smtp_port'],
            'username' => $company['smtp_username'],
            'password' => $company['smtp_password'],
        ];

        //To set configuration values at runtime, pass an array to the config helper
        config(['mail.mailers.smtp' => $mailConfig]);
    }
}
