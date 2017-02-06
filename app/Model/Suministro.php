<?php
/*
*  Modelo de Suministro
*/

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class Suministro extends AppModel {
    public $belongsTo = array(
        'Emplazamiento',
        'TitSuministro' => array(
            'className' => 'Entidad',
            'foreignKey' => 'titular'
        ),
        'ProvSuministro' => array(
            'className' => 'Entidad',
            'foreignKey' => 'proveedor'
        )
    );
    public $validate = array(
        'emplazamiento_id' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Debe seleccionar un emplazamiento'
            ),
            'unico' => array(
                'rule' => 'isUnique',
                'message' => 'Ya existe un suministro en dicho emplazamiento'
            )
        ),
        'titular' => array(
            'required' => array(
                'rule' => array('notBlank'),
                'message' => 'Debe seleccionar un titular'
            )
        )
    );
}
?>
