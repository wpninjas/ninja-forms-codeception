<?php
$I = new AcceptanceTester( $scenario );

$I->wantTo( 'create a new form, submit it, and verify the submission' );
// Login to wp-admin
$I->loginAsAdmin();

$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=new' );

$I->waitForText( 'First Name' );
$I->click( '[data-id="firstname"]' );
$I->waitForElement('#tmp-1', 30);

$I->click( '[data-id="lastname"]' );
$I->waitForElement('#tmp-2', 30);

$I->click( '[data-id="textarea"]' );
$I->waitForElement('#tmp-3', 30);

$I->click( '[data-id="submit"]' );
$I->waitForElement('#tmp-4', 30);

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
$I->fillField( 'First Name', 'Bob' );
$I->fillField( 'Last Name', 'Dylan' );
$I->fillField( 'Paragraph Text', 'Hey, Mr. Tambourine Man, play a song for me!' );
$I->click( 'Submit' );

$I->waitForText( 'Your form has been successfully submitted.' );

$I->amOnPage( '/wp-admin/edit.php?post_status=all&post_type=nf_sub&form_id=2&paged=1');
$I->see( 'Hey, Mr. Tambourine Man, play a song for me!' );