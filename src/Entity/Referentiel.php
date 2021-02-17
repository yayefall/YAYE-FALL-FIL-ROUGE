<?php

namespace App\Entity;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReferentielRepository;
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
 *        "pagination_items_per_page"=100,
 *         "security"="is_granted('ROLE_ADMIN')",
 *         "security_message"="Vous n'avez pas l'access à cette operation",
 *       },
 *     itemOperations={ "delete","get",
 *          "Put_referentiels"={
 *                 "method"="put",
 *                 "path"="/referentiels/{id}",
 *         },
 *    },
 *     collectionOperations={"get",
 *
 *       "Add_referentiels"={
             "method"="post",
 *           "path"="/referentiels",
 *       },
 *
 *      "GET_referentiels"={
 *           "method"="get",
 *            "path"="/referentiels/groupe_competences",
 *            "normalization_context"={"groups"={"referentielGen:read"}}
 *
 *           }
 *     },
 *
 *     normalizationContext={"groups"={"referentiel:read"}},
 *     denormalizationContext={"groups"={"referentiel:write"}}
 *   )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"groupe_competence:write","groupe_competence:read","promo:write","referentiel:read","referentiel:write"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read","referentiel:write","groupe_competence:write","groupe_competence:read"})
     * @Assert\NotBlank( message="le libelle est obligatoire" )
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read","referentiel:write","groupe_competence:write","groupe_competence:read"})
     * @Assert\NotBlank( message="la presentation est obligatoire" )
     */
    private $presentation;

    /**
     * @ORM\Column(type="blob")
     * @Assert\NotBlank( message="le programme est obligatoire" )
     * * @Groups({"referentiel:read","referentiel:write","groupe_competence:write","groupe_competence:read"})
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read","referentiel:write","groupe_competence:write","groupe_competence:read"})
     * @Assert\NotBlank( message="le critereAdmission est obligatoire" )
     */
    private $critereAdmission;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiel:read","referentiel:write","groupe_competence:write","groupe_competence:read"})
     * @Assert\NotBlank( message="le critereEvaluation est obligatoire" )
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archivage = 0;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetence::class, mappedBy="referentiels",cascade={"persist"})
     * @Groups({"referentiel:write","referentielGen:read","referentiel:read" })
     */
    private $groupeCompetences;

    /**
     * @ORM\ManyToMany(targetEntity=Promo::class, mappedBy="referentiels")
     */
    private $promos;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->promos = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme()
    {
        if($this->programme)
        {
            $data = stream_get_contents($this->programme);
            if(!$this->programme){

                fclose($this->programme);
            }
            return base64_encode($data);
        }else
        {
            return null;
        }
       // return $this->programme;
    }

    public function setProgramme( $programme): self
    {
        $this->programme = $programme;
        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

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
            //$groupeCompetence->addReferentiel($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetence $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeReferentiel($this);
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->addReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            $promo->removeReferentiel($this);
        }

        return $this;
    }
}
