<?php

class Question_model extends MY_model {

    public function addQuestionary($quest_title, $quest_description, $quest_observation, $quest_criteria, $quest_segment, $quest_section, $quest_data, $quest_time, $quest_status, $quest_teacher, $quest_user) {
    
        $data = array(
            'quest_title' => $quest_title, 
            'quest_description' => $quest_description,
            'quest_observation' => $quest_observation,
            'quest_criteria' => $quest_criteria, 
            'quest_segment' => $quest_segment, 
            'quest_section' => $quest_section, 
            'quest_data' => $quest_data,
            'quest_time' => $quest_time,
            'quest_status' => $quest_status,
            'quest_teacher' => $quest_teacher,
            'quest_user' => $quest_user
        ); 

        return $this->db->insert('questionnaries',$data);
    }


    public function addQuestionaryDuplicated($quest_title, $quest_description, $quest_observation, $quest_criteria, $quest_segment, $quest_section, $quest_data, $quest_time, $quest_status, $quest_teacher, $quest_user) {
    
        $data = array(
            'quest_title' => $quest_title, 
            'quest_description' => $quest_description,
            'quest_observation' => $quest_observation,
            'quest_criteria' => $quest_criteria, 
            'quest_segment' => $quest_segment, 
            'quest_section' => $quest_section, 
            'quest_data' => $quest_data,
            'quest_time' => $quest_time,
            'quest_status' => $quest_status,
            'quest_teacher' => $quest_teacher,
            'quest_user' => $quest_user
        ); 

        $this->db->insert('questionnaries',$data);
        return $this->db->insert_id();
    }

    public function updateQuestionary($quest_title, $quest_description, $quest_observation, $quest_status,  $quest_id) {
        $this->db->where('id', $quest_id);

        $data = array(
            'quest_title' => $quest_title, 
            'quest_description' => $quest_description,
            'quest_observation' => $quest_observation,
            'quest_status' => $quest_status,
        ); 

        return $this->db->update('questionnaries',$data);

    }

    public function getQuestionnaires() {

            $this->db->order_by('id','desc');
        return $this->db->get('questionnaries')->result();

    }

    public function getQuestionary($id) {

        $this->db->where('id',$id);
        return $this->db->get('questionnaries')->row_array();

    }

    public function deleteQuestionary($quest_id) {
        $this->db->where('id', $quest_id);
        return $this->db->delete('questionnaries');
    }


    // Inicio Respostas
    public function addAnswers($quest_id, $quest_ask_title ) {
        $data = array(
            'quest_id' => $quest_id,
            'quest_answer_title' => $quest_ask_title,
        );

        return $this->db->insert('questionnaries_answer', $data);
    }

    public function getAnswers($quest_id) {

        $this->db->where('quest_id', $quest_id);
        $this->db->order_by('id','desc');

        return $this->db->get('questionnaries_answer')->result();
    }

    public function getAnswer($answer_id) {

        $this->db->where('id', $answer_id);
        return $this->db->get('questionnaries_answer')->row_array()['quest_answer_title'];
    }


    public function deleteAnswers($answer_id) {

        $this->db->where('id', $answer_id);
        return $this->db->delete('questionnaries_answer');

    }
    // Fim Respotas


     // Inicio Perguntas
     public function addAsks($quest_id, $quest_ask_title ) {
        $data = array(
            'quest_id' => $quest_id,
            'quest_ask_title' => $quest_ask_title,
        );

        return $this->db->insert('questionnaries_ask', $data);
    }

    public function getAsks($quest_id) {

        $this->db->where('quest_id', $quest_id);
        $this->db->order_by('id','desc');

        return $this->db->get('questionnaries_ask')->result();
    }


    public function deleteAsks($ask_id) {

        $this->db->where('id', $ask_id);
        return $this->db->delete('questionnaries_ask');

    }
    // Fim Perguntas









// Inicio Respondendo Perguntas

    public function answerGetQuestion($quest_id) {

        $this->db->where('quest_id', $quest_id);
        $this->db->order_by('id','desc');

        return $this->db->get('questionnaries_answer')->result();
    }

    public function answerGetAsks($quest_id) {

        $this->db->where('quest_id', $quest_id);
        $this->db->order_by('id','desc');

        return $this->db->get('questionnaries_ask')->result();
    }

    public function user_answer_check($quest_id, $quest_user) {

        $this->db->where('quest_id', $quest_id);
        $this->db->where('quest_user', $quest_user);

        return $this->db->get('questionnaries_user_answer_check')->row_array();

    }

    public function deleteQuestionaryCheck($quest_id) {
        $this->db->where('id', $quest_id);
        return $this->db->delete('questionnaries_user_answer_check');
    }

    public function searchQuestionnairesCheck($quest_criteria, $quest_segment, $quest_section, $quest_teacher = null) {

        $this->db->where('quest_criteria', $quest_criteria);
        $this->db->where('quest_segment', $quest_segment);
        $this->db->where('quest_section', $quest_section);
       
        if ($quest_teacher !== 0) {
            $this->db->where('quest_teacher', $quest_teacher);
        }

        return $this->db->get('questionnaries_user_answer_check')->result();

    }

    //Pega a resposta da pergunta
    public function user_answer_check_item($quest_id, $quest_ask_id, $quest_user) {

        $this->db->where('quest_id', $quest_id);
        $this->db->where('quest_user', $quest_user);
        $this->db->where('quest_ask_id', $quest_ask_id);

        return $this->db->get('questionnaries_user_answer_list')->row_array()['quest_answer_id'];

    }

    //Pega o texto da resposta da pergunta

    public function questionnaries_user_answer_check($quest_id, $quest_user, $quest_data, $quest_time, $quest_criteria, $quest_segment, $quest_section, $quest_teacher = null) {

        $data = array(
            'quest_id' => $quest_id,
            'quest_user' => $quest_user,
            'quest_data' => $quest_data,
            'quest_time' => $quest_time,
            'quest_criteria' =>$quest_criteria,
            'quest_segment' => $quest_segment,
            'quest_section' => $quest_section,
            'quest_teacher' => $quest_teacher


        );

        return $this->db->insert('questionnaries_user_answer_check', $data);

    }

    public function questionnaries_user_answer_list($quest_id, $quest_ask_id, $quest_answer_id, $quest_user) {

        $data = array(
            'quest_id' => $quest_id,
            'quest_user' => $quest_user,
            'quest_ask_id' => $quest_ask_id,
            'quest_answer_id' => $quest_answer_id,
        );

        return $this->db->insert('questionnaries_user_answer_list', $data);

    }

// Fim Respondendo Perguntas

























 public function class_teacher($teacher_id) {
    $this->db->where('staff_id', $teacher_id);
    return $this->db->get('class_teacher')->result();
 }





























	 public function add($data) {
		$this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('questions', $data);
			$message      = UPDATE_RECORD_CONSTANT." On  questions id ".$data['id'];
			$action       = "Update";
			$record_id    = $data['id'];
			$this->log($message, $record_id, $action);
			//======================Code End==============================

			$this->db->trans_complete(); # Completing transaction
			/*Optional*/

			if ($this->db->trans_status() === false) {
				# Something went wrong.
				$this->db->trans_rollback();
				return false;

			} else {
				//return $return_value;
			}
        } else {
            $this->db->insert('questions', $data);          
			$id=$this->db->insert_id();
			$message      = INSERT_RECORD_CONSTANT." On  questions id ".$id;
			$action       = "Insert";
			$record_id    = $id;
			$this->log($message, $record_id, $action);
			//echo $this->db->last_query();die;
			//======================Code End==============================

			$this->db->trans_complete(); # Completing transaction
			/*Optional*/

			if ($this->db->trans_status() === false) {
				# Something went wrong.
				$this->db->trans_rollback();
				return false;

			} else {
				//return $return_value;
			}
			return $id;
        }
    }

    public function get($id = null) {
        $this->db->select('questions.*,subjects.name')->from('questions');

        $this->db->join('subjects', 'subjects.id = questions.subject_id');
        if ($id != null) {
            $this->db->where('questions.id', $id);
        } else {
            $this->db->order_by('questions.id');
        }
        $query = $this->db->get();
        if ($id != null) {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    public function remove($id){
		$this->db->trans_start(); # Starting Transaction
        $this->db->trans_strict(false); # See Note 01. If you wish can remove as well
        //=======================Code Start===========================
        $this->db->where('id', $id);
        $this->db->delete('questions');
		$message      = DELETE_RECORD_CONSTANT." On questions id ".$id;
        $action       = "Delete";
        $record_id    = $id;
        $this->log($message, $record_id, $action);
		//======================Code End==============================
        $this->db->trans_complete(); # Completing transaction
        /*Optional*/
        if ($this->db->trans_status() === false) {
            # Something went wrong.
            $this->db->trans_rollback();
            return false;
        } else {
        //return $return_value;
        }
    }

    public function image_add($id,$image){

        $this->db->where('id', $id);
        $this->db->update('questions', $image);

    }

    public function add_option($data){
        if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('question_options', $data);
        } else {
            $this->db->insert('question_options', $data);
            return $this->db->insert_id();
        }
    }

    public function add_question_answers($data){
 if (isset($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('question_answers', $data);
        } else {
            $this->db->insert('question_answers', $data);
            return $this->db->insert_id();
        }
    }

    public function get_result($id){
        return $this->db->select('*')->from('questions')->join('question_answers','question.id=question_answers.question_id')->get()->row_array();

    }
    public function get_option($id){
        return $this->db->select('id,option')->from('question_options')->where('question_id',$id)->get()->result_array();
    }

    public function get_answer($id){
        return $this->db->select('option_id as answer_id')->from('question_answers')->where('question_id',$id)->get()->row_array();
    }
}