<?php declare(strict_types=1);

namespace App\Models\Collections;

class ChangePasswordServiceCollection
{
    private string $currentPassword;
    private string $newPassword;
    private string $reNewPassword;
    private int $id;

    public function __construct(string $currentPassword,
                                string $newPassword,
                                string $reNewPassword,
                                int $id)
    {

        $this->currentPassword = md5($currentPassword);
        $this->newPassword = md5($newPassword);
        $this->reNewPassword = md5($reNewPassword);
        $this->id = $id;
    }

    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function getReNewPassword(): string
    {
        return $this->reNewPassword;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
