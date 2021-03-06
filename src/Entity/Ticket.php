<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use App\Utils\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Ticket
{
    use TimeStampTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Ce champ est obligatoire, merci de le renseigner")
     * @ORM\Column(type="string", length=255)
     */
    private $designation;

    /**
     * @Assert\NotBlank(message="Ce champ est obligatoire, merci de le renseigner")
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @Assert\NotBlank(message="Ce champ est obligatoire, merci de le renseigner")
     * @ORM\ManyToMany(targetEntity=Departement::class)
     */
    private $departements;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fichier;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tickets")
     */
    private $owner;

    public function __construct()
    {
        $this->departements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?status
    {
        return $this->status;
    }

    public function setStatus(?status $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|departement[]
     */
    public function getDepartements(): Collection
    {
        return $this->departements;
    }

    public function addDepartement(departement $departement): self
    {
        if (!$this->departements->contains($departement)) {
            $this->departements[] = $departement;
        }

        return $this;
    }

    public function removeDepartement(departement $departement): self
    {
        $this->departements->removeElement($departement);

        return $this;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(?string $fichier): self
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function getOwner(): ?user
    {
        return $this->owner;
    }

    public function setOwner(?user $owner): self
    {
        $this->owner = $owner;

        return $this;
    }
}
