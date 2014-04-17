<?php

namespace HeavyCodeGroup\LinkPub\GuiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class SiteType extends AbstractType
{

    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('category', 'entity', [
                'class' => 'HeavyCodeGroup\LinkPub\StorageBundle\Entity\Category',
                'property' => 'title',
                'empty_value'   => ' ',
                'required' => true
            ])
            ->add('rootUrl', 'url', [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('submit', 'submit')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HeavyCodeGroup\LinkPub\StorageBundle\Entity\Site'
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'linkpub_gui_add_site';
    }
}
 