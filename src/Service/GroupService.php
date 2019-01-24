<?php

/*
 * This file is part of Symfony4 Test Project 2019.
 *
 * @author Omar Makled <omar.makled@aqarmap.com>
 */

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Exception\NotEmptyException;
use App\Entity\Group;
use App\Repository\GroupRepository;

class GroupService
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
     * GroupRepository instance.
     * 
     * @var \App\Repository\GroupRepository
     */
    private $repo;

    /**
     * Group instance.
     * 
     * @var \App\Entity\Group
     */
    private $group;

    /**
     * Constructor.
     *
     * @param \App\Service\ValidatorService        $validator
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param \App\Repository\GroupRepository      $repo
     */
    public function __construct(ValidatorService $validator, EntityManagerInterface $em, GroupRepository $repo)
    {
        $this->validator = $validator;
        $this->em = $em;
        $this->repo = $repo;
    }

    /**
     * Get groups.
     * 
     * @return []
     */
    public function getGroups()
    {
        return $this->serialize($this->repo->findAll());
    }

    /**
     * Add group.
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \App\Service\ValidatorService
     */
    public function addGroup(Request $request)
    {
        $group = new Group();
        $group->setName($request->request->get('name', ''));

        if (!$this->validator->isValid($group)) {
            return $this->validator;
        }

        $this->group = $group;
        $this->em->persist($group);
        $this->em->flush($group);

        return $this->validator;
    }

    /**
     * Delete group.
     * 
     * @param \App\Entity\Group $group
     * 
     * @return \App\Service\ValidatorService||App\Exception\NotEmptyException
     */
    public function deleteGroup(Group $group)
    {
        if ($group->getUsers()->count() >= 1) {
            throw new NotEmptyException();
        }

        $this->em->remove($group);
        $this->em->flush();

        return $this->validator;
    }

    /**
     * Get group.
     * 
     * @return []
     */
    public function getGroup()
    {
        return $this->serialize($this->group);
    }
}
