<?php include "../lib/head.php"?>
</head>
<body>

	<?php include "../lib/top.php"?>


    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">사업부문
                    <small>Business of Company</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="./">Home</a>
                    </li>
                    <li class="active">사업부문</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->


        <div class="row">
            <div class="col-md-9">
                <h2>
					<a href="#">유지보수</a>
				</h2>
                <p><i class="fa fa-clock-o"></i> Created on <?php echo date("F d, Y H:i",time());?></p>
                <hr>
				<a href="#">
                    <img class="img-responsive img-hover" src="imgs/busi_01.jpg" alt=""><!--846*282-->
                </a>
				<p></p>


				<hr>
				<p>&nbsp;</p>
				<p>&nbsp;</p>


                <h2>
					<a href="#">영상인식 솔루션</a>
				</h2>
                <p><i class="fa fa-clock-o"></i> Created on <?php echo date("F d, Y H:i",time());?></p>
                <hr>
				<a href="#">
                    <img class="img-responsive img-hover" src="imgs/busi_02.jpg" alt=""><!--846*282-->
                </a>
				<p>
				</p>


				<p>&nbsp;</p>




				<hr>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="./certificate.php">&larr; Prev</a>
                    </li>
                    <li class="next">
                        <a href="./solution1.php">Next &rarr;</a>
                    </li>
                </ul>

			</div>



			<div class="col-md-3">

                <!-- Blog Search Well -->
                <div class="well">
					<form name=fsearch method=get style="margin:0px;"  action="http://search.naver.com/search.naver" target="_blank">
                    <h4>Keyword Search</h4>
                    <div class="input-group">
						<input type=hidden name=where value="nexteach">
                        <input type="text" class="form-control" name=query value="">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="image"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
					</form>
                    <!-- /.input-group -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h5><strong>Banner List</strong></h5>
                    <p>&nbsp;</p>
                </div>

            </div>

		</div><!--row-->




    </div>
    <!-- /.container -->





	<div class="clearfix"></div>
	<div class="space40"></div>

	<?php include "../lib/trail.php"?>