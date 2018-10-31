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
    public function newAction(UserPasswordEncoderInterface $encoder,Request $request)
    {
        $user = new Users();
        $form = $this->createForm('AppBundle\Form\UsersType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user , $user->getPassword() );
            $user->setPassword($hash);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users_show', array('id' => $user->getId()));
        }

        return $this->render('users/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
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
