<?php

use Nette\Http\User;

abstract class BasePresenter extends Nette\Application\UI\Presenter {

    /**
     * @brief controls user privileges for actions + signals
     */
    protected function startup() {

        parent::startup();
        $user = $this->user;

        if (!$user->loggedIn && $user->logoutReason === User::INACTIVITY && $this->action !== 'logout') { // just inform the user about the logout
            $user->logout(TRUE); // clear the identity
            $this->flashMessage('You were automatically logged out due to your inactivity.');
            $this->redirect('Default:');
        }

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

    protected function formatSignalString() {
        return $this->signal === NULL ? NULL : ltrim(implode('-', $this->signal), '-') . '!';
    }

}
