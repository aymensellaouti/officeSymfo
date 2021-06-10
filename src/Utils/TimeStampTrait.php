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
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

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