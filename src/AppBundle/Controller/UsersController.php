<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Users;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use AppBundle\Form\UserType;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

use AppBundle\Form\LoginType;

use \Swift_Mailer;
use \Swift_Message;
use Doctrine\ORM\EntityManagerInterface;


/**
 * User controller.
 *
 */
class UsersController extends Controller
{
    /**
     * Lists all user entities.
     *
     */
    public function indexAction()
    {
      $em = $this->getDoctrine()->getManager();


      $users = $em->getRepository('AppBundle:Users')->findAll();


        return $this->render('users/index.html.twig',array(
            'users' => $users,
        ));
    }

    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
 	{
	 	 // get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();

	  	// instancier le formulaire
	    $form = $this->createForm(LoginType::class);

	    // last username entered by the user - permet aussi de hasher MDP (voir déclaration fonction plus haut)
	    $lastUsername = $authenticationUtils->getLastUsername();





	 	// renvoie à la view login avec variable pour afficher erreurs et lastUsername
		return $this->render('default/login.html.twig', [
	    	'form' 			=> $form->createView(), // envoyer formulaire à la view
	    	'last_username' => $lastUsername, // récupère infos user
	        'error'         => $error // récupère login error s'il y en a une
	        ]);
	}
  public function logoutAction(Request $request)
    {

    }

    /**
     * Creates a new user entity.
     *
     */
    public function newAction(UserPasswordEncoderInterface $encoder,Request $request,Swift_Mailer $mailer)
    {
        $user = new Users();
        $form = $this->createForm('AppBundle\Form\UsersType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user , $user->getPassword() );
            $user->setPassword($hash);
            $user->setIsActive(false);
            $token = bin2hex(random_bytes(32));
            $user->setToken($token);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $message = (new Swift_Message('Validation'))
          		->setFrom('contact@website.com')
          		->setTo($user->getEmail())
          		// ->setBody('<h1> Confirmation </h1><p> coucou </p>', 'text/html'); // pour créer contenu du mail - HTML : on doit mettre du HTML en string. on passe en deuxième paramètre le type du contenu, ici text/html
          		// // OU pour mettre dedans une view twig dans laquelle on a créé la vue du mail que l'on veut
          		->setBody(
              		$this->renderView(
                          // view à mettre dans app/Resources/views/email/confirm.html.twig
                          'email/confirm.html.twig',
                          ['user' => $user] // récupère les données user pour pouvoir afficher dans le mail
                      ),'text/html' // type du contenu, ici text/html
              );

          	// envoie le message (utiliser $mailer en nom car on lui passe en parmètre)
              $mailer->send($message);

            return $this->redirectToRoute('users_show', array('id' => $user->getId()));
        }

        return $this->render('users/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }
    // retour du mail de confirmation
    public function validateAction($token, Swift_Mailer $mailer)
    {
        // récupère infos user en fonction token du user pour lien dans le mail
            // findOneByToken pour ne sortir qu'un résultat : celui dont le champs "token" a la même valeur que $token, si on avait mis findByToken aurait sorti un tableau, pas pratique à exploiter
        $user = $this->getDoctrine()->getRepository(Users::class)->findOneByToken($token);

        if($user) { // si on a un user : si variable a une valeur (équivalent de $user == true)

            // passe champs is_active en true pour autoriser accès aux pages du site
            $user->setIsActive(true);

            // vide le contenu du champs token
            $user->setToken(NULL);

            // entityManager est ce qui va permettre insertion, par une classe déjà existante dans Doctrine
            $entityManager = $this->getDoctrine()->getManager();

            // prepare l'insertion
            $entityManager->persist($user);

            // execute toutes les requetes set du dessus
            $entityManager->flush();

            // création du mail de confirmation d'inscription
            $message = (new Swift_Message('Compte validé')) // Objet du mail
                ->setFrom('contact@website.com') // expediteur, si dans mailtrap on peut mettre nawak
                ->setTo($user->getEmail()) // destinataire, récup depuis fonction getMail
                ->setBody( // pour créer contenu du mail - mettre dedans view twig dans laquelle on a créé la vue du mail que l'on veu
                    $this->renderView(
                        // view à mettre dans app/Resources/views/email/validate.html.twig
                        'email/validate.html.twig',
                        ['user' => $user] // récupère les données user pour pouvoir afficher dans le mail
                        ), 'text/html' // type du contenu, ici text/html
                    );

            // envoie le message (utiliser $mailer en nom car on lui passe en parmètre)
            $mailer->send($message);

            // envoie à la vue home une fois inscription terminée
            return $this->redirectToRoute('login');
        } else {
            // envoie à la vue home si $user a une valeur nulle (équivalent de $user == false)
            return $this->redirectToRoute('home');
        }
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction(Users $user,Request $request)
    {
        $deleteForm = $this->createDeleteForm($user);



        return $this->render('users/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAction(UserPasswordEncoderInterface $encoder,Request $request, Users $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UsersType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
          $hash = $encoder->encodePassword($user , $user->getPassword() );
          $user->setPassword($hash);
          $this->getDoctrine()->getManager()->flush();

          return $this->redirectToRoute('users_edit', array('id' => $user->getId()));
        }

        return $this->render('users/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     */
    public function deleteAction(Request $request, Users $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('users_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param Users $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Users $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('users_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
