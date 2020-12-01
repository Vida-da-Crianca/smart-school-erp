<?php 

namespace Application\Core;

class JsonResponse
{
    public $status;
    public $message;
    public $data = [];
    public $statusCode;
    public $result;
    
    public function __construct(array $data = [], $status = 200)
    {
        //$this->status = $status;
        // $this->message = $message;
        //$this->data = $data;
        $ci =& get_instance();
		$ci->output->set_content_type('application/json');
        // $this->result = array(
        //   'status' => $this->status
        // );
        $ci->output->set_status_header($status);
		$ci->output->set_output(json_encode($data));
       
    }
    
    /**
     * Format user message with HTTP status and status code
     *
     * @return string, json object
     */
    public function response()
    {
        $statusCode = $this->status;
        
        //set the HTTP response code
        switch ($this->status)
        {
            case "unauthorized":
                $statusCode = 401;
                break;
            case "exception":
                $statusCode = 500;
                break;
        }
        
        //set the response header
        header("Content-Type", "application/json");
        header(sprintf('HTTP/1.1 %s %s', $statusCode, $this->status), true, $statusCode);
        return json_encode($this->data);
    }
}