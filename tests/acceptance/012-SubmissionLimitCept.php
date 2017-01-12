<?php
$I = new AcceptanceTester( $scenario );

// Login to wp-admin
$I->loginAsAdmin();

$I->wantTo( 'edit form title' );
$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=1' );
$I->waitForText( 'Advanced' );
$I->click( 'Advanced' );

$I->waitForText( 'Restrictions' );
$I->click( '.nf-setting-wrap.restrictions' );

$I->waitForElement( '#sub_limit_number' );
$I->fillField( '#sub_limit_number', '1' );
$I->executeJS( 'jQuery( "#sub_limit_msg" ).val( "LIMIT BREAK!" ).change();' );
$I->wait( 2 );
$I->click( '.nf-close-drawer' );

$I->wait( 2 );

$I->waitForText( 'PUBLISH' );
$I->click( 'PUBLISH' );
$I->wait( 2 );
$I->click( '.preview' );
$I->wait( 2 );

$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});

$I->waitForElementVisible( '.nf-form-content', 30 );

$I->fillField( 'Name', 'Bob' );
$I->fillField( 'Email', 'me@me.net' );
$I->fillField( 'Message', 'Hey, Mr. Tambourine Man, play a song for me!' );

$I->click( 'Submit' );

$I->waitForText( 'Form submitted successfully.' );

$I->amOnPage( '/wp-admin' );
$I->amOnPage( '/?nf_preview_form=1' );
$I->wait( 10 );
$I->see( 'LIMIT BREAK!' );