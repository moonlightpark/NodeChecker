<?php
class Template {
	
	protected $util ;
	protected $totalpage = 0;
	protected $totalcount = 0;
	protected $page = 1;
	protected $blockstart = 1;
	protected $blockend = 1;
	protected $pre = 1;
	protected $next = 1;
	protected $lang = "ja";
	protected $__VAR_LOG_PFIX__ = __ENV_LOG_PFIX__;
	protected $__VAR_LOG_LEVEL__ = 2;
	
	public function __construct() {
        //echo 'this is the view';
		$this->util = new Util(); 	
		
	//	$this->lang = $this->util->getRegion();
    }
    public function html($name){
        require __ENV_DOCUMENT_ROOT__.'/'.'html/' . $name ;
    }
    public function view($name){
        require 'views/' . $name . '.php';
    }
    public function page($page,$total_page, $total_count,$blocksize){
    	$this->page = $page;
    	$this->totalpages = (int)$total_page;
    	$this->totalcount = (int)$total_count;
    	$this->blockstart = (int)(($page -1 )/ $blocksize ) * $blocksize + 1;
    	$this->blockend = $this->blockstart + $blocksize -1;
    	if($this->blockend > $this->totalpages){
    		$this->blockend = $this->totalpages;
    	}
    	$this->pre = $this->blockstart-1;
    	$this->next = $this->blockend+1;
    }  
    public function smpaging(){
    	
    	echo " <div id=\"dataTable_paginate\" class=\"dataTables_paginate paging_simple_numbers pull-right\" > ";    	
    	if($this->totalpages > 1){    		
    		echo " <ul class=\"pagination\"> ";    		    
    		    if($this->blockstart > 1){
    		    	echo "<li id=\"dataTable_previous\" class=\"paginate_button page-item previous\"> ";
    				echo "	<a href=\"javascript:".$this->list."('".$this->pre."');\" aria-controls=\"dataTable\" data-dt-idx='".$this->pre."' tabindex='0' class='page-link' style=\"padding:3px 6px 2px;font-size:10px;\" ><</a> ";
    				echo "</li>";
    		    }else{
    				echo "<li id='dataTable_previous' class='paginate_button page-item previous disabled '> ";
    				echo " 	<a href='#' aria-controls='dataTable' data-dt-idx='0' tabindex='0' class='page-link' style=\"padding:3px 6px 2px;font-size:10px;\" ><</a>";
    				echo "</li>";
    		    }
    			for( $i = $this->blockstart; $i <= $this->blockend ; $i++ ){
    				if($i == $this->page ){    			
    					echo "<li class='paginate_button page-item active'>";
    					echo " 	<a href=\"javascript:".$this->list."('".$i."');\" aria-controls='dataTable' data-dt-idx='".$i."' tabindex='0' class='page-link' style=\"padding:3px 6px 2px;font-size:10px;\" >".$i."</a>";
    					echo "</li>";   
    				}else{   
    					echo "<li class='paginate_button page-item'> ";
    					echo "<a href=\"javascript:".$this->list."('".$i."');\" aria-controls='dataTable' data-dt-idx='".$i."' tabindex='0' class='page-link' style=\"padding:3px 6px 2px;font-size:10px;\" >".$i."</a>";
    					echo "</li>";    			
    				}
    			}
    			if( $this->blockend < $this->totalpages ){    			
    			   echo "<li id='dataTable_next' class='paginate_button page-item next'>";
    			   echo " 	<a href=\"javascript:".$this->list."('".$this->next."');\" aria-controls='dataTable' data-dt-idx='".$this->next."' tabindex='0' class='page-link' style=\"padding:3px 6px 2px;font-size:10px;\" >></a> ";
    			   echo "</li>";
    			}else{
    				
    				echo "<li id='dataTable_next' class='paginate_button page-item next disabled'>";
    				echo " 	<a href='#' aria-controls='dataTable' data-dt-idx='".$this->totalpages."' tabindex='0' class='page-link' style=\"padding:3px 6px 2px;font-size:10px;\" >></a> ";
    				echo "</li>";
    			}

    		echo "</ul>";    	
    	}
    	echo "</div>";
    } //END_paging
    
    public function paging(){
    	 
    	echo " <div id=\"dataTable_paginate\" class=\"dataTables_paginate paging_simple_numbers pull-right\" > ";
    	if($this->totalpages > 1){
    		echo " <ul class=\"pagination\"> ";
    		if($this->blockstart > 1){
    			echo "<li id=\"dataTable_previous\" class=\"paginate_button page-item previous\"> ";
    			echo "	<a href=\"javascript:".$this->list."('".$this->pre."');\" aria-controls=\"dataTable\" data-dt-idx='".$this->pre."' tabindex='0' class='page-link'>Previous</a> ";
    			echo "</li>";
    		}else{
    			echo "<li id='dataTable_previous' class='paginate_button page-item previous disabled '> ";
    			echo " 	<a href='#' aria-controls='dataTable' data-dt-idx='0' tabindex='0' class='page-link'>Previous</a>";
    			echo "</li>";
    		}
    		for( $i = $this->blockstart; $i <= $this->blockend ; $i++ ){
    			if($i == $this->page ){
    				echo "<li class='paginate_button page-item active'>";
    				echo " 	<a href=\"javascript:".$this->list."('".$i."');\" aria-controls='dataTable' data-dt-idx='".$i."' tabindex='0' class='page-link'>".$i."</a>";
    				echo "</li>";
    			}else{
    				echo "<li class='paginate_button page-item'> ";
    				echo "<a href=\"javascript:".$this->list."('".$i."');\" aria-controls='dataTable' data-dt-idx='".$i."' tabindex='0' class='page-link'>".$i."</a>";
    				echo "</li>";
    			}
    		}
    		if( $this->blockend < $this->totalpages ){
    			echo "<li id='dataTable_next' class='paginate_button page-item next'>";
    			echo " 	<a href=\"javascript:".$this->list."('".$this->next."');\" aria-controls='dataTable' data-dt-idx='".$this->next."' tabindex='0' class='page-link'>Next</a> ";
    			echo "</li>";
    		}else{
    
    			echo "<li id='dataTable_next' class='paginate_button page-item next disabled'>";
    			echo " 	<a href='#' aria-controls='dataTable' data-dt-idx='".$this->totalpages."' tabindex='0' class='page-link'>Next</a> ";
    			echo "</li>";
    		}
    
    		echo "</ul>";
    	}
    	echo "</div>";
    } //END_paging_small
    
    public function mfpaging(){   
       
        if($this->totalpages > 1){
            echo " <ul class=\"pagination\"> ";
            if($this->blockstart > 1){
                echo "<li> ";
                echo "	<a href=\"javascript:".$this->list."('".$this->pre."');\" ><i class=\"fas fa-angle-double-left\" style=\"color:#999\"></i></a> ";
                echo "</li>";
            }else{
                echo "<li > ";
                echo " 	<a href=\"javascript:".$this->list."(1);\" ><i class=\"fas fa-angle-double-left\" style=\"color:#999\"></i></a>";
                echo "</li>";
            }
            for( $i = $this->blockstart; $i <= $this->blockend ; $i++ ){
                if($i == $this->page ){
                    echo "<li  class='active'>";
                    echo " 	<a href=\"javascript:".$this->list."('".$i."');\" >".$i."</a>";
                    echo "</li>";
                }else{
                    echo "<li >";
                    echo " 	<a href=\"javascript:".$this->list."('".$i."');\" >".$i."</a>";
                    echo "</li>";
                }
            }
            if( $this->blockend < $this->totalpages ){
                echo "<li >";
                echo " 	<a href=\"javascript:".$this->list."('".$this->next."');\" ><i class=\"fas fa-angle-double-right\" style=\"color:#999\"></i></a> ";
                echo "</li>";
            }else{
                
                echo "<li >";
                echo " 	<a href=\"javascript:".$this->list."('".$this->totalpages."');\" ><i class=\"fas fa-angle-double-right\" style=\"color:#999\"></i></a> ";
                echo "</li>";
            }            
            echo "</ul>";           
        }
        
    } // end mfpaging
    
    public function dialog2($id,$idtitle,$formurl){
        
        echo '<div id="'.$id.'" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
        //	require 'templates/' . $formurl . '.php';
        require __APPLICATION_PATH__.'/'.'views/' . $formurl . '.php';
        echo  '</div>';
    }
    
    public function dialoglist($id,$idtitle,$id_list,$width="900"){
        
        echo '<div id="'.$id.'" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    	  <div class="modal-dialog " style="width:'.$width.'px;">
    		<div class="modal-content">
    		 <div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    			<h4 class="modal-title" id="'.$idtitle.'"></h4>
    		  </div>
              <div class="modal-body" id="'.$id_list.'" ></div>
            </div><!-- /.modal-content -->
    	  </div><!-- /.modal-dialog -->
    	</div><!-- /.modal -->
       ';
    }
    
    public function dialogForEditor($id,$idtitle,$formurl){
        
        echo '<div id="'.$id.'" class="modal draggable fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    	  <div class="modal-dialog" >
    		<div class="modal-content">
    		 <div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    			<h4 class="modal-title" id="'.$idtitle.'"></h4>
    		  </div>';
        //	require 'templates/' . $formurl . '.php';
        require 'views/' . $formurl . '.php';
        echo  '</div><!-- /.modal-content -->
    	  </div><!-- /.modal-dialog -->
    	</div><!-- /.modal -->
       ';
    }
    
    public function dialog($id,$idtitle,$formurl){
    	
    	echo '<div id="'.$id.'" class="modal draggable fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    	  <div class="modal-dialog" >
    		<div class="modal-content">
    		 <div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    			<h4 class="modal-title" id="'.$idtitle.'"></h4>
    		  </div>';
		//	require 'templates/' . $formurl . '.php';	
			require 'views/' . $formurl . '.php';
		echo  '</div><!-- /.modal-content -->
    	  </div><!-- /.modal-dialog -->
    	</div><!-- /.modal -->
       ';
    }
    
    public function dialogvod($id,$idtitle,$formurl){
    	 
    	echo '	<div id="'.$id.'" class="modal draggable  fade"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    	  <div class="modal-dialog">
    		<div class="modal-content">
    		 <div class="modal-header">
    			<button type="button" class="close" aria-hidden="true" onclick="CommonModule.closeVodDlg();">&times;</button>
    			<h4 class="modal-title" id="'.$idtitle.'"></h4>
    		  </div>
			  <div class="modal-body">
    		  ';
    			require 'templates/' . $formurl . '.php';
    			echo  '</div>
    	    </div><!-- /.modal-content -->
    	  </div><!-- /.modal-dialog -->
    	</div><!-- /.modal -->
       ';
    } //end - dialogvod
    
    public function www_paging(){
        
        if($this->totalpages > 1){
            //echo " <ul> ";
            if($this->blockstart > 1){
                //echo "<li> ";
                echo "	<a href=\"javascript:".$this->list."('".$this->pre."');\" ><i class=\"fas fa-angle-double-left\" ></i></a> ";
                //echo "</li>";
            }else{
                //echo "<li > ";
                echo " 	<a href=\"javascript:".$this->list."(1);\" ><i class=\"fas fa-angle-double-left\" ></i></a>";
                //echo "</li>";
            }
            for( $i = $this->blockstart; $i <= $this->blockend ; $i++ ){
                if($i == $this->page ){
                    //echo "<li  >";
                    echo " 	<a href=\"javascript:".$this->list."('".$i."');\" class='active' >".$i."</a>";
                    //echo "</li>";
                }else{
                    //echo "<li >";
                    echo " 	<a href=\"javascript:".$this->list."('".$i."');\" >".$i."</a>";
                    //echo "</li>";
                }
            }
            if( $this->blockend < $this->totalpages ){
                //echo "<li >";
                echo " 	<a href=\"javascript:".$this->list."('".$this->next."');\" ><i class=\"fas fa-angle-double-right\"></i></a> ";
                //echo "</li>";
            }else{
                //echo "<li >";
                echo " 	<a href=\"javascript:".$this->list."('".$this->totalpages."');\" ><i class=\"fas fa-angle-double-right\" ></i></a> ";
                //echo "</li>";
            }
            //echo "</ul>";
        }
        
    } // end mfpaging
    
}// END - Class