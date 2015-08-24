<?php

namespace Darkish\UserBundle\Validator\Constraints;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Darkish\CategoryBundle\Entity\InvalidNames;

/**
 * @Annotation
 */
class ValidNameValidator extends ConstraintValidator
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function validate($value, Constraint $constraint)
    {
        $pieces =  explode(' ', $value);
        $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:InvalidNames');
        $qb = $repo->createQueryBuilder('n');
        /* @var $qb \Doctrine\ORM\QueryBuilder */
        $qb->select('count(n.id)');
        $qb->where('n.name in (:name)')->setParameter('name', $pieces);
        $count = $qb->getQuery()->getSingleScalarResult();


        if($count > 0)
        {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }




    }
}
