<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tasks;
use AppBundle\Entity\Projects;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use \DateTime;

/**
 * Task controller.
 *
 */
class TasksController extends Controller
{
    /**
     * Lists all task entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tasks = $em->getRepository('AppBundle:Tasks')->findAll();

        return $this->render('tasks/index.html.twig', array(
            'tasks' => $tasks,
        ));
    }

    /**
     * Creates a new task entity.
     *
     */
    public function newAction(int $id, Request $request)
    {


        $task = new Tasks();
        $em = $this->getDoctrine()->getManager();
        $project=$em->getRepository('AppBundle:Projects')->find($id);
        $task->setProject($project);
        $task->setCreationdate(new DateTime());

        $form = $this->createForm('AppBundle\Form\TasksType', $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            // $task->setProject(4);
            $em->persist($task);
            $em->flush();

            return $this->redirectToRoute('projects_show', array('id' => $id));
        }

        return $this->render('tasks/new.html.twig', array(
            'task' => $task,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a task entity.
     *
     */
    public function showAction(Tasks $task)
    {
        $deleteForm = $this->createDeleteForm($task);

        return $this->render('tasks/show.html.twig', array(
            'task' => $task,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing task entity.
     *
     */
    public function editAction(Request $request, Tasks $task)
    {
        $deleteForm = $this->createDeleteForm($task);
        $editForm = $this->createForm('AppBundle\Form\TasksType', $task);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('projects_show', array('id' => $task->getProject()->getId()));
        }

        return $this->render('tasks/edit.html.twig', array(
            'task' => $task,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a task entity.
     *
     */
    public function deleteAction(Request $request, Tasks $task)
    {
        $form = $this->createDeleteForm($task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();
        }

        return $this->redirectToRoute('projects_show', array('id' => $task->getProject()->getId()));
    }

    /**
     * Creates a form to delete a task entity.
     *
     * @param Tasks $task The task entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tasks $task)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tasks_delete', array('id' => $task->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
