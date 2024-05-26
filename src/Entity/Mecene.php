<?php

namespace App\Entity;

use App\Repository\MeceneRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeceneRepository::class)]
class Mecene extends Compte
{
    public function __construct() {
        $this->roles = ['ROLE_MECENE'];
    }
}
