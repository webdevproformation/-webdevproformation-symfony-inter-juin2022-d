<?php

namespace App\Entity;

use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30)]
    #[Assert\Length(min:2)]
    private $nom;

    /* #[Assert\AtLeastOneOf([
        new Assert\EqualTo('Admin'),
        new Assert\EqualTo('Redacteur')
    ])] */


    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\Choice(callback:"listRole" , message:"l'utilisateur doit être {{ choices }}")]
    private $role;


    #[ORM\OneToMany(targetEntity:Article::class , mappedBy:"auteur")]
    private $articles ; // met un s à la fin de la variable 
    // mappedBy variable au singulier

    public function listRole():array {
        return [ "admin" , "redacteur" ];
    }

    #[ORM\OneToOne(targetEntity:Image::class, inversedBy:"auteur" , cascade:["persist"] )]
    private $image;

    #[ORM\Column(type: 'boolean')]
    private $actif;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function isActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuteur($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAuteur() === $this) {
                $article->setAuteur(null);
            }
        }

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        // unset the owning side of the relation if necessary
        if ($image === null && $this->image !== null) {
            $this->image->setAuteur(null);
        }

        // set the owning side of the relation if necessary
        if ($image !== null && $image->getAuteur() !== $this) {
            $image->setAuteur($this);
        }

        $this->image = $image;

        return $this;
    }
}
