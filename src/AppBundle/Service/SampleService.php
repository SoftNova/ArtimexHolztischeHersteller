<?php
/**
 * Created by PhpStorm.
 * User: cvisan
 * Date: 8/17/2016
 * Time: 10:16 AM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Sample;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\RequestStack;

class SampleService
{
    private $entityManager;
    private $request;

    public function __construct(EntityManager $em, RequestStack $requestStack)
    {
        $this->entityManager = $em;
        $this->request=$requestStack->getCurrentRequest();

    }

    public function save(Sample $sample){
        $sample->setRegisteredDate(new \DateTime());
        $this->entityManager->persist($sample);
        $this->entityManager->flush();
    }
}