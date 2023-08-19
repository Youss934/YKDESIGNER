<?php

namespace App\Controller;

use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use DateTime;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/mot-de-passe-oublié', name: 'reset_password')]
    public function index(Request $request): Response
    {
        if($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        if($request->get('email')) {
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            if($user) {
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatedAt(new DateTime());
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                $url = $this->generateUrl('update_password', ['token' => $reset_password->getToken()]);

                $content = "Bonjour " . $user->getFirstName() . "<br/>Vous avez essayé de réinitialiser votre mot de passe sur le site YK.DESIGN.<br/><br/>";
                $content .= "Merci de cliquer sur le lien pour <a href='" . $url . "'>mettre à jour votre mot de passe</a>.";
                $mail = new mail();
                $mail->send($user->getEmail(),$user->getFirstname().' '.$user->getLastname(),'reinitialisez votre mot de passe sur YK.DESIGN',$content);
                $this->addFlash('notice', 'vous allez recevoir un mail de confirmation');
            } else {
                $this->addFlash('notice', 'Addresse e-mail inconnu');
            }
        }
        return $this->render('reset_password/index.html.twig');
    }

    #[Route('/modifier-mon-mot-de-passe', name: 'update_password')]
    public function update(Request $request, $token,UserPasswordHasherInterface $encoder) {

        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);
        if(!$reset_password) {
            return $this->redirectToRoute('reset_password');
        }
        $now = new DateTime();
        if($now> $reset_password->getCreatedAt()->modify('+ 3 hour')) {
            $this->addFlash('notice','Votre demande de mot de passe a expiré. Merci de la renouvellé');
            return $this->redirectToRoute('reset_password');
        }
         
        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
           $new_Pwd = $form->get('new_password')->getData();
           $password = $encoder->hashPassword($reset_password->getUser(), $new_Pwd);
           $reset_password->getUser()->setPassword($password);
        //    $this->entityManager->persist($user);
           $this->entityManager->flush();
           $this->addFlash('notice','Votre mot de passe a bien été mis à jour.');
           return $this->redirectToRoute('app_login');
        }

        return $this->render('reset_password/update.html.twig', [
        'form' => $form->createView()

        ]);

    }
}
