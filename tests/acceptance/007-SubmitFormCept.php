<?php
$I = new AcceptanceTester( $scenario );

// Login to wp-admin
$I->loginAsAdmin();

$I->wantTo( 'confirm that form submits properly' );

// Test the form while logged in.
$I->amOnPage( '/?nf_preview_form=1' );
$I->waitForElementVisible( '.nf-form-content', 30 );

$I->fillField( 'Name', 'Bob' );
$I->fillField( 'Email', 'me@me.net' );
$I->fillField( 'Message', 'Hey, Mr. Tambourine Man, play a song for me!' );

$I->click( 'Submit' );

$I->waitForText( 'Form submitted successfully.' );

// Test the form while logged out.
$I->amOnPage( '/wp-admin/post-new.php?post_type=page' );

$I->waitForText( 'Add New Page' );

$I->fillField( '#title', 'Submit Me' );
$I->click( '#content-html' );
$I->executeJS( 'jQuery( "#content" ).val( "[ninja_form id=1]" ).blur();' );

$I->click( '#publish' );

$I->waitForText( 'Page published.' );

logOut( $I );

$I->amOnPage( '/index.php/submit-me/' );
$I->waitForElementVisible( '.nf-form-content', 30 );

$I->fillField( 'Name', 'Bob' );
$I->fillField( 'Email', 'me@me.net' );
$I->fillField( 'Message', 'Hey, Mr. Tambourine Man, play a song for me!' );

$I->click( 'Submit' );

$I->waitForText( 'Form submitted successfully.' );