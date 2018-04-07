<?php
namespace Teknicode\Form;
class Form{
    private $inputs=[];
    private $form;
    private $layout;

    public function open(){
        $args=func_get_args()[0];
        $html = '<form action="'.(empty($args['action'])? $_SERVER['REQUEST_URI'] : $args['action']).'" method="'.(empty($args['method'])? "post" : $args['method']).'" ';
        foreach( $args as $key => $value ){
            if($key == "class")$value = "row ".$value;
            if(!in_array($key,["action","method"])){
                $html .= $key.'="'.$value.'"';
            }
        }
        $html .= '>';
        $this->form = $html;
    }

    public function layout($columns){
        if(!isset($this->layout)){
            $this->layout = new Layout($columns);
        }
        return $this->layout;
    }

    public function input($column=1){
        $i = new Input($column);
        $this->inputs[]=$i;
        return $i;
    }

    public function select($column=1){
        $i = new Select($column);
        $this->inputs[]=$i;
        return $i;
    }

    public function button(){
        return new Button();
    }

    public function html(){
        $this->compile();

        $this->form .= '</form>';

        return $this->form;
    }

    private function compile(){
        $row_size = floor(12/$this->layout->columns());
        for($i=1;$i<=$this->layout->columns();$i++){
            $this->form .= '<div class="col-md-'.$row_size.'">';
            foreach($this->inputs as $input){
                if($input->column == $i)$this->form .= $input->html();
            }
            $this->form .= '</div>';
        }
    }
}