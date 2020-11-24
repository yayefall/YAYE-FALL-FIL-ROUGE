<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;


/**
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="Profil", type="string")
 * @ORM\DiscriminatorMap({"admin"="Admin","users"="Users","cm"="CM","formateur"="Formateur","apprenant"="Apprenant"})
 * @ApiResource(
 *  routePrefix="/admin/",
 *  attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=2,
 *           "security"="is_granted('ROLE_ADMIN')",
 *            "security_message"="Vous n'avez pas access à cette Ressource"
 *         },
 *  collectionOperations={"get",
 *                 "ADD_user"={
 *                        "method"="POST",
 *                        "path"="/users",
 *                         "route_name"="addUser",
 *
 *                        },
 *            },
 *     itemOperations={"put","get","delete"},
 *  normalizationContext={"groups"={"user:read","user:write"}},
 * )
 * @ApiFilter(BooleanFilter::class, properties={"archivage"})
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
 
class Users implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank( message="le Username est obligatoire" )
     * @Groups({"user:read"})
     */
    protected $username;

    
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le prenom est obligatoire" )
     * @Groups({"user:read"})
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le nom est obligatoire" )
     * @Groups({"user:read"})
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="l'email est obligatoire" )
     * @Groups({"user:read"})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le telephone est obligatoire" )
     * @Groups({"user:read"})
     */
    protected $telephone;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Assert\NotBlank( message="le photo est obligatoire")
     * @Groups({"user:read"})
     * @Groups({"user:write"})
     */
    protected $photo;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank( message="le genre est obligatoire" )
     * @Groups({"user:read"})
     */
    protected $genre;

    /**
     * @ORM\Column(type="integer")
     */
    protected $archivage;

    /**
     * @ORM\ManyToOne(targetEntity=Profils::class, inversedBy="users")
     * @Assert\NotBlank( message="le profile est obligatoire" )
     */
    protected $profils;

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
         $roles[] = 'ROLE_' . $this->profils->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getPhoto()
    {
        if($this->photo)
        {
            $data = stream_get_contents($this->photo);
            if(!$this->photo){

                fclose($this->photo);
            }
            return base64_encode($data);
        }else
        {
            return null;
        }

    }


    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

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

    public function getProfils(): ?Profils
    {
        return $this->profils;
    }

    public function setProfils(?Profils $profils): self
    {
        $this->profils = $profils;

        return $this;
    }

    
}
