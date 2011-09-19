<?php

/**
 * @author bulb 2011
 * @package New Tournament System (NTS)
 * 
 * @name Access Control List (ACL) implementation
 */

class Acl extends Nette\Security\Permission {

    public function __construct() {

        // ROLES
        $this->addRole('guest');
        $this->addRole('admin', 'guest');
        $this->addRole('superadmin', 'admin');

        // RESOURCES
        $this->addResource('Default');
        $this->addResource('Tournament');
        $this->addResource('Sign');
        $this->addResource('Admin');
        $this->addResource('admincp');
        $this->addResource('comments');

        // PRIVILEGES
        // guest:
        $this->allow('guest', 'Default', 'default');
        $this->allow('guest', 'Tournament', 'default'); // view tournament brackets
        $this->allow('guest', 'Tournament', 'postForm-submit!');
        $this->allow('guest', 'Sign', array('in', 'signInForm-submit!')); // sign-in
        // admin:
        $this->allow('admin', 'Admin', 'default');
        $this->allow('admin', 'Tournament', array('add', 'addForm-submit!'));
        $this->allow('admin', 'Tournament', 'overview'); // tournament list
        $this->allow('admin', 'Tournament', 'edit'); // edit tournament
        $this->allow('admin', 'Sign', 'out');
        $this->deny('admin', 'Sign', array('in', 'signInForm-submit!'));
        // superadmin:
        $this->deny('superadmin', 'Sign', array('in', 'signInForm-submit!'));
    }

}