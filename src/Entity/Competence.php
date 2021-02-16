<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *  attributes={
 *        "pagination_enabled"=true,
 *        "pagination_items_per_page"=1000
 *       },
 *  itemOperations={
 *     "delete"={
 *          "method"="DELETE",
 *          "security"="is_granted('DELETE_COMPETENCE', object)",
 *          "security_message"="Vous n'avez pas access"
 *     },
 *     "get"={
 *          "method"="GET",
 *          "security"="is_granted('GET_COMPETENCE', object)",
 *          "security_message"="Vous n'avez pas d'access"
 *     },
 *     "put"={
 *          "method"="PUT",
 *          "security"="is_granted('PUT_COMPETENCE', object)",
 *          "security_message"="Vous n'avez pas d'access"
 *     }
 * },
 * collectionOperations={"get","post"},
 *      normalizationContext={"groups"={"comp:read"}},
 *     denormalizationContext={"groups"={"comp:write"}}
 * )
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 */
class Competence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"groupe_competence:write","comp:read","comp:write","groupe_competence:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"groupe_competence:read","groupe_competence:write","comp:read","comp:write","referentielGen:read"})
     * @Assert\NotBlank( message="le libelle est obligatoire" )
     *
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comp:read","groupe_competence:read","comp:write","groupe_competence:write","referentielGen:read"})
     * @Assert\NotBlank( message="le descriptif est obligatoire" )
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"comp:read","groupe_competence:read","comp:write","groupe_competence:write","referentielGen:read"})
     */
    private $archivage = 0;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="competences")
     * @Groups({"comp:write"})
     *
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence",cascade={"persist"})
     * @Assert\Count(min="3",max="3",exactMessage="boumou eupou boumou yeusss")
     * @Groups({"comp:read","comp:write","groupe_competence:write","groupecomp:read"})
     * @ApiSubresource
     */
    private $niveaux;

    public function __construct()
    {
        $this->niveaux = new ArrayCollection();
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
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

        return $this;
    }



}
