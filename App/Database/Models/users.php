<?php

namespace App\Database\Models;

use Blab\Libs\Model;

class Users extends Model
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
	 * @index
	 */
	protected $_username;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 100
	 */
	protected $_password;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 50
	 */
	protected $_salt;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 100
	 * @index
	 */
	protected $_email;
	/**
	 * @column
	 * @readwrite
	 * @type int
	 * @length 1
	 * @index
	 * @default 1
	 */
	protected $_active;
	/**
	 * @column
	 * @readwrite
	 * @type int
	 * @length 1
	 * @index
	 * @default 1
	 */
	protected $_grp;
	/**
	 * @column
	 * @readwrite
	 * @type datetime
	 */
	protected $_created_at;
	/**
	 * @column
	 * @readwrite
	 * @type datetime
	 */
	protected $_updated_at;
	/**
	 * @column
	 * @readwrite
	 * @type boolean
	 * @index
	 */
	protected $_deleted_at;
}