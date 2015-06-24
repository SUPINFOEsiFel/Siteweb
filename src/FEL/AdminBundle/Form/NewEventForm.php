<?php

namespace FEL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewEventForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('begin', 'datetime')
            ->add('end', 'datetime')
            ->add('comment', 'textarea', array("required" => false, "attr" => array("class" => "tinymce")))
            ->add('price', 'integer', array("required" => false))
            ->add('address', 'textarea', array("required" => false))
            ->add('zipCode', 'integer', array("required" => false))
            ->add('city', 'text', array("required" => false))
            ->add('country', 'text', array("required" => false))
            ->add('link', 'url', array("required" => false))
			->add('image', 'file', array("required" => false));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fel_adminbundle_event';
    }
}
