<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 10)]
    #[Assert\Length(min:2)]
    private $libelle;

    #[ORM\Column(type: 'date')]
    #[Assert\Type("date")]
    private $dt_creation;

    // UNE Catégorie peut être associée à PLUSIEURS articles
    // UN article ne peut avoir UNE SEULE CATEGORIE
    #[ORM\OneToMany(targetEntity:Article::class, mappedBy:"categorie")]
    private $articles ; 

    // astuce attribuer une valeur par défaut 
    public function __construct()
    {
        $this->setDtCreation(new \DateTime()); 
        // plus besoin d'ajouter dans les formulaires le champ pour la date de création 
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle():  ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $article->setCategorie($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategorie() === $this) {
                $article->setCategorie(null);
            }
        }

        return $this;
    }
}
