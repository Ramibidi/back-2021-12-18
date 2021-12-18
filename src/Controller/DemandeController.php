<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use DateTimeInterface;
use App\Entity\Demande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeController extends AbstractController
{

    /**
     * @Route("/api/adddemande" ,methods={"POST"})
     */

    public function adddemande(Request $request)
    {
        $user = $this->getUser();
        //dd($user);
        $serializer = $this->get('serializer');
        $data = json_decode($request->getContent(), true);
        $user = $this->getDoctrine()->getRepository(User::class)->find($data['user']);
        $demande = $serializer->deserialize($request->getContent(), Demande::class, 'json');
        $demande->setUser($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($demande);
        $em->flush();
        return $this->json('ok');
    }


    /**
     * @Route("/api/affichedemande/{id}" , name="affichedemande")
     */
    public function affichedemande($id)
    {

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $demande = $this->getDoctrine()
            ->getRepository(Demande::class)
            ->findBy(array('user' => $user));
        // dd($demande);

        // $demande = $this->getDoctrine()
        //     ->getRepository(Demande::class)
        //     ->findAll();
        // dd($demande[0]);

        foreach ($demande  as $key => $user) {
            $data[$key]['id'] = $user->getId();
            $data[$key]['iduser'] = $user->getUser()->getId();
            $data[$key]['raison'] = $user->getRaison();
            $data[$key]['dateDebut'] = $user->getDateDebut();
            $data[$key]['dateFin'] = $user->getDateFin();
            $data[$key]['adresse'] = $user->getAdresse();
            
        }
        return new JsonResponse($data);
    }
}
