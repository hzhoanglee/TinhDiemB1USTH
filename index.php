    <?php
    if(session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
        session_start();
        if($_SESSION["student-id"] == NULL){
            header('Location: auth.html');
        }
    }
    $student_id = $_SESSION["student-id"];
    require_once('db.php');
    $sql = "SELECT * FROM users WHERE sid = '$student_id'";
    $student_info = $conn->query($sql)->fetch_assoc();
    $conn->close();

    $lang = array("l_n" => "Listening & Note-taking","pre" => "Presentation","wri" => "Academic Writing","laweco" => "Law/Eco","cellbio" => "Cellular biology","gen" => "Genetics","biochem" => "Biochemistry","genmicro" => "General microbiology","genchem" => "General Chemistry I","genchem2" => "General Chemistry II","orgchem" => "Organic Chemistry","prac_chem" => "Practical chemistry","basic_pro" => "Basic programming","infor" => "Introduction to Informatics","algo" => "Introduction to Algorithms","ca" => "Computer Architecture","line" => "Linear Algebra","cal1" => "Calculus I","cal2" => "Calculus II","discrete" => "Discrete Mathematics","phys1" => "Fundamental Physics I","phys2" => "Fundamental Physics II","electro" => "Electromagnetism","prac_phys" => "Practical physics");
    $heso = array("l_n"=>2, "pre"=>3, "wri"=>3, "laweco"=>2, "cellbio"=>4, "gen"=>3, "biochem"=>3, "genmicro"=>3, "genchem"=>4, "genchem2"=>4, "orgchem"=>4, "prac_chem"=>2, "basic_pro"=>4, "infor"=>3, "algo"=>3, "ca"=>3, "line"=>4, "cal1"=>4, "cal2"=>3, "discrete"=>3, "phys1"=>4, "phys2"=>4, "electro"=>4, "prac_phys"=>2);
    switch ($_SESSION["khoa"]){
        case 'DS':
        case 'ICT':
        case 'CS':
        case 'MAT':
            $nganh = ["l_n", "pre", "wri", "laweco", "cellbio", "gen", "genchem", "genchem2", "basic_pro", "infor", "algo", "ca", "line", "cal1", "cal2", "discrete", "phys1", "phys2"];
            break;
        case 'AES':
        case 'BIT':
        case 'FST':
            $nganh = ["l_n", "wri", "pre", "laweco", "cellbio", "gen", "biochem", "genmicro", "genchem", "genchem2", "orgchem", "prac_chem", "basic_pro", "infor", "line", "cal1", "phys1", "phys2"];
            break;
        case 'CHEM':
            $nganh = ["l_n", "wri", "pre", "laweco", "cellbio", "gen", "biochem", "genmicro", "genchem", "genchem2", "orgchem", "prac_chem", "basic_pro", "infor", "line", "cal1", "phys1", "phys2","electro", "prac_phys"];
            break;
        case 'MST':
            $nganh = ["l_n", "wri", "pre", "laweco", "cellbio", "gen", "biochem", "genmicro", "genchem", "genchem2", "orgchem", "prac_chem", "basic_pro", "infor", "line", "cal1", "phys1", "phys2","electro", "prac_phys", "algo", "discrete"];
            break;
        case 'EER':
        case 'AMSN':
        case 'EPE':
            $nganh = ["l_n", "wri", "pre", "laweco", "cellbio", "gen", "genchem", "genchem2", "orgchem", "prac_chem", "basic_pro", "infor", "line", "cal1", "phys1", "phys2", "electro", "prac_phys"];
            break;
        case 'MET':
        case 'AUTO':
            $nganh = ["l_n", "pre", "wri", "laweco", "cellbio", "gen", "genchem", "genchem2", "basic_pro",  "infor", "algo", "ca", "line", "cal1", "cal2", "phys1", "phys2", "prac_phys"];
            break;
        case 'SSST':
            $nganh = ["l_n", "pre", "wri", "laweco", "cellbio", "gen", "genchem", "genchem2", "basic_pro",  "infor", "algo", "line", "cal1", "discrete", "phys1", "phys2", "electro", "prac_phys"];
            break;
        default:
            $nganh = ["l_n", "pre", "wri", "laweco", "cellbio", "gen", "biochem", "genmicro", "genchem", "genchem2", "orgchem", "prac_chem", "basic_pro", "infor", "algo", "ca", "line", "cal1", "cal2", "discrete", "phys1", "phys2", "electro", "prac_phys"];
            break;
    }

    ?>
    <!-- Em không biết code đâu, em chỉ biết google thôi, đừng soi em, xin cảm ơn. -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Lmeo rảnh quá giúp các bạn tính điểm chơi =)))">

        <!-- Title -->
        <title>Tính điểm B1 USTH 2022</title>

        <!-- Styles -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/plugins/perfectscroll/perfect-scrollbar.css" rel="stylesheet">
        <link href="assets/plugins/pace/pace.css" rel="stylesheet">
        <link href="assets/plugins/highlight/styles/github-gist.css" rel="stylesheet">
        <script src="assets/plugins/jquery/jquery-3.5.1.min.js"></script>

        <script>
            function getcal(id,value) {
                if (value > 20){
                    value = 20;
                    document.getElementById(id).value = value;
                }
                $.ajax({
                    type: 'GET',
                    url: 'cal.php',
                    data: {mon: id, diem: value},
                    success: function (response, status, xhr) {
                        $('#diem'+id).html(response.diemtrongso);
                        $('#diem4'+id).html(response.diemhe4);
                        $('#diemchu'+id).html(response.diemchu);
                        sumgpa(id, value, response.diemtrongso, response.diemhe4);
                    }
                });

            }

        </script>
        <script>
            var ketqua = {};
            function sumgpa(id, value, dtrongso, diemhe4){
                var hesotong=0;
                var trongsotong = 0;
                var gpa=0;
                var gpathang4 = 0;
                var diemthang4 = 0;
                var trongsotong4 = 0;
                ketqua[id] = {};
                ketqua[id]['raw'] = parseFloat(value);
                ketqua[id]['heso'] = parseFloat(document.getElementById('heso'+id).innerText);
                ketqua[id]['diem4'] = parseFloat(diemhe4);
                ketqua[id]['dtrongso'] = parseFloat(dtrongso);
                for (let element of Object.keys(ketqua)) {
                    let capital = ketqua[element];
                    hesotong = hesotong + capital['heso'];
                    trongsotong = trongsotong + capital['dtrongso'];
                    trongsotong4 = trongsotong4 + (capital['diem4'] * capital['heso']);
                }
                gpa = trongsotong/hesotong;
                gpa = gpa.toFixed(2);
                gpathang4 = trongsotong4/hesotong;
                gpathang4 = gpathang4.toFixed(2);
                document.getElementById('gpa').innerHTML = gpa;
                document.getElementById('gpa4').innerHTML = gpathang4;
                console.clear();
                console.log("- Tổng hệ số: " + hesotong + " tín chỉ\n- GPA Thang 20: "+ gpa + "\n- GPA Thang 4: " +gpathang4 );

            }

            function resetform()
            {
                var yo = $(':input');
                yo.each(
                    function(index){
                        var input = $(this);
                        var lmeo = input.attr('id');
                        getcal(lmeo,'');
                    }
                );
                yo.not(':button, :submit, :reset, :hidden, :checkbox, :radio').val('');
            }
        </script>


        <!-- Theme Styles -->
        <link href="assets/css/main.min.css" rel="stylesheet">
        <link href="assets/css/custom.css" rel="stylesheet">

        <link rel="icon" type="image/png" sizes="32x32" href="assets/images/usth.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="assets/images/usth.png" />

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
    <div class="app align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo">
                <a href="/" class="logo-icon"><span class="logo-text">USTH 2022</span></a>
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="#">
                        <span class="user-info-text"><?php echo $_SESSION["name"];?><br><span class="user-state-info"><?php echo $student_id;?></span></span>
                    </a>
                </div>
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">
                        Apps
                    </li>
                    <li>
                        <a href="/"><i class="material-icons-two-tone">dashboard</i>Dashboard</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="material-icons-two-tone">inbox</i>Logout</a>
                    </li>
                    <li>
                        <a href="logout.php"><i class="material-icons-two-tone">link</i>Github</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="app-container">

            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>

                            </ul>

                        </div>
                    </div>
                </nav>
            </div>
            <div class="app-content">
                <div class="content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col">
                                <div class="page-description">
                                    <h2>Xin chào</h2><h1><?php echo $_SESSION["name"];?></h1>
                                    <span>Mã Sinh Viên: <span class="badge rounded-pill badge-primary"><?php echo $_SESSION["student-id"];?></span>  -  Ngành: <span class="badge rounded-pill badge-danger"><?php echo $_SESSION["khoa"];?></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Vui lòng nhập điểm ở bên dưới</h3>
                                        <small>Điểm sẽ ghi lại để nhằm phục vụ bạn nhập liệu trong tương lai. Nếu bạn không muốn điểm được ghi lại, vui lòng ấn vào nút Xoá ở cuối trang.</small>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="card widget widget-info-navigation">
                                                        <div class="card-body">
                                                            <div class="widget-info-navigation-container">
                                                                <div class="widget-info-navigation-content">
                                                                    <span class="text-muted">GPA Thang 20</span><br>
                                                                    <span class="text-primary fw-bolder fs-2" id="gpa">0.0</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="card widget widget-info-navigation">
                                                        <div class="card-body">
                                                            <div class="widget-info-navigation-container">
                                                                <div class="widget-info-navigation-content">
                                                                    <span class="text-muted">GPA Thang 4</span><br>
                                                                    <span class="text-danger fw-bolder fs-2" id="gpa4">0.0</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="example-container">
                                                <div class="example-content">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">STT</th>
                                                            <th scope="col">Môn</th>
                                                            <th scope="col">Điểm</th>
                                                            <th scope="col">Hệ số</th>
                                                            <th scope="col">Đ.Trọng số</th>
                                                            <th scope="col">Thang 4</th>
                                                            <th scope="col">Điểm chữ</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <form name="form" id="form" >
                                                            <?php
                                                            $i = 1;
                                                            foreach ($nganh as $mon){
                                                                echo '<tr>
                                                        <th style="width: 10px; white-space: normal;">' . $i++ . '</th>
                                                        <th style="max-width: 30px; white-space: normal;">' . $lang[$mon] . '</th>
                                                        <td style="max-width: 30px"><input onchange="getcal(this.id,this.value)" type="number" max="20" min="0" value="' . $student_info[$mon] . '" class="form-control m-b-md" id="' . $mon . '"></td>
                                                        <td id="heso' . $mon . '">' . $heso[$mon] . '</td>
                                                        <td id="diem' . $mon . '">N/A</td>
                                                        <td id="diem4' . $mon . '">N/A</td>
                                                        <td id="diemchu' . $mon . '">N/A</td>
                                                    </tr>';
                                                                if($student_info[$mon] != NULL){
                                                                    echo '<script>getcal("' . $mon . '", "' . $student_info[$mon] . '")</script>';
                                                                }
                                                            }
                                                            ?>
                                                        </form>
                                                        </tbody>
                                                    </table>
                                                    <button class="btn btn-primary" onclick="resetform()">Xoá dữ liệu</button>
                                                    <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>


    <!-- Javascripts -->

    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/plugins/perfectscroll/perfect-scrollbar.min.js"></script>
    <script src="assets/plugins/pace/pace.min.js"></script>
    <script src="assets/plugins/highlight/highlight.pack.js"></script>
    <script src="assets/js/main.min.js"></script>
    <script src="assets/js/custom.js"></script>

    </body>

    </html>