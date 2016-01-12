<?php

namespace DH\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModuleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'entity', array(
                'class'    => 'PIOTRUserBundle:Movie',
                'property' => 'name',
                'multiple' => true,
                'expanded' => false
                ))
            ->add('editer', 'submit')
        ;
        $builder
            ->add('name', 'text')
            ->add('description', 'textarea')
            ->add('type', 'text')
            ->add('organisme', 'text')
            ->add('logo', 'file', array('required' => false))
            // ->add('version', 'text')
            // ->add('url', 'text')
            ->add('save', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DH\PlatformBundle\Entity\Module'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dh_platformbundle_module';
    }
}
