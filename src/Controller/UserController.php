<?php

namespace App\Controller;


use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Swift_Attachment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class UserController extends AbstractController
{
    /**
     * @Route("/api/login_check", name="api/login_check")
     */
    public function loginAction()
    {
        return $this->render('user/login.html.twig');
    }

    /**

     * @Route("/api/register")

     * @param Request $request

     */

    public function create(Request $request, UserPasswordEncoderInterface $encoder)

    {

       $user = new User();   
       $data = json_decode($request->getContent(), true);
       $hash = $encoder->encodePassword($user, $data['password']);
       $user->setPassword($hash);
       $user->setNom($data['nom']);
       $user->setPrenom($data['prenom']);
       $user->setEmail($data['email']);
       $rol[] = $data['roles'];
       $user->setRoles($rol);
       if($data['typecontrat'] == "false"){
        $user->setTypeContrat($data['typecontrat']=0);
       }
       //dd($data['typecontrat']) ;
       $user->setTypeContrat($data['typecontrat']);
       $em = $this->getDoctrine()->getManager();
       $em->persist($user);
       $em->flush();

        return new JsonResponse($data);


    }

    /**
     * @Route("/dashboard")
     */
    public function dashboard(UserRepository $user)
    {
        $users = $user->findAll();
        foreach ($users as $key => $user) {
            $data[$key]['username'] = $user->getUsername();
            $data[$key]['password'] = $user->getPassword();
            $data[$key]['nom'] = $user->getNom();
            $data[$key]['prenom'] = $user->getPrenom();
            $data[$key]['id'] = $user->getId();
        }
        return new JsonResponse($data);
    }

 

    /**
     * @Route("/delete/{id}", name="delete_user")
     */
    public function deleteUser($id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($user);
        $entityManager->flush();

        return new JsonResponse($user);
    }

    
      /**
     * @Route("/user/{id}")
     */
    public function findUs( $id)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $data[0]['username'] = $user->getUsername();
        $data[0]['password'] = $user->getPassword();
        $data[0]['nom'] = $user->getNom();
        $data[0]['prenom'] = $user->getPrenom();
        $data[0]['id'] = $user->getId();
        $data[0]['email'] = $user->getEmail();

        return new JsonResponse($data);
    }

    /**
     * @Route("/api/getUserData")
     */
    public function getUserData(Request $request)
    {
        
       
        $data = ($request->getContent());
        
            $userdata = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(array('email' => $data));          
            $result[0]['nom'] = $userdata[0]->getNom();
            $result[0]['prenom'] = $userdata[0]->getPrenom();            
            $result[0]['id'] = $userdata[0]->getId();
            $result[0]['email'] = $userdata[0]->getEmail();
            $role = $userdata[0]->getRoles();
            $result[0]['roles']= $role[0];
            $result[0]['username'] =  $result[0]['prenom'].' '.$result[0]['nom'];
            return new JsonResponse($result);
    }

    

}