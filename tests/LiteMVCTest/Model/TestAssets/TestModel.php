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
 * @version 0.4.0-dev
 */

namespace LiteMVCTest\Model\TestAssets;

use LiteMVC\Model\AbstractModel;
use LiteMVC\ORM\ORM;

class TestModel extends AbstractModel
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
            'type' => ORM::COL_NUMERIC,
            'nullable' => false,
            'default' => null
        ),
        'name' => array(
            'type' => ORM::COL_STRING,
            'nullable' => false,
            'default' => null
        ),
        'age' => array(
            'type' => ORM::COL_NUMERIC,
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
                'foreign_table_name' => 'address',
                'foreign_field_name' => 'person_id',
                'type' => ORM::REL_PARENT
            )
        )
    );

}