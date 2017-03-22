<?php
// Funciones JQuery:
$functab = "$('div[class*=\"pestanya\"]').addClass('hidden');";
$functab .= "$('ul li').removeClass('active');";
$functab .= "$(this).parent().addClass('active');";
$functab .= "var divshow = $(this).attr('id');";
$functab .= "$('div#' + $(this).attr('id')).removeClass('hidden');";
$this->Js->get("div#principal ul li a");
$this->Js->event('click', $functab);
?>
<h1><?php echo __('Entidad') . ' ' . $entidad['Entidad']['nombre']; ?></h1>
<div id="principal">
    <ul class="nav nav-tabs">
        <li role="presentation" class="active">
            <a href="#" id="info">
                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> <?php echo __('Información');?>
            </a>
        </li>
        <!--<li role="presentation">
            <a href="#" id="Contactos">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo __('Contactos');?>
            </a>
        </li>-->
    </ul>
    <div id="info" class="pestanya">
        <div class="col-md-12">
            <h2><?php echo __('Información de la Entidad');?></h2>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('CIF');?></th>
                    <th><?php echo __('Entidad');?></th>
                    <th><?php echo __('Acrónimo');?></th>
                    <th><?php echo __('Tipo');?></th>
                    <th><?php echo __('Web');?></th>
                    <th><?php echo __('Mail');?></th>
                </tr>
                <tr>
                    <td><?php echo $entidad['Entidad']['cif'];?></td>
                    <td><?php echo $entidad['Entidad']['nombre'];?></td>
                    <td><?php echo $entidad['Entidad']['acronimo'];?></td>
                    <td><?php echo $entidad['Enttipo']['tipo'];?></td>
                    <td><?php echo $entidad['Entidad']['web'];?></td>
                    <td><?php echo $entidad['Entidad']['mail'];?></td>
                </tr>
            </table>
            <h2><?php echo __('Ubicación de la Entidad');?></h2>
            <table class="table table-condensed table-hover table-striped">
                <tr>
                    <th><?php echo __('Domicilio');?></th>
                    <th><?php echo __('CP');?></th>
                    <th><?php echo __('Provincia');?></th>
                    <th><?php echo __('Municipio');?></th>
                    <th><?php echo __('Teléfono');?></th>
                    <th><?php echo __('Fax');?></th>
                </tr>
                <tr>
                    <td><?php echo $entidad['Entidad']['domicilio'];?></td>
                    <td><?php echo $entidad['Entidad']['codpostal'];?></td>
                    <td><?php echo $entidad['Entidad']['provincia'];?></td>
                    <td>
                        <?php
                        if ($entidad['Municipio']['nombre'] != NULL){
                            echo $entidad['Municipio']['nombre'];
                        }
                        else{
                            echo $entidad['Entidad']['municipio'];
                        }
                        ?>
                    </td>
                    <td><?php echo $entidad['Entidad']['telefono'];?></td>
                    <td><?php echo $entidad['Entidad']['fax'];?></td>
                </tr>
            </table>
        </div>
        <div class="row">
            <div class="form-group text-center">
                <div class="btn-group" role="group" aria-label="...">
                    <?php
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>' . ' ' . __('Modificar entidad'),
                        array('controller' => 'entidads', 'action' => 'editar', $entidad['Entidad']['id']),
                        array('class' => 'btn btn-default', 'title' => __('Modificar suministro'), 'alt' => __('Modificar suministro'), 'escape' => false)
                    );
                    echo $this->Form->postLink(
                        '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>' . ' ' . __('Borrar entidad'),
                        array('controller' => 'entidads', 'action' => 'borrar', $entidad['Entidad']['id']),
                        array('class' => 'btn btn-default', 'title' => __('Borrar entidad'), 'escape' => false),
                        '¿' . __('Seguro que desea eliminar la entidad') . ' ' . $entidad['Entidad']['nombre'] .'?'
                    );
                    echo $this->Html->Link(
                        '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>' . ' ' . __('Volver'),
                        array('controller' => 'entidads', 'action' => 'index'),
                        array('class' => 'btn btn-default', 'title' => __('Volver'), 'alt' => __('Volver'), 'escape' => false)
                    );
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!--
    <div id="Contactos" class="pestanya hidden">
        <div class="col-md-12">
            <h2></h2>
        </div>
    </div>
    -->
</div>
