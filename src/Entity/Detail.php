<?php

namespace App\Entity;

use App\Repository\DetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailRepository::class)
 */
class Detail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="details")
     * @ORM\JoinColumn(nullable=false)
     */
    private $detailProduit;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="details")
     * @ORM\JoinColumn(nullable=false)
     */
    private $detailCommande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDetailProduit(): ?Product
    {
        return $this->detailProduit;
    }

    public function setDetailProduit(?Product $detailProduit): self
    {
        $this->detailProduit = $detailProduit;

        return $this;
    }

    public function getDetailCommande(): ?Commande
    {
        return $this->detailCommande;
    }

    public function setDetailCommande(?Commande $detailCommande): self
    {
        $this->detailCommande = $detailCommande;

        return $this;
    }
}
