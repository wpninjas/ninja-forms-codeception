<?php
$I = new AcceptanceTester( $scenario );

$I->wantTo( 'test and verify a simple calculation' );
// Login to wp-admin
$I->loginAsAdmin();

$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=new' );

// Add three number fields for our calculation.
$I->wait( 2 );
$I->executeJS( "jQuery( '#nf-drawer' ).scrollTop( 600 );" );

$I->click( '[data-id="number"]' );
$I->waitForElement('#tmp-1', 30);

$I->click( '[data-id="number"]' );
$I->waitForElement('#tmp-2', 30);

$I->click( '[data-id="number"]' );
$I->waitForElement('#tmp-3', 30);

$I->click( '[data-id="html"]' );
$I->waitForElement('#tmp-4', 30);

$I->click( '[data-id="submit"]' );
$I->waitForElement('#tmp-5', 30);

$I->click( '[data-id="hidden"]' );
$I->waitForElement('#tmp-6', 30);

$I->executeJS( "jQuery( '#nf-drawer' ).scrollTop( 0 );" );
$I->wait( 1 );
$I->click( '.nf-close-drawer' );
$I->wait( 2 );

// Edit our field keys.
$I->click( '#tmp-1' );
$I->wait( 2 );
$I->executeJS( 'jQuery( "h3.toggle" ).each( function() {
	if( \'Administration\' == jQuery( this ).text() ) {
		jQuery( this ).click();
    }
});' );

$I->waitForElement( '#key' );
$I->fillField( '#key', 'number1' );

$I->click( '#tmp-2' );
$I->wait( 2 );
$I->waitForElement( '#key' );
$I->fillField( '#key', 'number2' );

$I->click( '#tmp-3' );
$I->wait( 2 );
$I->waitForElement( '#key' );
$I->fillField( '#key', 'number3' );

$I->click( '.nf-close-drawer' );
$I->wait( 2 );

// Add our calculation
$I->click( 'Advanced' );
$I->wait( 2 );

$I->waitForText( 'Calculations' );
$I->click( '.nf-setting-wrap.calculations' );

$I->wait( 2 );
$I->click( '.nf-add-new' );
$I->wait( 1 );
$I->fillField( '[data-id="name"]', 'calc_1' );
$I->fillField( '[data-id="eq"]', '{field:number1} + {field:number2} + {field:number3}' );
$I->click( '.nf-close-drawer' );

// Update our HTML field to show our calculation
$I->wait( 2 );
$I->click( 'Form Fields' );
$I->wait( 2 );
$I->click( '[data-id="tmp-4"]' );
$I->wait( 2 );
$I->executeJS( 'jQuery( "#default" ).val( "Total: {calc:calc_1}" ).change();' );
$I->wait( 2 );
$I->click( '.nf-close-drawer' );

// Update our hidden field's default value to the calc merge tag
$I->wait( 2 );
$I->click( '[data-id="tmp-6"]' );
$I->wait( 2 );
$I->fillField( '#default', '{calc:calc_1}' );
$I->wait( 2 );
$I->click( '.nf-close-drawer' );

// Update our success message action to include our calc merge tag
$I->wait( 1 );
$I->click( 'Emails & Actions' );
$I->executeJS( 'jQuery( "tr:first-child" ).find( ".nf-edit-settings" ).click();' );
$I->wait( 1 );
$I->executeJS( 'jQuery( "#success_msg" ).val( "Your form has been successfully submitted. Total: {calc:calc_1}" ).change();' );
$I->click( '.nf-close-drawer' );

// Publish our form
$I->wait( 2 );
$I->click( 'PUBLISH' );
$I->wait( 2 );

$I->waitForElement( '#title' );
$I->fillField( '#title', 'My New Form' );

$I->click( '.publish', '#nf-drawer' );
$I->waitForElement( '.preview' );
$I->waitForText( 'PUBLISH' );
$I->wait(2);

// Preview the form
$I->click( '.preview' );
$I->wait( 2 );

$I->executeInSelenium(function (\Facebook\WebDriver\Remote\RemoteWebDriver $webdriver) {
     $handles=$webdriver->getWindowHandles();
     $last_window = end($handles);
     $webdriver->switchTo()->window($last_window);
});

// Make sure that our total is 15
$I->waitForElementVisible( '.nf-form-content', 30 );
$I->fillField( '#nf-field-5', '5' );
$I->fillField( '#nf-field-6', '5' );
$I->fillField( '#nf-field-7', '5' );
$I->executeJS( 'jQuery( "#nf-field-7" ).blur();' );
$I->wait( 1 );

// Check our JS total
$I->see( 'Total: 15.00' );
$I->click( 'Submit' );

// Submit our form and check that our success message has the correct total.
$I->waitForText( 'Your form has been successfully submitted.' );
$I->see( 'Total: 15.00' );

$I->amOnPage( '/wp-admin/edit.php?post_status=all&post_type=nf_sub&form_id=2&paged=1');
$I->executeJS( 'jQuery( ".row-actions" ).removeClass( "row-actions" );' );
$I->click( "span.edit > a" );
$I->wait( 2 );
$I->seeInField( '[name="fields[10]"]', '15.00' );