<?php
/**
 * @author bulb 2011
 * @package New Tournament System (NTS)
 * 
 * @name TournamentModel class
 */
class TournamentModel {
    
    public function getTours() {
        
        $result = dibi::select('*')
                ->from('nts_tournaments')
                ->orderBy('date');
        
        return $result;
    }
}

