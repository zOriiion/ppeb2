<?php

namespace App\Entity;

use App\Repository\TestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=TestRepository::class)
 * @ApiResource()
 */
class Test
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
    private $libelle;

    /**
     * @ORM\ManyToMany(targetEntity=ListeMot::class)
     */
    private $idListeMot;

    /**
     * @ORM\ManyToOne(targetEntity=Niveau::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $idNiveau;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageUrl;

    public function __construct()
    {
        $this->idListeMot = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|ListeMot[]
     */
    public function getIdListeMot(): Collection
    {
        return $this->idListeMot;
    }

    public function addIdListeMot(ListeMot $idListeMot): self
    {
        if (!$this->idListeMot->contains($idListeMot)) {
            $this->idListeMot[] = $idListeMot;
        }

        return $this;
    }

    public function removeIdListeMot(ListeMot $idListeMot): self
    {
        $this->idListeMot->removeElement($idListeMot);

        return $this;
    }

    public function getIdNiveau(): ?Niveau
    {
        return $this->idNiveau;
    }

    public function setIdNiveau(?Niveau $idNiveau): self
    {
        $this->idNiveau = $idNiveau;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
