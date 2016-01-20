<?php

namespace Acme\StoreBundle\Form;


use Acme\StoreBundle\Document\Tag;
use Doctrine\Bundle\MongoDBBundle\Form\Type\DocumentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
            ->add('price', 'number', array('required' => true))
            ->add('categorie', DocumentType::class, array(
                'class' => 'Acme\StoreBundle\Document\Category',
                'choice_label' => 'name'
            ));

        $builder->add('tags', CollectionType::class, array(
            'entry_type' => TagForm::class,
            'by_reference' => false,
            'allow_delete' => true,
            'allow_add'    => true
        ));


        /*
         * ->add('categories', 'document', array(
            'class'       => 'Acme\StoreBundle\Document\Category',
            'property'    => 'categories',
            'empty_value' => 'choisissez une categorie',
            'required'    => false));
        */
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults(array(
            'data_class' => 'Acme\StoreBundle\Document\Product'
        ));
    }

    public function getName()
    {
        return 'acme_store_bundle_product_form';
    }
}
