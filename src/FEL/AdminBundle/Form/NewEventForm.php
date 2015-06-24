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
            ->add('price', 'integer')
            ->add('address', 'textarea')
            ->add('zipCode', 'integer')
            ->add('city', 'text')
            ->add('country', 'text')
            ->add('link', 'url')
			->add('image', 'file');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fel_adminbundle_event';
    }
}
