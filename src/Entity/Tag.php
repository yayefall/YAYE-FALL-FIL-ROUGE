<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagRepository;
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
 *        "pagination_items_per_page"=4,
 *        "security"="is_granted('ROLE_ADMIN')",
 *         "security_message"="Vous n'avez pas l'access à cette operation",
 *
 *       },
 *  itemOperations={"delete","get","put"},
 *  collectionOperations={"get","post"},
 *   normalizationContext={"groups"={"tag:read"}},
 *     denormalizationContext={"groups"={"tag:write"}},
 * )
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tag:read","tag:write","groupetag:write","groupetag:read"})
     * @Assert\NotBlank( message="le libelle est obligatoire" )
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tag:read","tag:write","groupetag:write","groupetag:read"})
     * @Assert\NotBlank( message="le descriptif est obligatoire" )
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="tags")
     */
    private $groupeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeTag::class, inversedBy="tags")
     * @Groups({"groupetag:write"})
     */
    private $groupetags;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, inversedBy="tags")
     */
    private $briefs;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"tag:read","tag:write","groupetag:write","groupetag:read"})
     */
    private $archivage;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->groupetags = new ArrayCollection();
        $this->briefs = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|GroupeCompetence[]
     */
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addTag($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeTag($this);
        }

        return $this;
    }

    /**
     * @return Collection|GroupeTag[]
     */
    public function getGroupetags(): Collection
    {
        return $this->groupetags;
    }

    public function addGroupetag(GroupeTag $groupetag): self
    {
        if (!$this->groupetags->contains($groupetag)) {
            $this->groupetags[] = $groupetag;
        }

        return $this;
    }

    public function removeGroupetag(GroupeTag $groupetag): self
    {
        $this->groupetags->removeElement($groupetag);

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        $this->briefs->removeElement($brief);

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


}
