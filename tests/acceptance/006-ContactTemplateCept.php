<?php
$I = new AcceptanceTester( $scenario );

$I->wantTo( 'check that form templates import correctly' );

// Login to wp-admin
$I->loginAsAdmin();

$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=new' );
$I->waitForElement( '.template-box', 30 );
$I->click( '.template-box' );
$I->waitForText('Contact Me', 30);