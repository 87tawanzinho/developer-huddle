<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'cpf_cnpj' => $this->cpf_cnpj,
            'password' => $this->password,
            'email_verified_at' => $this->email_verified_at,
            'remember_token' => $this->remember_token,
            'profile_photo_path' => $this->profile_photo_path,
            'gateway_id' => $this->gateway_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'two_factor_secret' => $this->two_factor_secret,
            'two_factor_recovery_codes' => $this->two_factor_recovery_codes,
            'two_factor_confirmed_at' => $this->two_factor_confirmed_at,
            'profile_photo_url' => $this->profile_photo_url,
            'invitations_count' => $this->invitations_count,
            'invitations_sent_count' => $this->invitations_sent_count,
            'notifications_count' => $this->notifications_count,
            'projects_count' => $this->projects_count,
            'read_notifications_count' => $this->read_notifications_count,
            'tasks_count' => $this->tasks_count,
            'tokens_count' => $this->tokens_count,
            'unread_notifications_count' => $this->unread_notifications_count,

            'address_id' => 'teste',
        ];
    }
}
