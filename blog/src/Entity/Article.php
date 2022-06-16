<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;
// https://symfony.com/doc/current/validation.html
// vérification au niveau du formulaire 
// vérifier au moment de l'insertion 


#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200 , nullable:true)]
    #[Assert\Length(
            min:2, 
            max:200 , 
            minMessage : "le titre doit contenir au minimum {{ limit }} lettres",
            maxMessage : "le titre doit contenu au mximum {{ limit }} lettres"
            )]
    private $titre;
    
    /**
     * @var string
     */
    #[ORM\Column(type: 'text')]
    #[Assert\Length(
        min:2 ,
        max:2000 ,
        minMessage:"le champ contenu doit contenir {{ limit }} lettres, vous avez saisi {{ value }} caractères",
        maxMessage:"le champ contenu doit contenir {{ limit }} lettres, vous avez saisi {{ value }} caractères",
        //normalizer:fn($contenu) => trim($contenu),
    )]
    private $contenu;

    #[ORM\Column(type: 'boolean')]
    private $publie;

    #[ORM\Column(type: 'datetime')]
    private $dt_creation;

    public function trim(string $contenu) : string{
        return trim($contenu) ; // permet d'enlever les espaces en début et fin d'une string
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function isPublie(): ?bool
    {
        return $this->publie;
    }

    public function setPublie(bool $publie): self
    {
        $this->publie = $publie;

        return $this;
    }

    public function getDtCreation(): ?\DateTimeInterface
    {
        return $this->dt_creation;
    }

    public function setDtCreation(\DateTimeInterface $dt_creation): self
    {
        $this->dt_creation = $dt_creation;

        return $this;
    }
}
