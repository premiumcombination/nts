<?php

use Nette\Application\UI\Form;

class TournamentPresenter extends BasePresenter {

    private $slots = array(
        "4" => 4,
        "8" => 8,
        "16" => 16,
        "32" => 32,
        "64" => 64,
        "128" => 128
    );
    private $elim = array(
        1 => "single",
        2 => "double"
    );
    private $races = array(
        1 => "human",
        2 => "orc",
        4 => "undead",
        8 => "night elf"
    );
    private $mode = array(
        1 => "1v1",
        2 => "2v2",
        3 => "3v3"
    );
    private $type = array(
        "instant" => "instant",
        "standard" => "standard",
        "kift" => "kift"
    );

    public function renderDefault() {

        $this->template->random = array(
            'DJUKASUPESTAR',
            'In.My.Control',
            '[Flower]',
            'GNEV',
            'desserttov',
            'GloBer',
            'Scr3amofhe11',
            'Spork',
            'Finished.',
            'cen',
            'efko.wbs',
            'kow3.friend',
            'mothernatureson',
            'TryImprove',
            'armontiricksyks',
            'CRO_maniac',
            'OrangeFury',
            '4k.Peace',
            'bulbe',
            'Sporksfan.pero',
            'DesArthes'
        );
        $this->template->dump = $this;
    }

    protected function createComponentPostForm() {

        $form = new Form;
        $form->setMethod('GET');
        $form->addSelect('slots', 'Slots:', $this->slots)
                ->setPrompt('Set number of slots...');
        $form->addRadioList('elim', 'Elimination:', $this->elim);
        $form->addSubmit('send', 'Generate');
        $form->onSuccess[] = callback($this, 'postFormSubmitted');

        return $form;
    }

    public function postFormSubmitted(Form $form) {

        $values = $form->getValues();
        $slots = $values->slots;
        $this->template->formValues = $form->getValues();
        // number of slots
        $this->template->slots = $slots;
        // values from submitted form
        $this->template->values = $values;
        // number of columns in the final bracket table
        $this->template->width = 2 * log($slots, 2) + 1;
        // number of rows
        $this->template->height = 2 * $slots - 1;
        // defining each field in the bracket table, recursion (see app/tools/brackets.php)
        Brackets::single($arr, 2 * $slots / 2 - 1, 2 * log($slots, 2));
        $this->template->brackets = $arr;
    }

    protected function createComponentAddForm() {

        $form = new Form;
        $form->addSelect('slots', 'Slots:', $this->slots);
        $form->addSelect('elim', 'Elimination:', $this->elim);
        $form->addSelect('races', 'Race:', $this->races);
        $form->addSelect('mode', 'Mode:', $this->mode);
        $form->addSelect('type', 'Type:', $this->type);
        $form->addSubmit('send', 'Create Tournament');
        $form->onSuccess[] = callback($this, 'addFormSubmitted');
        return $form;
    }

    public function addFormSubmitted(Form $form) {

        $values = ($form->getValues());
        $data['races'] = $values['races'];
        $data['slots'] = $values['slots'];
        $data['elim'] = $values['elim'];
        $data['creator'] = $this->user->getIdentity()->username;
        $data['view'] = true;
        $data['state'] = 'scheduled';
        $data['mode'] = $values['mode'];
        $data['type'] = $values['type'];
        $data['date'] = date('Y-m-d H:i:s');
        dibi::query('INSERT INTO [nts_tournaments]', $data);
        $this->flashMessage('Tournament has been successfully created.');
        $this->redirect('Admin:');
    }

    public function renderOverview() {
        
        $tour = new TournamentModel;
        
        foreach($tour->getTours() as $row) {
            dump($row);
        }

        $result = dibi::query('SELECT * FROM [nts_tournaments] WHERE [state]<>"completed" ORDER BY date DESC');
        $this->template->running = $result; // +scheduled
        $this->template->completed = dibi::query('SELECT * FROM [nts_tournaments] WHERE [state]="completed" ORDER BY date DESC');
    }

    public function renderEdit($id) {
        echo $id;
    }

}
