<?php

namespace DH\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('username')
            ->add('locked')
            ->add('email')
            ->add('organisme', 'text', array('required' => false))
            ->add('phone')
            ->add('birthdate', 'date', array(
                'widget' => 'single_text',
                'attr' => array(
                    'class' => 'contact_form_input_noname',
                )
            ))
            ->add('profilePictureFile')
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'first_options'  => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'password',
                        'class' => 'contact_form_input_noname',
                    )
                ),
                'second_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'password confirmation',
                        'class' => 'contact_form_input_noname',
                    )
                )
            ))
            ->add('save', 'submit')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DH\UserBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dh_platformbundle_profile';
    }
}