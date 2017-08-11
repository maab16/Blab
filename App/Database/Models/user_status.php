<?php

namespace App\Database\Models;

use Blab\Libs\Model;

class User_Status extends Model
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
	protected $_status_id;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 100
	 */
	protected $_title;
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