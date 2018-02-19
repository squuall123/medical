<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Patient;
use AppBundle\Entity\Medecin;
use AppBundle\Entity\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
    * @Route("/", name="welcome")
    */
    public function showAction(Request $request)
    {
        return $this->render('default/index.html.twig'); 
    }

        /**
    * @Route("/nos-services", name="services")
    */
    public function showServicesAction(Request $request)
    {
        return $this->render('default/services.html.twig'); 
    }

    /**
     * Displays a form to edit an existing utilisateur entity.
     *
     * @Route("/profil/{role}/{id}", name="utilisateur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
      $role =  $request->get('role');
      $id = $request->get('id');
        if ($role == "ROLE_PATIENT") {
        $patient = new Patient();
        $editForm = $this->createForm('AppBundle\Form\PatientType');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateur_edit', array('id' => $patient->getId()));
        }

        return $this->render('default/profil.html.twig', array(
            'utilisateur' => $patient,
            'edit_form' => $editForm->createView(),
        ));
        } else if($role == "ROLE_MEDECIN"){
        $editForm = $this->createForm('AppBundle\Form\MedecinType');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('utilisateur_edit', array('id' => $medecin->getId()));
        }

        return $this->render('default/profil.html.twig', array(
            'utilisateur' => $medecin,
            'edit_form' => $editForm->createView(),
        ));
      }
      else if($role == "ROLE_ADMIN"){
        //$admin = new Admin();
        $em = $this->getDoctrine()->getManager();
        $temp = $em->getRepository('AppBundle:Admin')->findById($id);
        $admin = new Admin();
        $editForm = $this->createForm('AppBundle\Form\AdminType', $temp[0]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('welcome');
        }

        return $this->render('default/profil.html.twig', array(
            'utilisateur' => $admin,
            'edit_form' => $editForm->createView(),
        ));
        }

    }

}
