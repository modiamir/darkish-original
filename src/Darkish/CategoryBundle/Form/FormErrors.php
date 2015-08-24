<?php
namespace Darkish\CategoryBundle\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;


class FormErrors
{
    private $container;
    /**
     * @param \Symfony\Component\Form\Form $form
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * @param \Symfony\Component\Form\Form $form
     * @return array
     */
    public function getFormErrors(Form $form, $string = false)
    {
        //
        if ($err = $this->childErrors($form)) {
            $errors["form"] = $err;
        }
        //
        foreach ($form->all() as $key => $child) {
            //
            if ($err = $this->childErrors($child)) {
                $errors[$key] = $err;
            }
        }

        if($string) {
            $errorString = '';
            foreach($errors as $error)
            {
                $errorString .= $error[0];
            }
            return $errorString;
        }

        return $errors;
    }
    /**
     * @param \Symfony\Component\Form\Form $form
     * @return array
     */
    public function childErrors(Form $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            // Переведем ошибку, если есть перевод
            $message = $this->container->get('translator')->trans($error->getMessage(), array(), 'validators');
            array_push($errors, $message);
        }
        return $errors;
    }
}