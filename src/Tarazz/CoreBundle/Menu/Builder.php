<?php

/**
 * Tarazz\CoreBundle\Menu
 */
namespace Tarazz\CoreBundle\Menu;

use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Class Builder
 */
class Builder
{
    /**
     * @var \Knp\Menu\FactoryInterface
     */
    private $factory;
    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    private $security;

    /**
     * @param FactoryInterface $factory
     * @param \Symfony\Component\Security\Core\SecurityContext $security
     */
    public function __construct(FactoryInterface $factory, SecurityContext $security)
    {
        $this->factory  = $factory;
        $this->security = $security;
    }


    /**
     * @param RouterInterface $router
     *
     * @return ItemInterface
     */
    public function createMainMenu(RouterInterface $router)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        $defaultOption = array(
            'uri'                => '#',
            'label'              => null,
            'attributes'         => array(),
            'linkAttributes'     => array(),
            'childrenAttributes' => array(),
            'labelAttributes'    => array(),
            'extras'             => array(),
            'display'            => true,
            'displayChildren'    => false,
        );

        $menuKey = array(
            'dashboard',
            'merchants',
            'brands',
            'categories',
            'products',
            'customers',
            'purchase orders',
            'customer orders',
            'promotions',
            'cms',
            'reports',
            'configuration',
        );

        $configurationKey = array(
            'general',
            'hubs',
            'feeds',
            'feed schedule',
            'storefronts',
            'shipping providers',
            'currencies',
            'users',
            'permissions',
            'product flags',
        );

        $menuSetting = array();
        foreach ($menuKey as $key) {
            $setting          = $defaultOption;
            $setting['label'] = $key === 'cms' ? 'CMS' : ucwords($key);
            $setting['uri'] .= str_replace(' ', '-', strtolower($key));

            $menuSetting[$key] = $setting;
        }

        $configurationMenuSetting = array();
        foreach ($configurationKey as $key) {
            $setting          = $defaultOption;
            $setting['label'] = ucwords($key);
            $setting['uri'] .= 'configurations-' . str_replace(' ', '-', strtolower($key));

            $configurationMenuSetting[$key] = $setting;
        }

        $uris = array(
            'dashboard'       => 'tarazz_core_homepage',
            'merchants'       => 'tarazz_core_homepage',
            'brands'          => 'tarazz_core_homepage',
            'categories'      => 'tarazz_core_homepage',
            'products'        => 'tarazz_core_homepage',
            'customers'       => 'tarazz_core_homepage',
            'purchase orders' => 'tarazz_core_homepage',
            'customer orders' => 'tarazz_core_homepage',
            'promotions'      => 'tarazz_core_homepage',
            'cms'             => 'tarazz_core_homepage',
            'reports'         => 'tarazz_core_homepage',
        );

        $configurationUris = array(
            'general'            => 'tarazz_core_homepage',
            'hubs'               => 'tarazz_core_homepage',
            'feeds'              => 'tarazz_core_homepage',
            'feed schedule'      => 'tarazz_core_homepage',
            'storefronts'        => 'tarazz_core_homepage',
            'shipping providers' => 'tarazz_core_homepage',
            'currencies'         => 'tarazz_core_homepage',
            'users'              => 'tarazz_core_homepage',
            'permissions'        => 'tarazz_core_homepage',
            'product flags'      => 'tarazz_core_homepage',
        );

        foreach ($uris as $key => $uri) {
            $menuSetting[$key]['uri'] = $router->generate(
                $uri,
                array(),
                UrlGeneratorInterface::ABSOLUTE_PATH
            );
        }

        foreach ($configurationUris as $key => $configurationUri) {
            $configurationMenuSetting[$key]['uri'] = $router->generate(
                $configurationUri,
                array(),
                UrlGeneratorInterface::ABSOLUTE_PATH
            );
        }

        $menuSetting['configuration']['displayChildren']        = true;
        $menuSetting['configuration']['children']               = $configurationMenuSetting;
        $menuSetting['configuration']['attributes']['dropdown'] = true;

        $permissionMenus = array(
            'dashboard'       => array(
                'ROLE_REPORTS',
                'ROLE_ORDERS_LIST',
                'ROLE_ORDERS_VIEW',
                'ROLE_ORDERS_EDIT',
                'ROLE_ORDERS_ADMIN',
            ),
            'merchants'       => array('ROLE_CATALOGUE_MANAGEMENT', 'ROLE_MERCHANT_CATEGORY_MAPPING'),
            'brands'          => array('ROLE_CATALOGUE_ADMIN', 'ROLE_CATALOGUE_MANAGEMENT'),
            'categories'      => array('ROLE_CATALOGUE_MANAGEMENT'),
            'products'        => array('ROLE_CATALOGUE_MANAGEMENT'),
            'customers'       => array(
                'ROLE_CUSTOMER_MANAGEMENT',
            ),
            'purchase orders' => array('ROLE_ORDERS_LIST', 'ROLE_ORDERS_VIEW', 'ROLE_ORDERS_EDIT', 'ROLE_ORDERS_ADMIN'),
            'customer orders' => array(
                'ROLE_ORDERS_LIST',
                'ROLE_ORDERS_VIEW',
                'ROLE_ORDERS_EDIT',
                'ROLE_ORDERS_ADMIN',
                'ROLE_RETURNS_EDIT',
            ),
            'promotions'      => array('ROLE_PROMOTIONS_LIST', 'ROLE_PROMOTIONS_EDIT'),
            'cms'             => array('ROLE_CMS'),
            'reports'         => array('ROLE_REPORTS'),
            'configuration'   => array(
                'ROLE_CONFIGURATION',
                'ROLE_CONFIGURATION_CREDIT_CARD_VIEW',
                'ROLE_CONFIGURATION_CREDIT_CARD_EDIT',
                'ROLE_FEED_MANAGEMENT',
            ),
        );

        foreach ($permissionMenus as $_key => $_permissions) {
            $unset = true;
            foreach ($_permissions as $_permission) {
                if (true) {
                    $unset = false;
                    break;
                }
            }

            if ($unset) {
                if ($_key !== 'configuration') {
                    unset($menuSetting[$_key]);
                } else {
                    foreach ($menuSetting['configuration']['children'] as $_childKey => $_childMenu) {
                        if ('users' !== $_childKey && 'permissions' !== $_childKey) {
                            unset($menuSetting['configuration']['children'][$_childKey]);
                        }
                    }
                }
            }
        }

        // Auth permission
        if (false) {
            if (isset($menuSetting['configuration'])) {
                unset($menuSetting['configuration']['children']['users']);
                unset($menuSetting['configuration']['children']['permissions']);
            }
        }

        if (0 === count($menuSetting['configuration']['children'])) {
            unset($menuSetting['configuration']);
        }

        $this->buildMenu($menu, $menuSetting);

        return $menu;
    }


    /**
     * @param ItemInterface $menu
     * @param $menuSetting
     */
    private function buildMenu(ItemInterface $menu, $menuSetting)
    {
        foreach ($menuSetting as $key => $options) {
            $menu->addChild($key, $options);
            if (isset($options['children'])) {
                $this->buildMenu($menu->getChild($key), $options['children']);
            }
        }
    }
}
