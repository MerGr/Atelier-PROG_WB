<?php
class Etudiants{
    public string $nom;
    private float $noteM;
    private float $noteInfo;

    public function __construct($nom,$noteM,$noteInfo){
        $this->nom=$nom;
        $this->noteM=$noteM;
        $this->noteInfo=$noteInfo;
    }

    public function __get($name){
        return $this->$name;
    }


    public function __set($name,$value){
        $this->$name=$value;
    }
    public function calculemoyenne(){
        return ($this->noteM+$this->noteInfo)/2;
    }
    public function remarque(){
        return $this->calculemoyenne()>=10? "<td id='V'>Votre admission a été retenue</td>" : "<td id='NV'>Votre admission n'a été retenue</td>" ;
    }

    public function __serialize(){
        return[
            "nom"=>$this->nom,
            "noteM"=>$this->noteM,
            "noteInfo"=>$this->noteInfo
        ];
    }

    public function __unserialize(array $tab){
        $this->nom=$tab['nom'];
        $this->noteM=$tab['noteM'];
        $this->noteInfo=$tab['noteInfo'];
    }

    public function toArray(){
        return [
            "nom"=>$this->nom,
            "noteM"=>$this->noteM,
            "noteInfo"=>$this->noteInfo
        ];
    }

}

?>