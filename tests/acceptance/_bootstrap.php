<?php
// Here you can initialize variables that will be available to your tests

/**
 * Function to log the user out of WordPress.
 * @param $I instanceof AcceptanceTester.
 */
function logOut( $I ) {
    $I->executeJS( 'jQuery("#wp-admin-bar-user-actions").parent().removeClass("ab-sub-wrapper");' );
    $I->click( '#wp-admin-bar-logout > a' );
    $I->wait( 2 );
}