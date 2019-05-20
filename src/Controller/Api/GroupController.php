<?php

/*
 * This file is part of Symfony4 Test Project 2019.
 *
 * @author Omar Makled <omar.makled@aqarmap.com>
 */

namespace App\Controller\Api;

use App\Service\GroupService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api/groups")
 */
class GroupController extends AbstractController
{
    /**
     * Get all groups.
     *
     * @Route(methods="GET", name="get_groups")
     *
     * @param \App\Service\GroupService $service
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(GroupService $service)
    {
        return new JsonResponse(['groups' => $service->getGroups()], Response::HTTP_OK);
    }

    /**
     * Add group.
     *
     * @Route(methods="POST", name="add_group")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Service\GroupService                 $service
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function store(Request $request, GroupService $service)
    {
        $result = $service->addGroup($request);

        if ($result->hasError()) {
            return new JsonResponse(['error' => $result->getError()],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return new JsonResponse([
                'message' => $result->success(),
                'group' => $service->getGroup(),
            ], Response::HTTP_CREATED
        );
    }

    /**
     * Delete group.
     *
     * @Route("/{group}", methods="DELETE", name="delete_group")
     *
     * @param \App\Entity\Group         $group
     * @param \App\Service\GroupService $service
     * 
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteGroup(Group $group, GroupService $service)
    {
        $result = $service->deleteGroup($group);

        return new JsonResponse(['message' => $result->success()],
            Response::HTTP_OK
        );
    }
}
