<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FreeDays;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Freeday controller.
 *
 * @Route("freedays")
 */
class FreeDaysController extends Controller
{
    /**
     * Lists all freeDay entities.
     *
     * @Route("/", name="freedays_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $freeDays = $em->getRepository('AppBundle:FreeDays')->findAll();

        return $this->render('freedays/index.html.twig', array(
            'freeDays' => $freeDays,
        ));
    }

    /**
     * Creates a new freeDay entity.
     *
     * @Route("/new", name="freedays_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $freeDays = new Freedays();
        $freeDays->setMedecinId($this->getUser()->getId());
        $form = $this->createForm('AppBundle\Form\FreeDaysType', $freeDays);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($freeDays);
            $em->flush();
            $this->addFlash("freedayAdded", "Added Free Day Successfully");
            return $this->redirectToRoute('utilisateur_edit', array('id' => $this->getUser()->getId(), 'role' => $this->getUser()->getRole()));

        }

        return $this->render('freedays/new.html.twig', array(
            'freeDays' => $freeDays,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a freeDay entity.
     *
     * @Route("/{id}", name="freedays_show")
     * @Method("GET")
     */
    public function showAction(FreeDays $freeDays)
    {
        $deleteForm = $this->createDeleteForm($freeDays);

        return $this->render('freedays/show.html.twig', array(
            'freeDay' => $freeDays,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing freeDay entity.
     *
     * @Route("/{id}/edit", name="freedays_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, FreeDays $freeDays)
    {
        $deleteForm = $this->createDeleteForm($freeDays);
        $editForm = $this->createForm('AppBundle\Form\FreeDaysType', $freeDays);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('freedays_edit', array('id' => $freeDay->getId()));
        }

        return $this->render('freedays/edit.html.twig', array(
            'freeDay' => $freeDays,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a freeDay entity.
     *
     * @Route("/{id}", name="freedays_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, FreeDays $freeDays)
    {
        $form = $this->createDeleteForm($freeDays);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($freeDays);
            $em->flush();
        }

        return $this->redirectToRoute('freedays_index');
    }

    /**
     * Creates a form to delete a freeDay entity.
     *
     * @param FreeDays $freeDay The freeDay entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(FreeDays $freeDays)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('freedays_delete', array('id' => $freeDays->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
