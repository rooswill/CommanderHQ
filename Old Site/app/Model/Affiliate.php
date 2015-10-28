<?php
App::uses('AppModel', 'Model');

class Affiliate extends AppModel 
{

    public function getAffiliate($id) 
    {
        $conditions = array(
            'conditions' => array(
                'id' => $id,
                'active' => 1
            )
        );

        $data = $this->find('all', $conditions);
        
        return $data;
    }

    public function getAffiliates($longitude = NULL, $latitude = NULL) {

        $start_latitude = $latitude - 1;
        $end_latitude = $latitude + 1;
        $start_longitude = $longitude - 1;
        $end_longituted = $longitude + 1;

        $conditions = array(
            'conditions' => array(
                'and' => array(
                    array(
                        'longitude <= ' => $start_longitude,
                        'longitude >= ' => $end_longituted,
                        'latitude <= ' => $start_latitude,
                        'latitude >= ' => $end_latitude
                    ),
                    'active' => 1
                )
            ),
            'order' => 'name'
        );
        
        $data = $this->find('all', $conditions);
        return $data;
    }
    
    public function getAffiliatesFromSearch($keyword) 
    {
        $conditions = array(
            'conditions' => array(
                'OR' => array(
                    'name LIKE' => '%'.$keyword.'%',
                    'city LIKE' => '%'.$keyword.'%',
                    'region LIKE' => '%'.$keyword.'%',
                ),
                'active' => 1
            ),
            'limit' => 50,
            'order' => 'name'
        );

        $data = $this->find('all', $conditions);

        // $log = $this->getDataSource()->getLog(false, false);
        // debug($log);

        // die();

        return $data;
    }
}