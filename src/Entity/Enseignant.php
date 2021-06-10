<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EnseignantRepository::class)
 */
class Enseignant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Cours::class, mappedBy="enseignant", cascade={"persist", "remove"})
     */
    private $cours;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        // unset the owning side of the relation if necessary
        if ($cours === null && $this->cours !== null) {
            $this->cours->setEnseignant(null);
        }

        // set the owning side of the relation if necessary
        if ($cours !== null && $cours->getEnseignant() !== $this) {
            $cours->setEnseignant($this);
        }

        $this->cours = $cours;

        return $this;
    }
}
