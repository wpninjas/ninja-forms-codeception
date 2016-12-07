<?php
$I = new AcceptanceTester( $scenario );

// Login to wp-admin
$I->loginAsAdmin();

$I->wantTo( 'make sure required fields are working' );
$I->amOnPage( '/?nf_preview_form=1' );
$I->waitForElementVisible( '.nf-form-content', 30 );

$I->fillField( 'Email', 'me.net' );

$I->click( 'Submit' );
$I->wait( 1 );
$I->see( 'Please enter a valid email address!' );