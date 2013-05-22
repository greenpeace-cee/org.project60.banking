<?php
/*
+--------------------------------------------------------------------+
| CiviCRM version 4.3                                                |
+--------------------------------------------------------------------+
| Copyright CiviCRM LLC (c) 2004-2013                                |
+--------------------------------------------------------------------+
| This file is a part of CiviCRM.                                    |
|                                                                    |
| CiviCRM is free software; you can copy, modify, and distribute it  |
| under the terms of the GNU Affero General Public License           |
| Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
|                                                                    |
| CiviCRM is distributed in the hope that it will be useful, but     |
| WITHOUT ANY WARRANTY; without even the implied warranty of         |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
| See the GNU Affero General Public License for more details.        |
|                                                                    |
| You should have received a copy of the GNU Affero General Public   |
| License and the CiviCRM Licensing Exception along                  |
| with this program; if not, contact CiviCRM LLC                     |
| at info[AT]civicrm[DOT]org. If you have questions about the        |
| GNU Affero General Public License or the licensing of CiviCRM,     |
| see the CiviCRM license FAQ at http://civicrm.org/licensing        |
+--------------------------------------------------------------------+
*/
/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2013
 * $Id$
 *
 */
require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Banking_DAO_BankTransaction extends CRM_Core_DAO
{
  /**
   * static instance to hold the table name
   *
   * @var string
   * @static
   */
  static $_tableName = 'civicrm_bank_tx';
  /**
   * static instance to hold the field values
   *
   * @var array
   * @static
   */
  static $_fields = null;
  /**
   * static instance to hold the FK relationships
   *
   * @var string
   * @static
   */
  static $_links = null;
  /**
   * static instance to hold the values that can
   * be imported
   *
   * @var array
   * @static
   */
  static $_import = null;
  /**
   * static instance to hold the values that can
   * be exported
   *
   * @var array
   * @static
   */
  static $_export = null;
  /**
   * static value to see if we should log any modifications to
   * this table in the civicrm_log table
   *
   * @var boolean
   * @static
   */
  static $_log = true;
  /**
   * ID
   *
   * @var int unsigned
   */
  public $id;
  /**
   * The unique reference for this transaction
   *
   * @var string
   */
  public $bank_reference;
  /**
   * Value date for this bank transaction
   *
   * @var datetime
   */
  public $value_date;
  /**
   * Booking date for this bank transaction
   *
   * @var datetime
   */
  public $booking_date;
  /**
   * Transaction amount (positive or negative)
   *
   * @var float
   */
  public $amount;
  /**
   * Currency for the amount of the transaction
   *
   * @var string
   */
  public $currency;
  /**
   * Link to an option list
   *
   * @var int unsigned
   */
  public $type_id;
  /**
   * Link to an option list
   *
   * @var int unsigned
   */
  public $status_id;
  /**
   * The complete information received for this transaction
   *
   * @var text
   */
  public $data_raw;
  /**
   * A JSON-formatted array containing decoded fields
   *
   * @var text
   */
  public $data_parsed;
  /**
   * FK to bank_account of target account
   *
   * @var int unsigned
   */
  public $ba_id;
  /**
   * FK to bank_account of party account
   *
   * @var int unsigned
   */
  public $party_ba_id;
  /**
   * FK to parent bank_tx_batch
   *
   * @var int unsigned
   */
  public $tx_batch_id;
  /**
   * Numbering local to the tx_batch_id
   *
   * @var int unsigned
   */
  public $sequence;
  /**
   * class constructor
   *
   * @access public
   * @return civicrm_bank_tx
   */
  function __construct()
  {
    $this->__table = 'civicrm_bank_tx';
    parent::__construct();
  }
  /**
   * return foreign links
   *
   * @access public
   * @return array
   */
  function links()
  {
    if (!(self::$_links)) {
      self::$_links = array(
        'ba_id' => 'civicrm_bank_account:id',
        'party_ba_id' => 'civicrm_bank_account:id',
        'tx_batch_id' => 'civicrm_bank_tx_batch:id',
      );
    }
    return self::$_links;
  }
  /**
   * returns all the column names of this table
   *
   * @access public
   * @return array
   */
  static function &fields()
  {
    if (!(self::$_fields)) {
      self::$_fields = array(
        'id' => array(
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'required' => true,
          'export' => true,
          'where' => 'civicrm_bank_tx.id',
          'headerPattern' => '',
          'dataPattern' => '',
        ) ,
        'bank_reference' => array(
          'name' => 'bank_reference',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Unique Statement Reference') ,
          'required' => true,
          'maxlength' => 64,
          'size' => CRM_Utils_Type::BIG,
          'export' => true,
          'where' => 'civicrm_bank_tx.bank_reference',
          'headerPattern' => '',
          'dataPattern' => '',
        ) ,
        'value_date' => array(
          'name' => 'value_date',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => ts('Value date') ,
          'required' => true,
        ) ,
        'booking_date' => array(
          'name' => 'booking_date',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => ts('Booking date') ,
          'required' => true,
        ) ,
        'amount' => array(
          'name' => 'amount',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => ts('Transaction amount') ,
          'required' => true,
        ) ,
        'currency' => array(
          'name' => 'currency',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Currency') ,
          'maxlength' => 3,
          'size' => CRM_Utils_Type::FOUR,
        ) ,
        'type_id' => array(
          'name' => 'type_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Bank Transaction Type') ,
          'required' => true,
        ) ,
        'status_id' => array(
          'name' => 'status_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Bank Transaction Status') ,
          'required' => true,
        ) ,
        'data_raw' => array(
          'name' => 'data_raw',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Data Raw') ,
        ) ,
        'data_parsed' => array(
          'name' => 'data_parsed',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Data Parsed') ,
        ) ,
        'ba_id' => array(
          'name' => 'ba_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Bank Account ID') ,
          'FKClassName' => 'CRM_Banking_DAO_BankAccount',
        ) ,
        'party_ba_id' => array(
          'name' => 'party_ba_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Party Bank Account ID') ,
          'FKClassName' => 'CRM_Banking_DAO_BankAccount',
        ) ,
        'tx_batch_id' => array(
          'name' => 'tx_batch_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Bank Transaction Batch ID') ,
          'FKClassName' => 'CRM_Banking_DAO_BankTransactionBatch',
        ) ,
        'sequence' => array(
          'name' => 'sequence',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Sequence in statement') ,
        ) ,
      );
    }
    return self::$_fields;
  }
  /**
   * returns the names of this table
   *
   * @access public
   * @static
   * @return string
   */
  static function getTableName()
  {
    return self::$_tableName;
  }
  /**
   * returns if this table needs to be logged
   *
   * @access public
   * @return boolean
   */
  function getLog()
  {
    return self::$_log;
  }
  /**
   * returns the list of fields that can be imported
   *
   * @access public
   * return array
   * @static
   */
  static function &import($prefix = false)
  {
    if (!(self::$_import)) {
      self::$_import = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('import', $field)) {
          if ($prefix) {
            self::$_import['bank_tx'] = & $fields[$name];
          } else {
            self::$_import[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_import;
  }
  /**
   * returns the list of fields that can be exported
   *
   * @access public
   * return array
   * @static
   */
  static function &export($prefix = false)
  {
    if (!(self::$_export)) {
      self::$_export = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('export', $field)) {
          if ($prefix) {
            self::$_export['bank_tx'] = & $fields[$name];
          } else {
            self::$_export[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_export;
  }
}
