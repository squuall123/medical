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
use AppBundle\Form\PatientType;


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
  * @Get("/api/patient/consultations/{id}")
  */
  public function getPatientConsultationsAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();
    $patient = $em->getRepository('AppBundle:Patient')->findOneById($request->get('id'));
    $consultations = $em->getRepository('AppBundle:Consultation')->findByIdPatient($patient->getId());

    return $consultations;

  }

  /**
  * @Rest\View()
  * @Get("/api/getUser")
  */
  public function getCurrentUserAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $user = $em->getRepository('AppBundle:Patient')->findOneById($this->getUser()->getId());

    return $user;

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
  * @Get("/api/medecins/{uid}")
  */
  public function getmyDoctorsAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();
    $consultations = $em->getRepository('AppBundle:Consultation')->findByIdPatient($request->get('id'));
    $medecins= array();
    foreach ($consultations as $value) {

      $tempDoc = $em->getRepository('AppBundle:Medecin')->findOneById($value->getIdMedecin());
      if(!in_array($tempDoc,$idmedecins)){
        array_push($idmedecins,$tempDoc);
      }

    }

    return $idmedecins;

  }

  /**
  * @Rest\View()
  * @Get("/api/profile/{mail}")
  */
  public function getprofilePatientAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $profile = $em->getRepository('AppBundle:Patient')->findOneByEmail($request->get('mail'));

    return $profile;

  }

  /**
  * @Rest\View()
  * @Get("/api/medecin/{id}")
  */
  public function getMedecinAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $medecin = $em->getRepository('AppBundle:Medecin')->findOneById($request->get('id'));

    return $medecin;

  }

  /**
  * @Rest\View()
  * @Get("/api/medecins/{specialite}")
  */
  public function getMedecinParSpecialiteAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();
    $specialite = $em->getRepository('AppBundle:Service')->findOneByNom($request->get('specialite'));
    $medecins = $em->getRepository('AppBundle:Medecin')->findBySpecialite($specialite);

    return $medecins;

  }

  /**
  * @Rest\View()
  * @Get("/api/service/{id}")
  */
  public function getServiceAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $service = $em->getRepository('AppBundle:Service')->findOneById($request->get('id'));

    return $service;

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
  * @Get("/api/patient/traitements/{id}")
  */
  public function gettraitementsAction(Request $request)
  {

    $em = $this->getDoctrine()->getManager();

    $temp = $em->getRepository('AppBundle:Patient')->findById($request->get('id'));
    //var_dump($temp[0]);
    $traitements = $em->getRepository('AppBundle:Traitement')->findByPatient($temp[0]->getId());
    //$patient = $em->getRepository('AppBundle:Patient')->findById($request->get('id'));

    return $traitements;

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

  /**
* @Rest\View()
* @Post("/api/register")
*/
public function registerApiAction(Request $request)
{
      $user = new Patient();
      $form = $this->createForm(PatientType::class, $user);

  if ($form->handleRequest($request)->isSubmitted() && $form->isValid()) {

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


      return new Response($user->getId());
  }
  else {
    //return new Response('not created user');
    return new Response($this->serialize(['resp ' => $form]));
  }
  //return new Response($data['test']);

}


/**
* @Rest\View()
* @Post("/api/login")
*/
public function loginApiAction(Request $request)
{
     $username = $request->getUser();
     $password = $request->getPassword();

     $em = $this->getDoctrine()->getManager();
     $user = $em->getRepository('AppBundle:Patient')->findOneByName($username);

     if (!$user) {
       return new Response("Not_Found",Response::HTTP_NOT_FOUND);
         //throw $this->createNotFoundException();
     }

     $isValid = $this->get('security.password_encoder')
         ->isPasswordValid($user, $password);

     if (!$isValid) {
       return new Response("BadCredentials",Response::HTTP_UNAUTHORIZED);
         //throw new BadCredentialsException();
     }

     $token = $this->getToken($user);
     $response = new Response($this->serialize(['token' => $token]), Response::HTTP_OK);

     return $this->setBaseHeaders($response);

}

/**
* Returns token for user.
*
* @param User $user
*
* @return array
*/
public function getToken(Patient $user)
{/*
  return $this->container->get('lexik_jwt_authentication.encoder.default')
          ->encode([
              'username' => $user->getName(),
              'exp' => $this->getTokenExpiryDateTime(),
          ]);
          */

          return $this->container->get('lexik_jwt_authentication.encoder.default')
                  ->encode([
                      'username' => $user->getName(),
                      'exp' => $this->getTokenExpiryDateTime(),
                  ]);
}

/**
* Returns token expiration datetime.
*
* @return string Unixtmestamp
*/
private function getTokenExpiryDateTime()
{
  $tokenTtl = $this->container->getParameter('lexik_jwt_authentication.token_ttl');
  $now = new \DateTime();
  $now->add(new \DateInterval('PT'.$tokenTtl.'S'));

  return $now->format('U');
}
/**
 * Set base HTTP headers.
 *
 * @param Response $response
 *
 * @return Response
 */
private function setBaseHeaders(Response $response)
{
    $response->headers->set('Content-Type', 'application/json');
    $response->headers->set('Access-Control-Allow-Origin', '*');

    return $response;
}

/**
* Data serializing via JMS serializer.
*
* @param mixed $data
*
* @return string JSON string
*/
public function serialize($data)
{
  $context = new SerializationContext();
  $context->setSerializeNull(true);

  return $this->get('jms_serializer')
      ->serialize($data, 'json', $context);
}

}
