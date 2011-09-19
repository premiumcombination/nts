<?php

/** 
 * @author bulb 2011
 * @package New Tournament System (NTS)
 * 
 * @name BasePresenter
 * - 
 */

use Nette\Http\User;

abstract class BasePresenter extends Nette\Application\UI\Presenter {

    /**
     * controls user privileges for actions + signals
     * user privileges are defined in app/models/Acl.php
     */
    protected function startup() {

        parent::startup();
        $user = $this->user;

        // user logged out due his inactivity?
        if (!$user->loggedIn && $user->logoutReason === User::INACTIVITY && $this->action !== 'logout') {
            $user->logout(TRUE); // clear the identity
            $this->flashMessage('You were automatically logged out due to your inactivity.');
            $this->redirect('Default:');
        }

        // checking persmission for current <presenter>/<action> or <presenter>/<signal>
        elseif (!$user->isAllowed($this->name, $this->action)
                || ($this->signal !== NULL && !$user->isAllowed($this->name, $this->formatSignalString()))) {
            if (!$user->loggedIn) {
                $this->flashMessage('You do not have access for this operation. (' . $user->getLogoutReason() . ')');
                $user->logout(TRUE); // clear the identity

                $backlink = $this->application->storeRequest();
                $this->redirect('Default:', array(
                    'backlink' => $backlink,
                ));
            } else {
                $this->flashMessage('You\'re not permitted for this operation!', 'fail');
                $this->redirect('Default:');
            }
        }
    }

    // get the signal's name
    protected function formatSignalString() {
        return $this->signal === NULL ? NULL : ltrim(implode('-', $this->signal), '-') . '!';
    }

}
