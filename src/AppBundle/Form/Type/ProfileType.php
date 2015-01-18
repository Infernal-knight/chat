<?php

namespace AppBundle\Form\Type;

use Sonata\UserBundle\Form\Type\ProfileType as BaseProfileType;

use Symfony\Component\Form\FormBuilderInterface;

class ProfileType extends BaseProfileType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('avatar', 'sonata_media_type', array(
                'provider' => 'sonata.media.provider.image',
                'context'  => 'default',
                'label'    => 'form.label_avatar',
                'required' => false
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'app_profile';
    }
}