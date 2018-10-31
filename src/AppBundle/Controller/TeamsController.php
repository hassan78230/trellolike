<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Teams;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\TeamsType;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\PhpBridgeSessionStorage;

/**
 * Team controller.
 *
 */
class TeamsController extends Controller
{
    /**
     * Lists all team entities.
     *
     */
    public function indexAction(Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $teams = $em->getRepository('AppBundle:Teams')->findAll();
        


        return $this->render('teams/index.html.twig', array(
            'teams' => $teams,
        ));
    }

    /**
     * Creates a new team entity.
     *
     */
    public function newAction(Request $request)
    {
        $team = new Teams();
        $form = $this->createForm(TeamsType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($team);
            $em->flush();
//             echo '<pre>';
// \Doctrine\Common\Util\Debug::dump($form);
// echo '</pre>';


            return $this->redirectToRoute('teams_show', array('id' => $team->getId()));
        }

        return $this->render('teams/new.html.twig', array(
            'team' => $team,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a team entity.
     *
     */
    public function showAction(Teams $team)
    {
        $deleteForm = $this->createDeleteForm($team);
//         echo '<pre>';
// \Doctrine\Common\Util\Debug::dump($team);
// echo '</pre>';
        return $this->render('teams/show.html.twig', array(
            'users' => $team->getUsers(),
            'team' => $team,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing team entity.
     *
     */
    public function editAction(Request $request, Teams $team)
    {
        $deleteForm = $this->createDeleteForm($team);
        $editForm = $this->createForm('AppBundle\Form\TeamsType', $team);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('teams_edit', array('id' => $team->getId()));
        }

        return $this->render('teams/edit.html.twig', array(
            'team' => $team,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a team entity.
     *
     */
    public function deleteAction(Request $request, Teams $team)
    {
        $form = $this->createDeleteForm($team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($team);
            $em->flush();
        }

        return $this->redirectToRoute('teams_index');
    }

    /**
     * Creates a form to delete a team entity.
     *
     * @param Teams $team The team entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Teams $team)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teams_delete', array('id' => $team->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
