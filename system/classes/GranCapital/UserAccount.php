<?php

namespace GranCapital;

use HCStudio\Orm;

class UserAccount extends Orm {
  const DEFAULT_IMAGE = '../../src/img/user/user.png';
  protected $tblName  = 'user_account';

  public function __construct() {
    parent::__construct();
  }
}