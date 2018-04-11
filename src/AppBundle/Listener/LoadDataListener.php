<?php

namespace AppBundle\Listener;

use AncaRebeca\FullCalendarBundle\Model\FullCalendarEvent;

use AncaRebeca\FullCalendarBundle\Event\CalendarEvent;
use AncaRebeca\FullCalendarBundle\Model\Event;
use AppBundle\Entity\Consultation;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LoadDataListener
{

    /**
    * @var EntityManager
    */
    private $em;

    private $tokenStorage;

    public function __construct(EntityManager $em, TokenStorageInterface $tokenStorage)
    {
      $this->em = $em;
      $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param CalendarEvent $calendarEvent
     *
     * @return FullCalendarEvent[]
     */
    public function loadData(CalendarEvent $calendarEvent)
    {
        $id = $this->tokenStorage->getToken()->getUser()->getId();
              $repository = $this->em->getRepository('AppBundle:Consultation');
              $consultations = $repository->findByIdMedecin($id);
              // You may want to add an Event into the Calendar view.

              foreach ($consultations as $consultation) {
                if($consultation->getEtat() == true){
                  $date = $consultation->getDateRDV();
                  $time = $consultation->getTimeRDV();
                  //$datetime = date('Y-m-d H:i:s', strtotime("$date $time"));
                  $merge = new \DateTime($date->format('Y-m-d').' ' .$time->format('H:i'));
                  $result = $merge->format('Y-m-d H:i');
                  //var_dump($result);
                  //$final = date('Y-m-d H:i', $merge->format('Y-m-d H:i'));
                  $event = new Event($consultation->getDescription(), $merge);
                  $endTime = clone $merge;

                  $endTime->add(new \DateInterval('PT30M'));



                  $event->setAllDay(false);
                  $event->setEndDate($endTime);
                  $calendarEvent->addEvent($event);
                  }
              }



    	 //$calendarEvent->addEvent(new Event('Event Title 1', new \DateTime()));
    	 //$calendarEvent->addEvent(new Event('Event Title 2', new \DateTime()));
    }
}
