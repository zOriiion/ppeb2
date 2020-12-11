<?php

namespace App\Entity;

use App\Repository\HistoriqueTestRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=HistoriqueTestRepository::class)
 * @ApiResource()
 */
class HistoriqueTest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $datetest;

    /**
     * @ORM\Column(type="integer")
     */
    private $resultat;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     */
    private $idUtilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=Test::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $idTest;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetest(): ?\DateTimeInterface
    {
        return $this->datetest;
    }

    public function setDatetest(\DateTimeInterface $datetest): self
    {
        $this->datetest = $datetest;

        return $this;
    }

    public function getResultat(): ?int
    {
        return $this->resultat;
    }

    public function setResultat(int $resultat): self
    {
        $this->resultat = $resultat;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }

    public function getIdTest(): ?Test
    {
        return $this->idTest;
    }

    public function setIdTest(?Test $idTest): self
    {
        $this->idTest = $idTest;

        return $this;
    }
}
