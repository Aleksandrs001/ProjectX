<?php declare(strict_types=1);

namespace App\Models;

class RegisterServiceRequest
{
    public string $name;
    public string $email;
    public string $password;
    public string $login;
    public array $avatar;

    public function __construct(string $name,
                                string $login,
                                string $email,
                                string $password,
                                array $avatar
    )
    {
        $this->name = $name;
        $this->login = $login;
        $this->email = $email;
        $this->password = $password;
        $this->avatar = $avatar;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAvatar(): string
    {
        $path = 'uploads/' . time() . $this->avatar['name'];
        if (!move_uploaded_file($this->avatar['tmp_name'], $path)) {
//            $_SESSION['message'] = "Error uploading Avatar";
            return "<null>";
        }
        return $path;
    }
}
