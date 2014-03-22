<?php
/**
 * LiteMVC Application Framework
 *
 * Result for Pdo drivers
 *
 * @author Phil Bayfield
 * @copyright 2010 - 2014
 * @license GNU General Public License version 3
 * @package LiteMVC
 * @version 0.4.0
 */

namespace LiteMVC\Orm\Driver\Pdo;

use LiteMVC\Orm\Driver\AbstractResult;

class PdoResult extends AbstractResult
{

    /**
     * Populate the result
     *
     * @param \PDOStatement $stmt
     */
    public function __construct(\PDOStatement $stmt) {
        $this->_affectedRows = $stmt->rowCount();
        $this->_data = $stmt->fetchAll();
    }

} 