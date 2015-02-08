<?php


namespace Darkish\CustomerBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Darkish\CustomerBundle\Entity\Customer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class CustomerRepository extends EntityRepository
{
    
}