<?php

/*
 * This file is part of Symfony4 Test Project 2019.
 *
 * @author Omar Makled <omar.makled@aqarmap.com>
 */

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\UserService;
use App\Entity\User;
use App\Entity\Group;

/**
 * @Route("/api/users")
 */
class UserController extends AbstractController
{
    /**
     * Get all users.
     *
     * @Route(methods="GET", name="get_users")
     *
     * @param \App\Service\UserService $service
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUsers(UserService $service)
    {
        return new JsonResponse(['users' => $service->getUsers()], Response::HTTP_OK);
    }

    /**
     * Add user.
     *
     * @Route(methods="POST", name="add_user")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \App\Service\UserService                  $service
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addUser(Request $request, UserService $service)
    {
        $result = $service->addUser($request);

        if ($result->hasError()) {
            return new JsonResponse(['error' => $result->getError()],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        return new JsonResponse([
            'message' => $result->success(),
            'user' => $service->getUser(),
        ], Response::HTTP_CREATED
        );
    }

    /**
     * Delete user.
     *
     * @Route("/{user}", methods="DELETE", name="delete_user")
     *
     * @param \App\Entity\User         $user
     * @param \App\Service\UserService $service
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteUser(User $user, UserService $service)
    {
        $result = $service->deleteUser($user);

        return new JsonResponse([
            'message' => $result->success(),
        ], Response::HTTP_OK);
    }

    /**
     * Attach group to user.
     *
     * @Route("/{user}/groups/{group}", methods="POST", name="attach_group")
     *
     * @param \App\Entity\User         $user
     * @param \App\Entity\Group        $group
     * @param \App\Service\UserService $service
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function attachGroup(User $user, Group $group, UserService $service)
    {
        $result = $service->attachGroup($user, $group);

        return new JsonResponse([
            'message' => $result->success(),
        ], Response::HTTP_CREATED);
    }

    /**
     * Attach group to user.
     *
     * @Route("/{user}/groups/{group}", methods="DELETE", name="detach_group")
     *
     * @param \App\Entity\User         $user
     * @param \App\Entity\Group        $group
     * @param \App\Service\UserService $service
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function detachGroup(User $user, Group $group, UserService $service)
    {
        $result = $service->detachGroup($user, $group);

        return new JsonResponse([
            'message' => $result->success(),
        ], Response::HTTP_OK);
    }
}
