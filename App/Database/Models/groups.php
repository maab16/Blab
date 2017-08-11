<?php

namespace App\Database\Models;

use Blab\Libs\Model;

class Groups extends Model
{
	/**
	 * @column
	 * @readwrite
	 * @primary
	 * @type autonumber
	 */
	protected $_id;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 100
	 */
	protected $_group_name;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 100
	 */
	protected $_permission;
	/**
	 * @column
	 * @readwrite
	 * @type datetime
	 */
	protected $_created;
	/**
	 * @column
	 * @readwrite
	 * @type datetime
	 */
	protected $_updated;
	/**
	 * @column
	 * @readwrite
	 * @type boolean
	 * @index
	 */
	protected $_deleted;
}