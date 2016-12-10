<?php

namespace DH\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;


class CommentModuleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'text', array('constraints' => array(new NotBlank())))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DH\PlatformBundle\Entity\CommentModule'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dh_platformbundle_commentmodule';
    }

    /**
     * @return string
     */
    public function getText()
    {
        return 'dh_platformbundle_module';
    }
}
