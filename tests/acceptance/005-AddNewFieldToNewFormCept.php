<?php
$I = new AcceptanceTester( $scenario );

$I->wantTo( 'check that the builder drawer opens and fields are added' );

// Login to wp-admin
$I->loginAsAdmin();

$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=new' );
$I->waitForText( 'Single Checkbox' );
$I->click( '[data-id="checkbox"]' );
$I->waitForElement('.nf-field-wrap', 30); 