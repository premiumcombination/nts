<?php

/**
 * @author bulb 2011
 * @package New Tournament System (NTS)
 * 
 * @name SignPresenter
 */

use Nette\Application\UI,
 Nette\Security as NS;

class SignPresenter extends BasePresenter {

    /**
     * Sign in form component factory.
     * @return Nette\Application\UI\Form
     */
    protected function createComponentSignInForm() {
        $form = new UI\Form;
        $form->addText('username', 'Username:')
                ->setRequired('Please provide a username.');

        $form->addPassword('password', 'Password:')
                ->setRequired('Please provide a password.');

        $form->addCheckbox('remember', 'Remember me on this computer');

        $form->addSubmit('send', 'Sign in');

        $form->onSuccess[] = callback($this, 'signInFormSubmitted');
        return $form;
    }

    public function signInFormSubmitted($form) {
        try {
            $values = $form->getValues();
            if ($values->remember) {
                $this->getUser()->setExpiration('+ 14 days', FALSE);
            } else {
                $this->getUser()->setExpiration('+ 20 minutes', TRUE);
            }
            $this->getUser()->login($values->username, $values->password);
            $this->redirect('Admin:');
        } catch (NS\AuthenticationException $e) {
            //$form->addError($e->getMessage());
            $this->flashMessage($e->getMessage());
        }
    }

    public function actionOut() {
        $this->getUser()->logout();
        $this->flashMessage('You have been signed out.');
        $this->redirect('in');
    }

}
