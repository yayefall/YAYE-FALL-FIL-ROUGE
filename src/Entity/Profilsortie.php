<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilsortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 * routePrefix="/admin",
 * attributes={
 *           "pagination_enabled"=true,
 *           "pagination_items_per_page"=2,
 *           "security"="is_granted('ROLE_ADMIN')",
 *           "security_message"="Vous n'avez pas access à cette ressource",
 *         },
 *  itemOperations={"get", "put","delete",
 *      "getProfilsortieAtPromo"={
 *           "method"="GET",
 *           "path"="/promos/id_promo/profilsorties/id_profilsortie",
 *           "api_item_operation_name"="getProfilsortieAtPromo",
 *           "requirements"={"id"="\d+"},
 *
 *           },
 *
 *      },
 *  collectionOperations={"post","get"},
 *
 * normalizationContext={"groups"={"profilsortie:read"}}
 * )
 * @ORM\Entity(repositoryClass=ProfilsortieRepository::class)
 */
class Profilsortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"Profilsortie:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"Profilsortie:read"})
     */
    private $archivage;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilsortie")
     */
    private $apprenants;

    public function __construct()
    {
        $this->apprenants = new ArrayCollection();
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

    public function getArchivage(): ?int
    {
        return $this->archivage;
    }

    public function setArchivage(int $archivage): self
    {
        $this->archivage = $archivage;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenants(): Collection
    {
        return $this->apprenants;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenants->contains($apprenant)) {
            $this->apprenants[] = $apprenant;
            $apprenant->setProfilsortie($this);
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        if ($this->apprenants->removeElement($apprenant)) {
            // set the owning side to null (unless already changed)
            if ($apprenant->getProfilsortie() === $this) {
                $apprenant->setProfilsortie(null);
            }
        }

        return $this;
    }

}
