<?php
namespace Civi\Api4;

/**
 * BankAccountReference entity.
 *
 * Provided by the CiviBanking extension.
 *
 * @package Civi\Api4
 */
class BankAccountReference extends Generic\DAOEntity {
  public static function permissions() {
    return [
      'meta' => ['access CiviCRM'],
      'default' => ['administer CiviCRM'],
      'get' => ['access CiviCRM'],
      'autocomplete' => ['access CiviCRM'],
    ];
  }

}
