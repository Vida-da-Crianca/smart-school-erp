class Questionnaires_model extends MY_model {



    public function addQuestionary($quest_title, $quest_description, $quest_observation, $quest_criteria, $quest_segment, $quest_section, $quest_data, $quest_time, $quest_status) {
    
        $data = array(
            'quest_title' => $quest_title, 
            'quest_description' => $quest_description,
            'quest_observation' => $quest_observation,
            'quest_criteria' => $quest_criteria, 
            'quest_segment' => $quest_segment, 
            'quest_section' => $quest_section, 
            'quest_data' => $quest_data,
            'quest_status' => $quest_status
        ); 

        return $this->db->insert($dat);
    }
}

}