<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchPartnersType extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', 'entity', [
                'class' => 'HeavyCodeGroup\LinkPub\StorageBundle\Entity\Category',
                'property' => 'title',
                'empty_value'   => ' ',
                'required' => true
            ])
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'linkpub_gui_add_site';
    }
}
 