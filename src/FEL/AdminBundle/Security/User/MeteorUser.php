<?php
namespace FEL\AdminBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;

class MeteorUser implements UserInterface
{
    private $username;
    private $password;
    private $salt;
    private $roles;
    private $userid;
    private $meteortoken;

    public function __construct($username, $password, $salt, array $roles, $userid, $meteortoken)
    {
        $this->username = $username;
        $this->password = $password;
        $this->salt = $salt;
        $this->roles = $roles;
        $this->userid = $userid;
        $this->meteortoken = $meteortoken;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return $this->salt;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getUserid()
    {
        return $this->userid;
    }

    public function getMeteortoken()
    {
        return $this->meteortoken;
    }

    public function eraseCredentials()
    {
    }

    public function equals(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}