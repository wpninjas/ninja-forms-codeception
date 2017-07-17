<?php
$I = new AcceptanceTester( $scenario );

$I->wantTo( 'make sure the date picker shows up properly' );
// Login to wp-admin
$I->loginAsAdmin();

$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=new' );

$I->waitForText( 'Date' );
$I->click( '[data-id="date"]' );
$I->waitForElement('#tmp-1', 30);

$I->click( '[data-id="submit"]' );
$I->waitForElement('#tmp-2', 30);

$I->click( '.nf-close-drawer' );
$I->wait(2);
$I->click( 'PUBLISH', '.nf-app-buttons span' );

$I->waitForElement( '#title' );
$I->wait( 2 );
$I->fillField( '#title', 'My New Form' );

$I->click( '.publish', '#nf-drawer' );
$I->waitForElement( '.preview' );
$I->waitForText( 'PUBLISH' );
$I->wait(2);
$I->click( '.preview' );
$I->wait(2);

$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});

$I->waitForElementVisible( '.nf-form-content', 30 );
$I->fillField( '.pikaday__display', '01/12/2017' );
$I->wait( 2 );
$I->seeElement( '.pika-single' );