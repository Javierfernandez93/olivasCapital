<?php

namespace GranCapital;

use HCStudio\Orm;

class CatalogCommission extends Orm {
  protected $tblName  = 'catalog_commission';
  public static $COLOCATION = 1;
  public static $AMMOUNT = 2;
  public static $WEEK = 3;

  public function __construct() {
    parent::__construct();
  }
}