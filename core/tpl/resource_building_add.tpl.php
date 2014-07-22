<?php


$langs->load('place@place');

print_titre($langs->trans('AddBuilding'));

$form = new Form($db);
if(!class_exists('FormPlace'))
	dol_include_once('/place/class/html.formplace.class.php');
$formplace = new FormPlace($db);

$out .= '<div class="tagtable centpercent border allwidth">';

$out .= '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
$out .= '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
$out .= '<input type="hidden" name="action" value="add_resource_building">';
$out .= '<input type="hidden" name="element" value="'.$element.'">';
$out .= '<input type="hidden" name="element_id" value="'.$element_id.'">';
$out .= '<input type="hidden" name="resource_type" value="'.$resource_type.'">';


// Place & Room
$out .= '<div class="nowrap">'.$langs->trans("Place").'</div>';
$out .= '<div>';
if (GETPOST('fk_resource_place','int') > 0)
{
	if(!class_exists('Place'))
		dol_include_once('/place/class/place.class.php');
	$room = new Place($db);
	$room->fetch(GETPOST('fk_resource_place','int'));
	$out .= $room->getNomUrl(1);
	$out .= '<input type="hidden" name="fk_resource_place" value="'.GETPOST('fk_resource_place','int').'">';
}
else
{
	$events=array();
	$events[]=array('method' => 'getBuildings', 'url' => dol_buildpath('/place/core/ajax/buildings.php',1), 'htmlname' => 'fk_resource_building', 'params' => array());
	$out .= $formplace->select_place_list('','fk_resource_place','',1,1,0,$events);
}

$out .= '</div>';
$out .= '<div>'.$langs->trans("Buildings").'</div>';
$out .= '<div>';
$out .= $formplace->selectbuildings(GETPOST('fk_resource_building','int'),GETPOST('fk_resource_building'),'fk_resource_building',1);
$out .= '</div>';

/*$out .= '<div><label>'.$langs->trans('Busy').'</label> '.$form->selectyesno('busy',$linked_resource['busy']?1:0,1).'</div>';
$out .= '<div><label>'.$langs->trans('Mandatory').'</label> '.$form->selectyesno('mandatory',$linked_resource['mandatory']?1:0,1).'</div>';*/
$out .= '<div>';
$out .='<input type="submit" id="add-resource-building" class="button" value="'.$langs->trans("Add").'"';
$out .=' />';
$out .='<input type="submit" name="cancel" class="button" value="'.$langs->trans("Cancel").'" />';

$out .= '</div>';

$dateurl='';
if (!empty($act->date_start)) {
	$dateurl='&datemonth='.dol_print_date($act->date_start,'%m').'&dateday='.dol_print_date($act->date_start,'%d').'&dateyear='.dol_print_date($act->date_start,'%Y');
}
print '<iframe seamless allow-scripts height="400px" width="100%" src="'.dol_buildpath('/resource/resource_planning.php',1).'?nomenu=1'.$dateurl.'"></iframe>';

$out .='</form>';
$out .= '</div>';

print $out;


