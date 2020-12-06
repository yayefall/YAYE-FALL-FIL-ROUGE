<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormateurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     routePrefix="/admin/",
 *  attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=2,
 *           "security"="is_granted('ROLE_ADMIN')",
 *            "security_message"="Vous n'avez pas access à cette Ressource"
 *         },
 *     collectionOperations={"get",
 *                 "ADD_formateur"={
 *                        "method"="POST",
 *                        "path"="/formateurs",
 *                         "route_name"="addFormateur",
 *
 *
 *                        },
 *            },
 *     itemOperations={"get",
 *     "Edit_formateur"={
 *          "method"="post",
 *          "path"="/formateurs/{id}",
 *         "route_name"="editFormateur",
 *
 *     },
 *        "ARCHIVE_formateurs"={
 *          "method"="PUT",
 *          "path"="/formateurs/archivage"
 *
 *            },
 *      },
 *  normalizationContext={"groups"={"formateur:read"}},
 * )
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 */
class Formateur extends Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="le Username est obligatoire" )
     * @Groups({"groupe:write","promo:write"})
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="formateur")
     */
    private $promos;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="formateur")
     */
    private $groupes;

    public function __construct()
    {
        $this->promos = new ArrayCollection();
        $this->groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addFormateur($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeFormateur($this);
        }

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
            $groupe->addFormateur($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeFormateur($this);
        }

        return $this;
    }
}
