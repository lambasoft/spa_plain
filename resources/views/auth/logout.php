<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 4/15/16
 * Time: 11:34 AM
 */
$User->logout($User->getSessionHash());
RedirectToURL("home");