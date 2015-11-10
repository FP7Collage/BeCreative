/* Aspects of this code reference http://srchulo.com/jquery_plugins/jquery_facets.html
* The MIT License

* Copyright (c) 2013 Adam Hopkins, Inc. http://srchulo.com

* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:

* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.

* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/

<?php
	
	function get_db() { 
           $db = NULL;
             $user = '';
             $pass = '';
		 if(!$db)
			 $db = new PDO('', $user, $pass);
		 return $db;
	}

	function get_tecnqs () { 
		$file_db = get_db();
		$id_where = "";
		$where = "";
		$vals = array();
		$id_vals = array();

          if(isset($_GET['search'])){ 
		if($_GET['search'] != "")  {
		 	$words = explode(" ", $_GET['search']);
			
			$id_where = " WHERE ";
			foreach($words as $word) { 
				$word = "%$word%";
				$id_where .= "technique_name LIKE ? OR description LIKE ? OR stage LIKE ? OR method LIKE ? OR example LIKE ? OR";
				array_push($id_vals, $word, $word, $word, $word, $word);
			}

			$id_where = substr($id_where, 0, -3);
		}
          }

		$stmt = $file_db->prepare("SELECT technique_id FROM tech $id_where ORDER BY technique_name ASC");
		$stmt->execute($id_vals);

		$ids_list = "";
		while($tecnq = $stmt->fetch()) { 
			$ids_list .= $tecnq['technique_id'] . ",";	
		}
		$ids_list = substr($ids_list, 0, -1);

		#return if we got no results from search!
		if($ids_list == "") { 
			return $stmt;
		}

		unset($_GET['search']);

		#if we have facets
		if(count($_GET) > 0) { 

		    #handle specialCases

               if(isset($_GET['People'])){
			if($_GET['People'] != "") { 
				$where .= " AND $_GET[People] >= People AND $_GET[People] <= maxPeople";
			}
               }

			unset($_GET['People']);
			unset($_GET['maxPeople']);


               if(isset($_GET['minYear'])){
			if($_GET['minYear'] != "") {
				$where .= " AND year >= $_GET[minYear] ";
			}
               }

               if(isset($_GET['minYear'])){
			if($_GET['maxYear'] != "") {
				$where .= " AND year <= $_GET[maxYear] ";
			}
               }

			unset($_GET['minYear']);
			unset($_GET['maxYear']);


			foreach($_GET as $key=>$value) {
				if(is_array($value)) {
					$where .= " AND $key IN (";
					foreach($value as $el) { 
						$where .= "?,";
						array_push($vals, $el);
					}
					$where = substr($where, 0, -1);
					$where .= ") ";
				}
				else { 
					$where .= " AND $key=? ";
					array_push($vals, $value);
				}
			}
		}

		$stmt = $file_db->prepare("SELECT * FROM tech WHERE technique_id IN ($ids_list) $where ORDER BY technique_name ASC");
		$stmt->execute($vals);

		return $stmt;
	}

	function grid_view($stmt) { 
		$string = "";
		while ($tecnq = $stmt->fetch()) {
			$conds = explode("_", $tecnq['stage']);
			
			$stage = ucfirst($conds[0]);
			if(count($conds) > 1) { 
				$stage .= " " . ucfirst($conds[1]);
			}

                $desc = $tecnq['description'];
			$techid = $tecnq['technique_id'];
                /*$definition = strstr($desc, '</p>', true). "..";*/
			$definition = $tecnq['short_desc'];
			$minPeople = $tecnq['minPeople'];
			
			if ($tecnq['maxPeople']==10000){
				$maxPeople = "Many";
			} else {
				$maxPeople = $tecnq['maxPeople'];
			}

			$exp = $tecnq['exploratory'];
			$comb = $tecnq['combinational'];
			$trans = $tecnq['transformational'];

			$boden = "";
			if($exp){
				$boden = "Exploratory";
			}
			if($comb){
				$boden .= ", Combinational";
			}
			if($trans){
				$boden .= ", Transformational";
			}
			



			$string .= "
				<div class='col-md-12 col-sm-6'>
                            <div class='thumbnail'>
                                
                                    <div class='caption'>
                                       <h4 class='title'><a href='details.php?id=" . $techid ."'>" .  " $tecnq[technique_name] </a></h4>
							   
                                        <ul class='list-unstyled'>

                                            <li><span><strong></strong> " . $definition . "
                                            </li>
								 <li><span><strong>Stage:</strong> " . $stage . "</span>
                                            <span><strong>People:</strong> " . $minPeople . "&#8211;" . $maxPeople ."</span>
								  <span><strong>Boden:</strong> " . $boden . "</span>
                                            </li>
                                        </ul>
                                       
                                    </div>
                                </div>
								</div>
								";
		}	

		if($string == "") { 
			$string = "<h3 style='text-align:center;color:white;'>NO RESULTS</h3>";
		}

		return $string;
	}

	function get_models () { 
		$file_db = get_db();
		return $file_db->query('SELECT DISTINCT make FROM tecnqs ORDER BY make ASC');
	}


if(isset($_GET['ajax'])){
	if($_GET['ajax'] == "true") {
		unset($_GET['ajax']);
		echo grid_view(get_tecnqs());
		exit;
	}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>



    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BeCreative</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS Assets -->

    <link href="assets/css/scojs.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.fs.picker.css">
    <link href="assets/css/jquery.fs.selecter.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.fs.scroller.css">
    <link rel="stylesheet" href="assets/css/font-awesome.css">
    <link href="assets/css/theme.css" rel="stylesheet">
<style>


<!-- Progress with steps -->

ol.progtrckr {
  margin: 0;
  padding: 0;
  list-style-type none;
}

ol.progtrckr li {
  display: inline-block;
  text-align: center;
  line-height: 30px;
}

ol.progtrckr li { 
  width: 32%;
}

#index ol.progtrckr li.index {
  color: #FFFFFF;
  border-bottom: 7px solid #F1C40F;
  font-size: 16px;
  font-family: verdana, Sans-serif;
}
#index ol.progtrckr li.results {
  color: #BEC3C7;
  border-bottom: 7px solid #BEC3C7;
  font-size: 16px;
  font-family: verdana, Sans-serif;
}
#index ol.progtrckr li.details {
  /*color: #95A5A5;*/
  color: #7E8C8C; 
  border-bottom: 7px solid #7E8C8C;
  font-size: 16px;
  font-family: verdana, Sans-serif;
}

#results ol.progtrckr li.index {
  color: #BEC3C7;
  border-bottom: 7px solid #BEC3C7;
  font-size: 16px;
  font-family: verdana, Sans-serif;

}
#results ol.progtrckr li.results {
  color: #FFFFFF;
  border-bottom: 7px solid #F1C40F;
  font-size: 16px;
  font-family: verdana, Sans-serif;

}
#results ol.progtrckr li.details {
  color: #BEC3C7; 
  border-bottom: 7px solid #BEC3C7;
  font-size: 16px;
  font-family: verdana, Sans-serif;

}

#middle {
background-color:#ECF0F1;
min-height: 380px;
background:url('images/BeCreative_pipes_makeup.png');
}

h4 {
  color: #FFFFFF;
}

.right-sec .thumbnail a {
color: #FFFFFF;
}

input#searchbox {
  margin-left: 0px;
  padding: 7px 14px 7px 10px;
  font-family: Lucida Sans, Tahoma, sans-serif;
  font-size:16px;
  outline: none;
  text-decoration: none;
  border: solid 1px #3598DC;
  background-color: #FFFFFF;
  border-radius: 4px 4px 4px 4px;
}

#searchbtn {
  margin-left: 0px;
  padding: 7px 10px 7px 10px;
  font-family: Verdana, Lucida Sans, Tahoma, sans-serif;
  font-size:14px;
  font-weight:bold;
  outline: none;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  color: #ffffff;
  border: solid 1px #558ED5;
  background-color: #558ED5;
  border-radius: 4px 4px 4px 4px;
}

#sub-box {
  padding: 4px 4px 4px 4px;
  margin: 3px;
  margin-bottom:10px;
  color: #FFFFFF;
  font-family: arial black;
  width:97%;
  /*height:100px;*/
  border: 1px solid #C1392D;
  background-color:#2D3E50;
  border-radius: 4px;
}

#footer-text {
  font-size: 16px;
  font-family: verdana, Sans-serif;
  color: #FFFFFF;
}

.right-sec .thumbnail {
font-family: Verdana,sans-serif;
border-radius: 4px;
-moz-border-radius: 4px;
-webkit-border-radius: 4px;	
padding:0px;
padding-top: 0px;
margin-bottom: 10px;
margin-left: 0%;
margin-right: 3%;
border: 4px solid #ECF0F1;

background-color:#253241;
color: #EEEEEE;

}

</style>

</head>


<body id="results">

    <!-- /Wrap -->
    <div id="wrap">

        <nav class="navbar  navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img src="images/BeCreative_logo_black.png" ></a>                 
                    
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">


                    <div class="btn-toolbar pull-right">
                     
                    	<p class="navbar-text pull-right">
				  <a class="navbar-link" href="JavaScript: infopop()" onMouseOver="window.status='Status Bar Message'; return true" onMouseOut="window.status=''; return true"><img src="images/BeCreative_about.png" height="75"></a>
                       <a class="navbar-link" href="JavaScript: infopop2()" onMouseOver="window.status='Status Bar Message'; return true" onMouseOut="window.status=''; return true"><img src="images/BeCreative_contact.png" height="75"></a>
				</p>
                    </div>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <div id="top">
            <nav class="secondary navbar navbar-default" role="navigation">
                <div class="container">

                    <!-- Put progress bar in here-->
                      <div>
                        <ol class="progtrckr">
                          <li class="index"><strong>1. Problem description</strong></li>
                          <li class="results"><strong>2. Search results</strong></li>
                          <li class="details"><strong>3. Technique</strong></li>
                        </ol>
                      </div>
                </div>
            </nav>
        </div>

     <div id="middle">
        <div class="container">

            <div class="row">

                <div class="col-md-3 col-sm-4"> 
                    <!-- left sec -->
                    <div class="left-sec">

                        <div class="left-cont">
                          <h4><span class="glyphicon glyphicon-search"></span> Search for Technique</h4>
                            <form class="navbar-form navbar-left" role="search" action="results.php">
                               <div class="form-group">
							<input name="search" type="text" id="searchbox" placeholder="Search here" value="<?php if(isset($_GET['search'])){ $search = $_GET['search']; }?>">
							<!--<input name="search" type="text" class="form-control input-lg" placeholder="Search..." value="<?php if(isset($_GET['search'])){ $search = $_GET['search']; }?>">-->
                               </div>
                            </form>

                            <h4>Refine Search</h4>
			   <form class="filter-sec" id="facets">
                               
				<h5>Problem-solving stage:</h5>
				  <div class="">

                                    <input name="stage[]" class="checkbox" id="new" type="checkbox" value="Problem definition" />
                                    <label for="new">Problem definition</label>

                                    <input name="stage[]" class="checkbox" id="like_new" type="checkbox" value="Idea Generation" />
                                    <label for="like_new">Idea Generation</label>

                                    <input name="stage[]" class="checkbox" id="used" type="checkbox" value="Idea Selection" />
                                    <label for="used">Idea Selection</label>

                                    <input name="stage[]" class="checkbox" id="really_used" type="checkbox" value="Idea Implementation" />
                                    <label for="really_used">Idea implementation</label>

                                </div>

                                <h5>Number of people:</h5>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6">
                                        <input name="People" id="People" type="text" class="form-control input-sm" placeholder="Number">
                                    </div>
                                </div>
                               
				<h5>Problem solving characteristic:</h5>
				  <div class="">
                                    <input name="exploratory[]" class="checkbox" id="red" type="checkbox" value="1" />
                                    <label for="red">Exploratory</label>

                                    <input name="combinational[]" class="checkbox" id="blue" type="checkbox" value="1" />
                                    <label for="blue">Combinational</label>

                                    <input name="transformational[]" class="checkbox" id="green" type="checkbox" value="1" />
                                    <label for="green">Transformational</label>
                                </div>
                            </form>
					<!--<a href='results.php'>RESET ALL</a>-->

                            <form name="reset" action="results.php" method='POST'>

                                  <input type="submit" id="searchbtn" value="Reset all"/>
                            </form>
                        </div>                     
                    </div>
                    <!-- /left sec -->
                </div>
                <div class="col-md-9 col-sm-8">
                    <div class="right-sec">
                        
                        <div class="row" id="searchCont">
							<?php echo grid_view(get_tecnqs()); ?>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
           </div>
            <!--<hr> -->
            <!--<hr> -->

        </div>
        <!-- /.container -->
        <div class="sub-foot">
    </div>

    <!-- /Wrap -->

    <!-- Footer -->

    <div id="footer">
        <div class="container">
           <div class="footer-left">
            <a class="navbar-link" href="http://projectcollage.eu/" target="_blank"><img src="images/BeCreative_COLLAGE_logo.png" height="45"></a>
           </div>
           <div class="footer-right">
            <div id='footer-text'>Use this toolbox to explore new ways to solve problems. The toolbox will provide you with advice on many different problem-solving techniques</div>
           </div>
        </div>
    </div>

    <!-- /Footer -->


    <!-- javascript -->
    <script src="js/jquery.min.js"></script>
    <script type='text/javascript' src='js/jquery.deserialize.js'></script> 
    <script type='text/javascript' src='js/jquery.facets.js'></script>
    <script type='text/javascript' src='js/demo.js'></script>

    <script src="assets/js/jquery.fs.selecter.js"></script>
    <script src="assets/js/jquery.fs.picker.js"></script>
    <script src="assets/js/jquery.fs.scroller.js"></script>

    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/theme.js"></script>
    <script src="assets/js/sco.modal.js"></script>
    <script src="assets/js/sco.confirm.js"></script>
    <script src="assets/js/sco.ajax.js"></script>
    <script src="assets/js/sco.collapse.js"></script>
    <script src="assets/js/sco.countdown.js"></script>
    <script src="assets/js/sco.message.js"></script>

    <script>
        $(document).ready(function (e) {

            $("input[type=checkbox], input[type=radio]").picker();
  
        });
    </script>
    <script>
	function infopop() {
  		window.open('BCabout.html','infopop','toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=yes,copyhistory=no,scrollbars=yes,width=500,height=500');
	}

	function infopop2() {
  		window.open('BCcontact.html','infopop','toolbar=no,location=no,directories=no,status=no,menubar=no,resizable=yes,copyhistory=no,scrollbars=yes,width=500,height=400');
	}
     </script>
    <!-- /Javascript -->
</body>
</html>
