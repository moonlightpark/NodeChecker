<?php
class CalendarMem{

    private $_this_year;
    private $_this_month;
    private $_this_day;
    private $_prev_month;
    private $_next_month;
    private $_prev_year;
    private $_next_year;
    private $_pprev_year;
    private $_nnext_year;
    private $_url ;
    private $_holiday = array();

    public function __construct($year, $month, $day,$url)
    {
        $this->__url = $url;
        $this->_this_year = $year;
        $this->_this_month = $month;
        $this->_this_day = $day;
        $this->_prev_month = $month - 1;
        $this->_next_month = $month + 1;
        $this->_prev_year = $this->_next_year = $year;
        
        if ($month == 1) {
            $this->_prev_month = 12;
            $this->_prev_year = $year - 1;
        } else if ($month == 12) {
            $this->_next_month = 1;
            $this->_next_year = $year + 1;
        }
        $this->_pprev_year = $year - 1;
        $this->_nnext_year = $year + 1;
        
        $this->_max_day = date('t', mktime(0, 0, 0, $month, 1, $year)); 
        $this->_start_week = date("w", mktime(0, 0, 0, $month, 1, $year));
        $this->_total_week = ceil(($this->_max_day + $this->_start_week) / 7);
        $this->_last_week = date('w', mktime(0, 0, 0, $month, $this->_max_day, $year));
    }
    
    public function setHoliday($data){
        $this->_holiday = $data;
    }
    
    public function print()
    {  
        $chk_holiday = Array();
        foreach ($this->_holiday as $key=>$value){
		
            $chk_holiday[(int)$value["free_day"]] = $value["title"];
        }

        $_P_URL = "javascript:CalenderM.call(".$this->_prev_year.",".$this->_prev_month.",1)";
        $_N_URL = "javascript:CalenderM.call(".$this->_next_year.",".$this->_next_month.",1)";
        ?>
	<table class="cal">
		<caption>
			<span class="prev"><a href="<?=$_P_URL?>"><</a></span> 
			<span class="next"><a href="<?=$_N_URL?>">></a></span> 
			<?php
			echo $this->_this_year . "-". $this->_this_month;
			?> 
		</caption>
		<thead>
			<tr>
				<th><span class="text-red">日</span></th>
				<th>月</th>
				<th>火</th>
				<th>水</th>
				<th>木</th>
				<th>金</th>
				<th><span class='text-blue'>土</span></th>
			</tr>
		</thead>
		<tbody>
		  <?php
            $day=1;
            $style2="";
            
            for($i=1; $i <= $this->_total_week; $i++){
                echo "<tr>";
                
                for ($j = 0; $j < 7; $j++) {
                    
                    $active_style = "";
                    $active_title = "";
                    if(isset($chk_holiday[$day])){
                        $active_style = "active";
                        $active_title = $chk_holiday[$day];
                    }
                    if($j==0 || $j == 6){
                        $active_style = "active";
                    }
                    
                    if (!(($i == 1 && $j < $this->_start_week) || ($i == $this->_total_week && $j > $this->_last_week))) {
	                    
	                    if ($this->_this_day == $day){
                        	$style2 = "background-color: #808B96";
                        	echo '<td class="'.$active_style.'" style="'.$style2.'" > ';
                        }else{
                        	$style2 = "";
                        	echo '<td class="'.$active_style.'"  title="'.$active_title.'" ><a href="javascript:void(0);">';
                        }
	                    
                         
                        if ($j == 0) {
                            $style = "text-red";
                        } else if ($j == 6) {
                            $style = "text-blue";
                        } else {
                            $style = "";
                        }                        
                        
                        if ($this->_this_day == $day && $this->_this_month == date("m") ){
                        	echo "<p style='font-color:#000;color:#fff'>".$day."</p>";
                        }else{
                        	echo $day;
                        }

                        $day++;
                    }else{
                        echo '<td><a href="#">'; 
                        
                    }
                    echo '</a></td>';
                 }
			     echo "</tr>";
            }
			?>
		</tbody>
	</table>
<?php
    }

    public function toSting()
    {
        echo $this->_this_year . "/" . $this->_this_month . "/" . $this->_this_day;
    }
}

