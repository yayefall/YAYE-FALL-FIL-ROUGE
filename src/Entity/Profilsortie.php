<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProfilsortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 * routePrefix="/admin",
 * attributes={
 *           "pagination_enabled"=true,
 *           "pagination_items_per_page"=20,
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
 *   collectionOperations={"post","get"},
 *
 *    normalizationContext={"groups"={"profilsorties:read"}},
 *    denormalizationContext={"groups"={"profilsorties:write"}}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=ProfilsortieRepository::class)
 */
class Profilsortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profilsorties:read","apprenant:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @Groups({"profilsorties:read","profilsorties:write","apprenant:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"profilsorties:read"})
     *
     */
    private $archivage = 0;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profilsortie")
     * @Groups({"profilsorties:read"})
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

    public function getArchivage(): ?bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
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
