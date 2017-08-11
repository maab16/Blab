<?php

namespace App\Database\Models;

use Blab\Libs\Model;

class Sample extends Model
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
	 * @type text
	 * @length 100
	 */
	protected $_username;
	/**
	 * @column
	 * @readwrite
	 * @type text
	 * @length 100
	 */
	protected $_password;
	/**
	 * @column
	 * @readwrite
	 * @type text
	 */
	protected $_salt;
	/**
	 * @column
	 * @readwrite
	 * @type text
	 * @length 100
	 * @index
	 */
	protected $_email;
	/**
	 * @column
	 * @readwrite
	 * @type text
	 * @length 100
	 * @index
	 * @default 1
	 */
	protected $_actve;
	/**
	 * @column
	 * @readwrite
	 * @type boolean
	 * @index
	 * @default 1
	 */
	protected $_grp;
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