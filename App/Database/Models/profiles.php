<?php

namespace App\Database\Models;

use Blab\Libs\Model;

class Profiles extends Model
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
	protected $_fname;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 100
	 */
	protected $_lname;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 100
	 */
	protected $_gender;
	/**
	 * @column
	 * @readwrite
	 * @type text
	 */
	protected $_user_image;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 100
	 */
	protected $_birth_date;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 10 
	 */
	protected $_country_code;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 50
	 */
	protected $_city;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 50
	 */
	protected $_zip_code;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 50
	 */
	protected $_phone;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 50
	 */
	protected $_mobile;
	/**
	 * @column
	 * @readwrite
	 * @type text
	 */
	protected $_address;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 50
	 */
	protected $_company;
	/**
	 * @column
	 * @readwrite
	 * @type varchar
	 * @length 50
	 */
	protected $_website;
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