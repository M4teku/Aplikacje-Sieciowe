<?php
class Messages {
    private $errors = array();
    private $infos = array();
    private $num = 0;

    public function addError($text) {
        $this->errors[] = $text;
        $this->num++;
    }

    public function addInfo($text) {
        $this->infos[] = $text;
        $this->num++;
    }

    public function isEmpty() {
        return $this->num == 0;
    }

    public function isError() {
        return count($this->errors) > 0;
    }

    public function isInfo() {
        return count($this->infos) > 0;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getInfos() {
        return $this->infos;
    }

    public function clear() {
        $this->errors = array();
        $this->infos = array();
        $this->num = 0;
    }
}
?>