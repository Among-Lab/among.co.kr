<?php include "../lib/head.php"?>
</head>
<body>

	<?php include "../lib/top.php"?>


    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">공장 솔루션
                    <small>Solution of Company</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="./">Home</a>
                    </li>
                    <li class="active">솔루션</li>
                    <li class="active">공장 솔루션</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->


        <div class="row">
            <div class="col-md-9">
                <h2>
					<a href="#">하네스비전 검사기</a>
				</h2>
                <p><i class="fa fa-clock-o"></i> Created on <?php echo date("F d, Y H:i",time());?></p>
                <hr>
				<p>
				사람의 눈으로 검사하는 와이어링하네스의 색상 검사를 컴퓨터비전으로 실시하는 제품입니다.<br>
				인간의 눈으로 하네스의 색상 검사를 수행시 발생하는 불량을 와이어링하네스 전용으로 개발된 컴퓨터비전으로 수행함으로써 고품질의 신뢰도를 보장합니다.
				</p>

				<br>
				<p>
				<a href="#">
                    <img class="img-responsive img-hover" src="imgs/sol1_07.png" alt=""><!--846*282, ppt22.38cm-->
                </a>
				</p>

				<br>
				<br>
				<p>
				<strong>시스템 특장점</strong>
				<ul>
					<li>자동으로 하네스의 객체를 추적하는 기능이 있어서 일반적으로 색상검사에 사용하는 영역지정의 방식과는 차원이 다른 색상검사를 수행합니다.
					<li>데이터베이스가 구축이 되어 과거의 히스토리를 검색하여 활용이 가능합니다.
					<li>문자 및 숫자 인식 알고리즘의 내장으로 커넥터 및 단자대에 새겨진 문자 및 숫자를 자동으로 인식하여 활용함으로써 검사의 효율성을 기할 수 있습니다.
				</ul>
				</p>

				<br>
				<br>
				<div class="row">
					<div class="col-md-3 img-portfolio">
						<a href="#">
							<img class="img-responsive img-hover" src="./imgs/sol1_08_1.png" alt="" style="border:1px solid #333">
						</a>
						<h5>&nbsp;</h5>
					</div>
					<div class="col-md-3 img-portfolio">
						<a href="#">
							<img class="img-responsive img-hover" src="./imgs/sol1_08_2.png" alt="" style="border:1px solid #333">
						</a>
						<h5>&nbsp;</h5>
					</div>
					<div class="col-md-3 img-portfolio">
						<a href="#">
							<img class="img-responsive img-hover" src="./imgs/sol1_08_3.png" alt="" style="border:1px solid #333">
						</a>
						<h5>&nbsp;</h5>
					</div>
					<div class="col-md-3 img-portfolio">
						<a href="#">
							<img class="img-responsive img-hover" src="./imgs/sol1_08_4.png" alt="" style="border:1px solid #333">
						</a>
						<br>
						<a href="#">
							<img class="img-responsive img-hover" src="./imgs/sol1_08_5.png" alt="" style="border:1px solid #333">
						</a>
						<h5>&nbsp;</h5>
					</div>
				</div>





				<hr>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="./solution2.php">&larr; Prev</a>
                    </li>
                    <li class="next">
                        <a href="./documents.php">Next &rarr;</a>
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