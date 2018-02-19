<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Entity\Patient;
use AppBundle\Entity\Medecin;
use AppBundle\Form\PatientType;
use AppBundle\Form\MedecinType;
use AppBundle\Entity\Admin;
use AppBundle\Form\AdminType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @Route("/registerMedecin", name="registerMedecin")
     */
    public function registerMedecinAction(Request $request)
    {
        // Create a new blank user and process the form
        $user = new Medecin();
        $form = $this->createForm(MedecinType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Set their role
            $user->setRole('ROLE_MEDECIN');
            $user->setEtat(false);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/registerPatient", name="registerPatient")
     */
    public function registerPatientAction(Request $request)
    {
        // Create a new blank user and process the form
        $user = new Patient();
        $form = $this->createForm(PatientType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Set their role
            $user->setRole('ROLE_PATIENT');

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/registerAdmin", name="registerAdmin")
     */
    public function registerAdminAction(Request $request)
    {
        // Create a new blank user and process the form
        $user = new Admin();
        $form = $this->createForm(AdminType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // Set their role
            $user->setRole('ROLE_ADMIN');
            

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('auth/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
