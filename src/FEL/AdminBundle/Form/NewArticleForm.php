<?php

namespace FEL\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NewArticleForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content', null, array("attr" => array("class" => "tinymce"), "required" => false))
            ->add('author');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'FEL\AdminBundle\Entity\Article'
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fel_adminbundle_article';
    }
}
