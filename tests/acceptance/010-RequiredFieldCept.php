<?php
$I = new AcceptanceTester( $scenario );

// Login to wp-admin
$I->loginAsAdmin();

$I->wantTo( 'make sure required fields are working' );
$I->amOnPage( '/?nf_preview_form=1' );
$I->waitForElementVisible( '.nf-form-content', 30 );

$I->fillField( 'Name', 'Bob' );
$I->fillField( 'Name', '' );

$I->wait( 1 );
$I->see( 'This is a required field.' );