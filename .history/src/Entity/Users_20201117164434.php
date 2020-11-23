<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UsersRepository;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="Profil", type="string")
 * @ORM\DiscriminatorMap({"admin"="Admin","users"="Users","cm"="CM","formateur"="Formateur","apprenant"="Apprenant"})
 * @ApiResource(
 * 
 *  collectionOperations={
 *                 "ADD_user"={
 *                        "method"="POST",
 *                        "path"="/admin/users",
 *                        "security_post_denormalize"="is_granted('ROLE_Admin')",
 *                        "security_post_denormalize_message"="Vous n'avez pas access à cette Ressource",
 *                        },
 *                 "LIST_users"={
 *                        "method"="GET",
 *                         "path"="/admin/users",
 *                         "security"="is_granted('ROLE_Admin')",
 *                         "security_message"="Vous n'avez pas access à cette Ressource"
 *                             },
 *            },
 * itemOperations={
 *        "ARCHIVE_profil"={
 *          "method"="PUT",
 *          "path"="/admin/profils/{id}/archivage",
 *          "controller"="App\Controller\API\ArchivageProfilController",
 *           "security"="is_granted('ROLE_Admin')",
 *           "security_message"="Vous n'avez pas access à cette ressource"
 *        },
 *       "EDIT_profil"={
 *              "method"="PUT",
 *              "path"="/admin/profils/{id}",
 *              "requirements"={"id"="\d+"},
 *              "security"="is_granted('ROLE_Admin')",
 *              "security_message"="Vous n'avez pas access à cette Ressource"
 *          },  
 *        "GET_profil"={
 *              "method"="GET",
 *              "path"="/admin/profils/{id}",
 *              "requirements"={"id"="\d+"},
 *              "security"="is_granted('ROLE_Admin')",
 *              "security_message"="Vous n'avez pas access à cette Ressource"
 *          }, 
 *      },
 *  normalizationContext={"groups"={"user:read"}},
 * )
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
     * @Groups({"Profil:read"})
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
     * @Groups({"Profil:read"})
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le nom est obligatoire" )
     * @Groups({"Profil:read"})
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="l'email est obligatoire" )
     * @Groups({"Profil:read"})
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le telephone est obligatoire" )
     * @Groups({"Profil:read"})
     */
    protected $telephone;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank( message="le photo est obligatoire" )
     * @Groups({"Profil:read"})
     */
    protected $photo;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank( message="le genre est obligatoire" )
     * @Groups({"Profil:read"})
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
    private $profils;


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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
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
