<?php

namespace src\Form;

class Form
{

    protected $data;
    public $surround = 'p';


    /**
     * @param array $data Données utilisées par le formulaire
     */
    public function __construct($data){
        $this->data = $data;
    }


    /**
     * @param $html string Code HTML à entourer
     * @return string
     */
    protected function surround($html){
        return "<{$this->surround}>$html</{$this->surround}>";
    }


    /**
     * @param $index string
     * @return string
     */
    protected function getValue($index){
        if(is_object($this->data)){
            return $this->data->$index;
        }
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    /**
     * @param $index string
     * @return string
     */
    protected function getValueImplode($index){
        if(is_object($this->data)){
            return implode(', ', $this->data->$index);
        }
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }


    /**
     * @param $name string
     * @param $label
     * @param array $option
     * @return string
     */
    public function input($name, $label, $placeholder, $option = [], $mdeditor = null){
        $type = isset($option['type']) ? $option['type'] : 'text';
        return $this->surround(
            '<input type="' . $type . '" name="'. $name .'" value="' . $this->getValue($name) . '">'
        );
    }

    public function date(){
        return new \DateTime();
    }

}