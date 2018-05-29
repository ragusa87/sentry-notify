<?php
/**
 * @author     Laurent Constantin <lconstantin@pubfac.com>
 * @copyright  Copyright (c) 2018 Publishing Factory SA (http://www.pubfac.com/)
 * @license    proprietary
 */

namespace AppBundle\Form\Type;


use Psr\Log\LogLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class DefaultForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @throws \ReflectionException
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add("level", ChoiceType::class, ["choices" => $this->getChoices()])
            ->add("message", TextareaType::class, ["required" => false])
            ->add("submit", SubmitType::class, ["label" => "Submit"]);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getChoices()
    {
        $choices = (new \ReflectionClass(LogLevel::class))->getConstants();

        return array_combine($choices, $choices);
    }
}