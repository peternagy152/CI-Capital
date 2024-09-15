<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Mail\AccountActivate;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

use App\Traits\GlobalWidgets;

class EditUser extends EditRecord
{
    use GlobalWidgets;
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user_info  = User::where("email", $data['email'])->first();
        if($user_info->is_activate_verified == '0'){
            if($data['is_activated']){
                $new_password   = $this->randomPassword(15) ;
                $user_info->password = $new_password ;
                $user_info->save() ;
                $mail = new AccountActivate($user_info->name , $new_password) ;
                Mail::to($user_info->email)->send($mail);
                $user_info->is_activate_verified = 1 ;
                $user_info->save() ;
            }

        }

        return $data;
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
