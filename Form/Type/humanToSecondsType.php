<?php

namespace NSM\Bundle\DateTimeBundle\Form\Type;

use NSM\Bundle\DateTimeBundle\Form\DataTransformer\HumanToSecondsTransformer;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;

class HumanToSecondsType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->appendClientTransformer(new HumanToSecondsTransformer());
    }

    /**
     * {@inheritdoc}
     */
    public function getParent(array $options)
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