<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormateurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     routePrefix="/admin/",
 *  attributes={
 *          "pagination_enabled"=true,
 *           "pagination_items_per_page"=2,
 *           "security"="is_granted('ROLE_ADMIN')",
 *            "security_message"="Vous n'avez pas access à cette Ressource"
 *         },
 *     collectionOperations={"get",
 *                 "ADD_formateur"={
 *                        "method"="POST",
 *                        "path"="/formateurs",
 *                         "route_name"="addFormateur",
 *
 *
 *                        },
 *            },
 *     itemOperations={"get",
 *     "Edit_formateur"={
 *          "method"="post",
 *          "path"="/formateurs/{id}",
 *         "route_name"="editFormateur",
 *
 *     },
 *        "ARCHIVE_formateurs"={
 *          "method"="PUT",
 *          "path"="/formateurs/archivage"
 *
 *            },
 *      },
 *  normalizationContext={"groups"={"formateur:read"}},
 * )
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 */
class Formateur extends Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Assert\NotBlank( message="le Username est obligatoire" )
     * @Groups({"user:read"})
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
