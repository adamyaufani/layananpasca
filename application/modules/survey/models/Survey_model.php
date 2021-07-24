<?php
class Survey_model extends CI_Model
{
  public function index()
  {
    
  }
  // public function get_survey_by_id($id) {
  //   return $this->db->select('s.survey, sqi.question_text, sqiv.content')->from('surveys s')
  //   ->join('surveys_questionnaire_items sqi','s.id = sqi.survey_id','left')
  //   ->join('surveys_answers sa','sqi.id = sa.questionnaire_item_id','left')
  //   ->join('surveys_questionnaire_item_variants sqiv','sa.questionnaire_item_variant_id = sqiv.id','left')
  //   ->where(['s.id' => $id, 'sa.user_id' => 129])
  //   ->get()->result_array();
  // }

  public function get_survey($id_surat) {
    return $this->db->get_where('surveys',['surat_id' => $id_surat, 'user_id' => $_SESSION['user_id']])->row_array();
  }

  public function get_surveys() {
    return $this->db->query('select answer, count(answer) as juml_answer,  count(answer)/t.a*100 as persen, surveys_option.* from surveys 
    INNER JOIN surveys_option ON surveys.answer = surveys_option.id
    CROSS JOIN (SELECT COUNT(answer) AS a FROM surveys) t
    GROUP BY answer')->result_array();
  }
}
