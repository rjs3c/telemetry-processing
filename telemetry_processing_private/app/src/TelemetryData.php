<?php


namespace TelemProc;


class TelemetryData
{

    private $sender_number;
    private $sender_group;
    private $switch_one;
    private $switch_two;
    private $switch_three;
    private $switch_four;
    private $fan;
    private $temperature;
    private $keypad;
    private $timestamp;


    public function __construct()
    {

    }

    public function __destruct()
    {

    }

    public function setSenderNumber($sender_number){
        $this->sender_number = $sender_number;
    }

    public function getSenderNumber() : int{
        return $this->sender_number;
    }


    public function setSenderGroup($sender_group){
        $this->sender_group = $sender_group;
    }

    public function getSenderGroup() : string{
        return $this->sender_group;
    }

    public function setSwitchOne($switch_one){
        $this->switch_one = $switch_one;
    }

    public function getSwitchOne() : bool{
        return $this->switch_one;
    }

    public function setSwitchTwo($switch_two){
        $this->switch_two = $switch_two;
    }

    public function getSwitchTwo() : bool{
        return $this->switch_two;
    }

    public function setSwitchThree($switch_three){
        $this->switch_three = $switch_three;
    }

    public function getSwitchThree() : bool{
        return $this->switch_three;
    }

    public function setSwitchFour($switch_four){
        $this->switch_four = $switch_four;
    }

    public function getSwitchFour() : bool{
        return $this->switch_four;
    }

    public function setFan($fan){
        $this->fan = $fan;
    }

    public function getFan() : bool{
        return $this->fan;
    }

    public function setTemperature($temperature){
        $this->temperature = $temperature;
    }

    public function getTemperature() : float{
        return $this->temperature;
    }

    public function setKeypad($keypad){
        $this->keypad = $keypad;
    }

    public function getKeypad() : int{
        return $this->keypad;
    }
    public function setTimestamp($timestamp){
        $this->timestamp = $timestamp;
    }

    public function getTimeStamp() : string{
        return $this->timestamp;
    }

}