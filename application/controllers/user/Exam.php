<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}   

class Exam extends Student_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('customlib');

    }


    public function index()
    {
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'exam/index');
        $data['title']      = 'Add Exam';
        $data['title_list'] = 'Exam List';
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {

        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
            );
            $this->exam_model->add($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Employee details added to Database!!!</div>');
            redirect('admin/exam/index');
        }
        $stuid              = $this->session->userdata('student');
        $stu_record         = $this->student_model->getRecentRecord($stuid['student_id']);
        $data['class_id']   = $stu_record['class_id'];
        $data['section_id'] = $stu_record['section_id'];
        $exam_result        = $this->examschedule_model->getExamByClassandSection($data['class_id'], $data['section_id']);
        $data['examlist']   = $exam_result;
        $this->load->view('layout/student/header', $data);
        $this->load->view('user/exam/examList', $data);
        $this->load->view('layout/student/footer', $data);
    }

    public function questionnaires() {
        // if (!$this->rbac->hasPrivilege('exam_group', 'can_view')) {
        //     access_denied();
        // }
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'questionnaires/questionnaires');

        $student_id            = $this->customlib->getStudentSessionUserID();
        $student_current_class = $this->customlib->getStudentCurrentClsSection();

        $student = $this->student_model->getStudentByClassSectionID($student_current_class->class_id, $student_current_class->section_id, $student_id);

        

        $quest_criteria = "classes";
        $quest_segment = $student['class_id'];
        $quest_section = $student['section_id'];
        
       

        $data = array(
            'questionnaires' => $this->question_model->searchQuestionnairesForStudents($quest_criteria, $quest_segment, $quest_section),
            'student' => $student,
        );

     
  

        $this->load->view('layout/student/header', $data);
        $this->load->view('user/questionnaires/questionnaires', $data);
        $this->load->view('layout/student/footer', $data);
    }





    public function answerGetQuestion() {

        $quest_id = htmlspecialchars($this->input->post('quest_id'));
        $data =  $this->question_model->answerGetQuestion($quest_id);

        if (count($data) == 0) {
            echo ' <center><div> <br><br><p> Nenhuma Resposta Cadastrada.</p> </div></center> ';
        } else {
            $count = 0;
            foreach($this->question_model->answerGetAsks($quest_id) as $p) {
                $count++;

                echo '
                <div class="row" style="border-bottom:1px solid #555 ;">
                <div class="col-md-9" style="padding:10px">
                    <small style="font-weight: bold;">PERGUNTA '.$count.'</small>
                    <p>'.$p->quest_ask_title.'</p>
                </div>
                <div class="col-md-3"   >
                                 
                    <select class="form-control " required style="margin-top:15px" name="answers[]" id="">
                        <option value="">SELECIONAR RESPOSTA</option> 
                    
                    ';

                        foreach ($this->question_model->answerGetQuestion($quest_id) as $a) {
                            echo '<option value="'.$a->id.'-'.$p->id.'">'.$a->quest_answer_title.'</option>';
                        }

                echo '</select>
                </div>
            </div>
                ';
            }

        }
    }

    public function answerGetQuestionView() {

        $quest_id = htmlspecialchars($this->input->post('quest_id'));
        $data =  $this->question_model->answerGetQuestion($quest_id);


        $student_id            = $this->customlib->getStudentSessionUserID();
        $student_current_class = $this->customlib->getStudentCurrentClsSection();

        $student = $this->student_model->getStudentByClassSectionID($student_current_class->class_id, $student_current_class->section_id, $student_id);

        $quest_user = $student['id'];


        if (count($data) == 0) {
            echo ' <center><div> <br><br> <p> Nenhuma Resposta Cadastrada.</p> </div></center> ';
        } else {
            $count = 0;
            foreach($this->question_model->answerGetAsks($quest_id) as $p) {
                $count++;

                echo '
                <div class="row" style="border-bottom:1px solid #555 ;">
                <div class="col-md-9" style="padding:10px">
                    <small style="font-weight: bold;">PERGUNTA '.$count.'</small>
                    <p>'.$p->quest_ask_title.'</p>
                </div>
                <div class="col-md-3"   >
                                 
                   
                    
                    ';

                   $answer_id =  $this->question_model->user_answer_check_item($quest_id, $p->id, $quest_user);

                   echo '<p style="margin-top:15px;font-weight:bold;text-align:center">'.$this->question_model->getAnswer($answer_id).'</p>';

                echo '
                </div>
            </div>
                ';
            }

        }

    }

    public function answerAddAnswerUser() {

        $quest_id = $this->input->post('quest_id');
        $answers = $this->input->post('answers[]');
        $quest_data = date('d-m-Y');
        $quest_time = date('H:i:s');
       

        $student_id            = $this->customlib->getStudentSessionUserID();
        $student_current_class = $this->customlib->getStudentCurrentClsSection();

        $student = $this->student_model->getStudentByClassSectionID($student_current_class->class_id, $student_current_class->section_id, $student_id);

        $quest_user = $student['id'];

        $quest_criteria = $this->input->post('quest_criteria');
        $quest_segment = $this->input->post('quest_segment');
        $quest_section = $this->input->post('quest_section');
        $quest_teacher = $this->input->post('quest_teacher');
        $quest_student = $student['id'];

        // Check
        $this->question_model->questionnaries_user_answer_check($quest_id, $quest_user, $quest_data, $quest_time, $quest_criteria, $quest_segment, $quest_section, $quest_teacher, $quest_student);

        foreach ($answers as $a ) {

            $r = explode("-", $a);
            $quest_ask_id = $r[1];
            $quest_answer_id = $r[0];

            $this->question_model->questionnaries_user_answer_list($quest_id, $quest_ask_id, $quest_answer_id, $quest_user);

          
        }

      
    }















    public function view($id)
    {
        $data['title'] = 'Exam List';
        $exam          = $this->exam_model->get($id);
        $data['exam']  = $exam;
        $this->load->view('layout/header', $data);
        $this->load->view('exam/examShow', $data);
        $this->load->view('layout/footer', $data);
    }

    public function getByFeecategory()
    {
        $feecategory_id = $this->input->get('feecategory_id');
        $data           = $this->feetype_model->getTypeByFeecategory($feecategory_id);
        echo json_encode($data);
    }

    public function getStudentCategoryFee()
    {
        $type     = $this->input->post('type');
        $class_id = $this->input->post('class_id');
        $data     = $this->exam_model->getTypeByFeecategory($type, $class_id);
        if (empty($data)) {
            $status = 'fail';
        } else {
            $status = 'success';
        }
        $array = array('status' => $status, 'data' => $data);
        echo json_encode($array);
    }

    public function delete($id)
    {
        $data['title'] = 'Exam List';
        $this->exam_model->remove($id);
        redirect('admin/exam/index');
    }

    public function create()
    {
        $data['title'] = 'Add Exam';
        $this->form_validation->set_rules('exam', 'Exam', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('exam/examCreate', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'exam' => $this->input->post('exam'),
                'note' => $this->input->post('note'),
            );
            $this->exam_model->add($data);
            $this->session->set_flashdata('msg', '<div exam="alert alert-success text-center">Employee details added to Database!!!</div>');
            redirect('exam/index');
        }
    }

    public function edit($id)
    {
        $data['title']      = 'Edit Exam';
        $data['id']         = $id;
        $exam               = $this->exam_model->get($id);
        $data['exam']       = $exam;
        $data['title_list'] = 'Exam List';
        $exam_result        = $this->exam_model->get();
        $data['examlist']   = $exam_result;
        $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/exam/examEdit', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $data = array(
                'id'   => $id,
                'name' => $this->input->post('name'),
                'note' => $this->input->post('note'),
            );
            $this->exam_model->add($data);
            $this->session->set_flashdata('msg', '<div exam="alert alert-success text-center">Employee details added to Database!!!</div>');
            redirect('admin/exam/index');
        }
    }

    public function examSearch()
    {
        $data['title'] = 'Search exam';
        if ($this->input->server('REQUEST_METHOD') == "POST") {
            $search = $this->input->post('search');
            if ($search == "search_filter") {
                $data['exp_title']  = 'exam Result From ' . $this->input->post('date_from') . " To " . $this->input->post('date_to');
                $date_from          = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_from')));
                $date_to            = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('date_to')));
                $resultList         = $this->exam_model->search("", $date_from, $date_to);
                $data['resultList'] = $resultList;
            } else {
                $data['exp_title']  = 'exam Result';
                $search_text        = $this->input->post('search_text');
                $resultList         = $this->exam_model->search($search_text, "", "");
                $data['resultList'] = $resultList;
            }
            $this->load->view('layout/header', $data);
            $this->load->view('admin/exam/examSearch', $data);
            $this->load->view('layout/footer', $data);
        } else {
            $this->load->view('layout/header', $data);
            $this->load->view('admin/exam/examSearch', $data);
            $this->load->view('layout/footer', $data);
        }
    }

    public function examresult()
    {
        $this->session->set_userdata('top_menu', 'Examinations');
        $this->session->set_userdata('sub_menu', 'examresult/index');
        $student_current_class = $this->customlib->getStudentCurrentClsSection();
        $student_session_id    = $student_current_class->student_session_id;
        $data['exam_result']   = $this->examgroupstudent_model->searchStudentExams($student_session_id, true,true);
        $data['exam_grade']    = $this->grade_model->getGradeDetails();

        $this->load->view('layout/student/header', $data);
        $this->load->view('user/examresult/index', $data);
        $this->load->view('layout/student/footer', $data);
    }

}
