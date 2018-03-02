<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Service controller.
 *
 * @Route("service")
 */
class ServiceController extends Controller
{
    /**
     * Lists all service entities.
     *
     * @Route("/", name="service_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $services = $em->getRepository('AppBundle:Service')->findAll();

        return $this->render('default/services.html.twig', array(
            'services' => $services,
        ));
    }

    /**
     * Finds and displays a service entity.
     *
     * @Route("/{id}", name="service_show")
     * @Method("GET")
     */
    public function showAction(Service $service)
    {
        $spec = $service->getId();
        $em = $this->getDoctrine()->getManager();
        $medecin = $em->getRepository('AppBundle:Medecin')->findBySpecialite($spec,['name' => 'ASC']);
        //$medecin = $em->getRepository('AppBundle:Medecin')->findBy([array('specialite' => $spec),array('name' => 'ASC')]);
        //$medecin = $em->getRepository('AppBundle:Medecin')->findBy([], ['name' => 'ASC']);

            //var_dump($medecin);
        return $this->render('service/show.html.twig', array(
            'service' => $service, 'medecins' => $medecin
        ));
    }
}
