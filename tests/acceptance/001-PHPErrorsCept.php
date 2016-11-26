<?php
$I = new AcceptanceTester( $scenario );

$I->wantTo( 'check for PHP errors and notices' );

// Login to wp-admin
$I->loginAsAdmin();

$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=new' );
$I->dontSeeInSource( '<b>Notice</b>:' );
$I->dontSeeInSource( '<b>Warning</b>:' );

$I->amOnPage( '/wp-admin' );
$I->dontSeeInSource( '<b>Notice</b>:' );
$I->dontSeeInSource( '<b>Warning</b>:' );

$I->amOnPage( '/' );
$I->dontSeeInSource( '<b>Notice</b>:' );
$I->dontSeeInSource( '<b>Warning</b>:' );