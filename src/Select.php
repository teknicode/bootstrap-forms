<?php
namespace Teknicode\Form;
class Select{
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
        $html = '';

        $return = '<div class="form-group my-3">'.(!empty($this->attributes['label'])?'<label'.(!empty($this->attributes['id'])? ' for="'.$this->attributes['id'].'"':'').'>'.$this->attributes['label'].'</label>':'');

        unset($this->attributes['label']);
        foreach($this->attributes as $attribute => $value){
            if($attribute!="options"){
                $html .= (!empty($html)?' ':'').$attribute.'="'.$value.'"';
            }
        }

        $return .= '<select '.$html.'>';
        $group_open = false;
        foreach($this->attributes['options'] as $value => $label){
            if($label == "--group--"){
                $return .= ($group_open == true ? '</optgroup>' : '').'<optgroup label="'.$value.'">';
                $group_open=true;
            }else {
                $return .= '<option value="' . $value . '"'.($value == $this->attributes['value'] ? ' selected="selected"' : '').'>' . $label . '</option>';
            }
        }
        $return .= '</select>
        </div>';
        return $return;
    }
}