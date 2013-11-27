<?php
/**
 * Created by JetBrains PhpStorm.
 * User: diennt
 * Date: 11/27/13
 * Time: 11:20 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Tarazz\CoreBundle\Grid;


use APY\DataGridBundle\Grid\Grid;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractGrid
{
    /**
     * @var $grid Grid
     */
    protected $grid;

    /**
     * @var $container ContainerInterface
     */
    protected $container;

    /**
     * Construct function
     *
     * @param ContainerInterface $container
     * @param Grid $grid
     */
    function __construct(ContainerInterface $container, Grid $grid)
    {
        $this->grid = $grid;
        $this->container = $container;
        $this->setUp();
    }

    /**
     * Setup grid
     *
     * @return mixed
     */
    abstract public function setUp();

    /**
     * Get base grid
     *
     * @return Grid
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * Get grid response
     */
    public function getGridResponse($view = null, $params = null, Response $response = null)
    {
        return $this->grid->getGridResponse($view, $params, $response);
    }
}