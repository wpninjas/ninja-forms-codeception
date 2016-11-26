<?php
$I = new AcceptanceTester( $scenario );

// Login to wp-admin
$I->loginAsAdmin();

$I->wantTo( 'confirm that the builder loads properly' );
$I->amOnPage( '/wp-admin/admin.php?page=ninja-forms&form_id=new' );
$I->waitForText( 'Emails & Actions' );