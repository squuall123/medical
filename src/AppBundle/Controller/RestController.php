<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use AppBundle\Entity\Patient;


class RestController extends Controller
{

  /**
  * @Rest\View()
  * @Get("/api/patients")
  */
  public function getAllPatientsAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $users = $em->getRepository('AppBundle:Patient')->findAll();

    return $users;

  }

  /**
  * @Rest\View()
  * @Get("/api/services")
  */
  public function getAllServicesAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $services = $em->getRepository('AppBundle:Service')->findAll();

    return $services;

  }

  /**
  * @Rest\View()
  * @Get("/api/patient/{id}")
  */
  public function getPatientByIdAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $patient = $em->getRepository('AppBundle:Patient')->findById($request->get('id'));

    return $patient;

  }

  /**
  * @Rest\View()
  * @Get("/api/patients/{medecinId}")
  */
  public function getPatientsByMedecinAction(Request $request)
  {
    $patients = array();
    $em = $this->getDoctrine()->getManager();
    $consultations = $em->getRepository('AppBundle:Consultation')->findByIdMedecin($request->get('medecinId'));
    if (!empty($consultations)) {
      foreach ($consultations as $value) {
        //var_dump($value->getIdPatient());
        array_push($patients,$em->getRepository('AppBundle:Patient')->findById($value->getIdPatient()));
      }
    }
    return $patients;

  }

}
