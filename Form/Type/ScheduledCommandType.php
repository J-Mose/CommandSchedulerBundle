<?php

namespace JMose\CommandSchedulerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMose\CommandSchedulerBundle\Entity\UserHost;

/**
 * Class ScheduledCommandType
 *
 * @author  Julien Guyon <julienguyon@hotmail.com>
 * @author  Daniel Fischer <dfischer000@gmail.com>
 */
class ScheduledCommandType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'hidden');

        $builder->add(
            'name', 'text', array(
                'label' => 'detail.name',
                'required' => true
            )
        );

        $builder->add(
            'command', 'command_choice', array(
                'label' => 'detail.command',
                'required' => true
            )
        );

        $builder->add(
            'arguments', 'text', array(
                'label' => 'detail.arguments',
                'required' => false
            )
        );

        $builder->add(
            'cronExpression', 'text', array(
                'label' => 'detail.cronExpression',
                'required' => true
            )
        );

        $builder->add(
            'logFile', 'text', array(
                'label' => 'detail.logFile',
                'required' => true
            )
        );

        $builder->add(
            'rights', 'rights_choice', array(
                // use object as value
                'choices_as_values' => true,
                // anonymous function to build labels from object
                'choice_label' => function ($right, $key, $index) {
                    /** @var UserHost $right */
                    $user = (($user = $right->getUser()) ? $user : '*');
                    $host = (($host = $right->getHost()) ? $host : '*');

                    $val = $right->getTitle();

                    // if user ot host are set append to title
                    // output similar to mysql syntax
                    if(($user != '*') || ($host != '*')){
                        $val = sprintf("%s (%s@%s)",
                            $right->getTitle(),
                            $user,
                            $host
                        );
                    }

                    return $val;
                },
                'label' => 'detail.rights',
                'required' => false
            )
        );

        $builder->add(
            'priority', 'integer', array(
                'label' => 'detail.priority',
                'empty_data' => 0,
                'required' => false
            )
        );

        $builder->add(
            'expectedRuntime', 'integer', array(
                'label' => 'detail.expectedRuntime',
                'required' => false
            )
        );

        $builder->add(
            'executeImmediately', 'checkbox', array(
                'label' => 'detail.executeImmediately',
                'required' => false
            )
        );

        $builder->add(
            'disabled', 'checkbox', array(
                'label' => 'detail.disabled',
                'required' => false
            )
        );

        $builder->add(
            'logExecutions', 'checkbox', array(
                'label' => 'detail.logExecutions',
                'required' => false
            )
        );

        $builder->add(
            'save', 'submit', array(
                'label' => 'action.save',
            )
        );
    }

    /**
     * {@inheritdoc}
     *
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'JMose\CommandSchedulerBundle\Entity\ScheduledCommand',
                'wrapper_attr' => 'default_wrapper',
                'translation_domain' => 'JMoseCommandScheduler'
            )
        );
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getName()
    {
        return 'command_scheduler_detail';
    }
}
