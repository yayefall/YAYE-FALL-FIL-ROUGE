<?php

namespace App\Entity;

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
 *        "pagination_items_per_page"=5
 *
 *       },
 *
 *  itemOperations={"delete",
 *     "put"={
 *          "method"="PUT",
 *          "path"="/groupe_competences/{id}",
 *          "security"="is_granted('PUT_GroupeCompetence', object)",
 *          "security_message"="Vous n'avez pas d'access"
 *     },
 *     "get"={
 *          "method"="GET",
 *          "security"="is_granted('GET_GroupeCompetence', object)",
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
 *              "path" = "/groupecompetences/competences"
 *          },
 *     },
 *   normalizationContext={"groups"={"groupe_competence:read"}},
 *     denormalizationContext={"groups"={"groupe_competence:write"}}
 * )
 * @ORM\Entity(repositoryClass=GroupeCompetenceRepository::class)
 */
class GroupeCompetence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Groups({"groupe_competence:read","groupe_competence:write"})
     * @Assert\NotBlank( message="le libelle est obligatoire" )
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe_competence:read","groupe_competence:write"})
     * @Assert\NotBlank( message="descriptif est obligatoire" )
     */
    private $descriptif;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="l'archivage est obligatoire" )
     * @Groups({"groupe_competence:read","groupe_competence:write"})
     */
    private $archivage;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeCompetences")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="groupeCompetences",cascade={"persist"})
     * @Groups({"groupe_competence:read","groupe_competence:write","niveau:read","niveau:write"})
     * @ApiSubresource()
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, inversedBy="groupeCompetences")
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
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        $this->referentiels->removeElement($referentiel);

        return $this;
    }

}
