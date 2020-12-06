<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApprenantRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *  attributes={
 *        "pagination_enabled"=true,
 *        "pagination_items_per_page"=3,
 *         "security"="is_granted('ROLE_ADMIN')",
 *         "security_message"="Vous n'avez pas l'access à cette operation",
 *       },
 *     itemOperations={"delete","get","put"},
 *     collectionOperations={"get","post"},
 *    )
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 */
class Apprenant extends Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupe:write"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"user:read","user:write","groupes:read"})
     */
    protected $statut;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read","user:write","groupes:read"})
     */
    protected $infocomplementaire;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"user:read","user:write","groupes:read"})
     */
    protected $categorie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read","user:write","groupes:read"})
     */
    protected $adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Profilsortie::class, inversedBy="apprenants")
     * @Groups({"user:read","user:write"})
     */
    private $profilsortie;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="apprenant")
     */
    private $groupes;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getInfocomplementaire(): ?string
    {
        return $this->infocomplementaire;
    }

    public function setInfocomplementaire(string $infocomplementaire): self
    {
        $this->infocomplementaire = $infocomplementaire;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getProfilsortie(): ?Profilsortie
    {
        return $this->profilsortie;
    }

    public function setProfilsortie(?Profilsortie $profilsortie): self
    {
        $this->profilsortie = $profilsortie;

        return $this;
    }

    /**
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->addApprenant($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeApprenant($this);
        }

        return $this;
    }

}
