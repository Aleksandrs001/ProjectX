<?php declare(strict_types=1);

namespace App\Models;

class LoginServiceRequest
{
    public string $id;
    public string $name;
    public string $login;
    public string $email;
    public string $avatar;

    public function __construct(string $id,
                                string $name,
                                string $login,
                                string $email,
                                string $avatar)
    {
        $this->id = $id;
        $this->name = $name;
        $this->login = $login;
        $this->email = $email;
        $this->avatar = $avatar;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): string
    {
        return $this->id;
    }
}
