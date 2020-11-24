<?php

namespace App\Entity;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     routePrefix="/admin/",
 *     attributes={
 *           "pagination_enabled"=true,
 *           "pagination_items_per_page"=2,
 *           "security"="is_granted('ROLE_ADMIN')",
 *           "security_message"="Vous n'avez pas access à cette ressource"
 *         },
 *
 * collectionOperations={ "get","post"},
 * itemOperations={"put","get","delete"},
 * normalizationContext={"groups"={"profil:read"}},
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=ProfilsRepository::class)
 */
class Profils
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le libelle est obligatoire" )
     * @Groups({"Profil:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="l'archevage est obligatoire" )
     * @Groups({"Profil:read"})
     */
    private $archivage;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="profils")
     * @Assert\NotBlank( message="le user est obligatoire" )
     * @Groups({"Profil:read"})
     * @ApiSubresource()
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
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
     * @return Collection|Users[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Users $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setProfils($this);
        }

        return $this;
    }

    public function removeUser(Users $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getProfils() === $this) {
                $user->setProfils(null);
            }
        }

        return $this;
    }

   
}
