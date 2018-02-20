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
    * @Route("/contact", name="contact")
    */
    public function showContactAction(Request $request)
    {
        return $this->render('default/contact.html.twig');
    }

        /**
    * @Route("/nos-services", name="services")
    */
    public function showServicesAction(Request $request)
    {
                $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('AppBundle:Service')->findAll();

        return $this->render('default/services.html.twig', array(
            'services' => $services,
        ));
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
          $em = $this->getDoctrine()->getManager();
          $temp = $em->getRepository('AppBundle:Patient')->findById($id);

        $patient = new Patient();
        $editForm = $this->createForm('AppBundle\Form\PatientType',$temp[0]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('welcome');
        }

        return $this->render('default/profil.html.twig', array(
            'utilisateur' => $patient,
            'edit_form' => $editForm->createView(),
        ));
        } else if($role == "ROLE_MEDECIN"){
          $em = $this->getDoctrine()->getManager();
          $temp = $em->getRepository('AppBundle:Medecin')->findById($id);
          $medecin = new Medecin();
        $editForm = $this->createForm('AppBundle\Form\MedecinType', $temp[0]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('welcome');
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
