<?php
namespace Teknicode\Form;
class Input{
    private $attributes = array("class"=>"form-control");
    public $column=1;

    function __construct($column){
        $this->column=$column;
    }

    public function set(){
        if(func_num_args() == 2) {
            $key = func_get_arg(0);
            $value = func_get_arg(1);
            if ($key == "class") {
                $value = "form-control " . $value;
            }
            $this->attributes[$key] = $value;
        }else{
            foreach(func_get_args()[0] as  $key => $value){
                if($key == "class")$value = "form-control ".$value;
                $this->attributes[$key]=$value;
            }
        }
        return $this;
    }

    public function get($key){
        return $this->attributes[$key];
    }

    public function html(){
        $atts = '';
        $return = '<div class="form-group my-3">'.(!empty($this->attributes['label'])?'<label'.(!empty($this->attributes['id'])? ' for="'.$this->attributes['id'].'"':'').'>'.$this->attributes['label'].'</label>':'');

        unset($this->attributes['label']);
        foreach($this->attributes as $attribute => $value){
            if(!empty($this->attributes['type']) && $this->attributes['type']=="textarea" && ($attribute == "value" || $attribute == "type"))continue;
            $atts .= (!empty($html)?' ':'').$attribute.'="'.$value.'"';
        }

        if(!empty($this->attributes['type']) && $this->attributes['type'] == "textarea"){
            $return .= '<textarea '.$atts.'>'.$this->attributes['value'].'</textarea>';
        }else{
            $return .= '<input '.$atts.'/>';
        }


        $return .= '</div>';
        return $return;
    }

}