<?php
$I = new AcceptanceTester( $scenario );

$I->wantTo( 'test form duplication' );

// Login to wp-admin
$I->loginAsAdmin();

$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms' );
$I->waitForText( '[ninja_form id=1]');

$I->click( 'div.nf-item-edit > a' );

$I->wait( 1 );

$I->click( 'Duplicate' );

$I->wait( 2 );

$I->waitForText( 'Contact Me - copy' );

$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=2' );

$I->waitForText( 'Form Fields' );

$I->see( 'Contact Me - copy' );

// TODO: Currently broken in core.
//$I->see( 'Name' );
//$I->see( 'Email' );
//$I->see( 'Message' );
//$I->see( 'Submit' );

$I->click( 'Emails & Actions' );

$I->see( 'Store Submission' );
$I->see( 'Email Confirmation' );
$I->see( 'Email Notification' );
$I->see( 'Success Message' );

$I->executeJS( 'jQuery( "tr:last-child" ).find( ".nf-edit-settings" ).click();' );

$I->see( 'Form submitted successfully.' );

$I->see( 'A confirmation email was sent to {field:email}.' );