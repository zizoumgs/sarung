<?php
/**
 *this will be model for save id table which will be used when you delete or add item into database
CREATE TABLE IF NOT EXISTS `saveid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `namatable` varchar(20) NOT NULL,
  `idtable` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `namatable` (`namatable`,`idtable`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
**/
class SaveId extends Eloquent{
    //! we are no need to use table created_at and update_at for this table
    public $timestamps = false;
    protected $table = 'saveid';
    /**
     *  this will be find table whose name is @nama_table
     *  example to use :  SaveId::NamaTable('income')->first();
    */
    public function scopeNamaTable($query , $namatable){
        return $query->where('namatable', '=', $namatable);
    }
}