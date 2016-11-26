<?php
$I = new AcceptanceTester( $scenario );

// Login to wp-admin
$I->loginAsAdmin();

$I->wantTo( 'edit form title' );
$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=1' );
$I->waitForText( 'Advanced' );
$I->click( 'Advanced' );

$I->waitForText( 'Display Settings' );
$I->click( '.nf-setting-wrap:first-child' );

$I->waitForElement( '#title' );
$I->fillField( '#title', 'Swanky New Title' );
$I->click( '.nf-close-drawer' );

$I->waitForText( 'PUBLISH' );
$I->click( 'PUBLISH' );
$I->wait( '5' );
$I->waitForText( 'Swanky New Title' );
$I->click( '.preview' );
$I->wait(2);

$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});

$I->waitForElementVisible( '.nf-form-content', 30 );
$I->see( 'Swanky New Title' );