<?php

namespace App\Entity;

use App\Repository\AdminCategoryControllerRepository;
use App\Repository\AdminCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdminCategoryControllerRepository::class)]
class AdminCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
