<?php

namespace DH\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('roles', 'collection', array(
               'type' => 'choice',
               'options' => array(
                   'choices' => array(
                       'ROLE_PATIENT' => 'Patient',
                       'ROLE_DOCTOR' => 'Docteur',
                       'ROLE_PROCHE' => 'Proche',
                       'ROLE_ADMIN' => 'Admin'
                   )
               )
           )
        );
    }

    public function getParent()
    {
        // return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
