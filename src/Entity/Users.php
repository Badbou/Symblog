<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */

class Users implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 3,
     *  minMessage = "le champ doit avoir au moins  {{ limit }} characters de long "
     * )
     */
    private $name;

    // le assert permet de lilité le nombre de caractere a 3
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min = 3,
     *  minMessage = "le champ doit avoir au moins  {{ limit }} characters de long "
     * ) 
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateLastLogin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->dateCreate;
    }

    public function setDateCreate(\DateTimeInterface $dateCreate): self
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    public function getDateLastLogin(): ?\DateTimeInterface
    {
        return $this->dateLastLogin;
    }

    public function setDateLastLogin(\DateTimeInterface $dateLastLogin): self
    {
        $this->dateLastLogin = $dateLastLogin;

        return $this;
    }

    public function getRoles()
    {
     
    }



    public function getSalt()
    {
     
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials() 
    {
        
    }


    
}
