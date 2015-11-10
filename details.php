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

	function get_details () { 

		$id = 1;
  		if(isset($_GET['id'])) {
    	  	  $id = urldecode($_GET['id']);
  		}

		$file_db = get_db();
		$sql = 'SELECT technique_name,description,people,stage,method,problem_solving,creative_phases,location,equipment,video_english,video_italian
             FROM tech
              WHERE technique_id = :id';

    		$sth = $file_db->prepare($sql);
    		$sth->execute(array(':id' => $id));
    		return $sth;
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
}
#index ol.progtrckr li.results {
  color: #95A5A5; 
  border-bottom: 7px solid #95A5A5;
}
#index ol.progtrckr li.details {
  color: #95A5A5; 
  border-bottom: 7px solid #95A5A5;
}

#results ol.progtrckr li.index {
  color: #95A5A5;
  border-bottom: 7px solid #95A5A5;
}
#results ol.progtrckr li.results {
  color: #FFFFFF;
  border-bottom: 7px solid #F1C40F;
}
#results ol.progtrckr li.details {
  color: #95A5A5; 
  border-bottom: 7px solid #95A5A5;
}

#details ol.progtrckr li.index {
  color: #516274;
  border-bottom: 7px solid #516274;
}
#details ol.progtrckr li.results {
  color: #BEC3C7;
  border-bottom: 7px solid #BEC3C7;
}
#details ol.progtrckr li.details {
  color: #FFFFFF;
  border-bottom: 7px solid #F1C40F;
}

#middle {
background-color:#ECF0F1;
min-height: 380px;
background:url('images/BeCreative_pipes_makeup.png');

}


#subtop {
/*background-color transparent;*/
margin-bottom: 10px;
color: #FFFFFF;
text-align: center;
font-size: 18px;
padding-top: 10px;
}

#subtop p {
color: #FFFFFF;
}


#basics-box {

  padding: 15px 15px 15px 15px;
  margin-bottom: 30px;
  width:100%;
  border: 2px solid #95A5A5;
  border-radius: 4px;
}


body, p, ul, ol {
font-size: 16px;
font-family: verdana, Sans-serif;
color: #EEEEEE;
}

p {
margin-bottom:16px;
}

li {
margin-bottom:12px;
}

h3 {
color: #F1C40F;
font-family: Sans-serif;
margin-top: 30px;
}

.video a {
margin-left: 10px;
}

img .left {
    display: block;
    height: 300px;
}

a img{
  border:0;
}

#pdfbtn {
  float: right;
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


</style>

</head>

<body id="details">

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

         <div id="subtop">
             <div class="container">
            
		  <?php
  			$result = get_details();
  			if(isset($_GET['id'])) {
    	  	  		$idPDF = urldecode($_GET['id']);
  			}

	
			foreach ($result as $m) {					

    			/*echo "<p>This technique is called  <b>". $m['technique_name'] ."</b>.<br>Think about how to use it to solve your business or engineering problem.</p>";*/
         		echo "<p>Think about how to use <b>". $m['technique_name'] ."</b> to solve your business or engineering problem.</p>";
			echo "</div></div><div class='right-sec'><div class='thumbnail'><div class='caption'>";
 			echo "<a href='' onclick='window.history.go(-1); return false;'>Back to search results</a>";
			echo "<form action='techniquePDF.php' method='POST' target='_blank'><input type='hidden' name='idNo' value='" . $idPDF . "' /><input type='submit' id='pdfbtn' value='Create PDF'></form>";
			echo "<h3>What is " . $m['technique_name'] . "?</h3>";
			echo $m['description'];	
			echo "<h3>What to do</h3>". $m['method'];
			echo "<h3>The basics</h3><b>People</b>";
 			echo "<p>" . $m['people'] . "</p>";
			echo "<b>Problem solving characteristics</b>";
			echo "<p>" . $m['problem_solving'] . "</p>";
			echo "<b>Creative phases</b>";
     			echo "<p>" . $m['creative_phases']  ."</p>";
			echo "<b>Location</b>";
     			echo "<p>" .$m['location']."</p>";	
			echo "<b>Equipment</b>";
     			echo "<p>" . $m['equipment']  ."</p>";
			echo "<h3>Videos</h3>";
		
			if(!isset($m['video_english']) || empty($m['video_english'])){
    			echo "<p>* No videos for this technique *</p>";
			} else {
				echo "<a class='video' target='_blank' href=". $m['video_english'] . "><figure><img src='images/video.jpg'><figcaption>VIDEO ENGLISH</figcaption></a>";
			}

			if(!isset($m['video_italian']) || empty($m['video_italian'])){
    		
			} else {
				echo "<a class='video' target='_blank' href=". $m['video_italian'] . "><figure><img src='images/video.jpg'><figcaption>VIDEO ITALIAN</figcaption></a>";
			}
			echo "</div></div></div>";						
			}	
 		?>                     
           <!-- last three php echoed divs are: /.caption /.thumbnail /.right-sec -->

        </div> <!-- /.container -->
     </div> <!-- /Wrap -->

   
    <!-- Footer -->

    <div id="footer">
        <div class="container">
           <div class="footer-left">
            <a class="navbar-link" href="http://projectcollage.eu/" target="_blank"><img src="images/BeCreative_COLLAGE_logo.png" height="45"></a>
           </div>
           <div class="footer-right">
            Use this toolbox to explore new ways to solve problems. The toolbox will provide you with advice on many different problem-solving techniques
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

            $(".selecter_label_1").selecter({
                defaultLabel: ""
            });

            $(".selecter_label_2").selecter({
                defaultLabel: ""
            });

            $(".selecter_label_3").selecter({
                defaultLabel: ""
            });

            $(".selecter_label_4").selecter({
                defaultLabel: ""
            });

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

   	










