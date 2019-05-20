<?php

/*
 * This file is part of Symfony4 Test Project 2019.
 *
 * @author Omar Makled <omar.makled@aqarmap.com>
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Group;
use App\Repository\UserRepository;

class UserService
{
    use SerializerTrait;

    /**
     * ValidatorService instance.
     * 
     * @var \App\Service\ValidatorService
     */
    private $validator;

    /**
     * EntitnyManager instance.
     * 
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    private $em;

    /**
     * UserRepository instance.
     * 
     * @var \App\Repository\UserRepository
     */
    private $repo;

    /**
     * User instance.
     * 
     * @var \App\Entity\User
     */
    private $user;

    /**
     * UserService constructor.
     * @param ValidatorService $validator
     * @param EntityManagerInterface $em
     * @param UserRepository $repo
     */
    public function __construct(ValidatorService $validator, EntityManagerInterface $em, UserRepository $repo)
    {
        $this->validator = $validator;
        $this->em = $em;
        $this->repo = $repo;
    }

    /**
     * Get users.
     * 
     * @return []
     */
    public function getUsers()
    {
        return $this->serialize($this->repo->findAll());
    }

    /**
     * Add user.
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \App\Service\ValidatorService
     */
    public function add(Request $request)
    {
        $user = new User();
        $user->setName($request->request->get('name', ''));

        if (!$this->validator->isValid($user)) {
            return $this->validator;
        }

        $this->user = $user;
        $this->em->persist($user);
        $this->em->flush();

        return $this->validator;
    }

    /**
     * Get user.
     * 
     * @return []
     */
    public function getUser()
    {
        return $this->serialize($this->user);
    }

    /**
     * Delete user.
     *
     * @param \App\Entity\User $user
     *
     * @return \App\Service\ValidatorService
     */
    public function delete(User $user)
    {
        $this->em->remove($user);
        $this->em->flush();

        return $this->validator;
    }

    /**
     * Attach group to user.
     * 
     * @param \App\Entity\User  $user
     * @param \App\Entity\Group $group
     * 
     * @return \App\Service\ValidatorService
     */
    public function attachGroup(User $user, Group $group)
    {
        $user->addGroup($group);
        $this->em->persist($user);
        $this->em->flush();

        return $this->validator;
    }

    /**
     * Detach group from user.
     * 
     * @param \App\Entity\User  $user
     * @param \App\Entity\Group $group
     * 
     * @return \App\Service\ValidatorService
     */
    public function detachGroup(User $user, Group $group)
    {
        $user->removeGroup($group);
        $this->em->persist($user);
        $this->em->flush();

        return $this->validator;
    }
}
