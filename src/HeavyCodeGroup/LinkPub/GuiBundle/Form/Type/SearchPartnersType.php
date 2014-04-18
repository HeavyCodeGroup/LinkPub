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
            ->add('tci_min', 'integer', [
                'label' => 'linkpub.gui.partner_search.tci_min',
                'data'  => 0,
                'empty_data'  => 0,
            ])
            ->add('tci_max', 'integer', [
                'label' => 'linkpub.gui.partner_search.tci_max',
                'data'  => 20,
                'empty_data'  => 20,
            ])
            ->add('pr', 'integer', [
                'label' => 'linkpub.gui.partner_search.pr',
                'data'  => 1,
                'empty_data'  => 1,
            ])
            ->add('price', 'integer', [
                'precision' => 2,
                'label' => 'price',
                'data'  => 1,
                'empty_data'  => 1,
            ])
            ->add('level', 'integer', [
                'label' => 'level',
                'data'  => 0,
                'empty_data'  => 0,
            ])
            ->add('submit', 'submit')
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
 