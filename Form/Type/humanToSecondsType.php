<?php

namespace NSM\Bundle\DateTimeBundle\Form\Type;

use NSM\Bundle\NSMDateTimeBundle\Form\DataTransformer\HumanToSecondsTransformer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

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