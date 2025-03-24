<?php
class Etudiants{
    public int $ID;
    public string $nom;
    private float $noteM;
    private float $noteInfo;
    private string $photo;

    public function __construct($ID,$nom,$noteM,$noteInfo,$photo){
        $this->ID=$ID;
        $this->nom=$nom;
        $this->noteM=$noteM;
        $this->noteInfo=$noteInfo;
        $this->photo=$photo;
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
        return $this->calculemoyenne()>=10? "<p id='V'>Votre admission a été retenue</p>" : "<p id='NV'>Votre admission n'a été retenue</p>" ;
    }

    public function __serialize(){
        return[
            "ID"=>$this->ID,
            "nom"=>$this->nom,
            "noteM"=>$this->noteM,
            "noteInfo"=>$this->noteInfo,
            "photo"=>$this->photo
        ];
    }

    public function __unserialize(array $tab){
        $this->ID=$tab['ID'];
        $this->nom=$tab['nom'];
        $this->noteM=$tab['noteM'];
        $this->noteInfo=$tab['noteInfo'];
        $this->photo=$tab['photo'];
    }

    public function toArray(){
        return [
            "ID"=>$this->ID,
            "nom"=>$this->nom,
            "noteM"=>$this->noteM,
            "noteInfo"=>$this->noteInfo,
            "photo"=>$this->photo
        ];
    }

}

?>