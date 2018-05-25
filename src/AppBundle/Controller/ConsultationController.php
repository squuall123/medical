<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Consultation;
use AppBundle\Entity\DisabledDate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


/**
 * Consultation controller.
 *
 * @Route("consultation")
 */
class ConsultationController extends Controller
{
    /**
     * Lists all consultation entities.
     *
     * @Route("/", name="consultation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $consultations = $em->getRepository('AppBundle:Consultation')->findAll();

        return $this->render('consultation/index.html.twig', array(
            'consultations' => $consultations,
        ));
    }

    /**
     * Lists all consultation entities.
     * @Route("/validate/{id}", name="consultation_validate")
     * @Method("GET")
     */
    public function validateAction(Request $request)
    {
      $id = $request->get('id');
      $em = $this->getDoctrine()->getManager();
      $consultation = $em->getRepository('AppBundle:Consultation')->findOneById($id);
      $consultation->setEtat(true);
      $info = $consultation->getIdPatient();
      $user = $em->getRepository("AppBundle:Patient")->findOneById($info);
      $name = $consultation->getNomPatient();
      $mail = $user->getEmail();
      $doctor = $consultation->getNomMedecin();
      $date = $consultation->getDateRDV();
      $time = $consultation->getTimeRDV();
      $merge = new \DateTime($date->format('Y-m-d').' ' .$time->format('H:i'));
      $result = $merge->format('Y-m-d H:i');
      $em->persist($consultation);
      $em->flush();
      //return var_dump($consultation);
      //$deleteForm = $this->createDeleteForm($consultation);

      //send mail
      $message = \Swift_Message::newInstance()
        ->setSubject('Validate Email')
        ->setFrom('medicalcenterpfa@gmail.com')
        ->setTo($mail)
        ->setBody(
            $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/validate.html.twig',
                array('name' => $name, 'doctor' => $doctor, 'date' => $result)
            ),
            'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
    ;
    $this->get('mailer')->send($message);

      return $this->redirectToRoute('utilisateur_edit', array('id' => $this->getUser()->getId(), 'role' => $this->getUser()->getRole()));
    }

    /**
     * Lists all consultation entities.
     * @Route("/refuse/{id}", name="consultation_refuse")
     * @Method("GET")
     */
    public function refuseAction(Request $request)
    {
      $id = $request->get('id');
      $em = $this->getDoctrine()->getManager();
      $consultation = $em->getRepository('AppBundle:Consultation')->findOneById($id);
      $info = $consultation->getIdPatient();
      $user = $em->getRepository("AppBundle:Patient")->findOneById($info);
      $name = $consultation->getNomPatient();
      $mail = $user->getEmail();
      $doctor = $consultation->getNomMedecin();
      $date = $consultation->getDateRDV();
      $time = $consultation->getTimeRDV();
      $merge = new \DateTime($date->format('Y-m-d').' ' .$time->format('H:i'));
      $result = $merge->format('Y-m-d H:i');
      $em->remove($consultation);
      $em->flush();
      //return var_dump($consultation);
      //$deleteForm = $this->createDeleteForm($consultation);

      //send email

      //send mail
      $message = \Swift_Message::newInstance()
        ->setSubject('Validate Email')
        ->setFrom('medicalcenterpfa@gmail.com')
        ->setTo($mail)
        ->setBody(
            $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/refuse.html.twig',
                array('name' => $name, 'doctor' => $doctor, 'date' => $result)
            ),
            'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
    ;
    $this->get('mailer')->send($message);

      return $this->redirectToRoute('utilisateur_edit', array('id' => $this->getUser()->getId(), 'role' => $this->getUser()->getRole()));
    }

    /**
     * Creates a new consultation entity.
     *
     * @Route("/new/{medecinid}/{patientid}", name="consultation_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        //TODO fixing other roles !!


        if ($this->getUser()->getRole() == "ROLE_ADMIN")  {
          # ADMIN

          $idPatient = $this->getUser()->getId();
          $idMedecin = $request->get('medecinid');
            $em = $this->getDoctrine()->getManager();
            $medecin = $em->getRepository('AppBundle:Medecin')->findOneById($idMedecin);
            $patient = $em->getRepository('AppBundle:Admin')->findOneById($idPatient);
              //var_dump($medecin[0]);
              //var_dump($medecin);;
            $consultation = new Consultation();
            $consultation->setIdPatient($idPatient);
            $consultation->setIdMedecin($idMedecin);
            $consultation->setNomPatient($patient->getName());
            $consultation->setNomMedecin($medecin->getName());
            $date = new \DateTime("now");
            $consultation->setDateCreation($date);
            $consultation->setEtat(false);


              //fetching consultations
            $freeDays = $em->getRepository('AppBundle:FreeDays')->findByMedecinId($idMedecin);

              //disabling doctor's free dates

              $datesToDisable = array();
              foreach ($freeDays as $temp) {
                $date = $temp->getDate();
                array_push($datesToDisable,date_format($date,"Y/m/d"));
                //echo date_format($date,"Y/m/d");
                //var_dump($date);
              }


            $form = $this->createForm('AppBundle\Form\ConsultationType', $consultation, array(
              'entity_manager' => $em,
              'medecinId' => $idMedecin,
            ));
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($consultation);

                $em->flush();

                return $this->redirectToRoute('consultation_show', array('id' => $consultation->getId()));
            }

            return $this->render('consultation/new.html.twig', array(
                'consultation' => $consultation,
                'form' => $form->createView(),
                'disabledDates' => $datesToDisable,

            ));

        }

        if ($this->getUser()->getRole() == "ROLE_MEDECIN")  {
          # ADMIN

          $idPatientMedecin = $this->getUser()->getId();
          $idMedecin = $request->get('medecinid');
            $em = $this->getDoctrine()->getManager();
            $medecin = $em->getRepository('AppBundle:Medecin')->findOneById($idMedecin);
            $patient = $em->getRepository('AppBundle:Medecin')->findOneById($idPatientMedecin);
              //var_dump($medecin[0]);
              //var_dump($medecin);;
            $consultation = new Consultation();
            $consultation->setIdPatient($idPatientMedecin);
            $consultation->setIdMedecin($idMedecin);
            $consultation->setNomPatient($patient->getName());
            $consultation->setNomMedecin($medecin->getName());
            $date = new \DateTime("now");
            $consultation->setDateCreation($date);
            $consultation->setEtat(false);


              //fetching consultations
            $freeDays = $em->getRepository('AppBundle:FreeDays')->findByMedecinId($idMedecin);

              //disabling doctor's free dates

              $datesToDisable = array();
              foreach ($freeDays as $temp) {
                $date = $temp->getDate();
                array_push($datesToDisable,date_format($date,"Y/m/d"));
                //echo date_format($date,"Y/m/d");
                //var_dump($date);
              }

            $form = $this->createForm('AppBundle\Form\ConsultationType', $consultation, array(
              'entity_manager' => $em,
              'medecinId' => $idMedecin,
            ));
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($consultation);
                ///$em->persist($disabled);
                $em->flush();
                $this->addFlash("addedConsultation", "Added Consultation Successfully");
                return $this->redirectToRoute('utilisateur_edit', array('id' => $this->getUser()->getId(), 'role' => $this->getUser()->getRole()));
            }

            return $this->render('consultation/new.html.twig', array(
                'consultation' => $consultation,
                'form' => $form->createView(),
                'disabledDates' => $datesToDisable,

            ));

        }


      $idPatient = $request->get('patientid');
      $idMedecin = $request->get('medecinid');
        $em = $this->getDoctrine()->getManager();
        $medecin = $em->getRepository('AppBundle:Medecin')->findOneById($idMedecin);
        $patient = $em->getRepository('AppBundle:Patient')->findOneById($idPatient);
          //var_dump($medecin[0]);
          //var_dump($medecin);;
        $consultation = new Consultation();
        $consultation->setIdPatient($idPatient);
        $consultation->setIdMedecin($idMedecin);
        $consultation->setNomPatient($patient->getName());
        $consultation->setNomMedecin($medecin->getName());
        $date = new \DateTime("now");
        $consultation->setDateCreation($date);
        $consultation->setEtat(false);


          //fetching consultations
        $freeDays = $em->getRepository('AppBundle:FreeDays')->findByMedecinId($idMedecin);

          //disabling doctor's free dates

          $datesToDisable = array();
          foreach ($freeDays as $temp) {
            $date = $temp->getDate();
            array_push($datesToDisable,date_format($date,"Y/m/d"));
            //echo date_format($date,"Y/m/d");
            //var_dump($date);
          }


        $form = $this->createForm('AppBundle\Form\ConsultationType', $consultation, array(
          'entity_manager' => $em,
          'medecinId' => $idMedecin,
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($consultation);

            $em->flush();
            $this->addFlash("addedConsultation", "Added Consultation Successfully");
            return $this->redirectToRoute('utilisateur_edit', array('id' => $this->getUser()->getId(), 'role' => $this->getUser()->getRole()));
        }

        return $this->render('consultation/new.html.twig', array(
            'consultation' => $consultation,
            'form' => $form->createView(),
            'disabledDates' => $datesToDisable,
        ));
    }

    /**
     * Finds and displays a consultation entity.
     *
     * @Route("/{id}", name="consultation_show")
     * @Method("GET")
     */
    public function showAction(Consultation $consultation)
    {
        $deleteForm = $this->createDeleteForm($consultation);

        return $this->render('consultation/show.html.twig', array(
            'consultation' => $consultation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing consultation entity.
     *
     * @Route("/{id}/edit", name="consultation_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Consultation $consultation)
    {
        $deleteForm = $this->createDeleteForm($consultation);
        $editForm = $this->createForm('AppBundle\Form\ConsultationType', $consultation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('consultation_edit', array('id' => $consultation->getId()));
        }

        return $this->render('consultation/edit.html.twig', array(
            'consultation' => $consultation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a consultation entity.
     *
     * @Route("/{id}", name="consultation_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Consultation $consultation)
    {
        $form = $this->createDeleteForm($consultation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($consultation);
            $em->flush();
        }

        return $this->redirectToRoute('consultation_index');
    }

    /**
     * Creates a form to delete a consultation entity.
     *
     * @param Consultation $consultation The consultation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Consultation $consultation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('consultation_delete', array('id' => $consultation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
