<?php

/**
 * LiteMVC Application Framework
 *
 * Dummy test model
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2013
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVCTest\Model\TestAssets;

use LiteMVC\Model\AbstractModel;
use LiteMVC\Orm\Orm;

class PersonModel extends AbstractModel
{

    /**
     * Database name
     *
     * @var string
     */
    protected $_database = 'test';

    /**
     * Table name
     *
     * @var string
     */
    protected $_table = 'person';

    /**
     * Schema
     *
     * @var array
     */
    protected $_schema = array(
        'person_id' => array(
            'type' => Orm::COL_NUMERIC,
            'nullable' => false,
            'default' => null
        ),
        'name' => array(
            'type' => Orm::COL_STRING,
            'nullable' => false,
            'default' => null
        ),
        'age' => array(
            'type' => Orm::COL_NUMERIC,
            'nullable' => true,
            'default' => null
        )
    );

    /**
     * Primary key
     *
     * @var array
     */
    protected $_primaryKey = array('person_id');

    /**
     * Relationships
     *
     * @var array
     */
    protected $_relationships = array(
        'person_id' => array(
            array(
                'model' => 'Model\Address',
                'field' => 'person_id',
                'type' => Orm::REL_PARENT
            )
        )
    );

}