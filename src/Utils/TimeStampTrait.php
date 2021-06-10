<?php


namespace App\Utils;


use Doctrine\ORM\Mapping as ORM;

trait TimeStampTrait
{

    /**
     * @var
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist() {
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate()
     */
    public function onPreUpdate() {
        $this->updatedAt = new \DateTime('now');
    }

}