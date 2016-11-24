<?php
$I = new AcceptanceTester($scenario);
$I->am('user');
$I->wantTo('login to website');
$I->lookForwardTo('access all website features');
$I->amOnPage('/');
//codecept_debug($I);
$I->fillField('username','test');
$I->fillField('password','testtest');
$I->click('Connexion');
$I->see('test Profil');
