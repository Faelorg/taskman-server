<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Invite;
use  Illuminate\Support\Str;

class CompanyController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['CreateCompany']]);
    }
    public function CreateCompany(){

        $id_company = Str::uuid();
        $company = new Company();
        $company->name = request('name');
        $company->id_company = $id_company;
        $company->mainpage = "<div id='logo' class='grid-container ai-center'> <div> </div> <p class='fs-48'>Taskman - просто и быстро</p> </div> <p class='fs-32'>Почему мы?</p> <ul> <li class='grid-container ac-center ai-center'> <p class='fs-28'>Скорость.</p> <p class='fs-24> Возможность быстро создать проект и настроить все доступы и роли. </p> </li> <li class='grid-container grid-container ac-center ai-center'> <p class='fs-28'>Кастомизация.</p> <p class='fs-24'> Возможность настроить внешний вид в соответствии со стилем компании. </p> </li> <li class='grid-container grid-container ac-center ai-center'> <p class='fs-28'>Простота.</p> <p class='fs-24'> Простой и удобный интерфейс в котором может разобраться любой сотрудник. </p> </li> </ul>";
        $company->maincolor = request('maincolor');
        $company->additionalcolor = request('additionalcolor');
        $company->panelcolor = request('panelcolor');
        $company->outlinecolor = request('outlinecolor');
        $company->truebuttoncolor = request('truebuttoncolor');
        $company->selectedbuttoncolor = request('selectedbuttoncolor');
        $company->cancelbuttoncolor = request('cancelbuttoncolor');
        $company->fontcolor = request('fontcolor');
        $company->additionalfontcolor = request('additionalfontcolor');
        $company->codetask = request('codetask');
        $company->smtpsender = request('smtpsender');
        $company->smtpserver = request('smtpserver');
        $company->smtpport = request('smtpport');
        $company->smtppassword = request('smtppassword');

        $company->save();

        $invite = new Invite();
        $invite->email = request('smtpsender');
        $invite->id_company = $id_company;
        $invite->id_invite = $id_company;
        $invite->save();

        $invite->sendInvite($id_company, request('smtpsender'), $id_company);
    }

    public function UpdateCompany(){
        $auth = $user = auth()->user();
        if ($auth->is_admin) {
        $company = Company::find($auth->id_company);
        $company->mainpage = request('mainpage');
        $company->maincolor = request('maincolor');
        $company->additionalcolor = request('additionalcolor');
        $company->panelcolor = request('panelcolor');
        $company->outlinecolor = request('outlinecolor');
        $company->truebuttoncolor = request('truebuttoncolor');
        $company->selectedbuttoncolor = request('selectedbuttoncolor');
        $company->cancelbuttoncolor = request('cancelbuttoncolor');
        $company->fontcolor = request('fontcolor');
        $company->additionalfontcolor = request('additionalfontcolor');
        $company->codetask = request('codetask');
        $company->smtpsender = request('smtpsender');
        $company->smtpserver = request('smtpserver');
        $company->smtpport = request('smtpport');
        $company->smtppassword = request('smtppassword');

        $company->save();
        }
    }
}
