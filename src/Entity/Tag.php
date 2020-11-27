<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="integer")
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="tags")
     */
    private $groupeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeTag::class, inversedBy="tags")
     */
    private $groupetags;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, inversedBy="tags")
     */
    private $briefs;

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

    public function getLibelle(): ?int
    {
        return $this->libelle;
    }

    public function setLibelle(int $libelle): self
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

}
