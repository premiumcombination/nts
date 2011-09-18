<?php
/**
 * Description of TournamentModel
 * @author bulb 2011
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

