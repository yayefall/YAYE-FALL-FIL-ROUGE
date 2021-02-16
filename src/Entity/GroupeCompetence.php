<?php

namespace App\Entity;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\GroupeCompetenceRepository;
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
 *        "pagination_items_per_page"=1000
 *
 *       },
 *
 *  itemOperations={"delete",
 *     "put"={
 *          "method"="PUT",
 *          "path"="/groupe_competences/{id}",
 *          "security"="is_granted('PUT_GroupeComp', object)",
 *          "security_message"="Vous n'avez pas d'access"
 *     },
 *     "get"={
 *          "method"="GET",
 *          "security"="is_granted('GET_GroupeComp', object)",
 *          "security_message"="Vous n'avez pas d'access"
 *     },
 *          "GET_competences"={
 *                 "method" = "GET",
 *                 "path" = "/groupecompetences/{id}/competences",
 *                 "security"="is_granted('GET_GroupeComp', object)",
 *                 "security_message"="Vous n'avez pas d'access"
 *             },
 *       },
 *  collectionOperations={"get","post",
 *
 *         "GET_competence"={
 *              "method" = "GET",
 *              "path" = "/groupe_competences/competences",
 *              "normalization_context"={"groups"={"groupecomp:read"}}
 *          },
 *     },
 *   normalizationContext={"groups"={"groupe_competence:read"}},
 *     denormalizationContext={"groups"={"groupe_competence:write"}}
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 */
class GroupeCompetence
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"groupe_competence:write","groupe_competence:read","comp:write","referentiel:read","referentiel:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Groups({"groupe_competence:read","groupe_competence:write","referentiel:write","referentielGen:read","referentiel:read"})
     * @Assert\NotBlank( message="le libelle est obligatoire" )
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe_competence:read","groupe_competence:write","referentiel:write","referentielGen:read","referentiel:read"})
     * @Assert\NotBlank( message="descriptif est obligatoire")
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"groupe_competence:read","groupe_competence:write","referentiel:write","referentielGen:read","referentiel:read"})
     */
    private $archivage = 0;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeCompetences")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences",cascade={"persist"})
     * @Groups({"groupe_competence:read","groupe_competence:write","referentielGen:read","groupecomp:read"})
     * @ApiSubresource()
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, inversedBy="groupeCompetences",cascade={"persist"})
     */
    private $referentiels;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @return Collection|Competence[]
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competences->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        $this->referentiels->removeElement($referentiel);

        return $this;
    }

}
