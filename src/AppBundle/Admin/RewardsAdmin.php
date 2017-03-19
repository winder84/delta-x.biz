<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class RewardsAdmin extends AbstractAdmin
{
    protected $context = 'default';
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('title')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('title')
            ->add('_action', null, array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $link_parameters = array();
        $formMapper
            ->add('title')
            ->add('rewardsMedia', 'sonata_type_collection', array(
                'cascade_validation' => true,
                'type_options' => array('delete' => false),
                'required' => false,
            ), array(
                'edit' => 'inline',
                'required' => false,
                'inline' => 'table',
                'sortable' => 'position',
                'targetEntity' => 'AppBundle\Entity\RewardsHasMedia',
                'link_parameters' => array(
                    'context' => $this->context,
                ),
                'admin_code' => 'app.admin.rewards_has_media'
            ))
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('title')
        ;
    }

    public function prePersist($rewards)
    {
        $rewards->setRewardsMedia($rewards->getRewardsMedia());
    }
    public function preUpdate($rewards)
    {
        $rewards->setRewardsMedia($rewards->getRewardsMedia());
    }
}
