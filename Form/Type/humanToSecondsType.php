<?php

namespace NSM\Bundle\DateTimeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use NSM\Bundle\DateTimeBundle\Form\DataTransformer\HumanToSecondsTransformer;

class HumanToSecondsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new HumanToSecondsTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'nsm_datetime_human_to_seconds';
    }
}