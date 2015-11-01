<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure homepage loads');
$I->amOnPage('/');
$I->see('Congratulations');
