<?php

namespace src\Form;

class SpectreForm extends Form
{
    /**
     * @param $html string Code HTML à entourer
     * @return string
     */

    protected function surround($html){
        return "<div class=\"form-group\">$html</div>";
    }

    protected function switchSurround($html){
        return "<div class=\"form-group switch-group\">$html</div>";
    }

    protected function surroundDefault($html){

        return $html;
    }

    protected function surroundBlock($html){
        return '<div class="form-group">' .$html .'</div>';
    }

    protected function surroundInput($html){

        return '<div class="form-group"><div class="input-field">' .$html .'</div></div>';
    }

    protected function surroundInputIcon($html){

        return '<div class="form-group ic-comp">' .$html .'</div>';
    }

    protected function surroundInline($html){

        return '<div class="form-group columns">' .$html .'</div>';
    }


    /**
     * @param string $name
     * @param string $label
     * @param $info
     * @return string
     */
    public function tailDatetime(string $name, string $label, $info = false)
    {
        $label = '<label class="form-label">' . $label .'</label>';
        $input = '<input type="text" name="'. $name .'" value="'.$this->getValue($name).'" class="form-input tail-datetime-field" />';
        if($info == true){
            $input.= '<small><i class="icofont-info-circle"></i> ' . $info . '</small>';
        }
        return $this->surroundInput($label . $input);
    }

    /**
     * TAGS
     * @param $name
     * @param bool $value
     * @return string
     */

    public function inputTag($name, $value = false){
        $label = '<label class="form-label" for=" '. $name . '">Tags</label>';

        $html = '<input id=" '. $name . '" name="' . $name . '" type="text" class="form-input" value="' . $value . '" />';

        return $this->surround($label . $html);
    }

    /**
     * COLORS
     */

    public function inputColor($name, $label){
        $label = '<label class="form-label"><i class="icofont-dotted-right"></i> ' . $label . '</label>';

        $html = '<input class="form-input jscolor" name="' . $name . '" type="text" value="' . $this->getValue($name) .  '" />';

        return $this->surround($label . $html);
    }



    /**
     * COLORS BLOCK
     */

    public function inputColorBlock($name, $label){
        $label = '<label class="form-label">' . $label . '</label>';

        $html = '<input class="form-input jscolor" name="' . $name . '" type="text" value="' . $this->getValue($name) .  '" />';

        return $this->surroundBlock($label . $html);
    }


    /**
     * Permet de générer un input <radio> en forme de switch
     *
     * @param $name
     * @param $label
     * @param bool $info
     * @return string
     */
    public function inputswitch($name, $label, $info = false){
        $label = '<div class="switch-inline columns"><label class="col-4 col-sm-12" style="line-height: 1.8;" for="'. $name .'">' . $label . '</label>';
        $switch = '<div class="switch col-8 col-sm-12 m-0">';
        $switch .= '<input type="radio" class="switch-input" name="'.$name.'" value="1" id="'. $name .'-yes"';
        if($this->getValue($name) == 1){ //Vérifie si ON
            $switch .= ' checked>'; //Check le input
        }else{
            $switch .= '>'; //Ferme le input
        }
        $switch .= '<label for="'. $name .'-yes" class="switch-label switch-label-off">Oui</label>';
        $switch .= '<input type="radio" class="switch-input" name="'.$name.'" value="0" id="'. $name .'-no"';
        if($this->getValue($name) == 0){ //Vérifie si ON
            $switch .= ' checked>'; //Check le input
        }else{
            $switch .= '>'; //Ferme le input
        }
        $switch .= '<label for="'. $name .'-no" class="switch-label switch-label-on">Non</label>';
        $switch .= '<span class="switch-selection"></span></div></div><small>' . $info . '</small>';

        return $this->surround($label . $switch);
    }

    /**
     * Switch checkbox
     * @param $name
     * @param $label
     * @param bool $value
     * @return string
     */

    public function checkbox($name, $label, $value = false){
        $checkbox = '<label for="'.$value.'" class="checkbox">' . $label . '';
        $checkbox .= '<input type="checkbox" name="'.$name.'" value="'.$value.'" id="'.$value.'" data-toggle="checkbox" class="custom-checkbox"';
        if($this->getValue($name)){
            $checkbox .= 'checked="checked">';
        }else{
            $checkbox .= '>';
        }
        $checkbox .= '<span class="icons"><span class="icon-unchecked"></span><span class="icon-checked"></span></span></label>';

        return $this->switchSurround($checkbox);
    }


    /**
     * @param $name string
     * @param $label
     * @param bool $value
     * @param $placeholder
     * @param bool $binding
     * @param array $option
     * @return string
     */

    public function inputEmpty($name, $label, $placeholder, $value = false, $binding = false, $option = []){
        $type = isset($option['type']) ? $option['type'] : 'text';
        if($label == false){
            $label = '';
        }else{
            if($binding == true){
                $label = '<label class="form-label" for="' . $name . '">' . $label . ' <span style="color:red">*</span></label>';
            } else {
                $label = '<label class="form-label" for="' . $name . '">' . $label . '</label>';
            }
        }
        if($type === 'textarea'){

            $input = '<textarea class="form-input" name="'. $name .'" placeholder="'.$placeholder.'"></textarea>';

        } else {

            $input = '<input class="form-input boxed" type="'. $type .'" name="'. $name .'" value="'. $value .'" placeholder="'.$placeholder.'">';
        }


        return $this->surroundBlock($label . $input);

    }


    /**
     * @param string $name
     * @param $label
     * @param $placeholder
     * @param false $info
     * @param bool $binding
     * @return string
     */
    public function inputAutoCompletOff($name, $label, $placeholder, $info = false, bool $binding = false){

        if($label == false){
            $label = '';
        }else{
            if($binding == true){
                $label = '<label class="form-label" for="' . $name . '">' . $label . ' <span style="color:red">*</span></label>';
            } else {
                $label = '<label class="form-label" for="' . $name . '">' . $label . '</label>';
            }
        }
            $input = '<input class="form-input underlined" type="text" id="'. $name .'" name="'. $name .'" value="' . $this->getValue($name) . '" placeholder="'.$placeholder.'" autocomplete="off">';
            $input .= '<small>' . $info .'</small>';

        return $this->surroundBlock($label . $input);

    }

    /**
     * @param $name string
     * @param $label
     * @param $placeholder
     * @param bool $info
     * @param array $option
     * @param bool $binding
     * @param bool $attr
     * @return string
     */

    public function input($name, $label, $placeholder, $info = false, $option = [], bool $binding = false, $attr = null){

        $type = isset($option['type']) ? $option['type'] : 'text';
        if($attr == true){
            $attr = 'autocomplete="off"';
        }
        if($label == false){
            $label = '';
        }else{
            if($binding == true){
                $label = '<label class="form-label" for="' . $name . '">' . $label . ' <span style="color:red">*</span></label>';
            } else {
                $label = '<label class="form-label" for="' . $name . '">' . $label . '</label>';
            }
        }
        if($type === 'textarea'){

            $input = '<textarea class="form-input" name="'. $name .'" placeholder="'.$placeholder.'">' . $this->getValue($name) . '</textarea>';
            $input .= '<small>' . $info . '</small>';

        } else {

            $input = '<input class="form-input underlined" type="'. $type .'" id="'. $name .'" name="'. $name .'" value="' . $this->getValue($name) . '" placeholder="'.$placeholder.'" '.$attr.' >';
            $input .= '<small>' . $info .'</small>';
        }


        return $this->surroundBlock($label . $input);

    }

    /**
     * @param $name string
     * @param $label
     * @param $icon
     * @param $placeholder
     * @param array $option
     * @param bool $info
     * @param null $mdeditor
     * @return string
     */

    public function inputWithIcon($name, $label, $icon, $placeholder, $option = [], $info = false, $mdeditor = null){
        $type = isset($option['type']) ? $option['type'] : 'text';
        if($label == false){
            $label = '';
        }else{
            $label = '<label class="form-label" for="' . $name . '">' . $label . '</label>';
        }
        $input = '<div class="form-ic-comp"><i class="icofont-'.$icon.'"></i></div><div class="input-st"><input class="form-input" type="'. $type .'" id="'. $name .'" name="'. $name .'" value="' . $this->getValue($name) . '" placeholder="'.$placeholder.'"></div>';
        $input .= '<small>' . $info . '</small>';


        return $this->surroundInputIcon($label . $input);

    }


    /**
     *
     * @param type $name
     * @param string $label
     * @param type $placeholder
     * @param type $option
     * @param type $mdeditor
     * @return type
     */
    public function inputBlock($name, $label, $placeholder, $option = [], $mdeditor = null, bool $binding = false){
        $type = isset($option['type']) ? $option['type'] : 'text';
        if($binding == true){
            $label = '<label class="form-label" for="' . $name . '">' . $label . ' <span style="color:red">*</span></label>';
        } else {
            $label = '<label class="form-label" for="' . $name . '">' . $label . '</label>';
        }
        if($type === 'textarea'){

            $input = '<textarea class="form-input" name="'. $name .'" placeholder="'.$placeholder.'">' . $this->getValue($name) . '</textarea>';

        } else {

            $input = '<input class="form-input" type="'. $type .'" id="'. $name .'" name="'. $name .'" value="' . $this->getValue($name) . '" placeholder="'.$placeholder.'">';
        }

        return $this->surroundBlock($label . $input);
    }

    /**
     *
     * @param type $name
     * @param type $placeholder
     * @return string
     */
    public function mdeditor($name, $placeholder){

        $textarea = '<textarea id="mdeditor" class="form-control" name="'. $name .'" placeholder="'.$placeholder.'">' . $this->getValue($name) . '</textarea>';

        return $textarea;
    }


    /**
     * @param $name
     * @param $label
     * @param bool $text
     * @return string
     */
    public function number($name, $label, $text = false){
        $label = '<label class="form-label">' . $label . '</label>';

        $html = '<input class="form-input" name="' . $name . '" type="number" value="' . $this->getValue($name) .  '" /><span style="display:block;margin-top:0.2em;font-style: italic;">'.$text.'</span>';

        return $this->surround($label . $html);
    }

    /**
     * Permet d'afficher le textarea
     * @param $name
     * @param string $label
     * @param string $placeholder
     * @param false $info
     * @return string
     */
    public function textareaDefault($name, string $label, string $placeholder, $info = false)
    {
        $label = '<label class="form-label">' . $label . '</label>';
        $input = '<textarea class="form-input" name="'. $name .'" placeholder="'.$placeholder.'">' . $this->getValue($name) . '</textarea>';
        $input .= '<small>' . $info . '</small>';

        return $this->surroundBlock($label . $input);
    }

    /**
     * Permet de générer un textarea
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param bool $info
     * @param bool $binding
     * @return mixed
     */
    public function textareaMde(string $name, string $label, string $placeholder, $info = false, bool $binding = false)
    {
        if($info == true){
            $info = '<small><i class="icofont-info-circle"></i> ' . $info . '</small>';
        }
        $input = '<textarea class="form-input area-mdeditor" name="'. $name .'" placeholder="'.$placeholder.'">' . $this->getValue($name) . '</textarea>';
        if($binding == true){
            $label = '<label class="form-label">' . $label . ' <span style="color:red">*</span></label>';
        } else {
            $label = '<label class="form-label">' . $label . '</label>';
        }

        return $this->surroundBlock($label . $info . $input);
    }

    /**
     * Permet de générer un textarea
     * @param string $name
     * @param string $label
     * @param string $placeholder
     * @param bool $info
     * @param bool $binding
     * @return mixed
     */
    public function textareaCk(string $name, string $label, string $placeholder, $info = false, bool $binding = false)
    {
        if($info == true){
            $info = '<small><i class="icofont-info-circle"></i> ' . $info . '</small>';
        }
        $input = '<textarea class="form-input area-ckeditor" name="'. $name .'" placeholder="'.$placeholder.'">' . $this->getValue($name) . '</textarea>';
        if($binding == true){
            $label = '<label class="form-label">' . $label . ' <span style="color:red">*</span></label>';
        } else {
            $label = '<label class="form-label">' . $label . '</label>';
        }

        return $this->surroundBlock($label . $info . $input);
    }

    /**
     * Permet de générer un <input> de type password
     * @param string $name
     * @param string $label
     * @return string
     */
    public function password(string $name, string $label)
    {
        $label = '<label class="form-label">' . $label . '</label>';
        $input = '<input type="password" class="form-input" value="'.$this->getValue($name).'" name="'. $name .'">';

        return $this->surroundBlock($label . $input);
    }

    /**
     * Permet de générer un <input> de type email
     * @param string $name
     * @param string $label
     * @return string
     */
    public function email(string $name, string $label, string $placeholder)
    {
        $label = '<label class="form-label">' . $label . '</label>';
        $input = '<input type="email" class="form-input underlined" value="'.$this->getValue($name).'" name="'. $name .'" placeholder="' . $placeholder .'">';

        return $this->surroundBlock($label . $input);
    }

    /** Permet de générer un <select> lié
     * @param $placeholder
     * @param $name
     * @param $label
     * @param $target
     * @param $source
     * @param $options
     * @return string
     */
    public function selectLinked($placeholder, $name, $label, $target, $source, $options){

        $label = '<label class="form-label">' . $label . '</label>';
        $input = '<select class="form-input browser-default linked-select" data-target="#'.$target.'" data-source="'.$source.'" name="' . $name . '">';
        $input .= '<option value="0">'.$placeholder.'</option>';

        foreach ($options as $k => $v) {
            $attributes = '';
            if($k == $this->getValue($name)){
                $attributes = ' selected';
            }
            $input .= "<option value='$k'$attributes>$v</option>";
        }

        $input .= '</select>';
        return $this->surroundInput($label . $input);

    }

    /** Permet de générer un <select>
     * @param $name
     * @param $label
     * @param $options
     * @param $value
     * @return string
     */
    public function selectWithValue($name, $label, $options, $value){

        if($label == false){
            $label = '';
        }else{
            $label = '<label class="form-label">' . $label . '</label>';
        }
        $input = '<select class="form-select" name="' . $name . '">';

        foreach ($options as $k => $v) {
            $attributes = '';
            if($k == $value){
                $attributes = ' selected';
            }
            $input .= "<option value='$k'$attributes>$v</option>";
        }

        $input .= '</select>';
        return $this->surround($label . $input);

    }

    /** Permet de générer un <select>
     * @param $name
     * @param $label
     * @param $options
     * @param $info
     * @return string
     */
    public function select($name, $label, $options, $info = false){

        if($label == false){
            $label = '';
        }else{
            $label = '<label class="form-label">' . $label . '</label>';
        }

        $input = '<select class="form-select" name="' . $name . '">';
        if($info == true){
            $info = '<small><i class="icofont-info-circle"></i> ' . $info . '</small>';
        }

        foreach ($options as $k => $v) {
            $attributes = '';
            if($k == $this->getValue($name)){
                $attributes = ' selected';
            }
            $input .= "<option value='$k'$attributes>$v</option>";
        }

        $input .= '</select>';
        return $this->surround($label . $input . $info);

    }

    /**
     * Retourne select Bootstrap Alert
     * @param string $label
     * @param type $name
     * @return type
     */

    public function selectAlertMessage($label, $name){

        $label = '<label class="col-md-3 col-xs-12 control-label">' . $label . '</label>';
        $input = '<div class="col-md-6 col-xs-12"><select class="form-control select" name="' . $name . '">';
        $input .= '<option value="danger">Danger</option>';
        $input .= '<option value="info">Info</option>';
        $input .= '<option value="warning">Warning</option>';
        $input .= '</select></div>';

        return $this->surround($label . $input);
    }



    /**
     * @param bool $name
     * @param string $type
     * @param int|NULL $id
     * @return string
     */
    public function submit(string $type, $name = false, int $id = NULL){

        if($name === false){$name = 'Confirmer';}
        return $this->surroundBlock('<button type="submit" name="'.$id.'" class="btn btn-'.$type.'"><i class="icofont-check-circled"></i> '.$name.'</button><div class="clear"></div>');

    }

    /**
     * @param $title
     * @param string $type
     * @param string $name
     * @return string
     */
    public function submitDefault($title, string $type, $name = false){

        if($title === false){$title = 'Confirmer';}
        return $this->surroundDefault('<button type="submit" name="'.$name.'" class="btn btn-'.$type.'"><i class="icofont-check-circled"></i> '.$title.'</button>');

    }

    /**
     * Retoune le bouton submit sans le contenaur Bootstrap
     * @param $type
     * @param bool $name
     * @param bool $fa
     * @return string
     */

    public function submitSingleWithIcon($type, $name = false, $fa = false){

        if($name === false){$name = 'Confirmer';}
        if($fa === false){$fa = 'check-circled';}
        return '<button type="submit" class="btn btn-'.$type.'"><i class="icofont-'.$fa.'"></i> '.$name.'</button>';

    }

    /**
     * Retoune le bouton submit sans le contenaur Bootstrap
     * @param $type
     * @param string $nameForm
     * @param bool $name
     * @param bool $fa
     * @return string
     */

    public function submitSingle($type, string $nameForm, $name = false, $fa = false){

        if($name === false){$name = 'Confirmer';}
        if($fa === false){$fa = 'check-circled';}
        return '<button type="submit" name="'.$nameForm.'" class="btn btn-'.$type.'"><i class="icofont-'.$fa.'"></i> '.$name.'</button>';

    }
}