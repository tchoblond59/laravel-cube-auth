<?php

namespace Tchoblond59\CubeAuth\Models;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Authenticatable;

class CubeUser implements Authenticatable, \JsonSerializable
{
    public $id;
    public $civilite;
    public $nom;
    public $prenom;
    public $telephone;
    public $mobile;
    public $fax;
    public $email;
    public $code_representant;
    protected $token;
    public $attributes;
    public $client;
    public $roles;

    public function __construct($data, $token)
    {
        $this->id = $data['id'];
        $this->civilite = $data['civilite'];
        $this->nom = $data['nom'];
        $this->prenom = $data['prenom'];
        $this->telephone = $data['telephone'];
        $this->mobile = $data['mobile'];
        $this->fax = $data['fax'];
        $this->email = $data['email'];
        $this->code_representant = $data['code_representant'];
        $this->token = $token;
        $this->attributes['id'] = $this->id;
        if(array_key_exists('client', $data))
        {
            $this->client = $data['client'];
        }
//        dd(array_key_exists('roles', $data));
        $this->roles = $data['roles'];
    }

    /**
     * @inheritDoc
     */
    public function getAuthIdentifierName()
    {
        return 'token';
    }

    /**
     * @inheritDoc
     */
    public function getAuthIdentifier()
    {
        return $this->token;
    }

    /**
     * @inheritDoc
     */
    public function getAuthPassword()
    {
        dd('ici');
        return 'haché';
    }

    /**
     * @inheritDoc
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
        return $this->token;
    }

    /**
     * @inheritDoc
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
        $this->token = $value;
    }

    /**
     * @inheritDoc
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
        return 'token';
    }

    public function getEmailAttribute()
    {
        return $this->email;
    }

    public function jsonSerialize(): mixed
    {
        // TODO: Implement jsonSerialize() method.
        return [
            'id' => $this->id,
            'email' => $this->email,
        ];
    }
    public function hasRole($type, $module = 'SAV'){
        return !empty(array_filter($this->roles, function ($role) use ($type, $module) {
            return $role['type'] === $type && $role['module'] === $module;
        }));
    }

    public function getAuthPasswordName()
    {
        // TODO: Implement getAuthPasswordName() method.
        return 'password';
    }
}
