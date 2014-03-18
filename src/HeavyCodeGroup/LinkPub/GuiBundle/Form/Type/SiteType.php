<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SiteType extends AbstractType
{

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'linkpub_gui_site';
    }
}
 