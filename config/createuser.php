<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

return [

    /*
     * Whether or not the Opis Closure serialization is enabled
     */
    'enable_serialization' => true,

    /*
    * The class name of the user model to be used.
    */
    'model' => User::class,

    /*
    * The fields with their validation rules to check for user model input.
    */
    'fields' => [
        'name'     => [
            'validation_rules' => ['string', 'max:255'],
            'secret' => false,
            'modifier_fn' => null,
        ],
        'email'    => [
            'validation_rules' => ['string', 'email', 'max:255', 'unique:users'],
            'secret' => false,
            'modifier_fn' => null,
        ],
        'password' => [
            'validation_rules' => ['string', 'min:8'],
            'secret' => true,
            'modifier_fn' => \Opis\Closure\serialize(function ($value) {
                return Hash::make($value);
            }),
        ],
        'is_admin' => [
            'validation_rules' => ['bool'],
            'secret' => false,
            'modifier_fn' => null,
        ],
    ],

    'post_creation_fn' => \Opis\Closure\serialize(function ($user) {
        $user->markEmailAsVerified();

        return $user;
    }),

];
