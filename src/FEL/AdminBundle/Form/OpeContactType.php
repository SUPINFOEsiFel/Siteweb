<?php

namespace FEL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OpeContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('societyName')
            ->add('website')
            ->add('description')
            ->add('address')
            ->add('zipcode')
            ->add('city')
            ->add('phoneNumber')
            ->add('faxNumber')
			->add('email')
            ->add('notes')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FEL\AdminBundle\Entity\OpeContact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fel_adminbundle_opecontact';
    }
}
