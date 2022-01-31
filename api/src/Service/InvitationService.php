<?php

namespace App\Service;

use App\Entity\Invitation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class InvitationService
{
    private EntityManagerInterface $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getUserInvitations(int $userId)
    {
        return $this->em->getRepository(Invitation::class)->getUserInvitations($userId);
    }

    /**
     * @param array $data
     * @return array
     */
    public function sendInvitation(array $data)
    {
        try{
            $invitation = new Invitation();
            $invitation->setComment($data['comment'])
                ->setSender($this->em->getRepository(User::class)->find($data['sender']))
                ->setGuest($this->em->getRepository(User::class)->find($data['guest']));

            $this->em->persist($invitation);
            $this->em->flush();

            return ['code' => Response::HTTP_CREATED, 'message' => 'Invitation sent'];
        } catch (\Exception $exception) {
            return ['code' => $exception->getCode(), 'message' => $exception->getMessage()];
        }
    }

    /**
     * @param int $invitationId
     * @param int $userId
     * @return array|string[]
     */
    public function deleteInvitation(int $invitationId, int $userId)
    {
        $invitation = $this->em->getRepository(Invitation::class)->find($invitationId);

        if ($invitation->getSender()->getId() != $userId) {
            return ['message' => 'can not remove invitation'];
        }

        try {
            $this->em->remove($invitation);
            $this->em->flush();

            return ['message' => 'invitation removed'];
        } catch (\Exception $exception) {
            return ['code' => $exception->getCode(), 'message' => $exception->getMessage()];

        }
    }

    /**
     * @param int $invitationId
     * @param string $status
     * @return array|string[]
     */
    public function updateStatusInvitation(int $invitationId, string $status)
    {
        try {
            $invitation = $this->em->getRepository(Invitation::class)->find($invitationId);
            $invitation->setStatus($status);
            $this->em->persist($invitation);
            $this->em->flush();

            return ['message' => 'invitation updated'];
        } catch (\Exception $exception) {
            return ['code' => $exception->getCode(), 'message' => $exception->getMessage()];
        }
    }
}