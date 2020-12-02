<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *  attributes={
 *        "pagination_enabled"=true,
 *        "pagination_items_per_page"=5,
 *        "security"="is_granted('ROLE_ADMIN')",
 *         "security_message"="Vous n'avez pas l'access à cette operation",
 *
 *       },
 *  itemOperations={"delete","get","put",
 *     "get"={
 *     "method"="get",
 *     "path"="/groupetags/{id}/tags",
 *        }
 *     },
 *  collectionOperations={"get","post"},
 *   normalizationContext={"groups"={"groupetag:read"}},
 *     denormalizationContext={"groups"={"groupetag:write"}},
 * )
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
 */
class GroupeTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupetag:read","groupetag:write"})
     * @Assert\NotBlank(message="le descriptif est obligatoire" )
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"groupetag:read","groupetag:write"})
     * @Assert\NotBlank( message="le descriptif est obligatoire" )
     */
    private $archivage;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="groupetags")
     * @Groups({"groupetag:read","groupetag:write"})
     * @ApiSubresource()
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addGroupetag($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeGroupetag($this);
        }

        return $this;
    }
}
