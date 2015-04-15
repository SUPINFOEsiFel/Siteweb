<?php
namespace FEL\AppBundle\Form;

use Symfony\component\Form\AbstractType;
use Symfony\component\Form\FormBuilderInterface;

class JuifForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('content')
            ->add('auteur')
        ;
    }
    public function getName()
    {
        return 'article';
    }
}