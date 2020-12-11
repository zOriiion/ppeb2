<?php

namespace App\Entity;

use App\Repository\VocabulaireRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=VocabulaireRepository::class)
 * @ApiResource()
 */
class Vocabulaire
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
    private $libelleNonTraduit;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleFaux1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelleFaux2;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class)
     * @ORM\JoinColumn(nullable=true)
     */
    private $idCategorie;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleNonTraduit(): ?string
    {
        return $this->libelleNonTraduit;
    }

    public function setLibelleNonTraduit(string $libelleNonTraduit): self
    {
        $this->libelleNonTraduit = $libelleNonTraduit;

        return $this;
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

    public function getLibelleFaux1(): ?string
    {
        return $this->libelleFaux1;
    }

    public function setLibelleFaux1(string $libelleFaux1): self
    {
        $this->libelleFaux1 = $libelleFaux1;

        return $this;
    }

    public function getLibelleFaux2(): ?string
    {
        return $this->libelleFaux2;
    }

    public function setLibelleFaux2(string $libelleFaux2): self
    {
        $this->libelleFaux2 = $libelleFaux2;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?Categorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

}
