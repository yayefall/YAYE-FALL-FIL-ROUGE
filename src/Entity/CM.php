<?php

namespace App\Entity;

use App\Repository\CMRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

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
 *                 "ADD_cms"={
 *                        "method"="POST",
 *                        "path"="/formateurs",
 *                         "route_name"="addCm",
 *
 *
 *                        },
 *            },
 *     itemOperations={"put","get",
 *        "ARCHIVE_Cms"={
 *          "method"="PUT",
 *          "path"="/cms/archivage"
 *
 *            },
 *      },
 * )
 * @ORM\Entity(repositoryClass=CMRepository::class)
 */
class CM extends Users
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
