<?php

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword2
{

    /**
     * @var string
     *
     * @Assert\Length(
     *      min = 6,
     *      max = 500,
     *      minMessage = "El password nuevo debe de tener por lo menos de {{ limit }} caracteres.",
     *      maxMessage = "El password nuevo no puede tener mayor a {{ limit }} caracteres."
     * )
     */
    private $newPassword;


    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
    }

}