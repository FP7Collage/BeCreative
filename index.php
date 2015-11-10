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
  color: #7E8C8C;
  border-bottom: 7px solid #7E8C8C;
}
#results ol.progtrckr li.results {
  color: #FFFFFF;
  border-bottom: 7px solid #F1C40F;
}
#results ol.progtrckr li.details {
  color: #7E8C8C; 
  border-bottom: 7px solid #7E8C8C;
}

#blurb {
  font-size: 18px;
  font-family: verdana, Sans-serif;
  color: #FFFFFF;
}

#footer-text {
  font-size: 16px;
  font-family: verdana, Sans-serif;
  color: #FFFFFF;
}

.box1, .box2, .box3  {
  float:left;
  padding: 7px 5px 7px 5px;
  margin: 10px;
  margin-top: 0px;
  width:30.75%;
  height:250px;
  /*border: 1px solid #7195aa;*/
  //background-color: #F9FBFC;
  border-radius: 4px;
}

.box1 {
background-color: #E84C3D;
/*background-color: #2D3E50;*/
/*border: 1px solid #E84C3D;*/
border: 4px solid #C1392D;
}

.box2 {
background-color: #3598DC;
/*border: 1px solid #3598DC;*/
border: 4px solid #297FB8;
}

.box3 {
background-color: #2DCC70;
border: 4px solid #27AE61;
}

.sub-box1, .sub-box2, .sub-box3  {
  float:left;
  padding: 4px 4px 4px 4px;
  margin: 3px;
  margin-bottom:10px;
  color: #FFFFFF;
  font-family: arial black;
  width:97%;
  /*height:100px;*/
  border: 1px solid #7195aa;
  background-color:#2D3E50;
  border-radius: 4px;
}

.sub-box1 {
border: 1px solid #C1392D;
text-align: center;
}

.sub-box2 {
border: 1px solid #297FB8;
text-align: center;
}

.sub-box3 {
border: 1px solid #27AE61;
text-align: center;
}


#qmarkred {

  background:url('images/BeCreative_QM_red.png') no-repeat;
  width: 40px;
  height: 40px;
}

#qmarkred:hover {
  background:url('images/BeCreative_QM_red2.png') no-repeat;
}

#qmarkblue {

  background:url('images/BeCreative_QM_blue.png') no-repeat;
  width: 40px;
  height: 40px;
}

#qmarkblue:hover {
  background:url('images/BeCreative_QM_blue2.png') no-repeat;
}

input#prob, #sel, #gen, #imp {
  margin-left: 0px;
  padding: 7px;
  font-family: Lucida Sans, Tahoma, sans-serif;
  font-size:16px;
  font-weight:bold;
  outline: none;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  color: #ffffff;
  border: solid 1px #C1392D;
  background-color: #C1392D;
  /*border: solid 1px #2D3E50;*/
  /*background-color: #2D3E50;*/
  border-radius: 4px 4px 4px 4px;
  width:200px;
}

input#prob:hover, #sel:hover, #gen:hover, #imp:hover {
  background-color: #297FB8;
  border: solid 1px #E84C3D;
}

input#exp, #comb, #trans {
  margin-left: 0px;
  padding: 7px;
  font-family: Lucida Sans, Tahoma, sans-serif;
  font-size:16px;
  font-weight:bold;
  outline: none;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  color: #ffffff;
  border: solid 1px #297FB8;
  background-color: #297FB8;
  border-radius: 4px 4px 4px 4px;
  width:200px;
}

input#exp:hover, #comb:hover, #trans:hover {
  background-color:#3598DC;
  border: solid 1px #3598DC;

}

input#all, #searchbtn {
  margin-left: 0px;
  padding: 7px 10px 7px 10px;
  font-family: Lucida Sans, Tahoma, sans-serif;
  font-size:16px;
  font-weight:bold;
  outline: none;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  color: #ffffff;
  border: solid 1px #3598DC;
  border-bottom: solid 4px #297FB8;
  background-color: #3598DC;
  border-radius: 4px 4px 4px 4px;
}

input#all:hover, #searchbtn:hover {
  background-color:#297FB8;
  border: solid 1px #297FB8;
  border-bottom: solid 4px #297FB8;
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


#OR {
color: #FFFFFF;
font-weight:bold;
font-size:16px;
margin-top: 10px;
margin-bottom: 10px;
}

#middle {
background-color:#ECF0F1;
min-height: 380px;
background:url('images/BeCreative_pipes_makeup.png');
}

 #subtop {
background-color transparent;
/*background-color: #2D3E50;*/
min-height: 100px;
color: #FFFFFF;
font-weight: 600;
text-align: center;
font-size: 150%;
padding-top: 10px;
/*color: #ffffff;*/
}
</style>

</head>

<body id="index">

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
          <!--<div class="right-sec"> -->
                        <!--<div class="thumbnail"> -->
                          <!--<div class="caption"> -->
			            <!--<p>Follow these 3 simple steps to receive advice from the toolbox:</p><hr>-->
           <div id="subtop">
             <div class="container">
            
              <div id='blurb'>Describe your problem using 1 of the 3 search boxes below.<br>
              You can refine your search in step 2 if required.</div>
                          
              <!--<img src="images/BeCreative_process.jpg" height="75">-->
             </div>
           </div>      

                           <div class="container">
                                 <div class="box1">

                                   <div class="sub-box1">Choose which problem-solving stage you are at
                                   </div>
                                 
	                              <table>
                                     <tr><td><form id="problem" action="results.php#stage[]=Problem+definition" method="POST"><input type="submit" id="prob" value="Problem definition"></form></td><td><div id="qmarkred" title="We are still exploring the problem, trying to understand it and discover its boundaries. We cannot precisely define the problem at this time"></div></td></tr>
                                     <tr><td><form id="generation" action="results.php#stage[]=Idea+Generation" method="POST"><input type="submit" id="gen" value="Idea generation"></form></td><td><div id="qmarkred" title="We understand the problem, and now need to generate new ideas to solve it"></div></td></tr>
                                     <tr><td><form id="selection" action="results.php#stage[]=Idea+Selection" method="POST"><input type="submit" id="sel" value="Idea selection"></form></td><td><div id="qmarkred" title="We have lots of ideas, but need to work with these ideas to explore which combinations to use to solve the problem"></div></td></tr>
                                     <tr><td><form id="implementation" action="results.php#stage[]=Idea+Implementation" method="POST"><input type="submit" id="imp" value="Idea implementation"></form></td><td><div id="qmarkred" title="We know how we want to solve the problem, but now need to develop a more detailed plan or design of this solution"></div></td></tr>
	                              </table>
                                 
                                 
                               </div>

                               <div class="box2">
                                   <div class="sub-box2">Choose how best to characterise the problem solving that you are undertaking
                                   </div>


                                  <table>
                                   <tr><td><form id="exploratory" action="results.php#exploratory[]=1" method="POST"><input type="submit" id="exp" value="Exploratory"></form></td><td><div id="qmarkblue" title="We know how we want to solve the problem, and need to explore as many ideas as possible to solve the problem in that way"></div></td></tr>
                                   <tr><td><form id="combinational" action="results.php#combinational[]=1" method="POST"><input type="submit" id="comb" value="Combinational"></form></td><td><div id="qmarkblue" title="We have many ideas about how to solve the problem, and need to investigate how to combine these ideas together into possible solutions"></div></td></tr>
                                   <tr><td><form id="transformational" action="results.php#transformational[]=1" method="POST"><input type="submit" id="trans" value="Transformational"></form></td><td><div id="qmarkblue" title="We do not know how to solve the problem, and need to look at it from many different angles to uncover new directions"></div></td></tr>
                                  </table>
                                </div>

                                <div class="box3">

                                   <div class="sub-box3">Use simple keywords to search for a known technique
                                   </div>

                                 <form name="keywordSearch" action="results.php?" method="GET">
                                  <input type="text" id="searchbox" name="search" placeholder="Search here">
                                  <input type="submit" id="searchbtn" value="Search"/>
                                 </form>
                                 <div id="OR">OR</div>
                                  <form name="allTechniques" action="results.php" method="POST">
                                  <input type="submit" id="all" value="All Techniques"/>
                                 </form>
                                </div>
                         </div>
              <!--</div> -->                               
             <!--</div> -->
           <!--</div> -->
          </div>
        </div>
        <!-- /.container -->
        <!-- <div class="sub-foot">-->
    <!-- </div>-->

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
