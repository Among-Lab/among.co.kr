<?php include "../lib/head.php"?>
</head>
<body>

	<?php include "../lib/top.php"?>


    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">고객지원
                    <small>Support of Company</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="./">Home</a>
                    </li>
                    <li class="active">고객지원</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->


        <div class="row">
            <div class="col-md-9">
                <h2>
					<a name="catalog">카달로그</a>
				</h2>
                <p><i class="fa fa-clock-o"></i> Created on <?php echo date("F d, Y H:i",time());?></p>
                <hr>
				<p>
				아몽 솔루션 카달로그입니다.
				</p>



				<hr>
				<p>&nbsp;</p>
				<p>&nbsp;</p>


                <h2>
					<a name="manual">메뉴얼 및 관련문서</a>
				</h2>
                <p><i class="fa fa-clock-o"></i> Created on <?php echo date("F d, Y H:i",time());?></p>
                <hr>
				<p></p>
				<div class="row">
					<div class="col-md-2 img-portfolio">
						<a href="#">
							<img class="img-responsive img-hover" src="./imgs/doc_01.png" alt="" style="border:1px solid #333">
						</a>
						<h5>차량번호인식 DVR 사용자메뉴얼 <a href="./pds/manual_DVR_20100728.pdf">[download]</a></h5>
					</div>
				</div>







				<hr>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="./solution3.php">&larr; Prev</a>
                    </li>
                    <li class="next">
                        <a href="./contact.php">Next &rarr;</a>
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