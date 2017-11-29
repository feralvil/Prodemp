<h1><?php echo __('Nuevo suministro eléctrico de Emplazamiento de Telecomunicaciones'); ?></h1>
<?php
echo $this->Form->create('Suministro', array(
    'inputDefaults' => array('label' => false,'div' => false),
    'class' => 'form-horizontal'
));
?>
<fieldset>
    <legend><?php echo __('Emplazamiento');?></legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Suministro.emplazamiento_id', __('Emplazamiento'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.emplazamiento_id', array('options' => $emplazamientos, 'empty' => __('Seleccionar'), 'div' => 'col-sm-4 has-error', 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<fieldset>
    <legend><?php echo __('Titular y Proveedor del Suministro');?></legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Suministro.titular', __('Titular del Suministro'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.titular', array('options' => $titulares, 'empty' => __('Seleccionar'), 'div' => 'col-sm-4 has-error', 'class' => 'form-control'));
        echo $this->Form->label('Suministro.proveedor', __('Proveedor del Suministro'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.proveedor', array('options' => $proveedores, 'empty' => __('Seleccionar'), 'div' => 'col-sm-4', 'class' => 'form-control'));
        ?>
    </div>
</fieldset>
<fieldset>
    <legend><?php echo __('Datos del Suministro');?></legend>
    <div class="form-group">
        <?php
        echo $this->Form->label('Suministro.cups', __('CUPS'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.cups', array('div' => 'col-sm-6', 'class' => 'form-control'));
        echo $this->Form->label('Suministro.nreferencia', __('Nº Póliza / Ref. Contrato'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.nreferencia', array('div' => 'col-sm-2', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $this->Form->label('Suministro.dirsuministro', __('Dirección de Suministro'), array('class' => 'col-sm-3 control-label'));
        echo $this->Form->input('Suministro.dirsuministro', array('div' => 'col-sm-9', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $this->Form->label('Suministro.taracceso', __('Tarifa de Acceso (A)'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.taracceso', array('div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Suministro.potpunta', __('Pot. Punta'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.potpunta', array('div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Suministro.potacceso', __('Pot. Acceso'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.potacceso', array('div' => 'col-sm-2', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $this->Form->label('Suministro.potllano', __('Pot. Llano'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.potllano', array('div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Suministro.potvalle', __('Pot. Valle'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.potvalle', array('div' => 'col-sm-2', 'class' => 'form-control'));
        echo $this->Form->label('Suministro.expediente', __('Nº Expediente'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.expediente', array('div' => 'col-sm-2', 'class' => 'form-control'));
        ?>
    </div>
    <div class="form-group">
        <?php
        echo $this->Form->label('Suministro.notas', __('Observaciones'), array('class' => 'col-sm-2 control-label'));
        echo $this->Form->input('Suministro.notas', array('div' => 'col-sm-8', 'class' => 'form-control', 'rows' => 2));
        ?>
    </div>
    <div class="form-group text-center">
        <div class="btn-group" role="group" aria-label="...">
            <?php
            echo $this->Form->button(
            '<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span> &nbsp;' . __('Guardar Datos'),
            array('type' => 'submit', 'class' => 'btn btn-default', 'title' => __('Guardar Datos'), 'alt' => __('Guardar Datos'), 'escape' => false)
            );
            echo $this->Form->button(
            '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>  &nbsp;'.__('Cancelar Cambios'),
            array('type' => 'reset', 'class' => 'btn btn-default', 'title' => __('Cancelar Cambios'), 'alt' => __('Cancelar Cambios'), 'escape' => false)
            );
            echo $this->Html->Link(
                '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
                array('controller' => 'suministros', 'action' => 'index'),
                array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
            );
            ?>
        </div>
    </div>
</fieldset>
<?php
echo $this->Form->end();
?>
