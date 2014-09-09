<?php
/* All model from sarung database will follow this class , so that we just change
  change here to impact to another class
*/
class Sarung_Model_Root extends Eloquent{
	protected $connection = 'fusarung';
}
