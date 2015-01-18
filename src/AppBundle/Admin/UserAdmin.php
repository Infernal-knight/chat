<?php

namespace AppBundle\Admin;

use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseUserAdmin;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class UserAdmin extends BaseUserAdmin
{
    protected $baseRouteName = 'admin_sonata_user_user';
    protected $baseRoutePattern = '/sonata/user/user';

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        parent::configureShowFields($showMapper);
        /*$showMapper
            ->with('Other')
            ->add('avatar')
            ->end()
        ;*/
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        parent::configureFormFields($formMapper);
        $formMapper
            ->with('Other')
            ->add('avatar', 'sonata_media_type', array(
                'provider' => 'sonata.media.provider.image',
                'context'  => 'default',
                'required' => false,
            ))
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        parent::configureListFields($listMapper);
        /*$listMapper
            ->add('avatar')
        ;*/
    }

}