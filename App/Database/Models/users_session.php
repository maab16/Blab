<?php

namespace App\Database\Models;

use Blab\Libs\Model;

class Users_Session extends Model
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
	 * @type int
	 * @length 11
	 */
	protected $_user_id;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 100
	 */
	protected $_hash;
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
}