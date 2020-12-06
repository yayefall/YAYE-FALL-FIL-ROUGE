<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource (
 *       routePrefix="/admin",
 *  attributes={
 *        "pagination_enabled"=true,
 *        "pagination_items_per_page"=3,
 *         "security"="is_granted('ROLE_ADMIN')",
 *         "security_message"="Vous n'avez pas l'access à cette operation",
 *       },
 *     itemOperations={"delete","get","put",
 *     "DELETE_groupe"={
 *              "method" = "DELETE",
 *              "path" = "/groupes/{id}/apprenants",
 *
 *          },
 *     },
 *     collectionOperations={"get","post",
 *     "GET_groupe"={
 *              "method" = "GET",
 *              "path" = "/groupes/apprenants",
 *              "normalization_context"={"groups"={"groupes:read"}}
 *          },
 *     },
 *     normalizationContext={"groups"={"groupe:read"}},
 *     denormalizationContext={"groups"={"groupe:write"}}
 *
 * )
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupe:write","promo:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Groups({"groupe:read","groupe:write"})
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Groups({"groupe:read","groupe:write"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"groupe:read","groupe:write"})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe:read","groupe:write"})
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"groupe:read","groupe:write"})
     */
    private $archivage;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupe",cascade="persist")
     * @Groups({"groupe:read"})
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes")
     * @Groups({"groupe:read","groupe:write"})
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes")
     * @Groups({"groupe:read","groupe:write","groupes:read"})
     */
    private $apprenant;

    public function __construct()
    {
        $this->formateur = new ArrayCollection();
        $this->apprenant = new ArrayCollection();
        $this->dateCreation = new \DateTime("now");
        $this->archivage =false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getArchivage(): ?int
    {
        return $this->archivage;
    }

    public function setArchivage(int $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateur(): Collection
    {
        return $this->formateur;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateur->contains($formateur)) {
            $this->formateur[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->formateur->removeElement($formateur);

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        $this->apprenant->removeElement($apprenant);

        return $this;
    }

}
