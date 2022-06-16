<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Symfony\Component\Validator\Constraints as Assert ;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    public const CATEGORIES = ['PHP', 'JS', 'HTML'];
    
    #[ORM\Column(type: 'string', length: 200)]
    #[Assert\Choice(callback:"getCategories" , message : "il faut saisir : {{ choices }}")]
    private $nom;

    public static function getCategories() {
        return ['PHP', 'JS', 'HTML'];
    }

    #[ORM\Column(type: 'integer')]
    //#[Assert\PositiveOrZero]
    #[Assert\GreaterThan(0)]
    #[Assert\LessThan(100)]
    private $age;

    #[ORM\Column(type: 'string', length: 200)]
    #[Assert\Length( min:4,max:4, exactMessage:"ce champ doit contenir exactement {{ limit }} caractères, {{ value }} ne correspond pas")]
    private $adresse;

    #[ORM\Column(type: 'boolean')]
    private $etat;

    #[ORM\Column(type: 'string', length: 200)]
    #[Assert\Regex(pattern:"/^[0-9]+$/")]
    private $telephone;

    #[ORM\Column(type: 'string', length: 200)]
    #[Assert\Email]
    private $email;

    public function removeSpace($text){
        return trim($text);
    }

    #[ORM\Column(type: 'date')]
    #[Assert\Type(type:"datetime")] // Attention 
    private $date_naissance; // "2022-06-15"

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

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
