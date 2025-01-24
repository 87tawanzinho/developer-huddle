<?php

namespace App\Actions\Fortify;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            "name" => ["required", "string", "max:255"],
            "username" => ["required", "string", "max:255", "unique:users"],
            "email" => [
                "required",
                "string",
                "email",
                "max:255",
                "unique:users",
            ],
            "password" => $this->passwordRules(),
            "terms" => Jetstream::hasTermsAndPrivacyPolicyFeature()
                ? ["accepted", "required"]
                : "",
        ])->validate();

        $user = User::create([
            "name" => $input["name"],
            "cpf_cnpj" => $input["cpf_cnpj"],
            "username" => $input["username"],
            "email" => $input["email"],
            "password" => Hash::make($input["password"]),
        ]);

        $planId = Plan::select(["id"])
            ->where("type", "free")
            ->firstOrFail()->id;

        $user->subscription()->create([
            "plan_id" => $planId,
            "status" => "active",
        ]);

        return $user;
    }
}
