<?php
namespace FEL\AdminBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class MeteorUserProvider implements UserProviderInterface
{
    public function loadUserByUsername($username)
    {
        $userData = false;

        if ($userData) {
            return new MeteorUser($username, "", "", array("ROLE_USER"));
        }

        throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof MeteorUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        //Dump user info
        dump($user);

        return $user;
    }

    public function supportsClass($class)
    {
        return $class === 'FEL\AdminBundle\Security\User\MeteorUser';
    }
}