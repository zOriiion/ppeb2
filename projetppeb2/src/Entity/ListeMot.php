<?php

namespace App\Entity;

use App\Repository\ListeMotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ListeMotRepository::class)
 */
class ListeMot
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
     * @ORM\ManyToMany(targetEntity=Vocabulaire::class)
     */
    private $idVocabulaire;

    /**
     * @ORM\ManyToOne(targetEntity=Theme::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idTheme;

    public function __construct()
    {
        $this->idVocabulaire = new ArrayCollection();
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
     * @return Collection|Vocabulaire[]
     */
    public function getIdVocabulaire(): Collection
    {
        return $this->idVocabulaire;
    }

    public function addIdVocabulaire(Vocabulaire $idVocabulaire): self
    {
        if (!$this->idVocabulaire->contains($idVocabulaire)) {
            $this->idVocabulaire[] = $idVocabulaire;
        }

        return $this;
    }

    public function removeIdVocabulaire(Vocabulaire $idVocabulaire): self
    {
        $this->idVocabulaire->removeElement($idVocabulaire);

        return $this;
    }

    public function getIdTheme(): ?Theme
    {
        return $this->idTheme;
    }

    public function setIdTheme(?Theme $idTheme): self
    {
        $this->idTheme = $idTheme;

        return $this;
    }
}
