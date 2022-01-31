<?php

namespace App\Controller;

use App\Repository\InvitationRepository;
use App\Service\InvitationService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 * @Route("/api", name="api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/status", name="get_status", methods={"GET"})
     */
    public function status(): JsonResponse
    {
        return $this->json(['status' => 'OK']);
    }

    /**
     * @Route("/invitation", name="get_invitation", methods={"GET"})
     */
    public function getInvitations(InvitationService $invitationService): JsonResponse
    {
        return $this->json($invitationService->getUserInvitations($this->getUser()->getId()));
    }

    /**
     * @Route("/invitation", name="send_invitation", methods={"POST"})
     */
    public function sendInvitations(Request $request, InvitationService $invitationService): JsonResponse
    {
        return $this->json($invitationService->sendInvitation(json_decode($request->getContent(), true)));
    }

    /**
     * @Route("/invitation/{id}", name="delete_invitation", methods={"DELETE"})
     */
    public function deleteInvitations(InvitationService $invitationService, int $id): JsonResponse
    {
        return $this->json($invitationService->deleteInvitation($id, $this->getUser()->getId()));
    }

    /**
     * @param Request $request
     * @param InvitationService $invitationService
     * @param int $id
     * @return JsonResponse
     *
     * @Route("/invitation/{id}", name="update_status_invitation", methods={"POST"})
     */
    public function UpdateStatusInvitations(
        Request $request,
        InvitationService $invitationService,
        int $id
    ): JsonResponse
    {
        $status = json_decode($request->getContent(), true);
        
        return $this->json($invitationService->updateStatusInvitation($id, $status['status']));
    }

}
