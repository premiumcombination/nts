<?php
/**
 * Description of TournamentModel
 *
 * @author Petr Pruner
 */
class TournamentModel {
    
    private $pagination = 20;
    
    public function getTours() {
        
        $result = dibi::select('*')
                ->from('nts_tournaments')
                ->orderBy('date');
        
        return $result;
    }
}

?>
