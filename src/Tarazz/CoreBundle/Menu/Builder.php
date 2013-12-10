<?php
/**
 * Created by PhpStorm.
 * User: diennt
 * Date: 12/10/13
 * Time: 5:01 PM
 */

namespace Tarazz\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\SecurityContext;


class Builder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var SecurityContext
     */
    private $security;

    function __construct(FactoryInterface $factory, SecurityContext $security)
    {
        $this->factory = $factory;
        $this->security = $security;
    }


    public function createMainMenu(RouterInterface $router)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');

        $defaultOption = array(
            'uri' => '#',
            'label' => null,
            'attributes' => array(),
            'linkAttributes' => array(),
            'labelAttributes' => array(),
            'extras' => array(),
            'display' => true,
            'displayChildren' => false,
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
            'configuration'
        );

        $configurationKey = array(
            'general',
            'hubs',
            'storefronts',
            'shipping providers',
            'currencies',
            'users',
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

//        $uris = array(
//            'dashboard'       => 'tarazz_dashboard_index',
//            'merchants'       => 'tarazz_merchant_grid',
//            'brands'          => 'tarazz_brand_grid',
//            'categories'      => 'tarazz_category_index',
//            'products'        => 'tarazz_product_grid',
//            'customers'       => 'tarazz_customer_grid',
//            'purchase orders' => 'tarazz_order_purchase_grid',
//            'customer orders' => 'tarazz_order_customer_grid',
//            'promotions'      => 'tarazz_promotion_grid',
//            'cms'             => 'tarazz_cms_index',
//            'reports'         => 'tarazz_report_revenue',
//        );
//
//        $configurationUris = array(
//            'general'            => 'tarazz_config_general',
//            'hubs'               => 'tarazz_config_hub_grid',
//            'storefronts'        => 'tarazz_config_storefront',
//            'shipping providers' => 'tarazz_config_shipping_provider',
//            'currencies'         => 'tarazz_config_currencies',
//            'users'              => 'tarazz_auth_users',
//        );

        $uris = array(
            'dashboard'       => 'tarazz_core_homepage',
            'merchants'       => 'tarazz_core_homepage',
            'brands'          => 'tarazz_brand_grid',
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
            'storefronts'        => 'tarazz_core_homepage',
            'shipping providers' => 'tarazz_core_homepage',
            'currencies'         => 'tarazz_core_homepage',
            'users'              => 'tarazz_core_homepage',
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