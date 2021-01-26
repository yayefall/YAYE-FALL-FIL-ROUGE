<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;
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
 *  itemOperations={"delete","get","put"},
 * collectionOperations={"get","post"},
 *     normalizationContext={"groups"={"niveau:read"}},
 *     denormalizationContext={"groups"={"niveau:write"}}
 * )
 * @ORM\Entity(repositoryClass=NiveauRepository::class)
 */
class Niveau
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ({"groupe_competence:write","comp:read","comp:write","niveau:write","niveau:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe_competence:write","comp:read","comp:write","niveau:write","niveau:read"})
     * @Assert\NotBlank( message="le libelle est obligatoire" )
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe_competence:write","comp:read","comp:write","niveau:write","niveau:read"})
     * @Assert\NotBlank( message="le groupedaction est obligatoire" )
     */
    private $groupeDaction;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"groupe_competence:write","comp:read","comp:write","niveau:write","niveau:read"})
     * @Assert\NotBlank( message="le criteredevaluation est obligatoire" )
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"groupe_competence:write","comp:read","comp:write","niveau:write","niveau:read"})
     */
    private $archivage = 0;


    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, inversedBy="niveaux")
     */
    private $briefs;

    /**
     * @ORM\ManyToOne(targetEntity=Competence::class, inversedBy="niveaux",cascade={"persist"})
     */
    private $competence;



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

    public function getGroupeDaction(): ?string
    {
        return $this->groupeDaction;
    }

    public function setGroupeDaction(string $groupeDaction): self
    {
        $this->groupeDaction = $groupeDaction;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

        return $this;
    }

    public function getArchivage(): ?Bool
    {
        return $this->archivage;
    }

    public function setArchivage(bool $archivage): self
    {
        $this->archivage = $archivage;

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

    public function getCompetence(): ?Competence
    {
        return $this->competence;
    }

    public function setCompetence(?Competence $competence): self
    {
        $this->competence = $competence;

        return $this;
    }





}
