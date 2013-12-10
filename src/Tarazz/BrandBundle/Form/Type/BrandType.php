<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 12/5/13
 * Time: 5:20 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Tarazz\BrandBundle\Form\Type;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BrandType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * Construct function
     */
    function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('title', 'text', array(
                'required' => false
            ))
            ->add('description', 'text', array(
                'required' => false
            ))
            ->add('active', 'checkbox', array(
                'required' => false
            ))
            ->add('save', 'submit')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tarazz\BrandBundle\Entity\Brand'
        ));
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'tarazz_brand_detail_form_type';
    }
}