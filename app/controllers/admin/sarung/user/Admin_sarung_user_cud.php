<?php
/**
 *  This claas will handle add , edit and delete user
 *  of course power which is user has will be key
*/
class Admin_sarung_user_cud_support extends Admin_sarung_user{
    public function __construct(){
        parent::__construct();
    }
    protected function set_first_name_name($val){ $this->user_attr ['first_name'] = $val ; }
    protected function get_first_name_name(){ return $this->user_attr ['first_name'] ;}
    protected function get_first_name_selected(){return $this->get_value( $this->get_first_name_name() );}

    protected function set_second_name_name($val){ $this->user_attr ['second_name'] = $val ; }
    protected function get_second_name_name(){ return $this->user_attr ['second_name'] ;}
    protected function get_second_name_selected(){return $this->get_value( $this->get_second_name_name() );}

    protected function set_email_name($val){ $this->user_attr ['email'] = $val ; }
    protected function get_email_name(){ return $this->user_attr ['email'] ;}
    protected function get_email_selected(){return $this->get_value( $this->get_email_name() );}
    
    protected function set_password_name($val){ $this->user_attr ['password_'] = $val ; }
    protected function get_password_name(){ return $this->user_attr ['password_'] ;}
    protected function get_password_selected(){return $this->get_value( $this->get_password_name() );}

    protected function set_password_over_name($val){ $this->user_attr ['password__'] = $val ; }
    protected function get_password_over_name(){ return $this->user_attr ['password__'] ;}
    protected function get_password_over_selected(){return $this->get_value( $this->get_password_over_name() );}

    protected function set_day_name($val){ $this->user_attr ['day_date'] = $val ; }
    protected function get_day_name(){ return $this->user_attr ['day_date'] ;}
    protected function get_day_selected(){return $this->get_value( $this->get_day_name()  );}
    
    protected function set_mnt_name($val){ $this->user_attr ['mnt_date'] = $val ; }
    protected function get_mnt_name(){ return $this->user_attr ['mnt_date'] ;}
    protected function get_mnt_selected(){return $this->get_value( $this->get_mnt_name()  );}

    protected function set_year_name($val){ $this->user_attr ['year_date'] = $val ; }
    protected function get_year_name(){ return $this->user_attr ['year_date'] ;}
    protected function get_year_selected(){return $this->get_value( $this->get_year_name()  );}

    protected function set_tempat_lahir_name($val){ $this->user_attr ['tempat_lahir'] = $val ; }
    protected function get_tempat_lahir_name(){ return $this->user_attr ['tempat_lahir'] ;}
    protected function get_tempat_lahir_selected(){return $this->get_value( $this->get_tempat_lahir_name()  );}

    protected function set_group_name($val){ $this->user_attr ['group'] = $val ; }
    protected function get_group_name(){ return $this->user_attr ['group'] ;}
    protected function get_group_selected(){return $this->get_value( $this->get_group_name()  );}

    protected function set_propinsi_name($val){ $this->user_attr ['propinsi'] = $val ; }
    protected function get_propinsi_name(){ return $this->user_attr ['propinsi'] ;}
    protected function get_propinsi_selected(){return $this->get_value( $this->get_propinsi_name()  );}
    
    protected function set_kabupaten_name($val){ $this->user_attr ['kabupaten'] = $val ; }
    protected function get_kabupaten_name(){ return $this->user_attr ['kabupaten'] ;}
    protected function get_kabupaten_selected(){return $this->get_value( $this->get_kabupaten_name()  );}

    protected function set_kecamatan_name($val){ $this->user_attr ['kecamatan'] = $val ; }
    protected function get_kecamatan_name(){ return $this->user_attr ['kecamatan'] ;}
    protected function get_kecamatan_selected(){return $this->get_value( $this->get_kecamatan_name()  );}

    protected function set_desa_name($val){ $this->user_attr ['desa'] = $val ; }
    protected function get_desa_name(){ return $this->user_attr ['desa'] ;}
    protected function get_desa_selected(){return $this->get_value( $this->get_desa_name()  );}
    /* with this computer know how to make different between submit with button and with combobox/select */
    protected function set_signal_name($val){ $this->user_attr ['signal'] = $val ; }
    protected function get_signal_name(){ return $this->user_attr ['signal'] ;}
    protected function get_signal_selected(){return $this->get_value( $this->get_signal_name()  );}
    /* it relates with combobox/select */
    protected function set_store_url_name($val){ $this->user_attr ['store_url'] = $val ; }
    protected function get_store_url_name(){ return $this->user_attr ['store_url'] ;}
    protected function get_store_url_selected(){return $this->get_value( $this->get_store_url_name()  );}    
    /* name for woman gender*/
    protected function set_gender_name($val){ $this->user_attr ['gender'] = $val ; }
    protected function get_gender_name(){ return $this->user_attr ['gender'] ;}
    protected function get_gender_selected(){return $this->get_value( $this->get_gender_name() );}
    /* name for foto */
    protected function set_foto_name($val) {$this->user_attr ['foto_user'] = $val ; }
    protected function get_foto_name(){return $this->user_attr ['foto_user'] ;}
    protected function get_foto_selected() {return $this->get_value($this->get_foto_name());}
    
    protected function set_dialog_upload_name($val) {$this->user_attr ['dialog_upload'] = $val ; }
    protected function get_dialog_upload_name(){return $this->user_attr ['dialog_upload'] ;}
}

/**
 * this class contains something about folder
*/
class Admin_sarung_user_cud_folder extends Admin_sarung_user_cud_support{
    public function __construct(){
        parent::__construct();
    }
    /**
     *
    **/
    protected function set_tab_name($val){ $this->user_attr ['tab_widget'] = $val ;}
    protected function get_tab_name(){return $this->user_attr ['tab_widget'];}
    
    protected function set_btn_upload_name($val){ $this->user_attr ['btn_upload'] = $val ;}
    protected function get_btn_upload_name(){return $this->user_attr ['btn_upload'];}
    
    protected function set_des_dir_url($val){ $this->user_attr ['destination_dir_url'] = $val ; }
    protected function get_des_dir_url(){return $this->user_attr ['destination_dir_url'] ;}
    
    protected function set_des_dir_path($val){ $this->user_attr ['destination_dir_path'] = $val ; }
    protected function get_des_dir_path(){return $this->user_attr ['destination_dir_path'] ;}
    
    protected function set_des_dir_url_name($val){ $this->user_attr ['destination_dir_url_name'] = $val ; }
    protected function get_des_dir_url_name(){return $this->user_attr ['destination_dir_url_name'] ;}
    
    protected function set_des_dir_path_name($val){ $this->user_attr ['destination_dir_path_name'] = $val ; }
    protected function get_des_dir_path_name(){return $this->user_attr ['destination_dir_path_name'] ;}
    
    protected function set_upload_route($val){ $this->user_attr ['upload_route'] = $val ; }
    protected function get_upload_route(){return $this->user_attr ['upload_route'] ;}

    protected function set_del_img_route($val){ $this->user_attr ['del_img_route'] = $val ; }
    protected function get_del_img_route(){return $this->user_attr ['del_img_route'] ;}

    protected function set_del_img_btn_name($val){ $this->user_attr ['del_img_btn_name'] = $val ; }
    protected function get_del_img_btn_name(){return $this->user_attr ['del_img_btn_name'] ;}

    /*Watch out , $vals is array  , store all name of file */
    protected function set_store_files($vals){$this->user_attr ['store_files'] = $vals ;}
    protected function get_store_files(){ return $this->user_attr ['store_files'] ;}
    
    /**
     * make and create dir if necessary
     * @ param id: whole number
     * return none
    */
    protected function prepare_dir($id){
        if($id < 1):
            return;
        endif;
        $url =  helper_get_url_foto().'/'.$id;
        $this->set_des_dir_url($url);
        $path = helper_get_path_foto().'/'.$id;
        $this->set_des_dir_path( $path );
        
        if( ! $this->is_dir_exist( $path )):
            File::makeDirectory($path);    
        endif;
        return $path;
    }
    /**
     *  @ parameter is string of path not url
     *  return array files
    */
    protected function get_all_file($path){
        return helper_get_all_file_in_dir($path);
    }
    /**
     *  @ params  $img_urls  : array
     *  @ params  id         : $id
     *  make url for image from its id and name
     *  return url of image
    */
    private function make_img_url_from_id($dir , $files){
        $imgs = array();
        foreach( $files as $file){
            $imgs [] = sprintf('%1$s/%2$s'    ,
                $dir   ,
                $file
            );
        }
        return $imgs;
    }
    /**
     *  @ params  $img_urls : array
     *  return html string
    */
    private function make_files_as_img($img_urls , $with_js = true){
        $result = "";
        $uniques = array();
        foreach( $img_urls as $file){
            $unique = helper_make_name_from_path($file);
            $uniques [] = $unique ; 
            $result .= sprintf('<div class="col-md-4 home-foto-upload" >
                               <form class="thumbnail relative" id="%3$s" name="%3$s" method="Get" onsubmit="delete_handle(this);">
                                    <img src="%1$s" />
                                    <input type="hidden" value="%1$s" name="full_name_list_foto" id="full_name_list_foto">
                                    <input type="hidden" value="%4$s" name="base_name_list_foto" id="base_name_list_foto">
                                    <div class"absolute-left">
                                        <button class="btn btn-primary btn-xs ">Delete</button>
                                        <button class="btn btn-primary btn-xs " onclick="select_handle(this)">Select</button>
                                    </div>
                               </form></div>' ,
                             $file ,
                             $this->get_del_img_btn_name() ,
                             $unique ,
                             helper_anti_make_name($unique) /*useless*/
            );
        }
        $this->set_store_files($uniques);
        if($with_js):
            $this->set_js_for_ajax();
        endif;
        return $result;
    }
    /**
     *  Make home for our image
     *  return html div
    */
    private function get_image_home( $img_html){
        $file  = "<div class='row' id='list-img-user'>";
            $file .= $img_html ;
        $file .= "</div>";
        return $file;
    }
    /**
     *  best if you insert it outside of form
     *  return string html
    **/
    protected function get_dialog_add_file($values = array() , $disable = ""){
        $id         = $values ['id'];
        $path       = $this->prepare_dir( $id );
        $files      = $this->get_all_file($path);
        $urls       = $this->make_img_url_from_id( helper_get_url_foto()."/".$id, $files) ;
        $img_html   = $this->make_files_as_img($urls);
        $list       = $this->get_image_home($img_html);
        $des = sprintf('
                       <div id="%1$s"  class="hidden">%2$s</div>
                       <div id="%3$s" class="hidden">%4$s</div>
                       <div id="files"></div>
        ' , $this->get_des_dir_path_name() , $this->get_des_dir_path() ,
        $this->get_des_dir_url_name()       ,   $this->get_des_dir_url());
        return sprintf('
            <!-- Modal -->
            <div class="modal fade" id="%1$s" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <h4 class="modal-title" id="myModalLabel"><label class="label label-primary">Add Foto</label></h4>
                        </div>
                        <div class="modal-body">
                            <!-- Dialog -->
                            <ul class="nav nav-tabs" role="tablist" id="%3$s">
                                <li class="active" ><a href="#home" role="tab" data-toggle="tab">Uploads</a></li>
                                <li ><a href="#list-file" role="tab" data-toggle="tab">Media Library</a></li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane  active" id="home">
                                    <br>
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Select files...</span>
                                        <input type="file" name="files[]" multiple id="%4$s">
                                    </span>
                                </div>
                                %5$s
                                <div class="tab-pane" id="list-file">%2$s</div>
                            </div>
                            <br>
                            %5$s
                            <h4 class="label label-info"> You allow to keep total 1mb file only</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    
                </div>
            </div>
            
        ' ,
        $this->get_dialog_upload_name() ,
        $list,
        $this->get_tab_name() ,
        $this->get_btn_upload_name()    ,
        $des
        );
    }
    /**
     * check directory
     * return bool
    **/
    protected function is_dir_exist($file_name){
        return file_exists ( $file_name );
    }
    /**
     * all necessary js for uploading
     * return string
    **/
    private function set_special_js_this(){
		$js = sprintf('
		<script type="text/javascript">
			$(function() {
                $("#%1$s a[href="#list-file"]").tab("show");
			});
		</script>
        ' , $this->get_tab_name() , $this->get_dialog_upload_name()
		);
        $activated  =sprintf('$("#list-file").attr("class", "tab-pane  active")');
        $activated .=sprintf('$("#home").attr("class", "tab-pane")');

        $amigo = $this->base_url()."/upload_santri" ;
        $js .= sprintf(
        '
        <script src="%1$s/js/jquery.ui.widget.js"></script>
        <script src="%1$s/js/jquery.iframe-transport.js"></script>
        <script src="%1$s/js/jquery.fileupload.js"></script>
        <script>
            $(function () {
                // "use strict";
                var dir_url  = $("#%4$s").text();
                var dir_path = $("#%5$s").text();
                var url = "%3$s";
                $("#%2$s").fileupload({
                    url: url,
                    formData: { "%4$s": dir_url , "%5$s": dir_path , "test":"test_mydata"},
                    dataType: "json",
                    maxFileSize: 500000, // 0.5 MB
                    progressall: function (e, data) {
                    },
                    /*
                    add: function (e, data) {
                        $.getJSON("%3$s_test", function (result) {
                            data.formData = result; // e.g. {id: 123}
                            data.submit();
                        });
                    },
                    */
                    start: function (e, data) {
                        $("#%6$s a:last").tab("show") // Select last tab
                    },
                    done: function (e, data) {
                        $("#list-file").html( data.result.test );
                        //alert(data.formData.test);
                        //alert(data.result.test);
                        //$("#list-file").html( data.result );
                    }
                }).prop("disabled", !$.support.fileInput).parent().addClass($.support.fileInput ? undefined : "disabled");
            });
        </script>',
        helper_get_url_blueimp(),
        $this->get_btn_upload_name(),
        $this->get_upload_route() ,
        $this->get_des_dir_path_name() ,
        $this->get_des_dir_url_name()  ,
        $this->get_tab_name()
        );
        $this->set_js( $js);
    }
    /**
     *  to upload by ajax
     *  return none
    **/
    public function set_upload(){
        $this->init_dialog_with_ajax();
        if (Request::ajax()){
            $this->set_des_dir_path( $this->get_value($this->get_des_dir_path_name()) );
            $this->set_des_dir_url ( $this->get_value($this->get_des_dir_url_name()) );
            //Log::info ($this->get_value($this->get_des_dir_url_name()));
    		$option = array(
    			'upload_dir' => $this->get_des_dir_path()."/", 
    			'upload_url' => $this->get_des_dir_url()."/"
    		);
    		$upload_handler = new UploadHandler($option , false);
            $upload_handler->set_filter( $this , "set_upload_succeded" , array() );
            $upload_handler->initialize();
        }
    }
    /**
     *  have succeded to upload
     *  return none
    **/
    public function set_upload_succeded(){
       $files      = $this->get_all_file( $this->get_des_dir_path() );
       $urls       = $this->make_img_url_from_id( $this->get_des_dir_url() , $files) ;
       $img_html   = $this->make_files_as_img($urls , false);
       $list       = $this->get_image_home($img_html);
        return array("test" => $list);
    }
    /**
     *  function to handle ajax 
     *  return none;
    **/
    private function set_js_for_ajax(){
        $name_of_foto = $this->get_foto_name();
        $select_handle  = sprintf('
            function select_handle(obj){
                var form  = obj.form;
                var base_name = $("#base_name_list_foto", obj.form).val();
                var full_name = $("#full_name_list_foto", obj.form).val();
                $("#%1$s_src").attr("src",full_name);
                $("#%1$s").val(base_name);
                $("#%2$s").modal("hide");
                //alert($(form).attr("name"));
                event.preventDefault(); // disable normal form submit behavior
                return false; // prevent further bubbling of event        
        }' , $name_of_foto , $this->get_dialog_upload_name());
        $js = sprintf('<script>
            %2$s
            function delete_handle(obj){
                var url = "%1$s";
                var postData = $(obj).serializeArray();
                var nilai = $(obj).attr("name");
                $.ajax({
                    url:url,
                    data : postData,
                    success:function(result){
                        $("#list-file").html( result );
                    }
                }); // end of ajax
                event.preventDefault(); // disable normal form submit behavior
                return false; // prevent further bubbling of event        
            }
            ', $this->get_del_img_route(),
            $select_handle);
        $js.= "</script>";
        $this->set_js($js);
    }
    /**
     *  All function that i dont use anymore
     **/
    private function not_used_function(){
        //! below used to be inside of get_js_for_delete
        $js = sprintf(
        '
        <script>
            $(function () {
                var url = "%1$s";
        ',$this->get_del_img_route() );
        foreach($this->get_store_files() as $file ):
            $js .= sprintf(
                '
                    $("#%1$s").submit(function(e) {
                        var postData = $(this).serializeArray();
                        $.ajax({
                            url:url,
                            data : postData,
                            success:function(result){
                                $("#show_div").html( result );
                            }
                        }); // end of ajax                  
                        e.preventDefault(); //STOP default action
                        e.unbind(); //unbind. to stop multiple form submit.
                        return false;
                    }); // end of submit                    
                ', $file
            );
        endforeach;
        $js .= "
            })
        </script>";
        return $js;
    
    }
    /**
     *  delete file via ajax
     *  return none
    **/
    public function getDelete_img(){
        $original    = Input::get('full_name_list_foto');
        $nama_file   = helper_get_path_from_abs_url($original);
        $dir_url     = pathinfo($original , PATHINFO_DIRNAME  );
        $dir_path    = pathinfo($nama_file , PATHINFO_DIRNAME  );
        $thumbnail   = $dir_path."/thumbnail/".pathinfo($nama_file , PATHINFO_BASENAME  );
        if(unlink($nama_file) ){
            unlink($thumbnail);
            $this->init_dialog_with_ajax();
            
            $files      = $this->get_all_file($dir_path);
            $urls       = $this->make_img_url_from_id( $dir_url , $files) ;
            $img_html   = $this->make_files_as_img($urls , false);
            $list       = $this->get_image_home($img_html);
            echo $list;
        }
        else{
            echo "Not Sukses to delete file";
        }

    }
    /**
     *  Default value
    **/
    private function set_default_value_for_this(){
        //parent::set_default_value();
        $this->set_tab_name('tab_name');
        $this->set_btn_upload_name('btn_upload');
        $this->set_css_for_this();
        $this->set_des_dir_path_name('des_path_name');
        $this->set_des_dir_url_name('des_url_name');
        $this->set_upload_route( $this->base_url()."/upload_santri" );
        $this->set_del_img_route( $this->base_url()."/delete_img" );
        $this->set_del_img_btn_name('delete_img_btn');
    }
	/**
	 *	add special css for upload
	**/
	protected function set_css_for_this (){
        $hasil = "
        <style>
        .fileinput-button {
            position: relative;
            overflow: hidden;
        }
        .fileinput-button input {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            opacity: 0;
            -ms-filter: 'alpha(opacity=0)';
            font-size: 200px;
            direction: ltr;
            cursor: pointer;
        }
        /* Fixes for IE < 8 */
        @media screen\9 {
            .fileinput-button input {
                filter: alpha(opacity=0);
                font-size: 100%;
                height: 100%;
            }
        }
        </style>
        ";
        $this->set_css($hasil );
    }
    
	/**
	 *	init for anythings ecxept ajax
	**/
    protected function init_dialog(){
        $this->set_default_value_for_this();
        $this->set_special_js_this();
    }
	/**
	 *	init when you activated via ajax
	*/
    protected function init_dialog_with_ajax(){
        $this->set_default_value_for_this();
    }
}
/**
 *  this class contains  all input
*/
class Admin_sarung_user_cud_input extends Admin_sarung_user_cud_folder{
    public function __construct(){
        parent::__construct();
    }
    /**
     *  return foto input along with its button 
    **/
    protected function get_foto_input( $values = array() , $disable = ""){
        $widget = "";
        $unallow = "disabled";
        if($this->get_purpose() == 2){
            $unallow = "";
        }
        $foto_dir =  sprintf('%1$s/%2$s/%3$s' , $this->get_foto_folder() , $values ['id'], $values [$this->get_foto_name()] );
        $hasil = sprintf ('
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="thumbnail">
                            <img src="%1$s" name="%3$s_src" class= "%2$s" id="%3$s_src" %4$s style="width:128px;height:128px;margin:0px auto;" >
                            <input type="hidden" value="%2$s" name="%3$s" id="%3$s" >
                            <a class="btn btn-default btn-xs %6$s" data-toggle="modal" data-target="#%5$s">Add Foto</a>
                        </div>
                    </div>
                </div>
            </div>
          ' ,
            $foto_dir,
            $values [$this->get_foto_name()] ,
            $this->get_foto_name() ,
            $disable ,
            $this->get_dialog_upload_name(),
            $unallow
          );
        return $hasil; 
    }
    /**
     *  return group input for adding , editing and deleting
    */
    protected function get_group_alamat($label , $input ){
        $names = sprintf ('
            <div class="form-group">                
                <div class="row">
                    <label class="col-xs-3 control-label"> %2$s </label>
                    <div class="col-xs-8">
                        %1$s
                    </div>
              </div>
            </div>
          ' ,
            $input , $label
          );
        return $names; 
    }
    /**
     *  return desa select 
    **/
    protected function get_desa_select( $values , $disable = ""){
        $propinsi = $values [$this->get_propinsi_name()]   ;
        $kabupaten = $values [$this->get_kabupaten_name()] ;
        $kecamatan = $values [$this->get_kecamatan_name()] ;
        $desa       = $values [ $this->get_desa_name()];
        $default = array( "class" => "selectpicker col-md-12",
                         "name" => $this->get_desa_name() ,
                         'id'   => $this->get_desa_name() , 
                         'selected' => $desa,
						 );
        $obj = new Desa_Model();
        $names = array();
        $lists = $obj->get_desas_of_kecamatan('Indonesia',$propinsi , $kabupaten , $kecamatan);
        foreach(  $lists as $kabs){
            $names [] = $kabs->nama;
        }
        $items = $this->get_select($names , $default , $disable);
        return $this->get_group_alamat('Desa' , $items);
    }

    /**
     *  return kecamatan select 
    **/
    protected function get_kecamatan_select( $values , $disable = ""){
        $propinsi = $values [$this->get_propinsi_name()]   ;
        $kabupaten = $values [$this->get_kabupaten_name()] ;
        $kecamatan = $values [$this->get_kecamatan_name()] ;
        $default = array( "class" => "selectpicker col-md-12",
                         "name" => $this->get_kecamatan_name() ,
                         'id'   => $this->get_kecamatan_name() , 
                         'selected' => $kecamatan
						 );
        $obj = new Kecamatan_Model();
        $names = array();
        $lists = $obj->get_kecamatans_of_kabupaten('Indonesia',$propinsi , $kabupaten);
        foreach(  $lists as $list){
            $names [] = $list->nama;
        }
        $items = $this->get_select($names , $default, $disable);
        return $this->get_group_alamat('Kecamatan' , $items);
    }
    /**
     *  return kabupaten select 
    **/
    protected function get_kabupaten_select( $values , $disable = ""){
        $propinsi = $values [$this->get_propinsi_name()] ;
        $kabupaten = $values [$this->get_kabupaten_name()] ;
        $default = array( "class" => "selectpicker col-md-12",
                         "name" => $this->get_kabupaten_name() ,
                         'id'   => $this->get_kabupaten_name() , 
                         'selected' => $kabupaten
						 );
        $obj = new Kabupaten_Model();
        $names = array();
        $lists = $obj->get_kabupatens_of_propinsi('Indonesia',$propinsi)->orderBy('nama')->get();
        if( !$lists->isEmpty()){
            foreach( $lists as $kabs){
                $names [] = $kabs->nama;
            }
        }
        $items = $this->get_select($names , $default, $disable);
        return $this->get_group_alamat('Kabupaten' , $items);
    }

    /**
     *  return propinsi select 
    **/
    protected function get_propinsi_select( $values = array() , $disable = ""){
        $default = array( "class" => "selectpicker col-md-12" , 
                         "name" => $this->get_propinsi_name() ,
                         "id"   => $this->get_propinsi_name() ,
                         'selected' => $values [$this->get_propinsi_name()]
						 );
        $obj = new Propinsi_Model();
        $items = $this->get_select( $obj->get_namas() , $default, $disable);
        return $this->get_group_alamat('Propinsi' , $items);
    }
    /**
     *  return status select 
    **/
    protected function get_group_select( $values = array() , $disable = ""){
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" ,
                         "name" => $this->get_group_name() ,
                         'selected' => $values [$this->get_group_name()]
						 );
        $AdmindGroup = new AdmindGroup();
        $items = array();
        foreach( $AdmindGroup->get_lesser_power($this->get_user_power())->get() as $val){
            $items [] = $val->nama;
        }
        $statues = $this->get_select( $items , $default, $disable);
        return $this->get_group_alamat('Group' , $statues);
    }

    /**
     *  return status select 
    **/
    protected function get_status_select( $values = array() , $disable = ""){
        $default = array( "class" => "selectpicker col-md-12" , "id" => "" ,
                         "name" => $this->get_status_select_name() ,
                         'selected' => $values [$this->get_status_select_name()] ,
						 );
        $statues = $this->get_select_by_key( $this->get_available_status('Status') , $default ,  $disable);
        return $this->get_group_alamat('Status' , $statues);
    }
    /**
     *  return tempat lahir select 
    **/
    protected function get_tempat_lahir_select( $values = array() , $disable = ""){
        $default = array( "class" => "selectpicker col-md-12 form-control" , "id" => "" ,
                         "name" => $this->get_tempat_lahir_name() ,
                         "id"   => $this->get_tempat_lahir_name() ,
                         'selected' => $values [$this->get_tempat_lahir_name()]
						 );
        
        $items = array();
        $kabupaten = new Kabupaten_Model();
        $results = $kabupaten->orderBy('nama')->get();
        foreach($results as $result){
            $items [] = $result->nama;
        }
        $kabupaten_select = $this->get_select($items , $default , $disable);
        $names = sprintf ('
            <div class="form-group">                
                <div class="row">
                    <label class="col-xs-2 control-label">  Tempat Lahir </label>
                    <div class="col-xs-6">
                        %1$s
                    </div>
              </div>
            </div>
          ' ,
            $kabupaten_select
          );
        return $names;
    }
    
    /**
     *  return date input
    **/
    protected function get_date_input( $values = array() , $disable = ""){
        $names = sprintf ('
            <div class="form-group">
                <label> Tanggal Lahir </label>
                <div class="row">
                    <div class="col-xs-4">
                        <input type="number" class="form-control" id="%1$s"  placeholder="Day"  name="%1$s" %7$s value="%2$s" >
                    </div>
                    <div class="col-xs-4">
                        <input type="number" class="form-control" id="%3$s"  placeholder="Month" name="%3$s" %7$s value="%4$s" >
                    </div>
                    <div class="col-xs-4">
                        <input type="number" class="form-control" id="%5$s"  placeholder="Year" name="%5$s" %7$s value="%6$s" >
                    </div>

              </div>
            </div>
          ' , $this->get_day_name() ,   $values [$this->get_day_name()] ,
          $this->get_mnt_name()     ,   $values [$this->get_mnt_name()] ,
          $this->get_year_name()    ,   $values [$this->get_year_name()] ,
          $disable
          );
        return $names;
    }
    /**
     *  return email input
    **/
    protected function get_email_input( $values =array () , $disable = ""){
        $names = sprintf ('
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="input-group">
                            <div class="input-group-addon">@</div>
                            <input type="email" class="form-control" id="%1$s" placeholder="Email" name="%1$s" %3$s value="%2$s" >
                        </div>
                    </div>
              </div>
            </div>
          ' , $this->get_email_name() , $values [$this->get_email_name()] , $disable );
        return $names;
    }
    /**
     *  return input first and second name html
    **/
    protected function get_names_input( $values = array(), $disable = ""){
        $names = sprintf ('
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6">
                        <input type="text" class="form-control" id="%1$s" placeholder="First Name" name="%1$s" %3$s value="%4$s" >
                    </div>
                    <div class="col-xs-6">
                        <input type="text" class="form-control" id="%2$s" placeholder="Second Name" name="%2$s" %3$s value="%5$s">
                    </div>
                </div>
            </div>
          ' , $this->get_first_name_name() , $this->get_second_name_name() , $disable ,
          $values [$this->get_first_name_name()]  , $values [$this->get_second_name_name()] );
        return $names;
    }
    
    /**
     *  return input first and second name html
    **/
    protected function get_passwords_input( $values = array() , $disable = ""){
        $names = sprintf ('
            <div class="form-group">
                <label> Password</label>
                <div class="row">
                    <div class="col-xs-6">
                        <input type="password" class="form-control" id="%1$s"  name="%1$s" %3$s value="%4$s" >
                    </div>
                    <div class="col-xs-6">
                        <input type="password" class="form-control" id="%2$s" name="%2$s" %3$s value="%5$s">
                    </div>
                </div>
            </div>
          ' , $this->get_password_name() , $this->get_password_over_name() , $disable ,
          $values [$this->get_password_name()]  , $values [$this->get_password_over_name()]);
        return $names;
    }
    /**
     *  return gender input
    */
    protected function get_gender_input($values , $disable = ""){
        $checked = array( '' , '' );
        if( $values [$this->get_gender_name()] == "L" ){
            $checked [0] = 'checked';
        }
        else{
            $checked [1] = 'checked';
        }
        $gender = sprintf('
            <div class="form-group">
                <div class="row">
                    <label for="exampleInputEmail1" class="col-xs-2" >Gender</label>
                    <label class="radio-inline">
                        <input type="radio" name="%1$s" id="%1$s" value="L" %2$s >Pria
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="%1$s" id="%1$s" value="W" %3$s >Wanita
                    </label>
                </div>
            </div>
            ' ,$this->get_gender_name() ,
            $checked [0] ,
            $checked [1]
            );
        return $gender;
    }    
    /**
     *  @override
     *  js for button to executed check box
     *  return none
    */
    protected function set_special_js(){
        //parent::set_special_js();
        //parent::set_special_js();
		$propinsi = sprintf('
				$( "#%1$s"  ).change(function () {
                    $("#%2$s").val("1");
					$("#%3$s").submit();
				});',
                $this->get_propinsi_name(),
                $this->get_signal_name(),
                $this->get_table_form_name()
		);
		$kabupaten = sprintf('
				$( "#%1$s"  ).change(function () {
                    $("#%2$s").val("1");
					$("#%3$s").submit();
				});',
                $this->get_kabupaten_name(),
                $this->get_signal_name(),
                $this->get_table_form_name()
		);
		$kecamatan = sprintf('
				$( "#%1$s"  ).change(function () {
                    $("#%2$s").val("1");
					$("#%3$s").submit();
				});',
                $this->get_kecamatan_name(),
                $this->get_signal_name(),
                $this->get_table_form_name()
		);
        $upload = sprintf('<script src="%1$s/jquery.fileupload.js"></script>',
                          $this->get_url_js());
		$js = sprintf('                    
		<script type="text/javascript">
			$(function() {
                %1$s  %2$s %3$s
			});
		</script>
        %4$s
        ' ,
            $propinsi ,
            $kabupaten,
            $kecamatan ,
            $upload
		);
        $this->set_js( $js);     
    }
    /**
     *  return index
    */
    protected function on_changing_select($values , $title = "Add"){        
        $heading    = $title;
        $body       = $this->get_form_cud( $values[$this->get_store_url_name()] , $values);        
        $this->set_content( $this->get_panel($heading , $body , '') );
        return $this->index();
    }
    /**
      *  form which is used by adding , editing and deleting
      *  return   form 
    **/
    protected function get_form_cud( $go_where  , $values = array()  ,$disabled = "" , $method = 'post'){
        $this->use_select();
        $array = $this->set_values_to_inputs();
        $values = $this->make_one_two_array($array , $values);
        $dialog = "" ;
        if($this->get_purpose() == parent::EDIT || $this->get_purpose() == parent::DELE){
            $this->init_dialog();
            $dialog = $this->get_dialog_add_file($values , $disabled);            
        }
        
   		$hasil  = Form::open(array('url' => $go_where, 'method' => $method , 'role' => 'form' , 'id' => $this->get_table_form_name() )) ;
        
        $hasil .= '<div class="row"><div class="thumbnail col-md-7">';
            $hasil .= '<div class="row"><div class="col-md-8">';
            $hasil .= $this->get_names_input($values , $disabled). $this->get_email_input($values, $disabled).
            $this->get_passwords_input($values, $disabled);
            $hasil .= "</div>";
            $hasil .= '<div class="col-md-4">';
                $hasil .= $this->get_foto_input($values, $disabled);
            $hasil .= "</div></div>";
            
            $hasil .= $this->get_date_input($values, $disabled).
            $this->get_tempat_lahir_select($values, $disabled) .
            $this->get_gender_input( $values, $disabled);
        $hasil .="</div>";
        
        $hasil .= '<div class="thumbnail col-md-4 col-md-offset-1">';
            $hasil .= $this->get_status_select($values, $disabled) . $this->get_group_select($values, $disabled).
            $this->get_propinsi_select($values, $disabled). $this->get_kabupaten_select($values, $disabled) . $this->get_kecamatan_select($values , $disabled).
            $this->get_desa_select($values , $disabled);
        $hasil .="</div></div>";
        
        $hasil .= Form::hidden($this->get_signal_name()    , 0 , array('id' => $this->get_signal_name() ) );
        $hasil .= Form::hidden($this->get_store_url_name() , $go_where );
        $hasil .= Form::hidden('id' , $values ['id']  );
		$hasil .= '<hr><div class="form-group"><div class="col-sm-offset-10 col-lg-2">';
		$hasil .= Form::submit('Submit' , array( 'class' => 'btn btn-primary btn-lg' ) );
		$hasil .= '</div></div>';
        $hasil .= Form::close();
        //!
        //$hasil  .= $this->get_foto_input($values, $disabled);
        $hasil  .= $dialog;
        return $hasil;
    }
    /**
     *  all input name
     *  return array
    */
    protected function get_all_name_input(){
        $array = array(
            'id'                            =>  ''  ,
            $this->get_first_name_name()    =>  ''  ,
            $this->get_second_name_name()   =>  ''  ,
            $this->get_tempat_lahir_name()  =>  ''  ,
            $this->get_password_name()      =>  ''  ,
            $this->get_password_over_name() =>  ''  ,
            $this->get_email_name()         =>  ''  ,
            $this->get_day_name()           =>  ''  ,
            $this->get_mnt_name()           =>  ''  ,
            $this->get_year_name()          =>  ''  ,
            $this->get_status_select_name() =>  ''  ,
            $this->get_group_name()         =>  ''  ,
            $this->get_propinsi_name()      =>  ''  ,
            $this->get_kabupaten_name()     =>  ''  ,
            $this->get_kecamatan_name()     =>  ''  ,
            $this->get_desa_name()          =>  ''  ,
            $this->get_gender_name()        =>  ''  ,
            $this->get_store_url_name()     =>  ''  ,
            $this->get_foto_name()          =>  '' 
        );
        return $array;
    }
   /**
     *  return array 
     *  useful for edit and delele view
     *  it related with changing select and edit
    */
    protected function set_values_to_inputs($model = 'empty'){
        $array = $this->get_all_name_input();
        if($model == 'selected'):
            $items = Input::all();
            foreach( $array as $key => $val){
                $array [$key] = Input::get($key);
            }
        elseif( is_object($model)):
            $phpdate = strtotime( $model->lahir );
            $array [$this->get_first_name_name()] = $model->first_name;
            $array [$this->get_second_name_name()] = $model->second_name;
            $array [$this->get_email_name()]        = $model->email;
            $array [$this->get_day_name()]          = Date('d' , $phpdate);
            $array [$this->get_mnt_name()]          = Date('m' , $phpdate);
            $array [$this->get_year_name()]          = Date('Y' , $phpdate);
            $array [$this->get_tempat_lahir_name()]  = $model->tempat->nama;
            $array [$this->get_gender_name()]        = $model->jenis;
            $array [$this->get_status_select_name()] = $model->status;
            $array [$this->get_group_name()]        = $model->admindgroup->nama;
            $array [$this->get_propinsi_name()]       = $model->desa->kecamatan->kabupaten->propinsi->nama;
            $array [$this->get_kabupaten_name()]       = $model->desa->kecamatan->kabupaten->nama ;
            $array [$this->get_kecamatan_name()]       = $model->desa->kecamatan->nama ;
            $array [$this->get_desa_name()]       = $model->desa->nama;
            $array [$this->get_foto_name()]         =   $model->foto;
            //echo $this->get_status($model->status);
        endif;
        return $array;
	}
    /**
     *  set and get rules for input
     *  return array
    */
    protected function setting_and_get_rules(){
        $array = $this->get_all_name_input();
        foreach($array as $key => $val):
            $array [$key] = 'required'; 
        endforeach;
        $array [$this->get_foto_name()]  = '';
        $array [$this->get_day_name()]  = 'required|numeric';
        $array [$this->get_mnt_name()]  = 'required|numeric';
        $array [$this->get_year_name()] = 'required|numeric';
        $array ['id']                   = '';        
        if( $this->get_purpose() == parent::EDIT ){
            $array [$this->get_password_name()] = '';
            $array [$this->get_password_over_name()] = '';
        }
        return $array;
    }
}


/**
 *  main class of this file
*/
class Admin_sarung_user_cud extends Admin_sarung_user_cud_input {
    public function __construct(){
        parent::__construct();
    }
    /**
     *  @override
     *  This is must be function you should make if you make subclass from this class 
     *  return  none
    **/
    protected function set_default_value(){
        parent::set_default_value();
        //parent::set_default_value();
        $this->set_view('sarung/admin/index');
        $this->set_min_power( 1000 );
		$this->set_title('User register');
		$this->set_body_attribute( " class='admin admin_sarung_body' " );
        $this->set_table_name('admind');
        $this->set_purpose( parent::VIEW);
        //! input
        $this->set_first_name_name('first_name');
        $this->set_second_name_name('second_name');
        $this->set_email_name('email_name');
        $this->set_password_name('password_one');
        $this->set_password_over_name('password_over');
        $this->set_day_name('day');
        $this->set_mnt_name('mnt');
        $this->set_year_name('year');
        $this->set_tempat_lahir_name('tempat_lahir');
        $this->set_group_name('group_name');
        $this->set_signal_name('signal_name');
        $this->set_gender_name('ahmad_sakip');
        $this->set_status_select_name('status_select');

        $this->set_dialog_upload_name('dialog_upload');        
        $this->set_propinsi_name('propinsi');
        $this->set_kabupaten_name('kabupaten');
        $this->set_kecamatan_name('kecamatan');
        $this->set_desa_name('desa');
        
        $this->set_foto_name('name_of_foto');
        $this->set_store_url_name('store_url');
        //! input rules
   		$rules = $this->setting_and_get_rules();        
        //! it should be on last 
        $this->set_inputs_rules($rules);
        $this->set_special_js();
    }
    /**
	 *	@override
      *  sequence : @get_rules() , @Sarung_db_about()
      *  return  getEventedit()
    **/
    public function postEventedit(){
		$chose = $this->get_value( $this->get_signal_name() );
		if($chose == 1 ){
    		$values = $this->set_values_to_inputs( 'selected' );
			return $this->on_changing_select($values);
		}
        else{
    		$this->set_purpose( parent::EDIT);
            //! input rules
       		$rules = $this->setting_and_get_rules();        
            //! it should be on last 
            $this->set_inputs_rules($rules);
            return parent::postEventedit();
        }
    }
    /**
	 *	@override
     *  After_Submit , We overrid because we have select which will change according to other result
     *  return on_changing_select or postEventadd
    */
	public function postEventadd(){
        $data = Input::all();
		$chose = $this->get_value( $this->get_signal_name() );
		if($chose == 1 ){
    		$values = $this->set_values_to_inputs( 'selected' );
			return $this->on_changing_select($values);
		}
        /*Cek if password doest match*/
        if( $this->get_value( $this->get_password_name()) == $this->get_value($this->get_password_over_name()) ){
    		return parent::postEventadd();            
        }
        else{
            $message = "<label class='label label-danger'>Password doesnt same</label";
            return parent::getEventadd($message);
        }
	}
    /**
     * @ovverride
     * return object
    **/
    protected function Sarung_db_about($data , $edit = false , $values = array()){
        $event = $this->get_model_obj();
        if( !$edit ){
            $event->id = $data ['id'] ;
        }
        else{
            $event = $event->find( $data ['id'] );
            if( $data [$this->get_password_over_name()] != ""){
                $event->password        =   Hash::make($data [$this->get_password_over_name()]);                
            }
            $event->foto = $data [ $this->get_foto_name()] ;
        }
        $desa = new Desa_Model() ;
        $kab = new Kabupaten_Model();
        $kab = $kab->get_first(
                                 'Indonesia' ,
                                 $data [$this->get_propinsi_name()]     ,
                                 $data [$this->get_kabupaten_name()]            
                               );
        
        $event->idgroup         =   AdmindGroup::get_first( $data [$this->get_group_name()] )->id;
        $event->idtempat        = $kab->id;
        $desa = $desa->get_first(
                                 'Indonesia' ,
                                 $data [$this->get_propinsi_name()]     ,
                                 $data [$this->get_kabupaten_name()]    ,
                                 $data [$this->get_kecamatan_name()]    ,
                                 $data [$this->get_desa_name()]
                                 );        
        $event->iddesa          = $desa->id;
        $event->lahir           = sprintf('%1$s-%2$s-%3$s',
                                    $data [$this->get_year_name()],
                                    $data [$this->get_mnt_name()],
                                    $data [$this->get_day_name()]);
       	$event->first_name      = $data [ $this->get_first_name_name() ]		;
   		$event->second_name     = $data [ $this->get_second_name_name() ]	;
        $event->jenis           =   $data [$this->get_gender_name()] ;
        $event->email           =   $data [$this->get_email_name()];
        $event->status          =   $this->get_status( $data [$this->get_status_select_name()] , 1);
        
        return $event;
    }
    /**
     *  to upload by ajax
     *  return none
    */
    public function set_upload(){
        parent::set_upload();
    }
	/**
     *  @override
	 *	 onsucceded delete
	 *	 return @ index 
	*/
	protected function postEventdelsucceded($parameter = array()){
        $id = Input::get('id');
        $name_of_foto = Input::get( $this->get_foto_name() );
        $dir            = $this->get_foto_folder();
        $original   =   sprintf('%1$s/%2$s/%3$s' , $dir , $id , $name_of_foto);
        $nama_file   = helper_get_path_from_abs_url($original);
        $dir_path    = pathinfo($nama_file , PATHINFO_DIRNAME  );
        $thumbnail   = $dir_path."/thumbnail/".pathinfo($nama_file , PATHINFO_BASENAME  );
        if($success = File::deleteDirectory($dir_path)){
            Log::info("Delete succeded");
        }
        
		$messages = array(" Sukses Menghapus ");
		$message = sprintf('<span class="label label-info">%1$s</span>' , $this->make_message( $messages ));
        return $this->getIndex();
	}
}
