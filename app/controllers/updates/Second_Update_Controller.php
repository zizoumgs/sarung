<?php
class Second_Update_Controller extends update_support{
    public function __construct(){
		parent::__construct();
    }
    
	public function getIndex(){
        $this->init();		
	}
    private function init(){
		$db_sarung = $this->get_db_sarung_object();
        $this->create_post( $db_sarung );
        $this->create_category( $db_sarung );
		$this->create_taxanomy( $db_sarung );
        $this->create_bridge( $db_sarung );
	}
    private function create_post( $db_sarung ) {
		$sql = "
        CREATE TABLE blo_posts (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            post_date DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
            post_content LONGTEXT NOT NULL,
            post_title TEXT NOT NULL,
            post_name VARCHAR(200) NOT NULL DEFAULT '',
			created_at DATETIME,
			updated_at DATETIME,
            PRIMARY KEY (id)
        )
        ";
        $result = $db_sarung->exec($sql);        
    }
    
    private function create_category( $db_sarung ){
		$sql = "
        CREATE TABLE blo_terms (
            id BIGINT(20) UNSIGNED NOT NULL,
            name VARCHAR(200) NOT NULL DEFAULT '',
            slug VARCHAR(200) NOT NULL DEFAULT '',
			created_at DATETIME,
			updated_at DATETIME,
            PRIMARY KEY (id),
            INDEX slug (slug),
            INDEX name (name)
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB
        ";
        $result = $db_sarung->exec($sql);                
    }
    
    private function create_bridge( $db_sarung ){
		$sql = "
        CREATE TABLE blo_term_relationships (	
            object_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
            term_taxonomy_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
			created_at DATETIME,
			updated_at DATETIME,
            PRIMARY KEY (object_id, term_taxonomy_id),
            INDEX term_taxonomy_id (term_taxonomy_id)
        )
        COLLATE='utf8_general_ci'
        ENGINE=InnoDB
        ";
        $result = $db_sarung->exec($sql);                
        
    }

    private function create_taxanomy( $db_sarung ){
		$sql = "
		CREATE TABLE blo_term_taxonomy (
			id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
			term_id BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
			taxonomy VARCHAR(32) NOT NULL DEFAULT '',
			description LONGTEXT NOT NULL,
			parent BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
			count BIGINT(20) NOT NULL DEFAULT '0',
			created_at DATETIME,
			updated_at DATETIME,			
			PRIMARY KEY (id),
			UNIQUE INDEX term_id_taxonomy (term_id, taxonomy),
			INDEX taxonomy (taxonomy)
		)
		COLLATE='utf8_general_ci'
		ENGINE=InnoDB
		AUTO_INCREMENT=1
        ";
        $result = $db_sarung->exec($sql);                
        
    }
    
}
