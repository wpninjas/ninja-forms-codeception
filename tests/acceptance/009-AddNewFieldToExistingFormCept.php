<?php
$I = new AcceptanceTester( $scenario );

// Login to wp-admin
$I->loginAsAdmin();

$I->wantTo( 'add field to existing form' );
// Make sure we're on our contact form.
$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=1' );
// Make sure we're on the fields domain.
$I->waitForText( 'Form Fields' );
// Add a new field
$I->click( '.nf-master-control' );
$I->waitForText( 'Single Checkbox' );
$I->click( '[data-id="checkbox"]' );
// Edit our field label
$I->waitForText( 'Single Checkbox' );
$I->click( '.nf-field-wrap:last-child' );
$I->waitForElement( '#label' );
$I->fillField( '#label', 'Agree?' );
$I->click( '.nf-close-drawer' );

// Preview the form and make sure that our label showed up.
$I->wait( 2 );
$I->click( '.preview' );
$I->wait( 2 );

$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});

$I->waitForElementVisible( '.nf-form-content', 30 );
$I->see( 'Agree?' );