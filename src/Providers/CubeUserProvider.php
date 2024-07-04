<?php

namespace Tchoblond59\CubeAuth\Providers;

use Tchoblond59\CubeAuth\Models\CubeUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\Http;

class CubeUserProvider implements UserProvider
{

    public function retrieveById($identifier)
    {
        // TODO: Implement retrieveById() method.
        $reponse = Http::post(config('cube.cube_api_url').'/authentification', [
            'utilisateur' => 'cube@groupemaurizi.com',
            'password' => 'cube',
            'cle_client' => 'sda'
        ]);
        if ($reponse->successful()) {
            $token = $reponse->json()['token'];
            $user_reponse = Http::withHeader('token', $token)->get(config('cube.cube_api_url').'/utilisateur?inclus=client,roles,adresses');
            $user = json_decode($user_reponse->getBody()->getContents(), true);
            return new CubeUser($user, $token);
        } else {
            return null;
        }
    }

    public function retrieveByToken($identifier, $token)
    {
        // TODO: Implement retrieveByToken() method.
        $user_reponse = Http::withHeader('token', $token)->get(config('cube.cube_api_url').'/utilisateur?inclus=client,roles,adresses');
        $user = json_decode($user_reponse->getBody()->getContents(), true);
        if ($user_reponse->successful()) {
            return new CubeUser($user, $token);
        } else {
            return null;
        }
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // TODO: Implement updateRememberToken() method.
        return new CubeUser([], 70);
    }

    public function retrieveByCredentials(array $credentials)
    {
        // TODO: Implement retrieveByCredentials() method.
        $reponse = Http::post(config('cube.cube_api_url').'/authentification', [
            'utilisateur' => $credentials['email'],
            'password' => $credentials['password'],
            'cle_client' => 'sda'
        ]);
        if ($reponse->successful()) {
            $token = $reponse->json()['token'];
            $user_reponse = Http::withHeader('token', $token)->get(config('cube.cube_api_url').'/utilisateur?inclus=client,roles,adresses');
            $user = json_decode($user_reponse->getBody()->getContents(), true);
            session(['token' => $token]);
            return new CubeUser($user, $token);
        } else {
            return null;
        }
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // TODO: Implement validateCredentials() method.
        $reponse = Http::post(config('cube.cube_api_url').'/authentification', [
            'utilisateur' => 'cube@groupemaurizi.com',
            'password' => 'cube',
            'cle_client' => 'sda'
        ]);
        if ($reponse->successful()) {
            $token = $reponse->json()['token'];
            $user_reponse = Http::withHeader('token', $token)->get(config('cube.cube_api_url').'/utilisateur?inclus=client,roles,adresses', [
               'utilisateur' => 'cube@groupemaurizi.com',
               'password' => 'cube',
               'cle_client' => 'sda'
            ]);
            $user = json_decode($user_reponse->getBody()->getContents(), true);
            return new CubeUser($user, $token);
        } else {
            return null;
        }
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        // TODO: Implement rehashPasswordIfRequired() method.
    }
}
