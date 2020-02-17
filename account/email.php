<?php include 'inc/head.php'; ?>

<body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

        <a class="navbar-brand mr-1" href="index">INTELLITECH</a>

        <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Navbar Search -->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Navbar -->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-envelope fa-fw"></i>
                    <span class="badge badge-danger">7</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user-circle fa-fw"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="#">Settings</a>
                    <a class="dropdown-item" href="#">Activity Log</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
                </div>
            </li>
        </ul>

    </nav>

    <div id="wrapper">
        <!-- Sidebar -->
        <?php include 'inc/nav.php'; ?>

        <div id="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h2 class="page-header">
                            Welcome <span><?php echo $_SESSION['username'] ?></span> <sup class="btn btn-success">
                                <?php
                                if (isset($_SESSION['role'])) {
                                    if ($_SESSION['role'] == 'Admin') {
                                        echo "Admin";
                                    } else {
                                        echo "Subscriber";
                                    }
                                }
                                ?>
                            </sup>
                        </h2>
                        <hr>
                    </div>
                </div>
                <?php sendMail() ?>
                <div><?php
                    echo Error_Message();
                    echo Success_Message();
                    ?></div>
                <form id='campaignForm' action="email" method="POST">
                    <div class="row">
                        <div class="col-xl-7 form-group">
                            <label for="subject">SUBJECT:</label>
                            <input type="text" name="subject" placeholder="SUBJECT" id="subject" class="form-control">
                        </div>
                        <div class="col-xl-6 form-group">
                            <label for="">Recipients</label>
                            <textarea name="recipients" id="recipients" cols="10" rows="5" class="form-control" placeholder="Recipients"></textarea>
                            <p style="color: #56585a; font-style: italic; font-size: 14px">Enter recipients in the format info@xxxxxx.com,admin@xxxxxxxx.com. Duplicates would be filtered out</p>
                        </div>
                        <div class="col-xl-6 form-group">
                            <label for="address">Add recipients from address Book</label>
                            <select name="address" id="" class="form-control">
                                <option value="" selected disabled>Select a book to add from</option>
                            </select>
                            <label for="upload">Or Pull recipients from a text file</label>
                            <div class="row">
                                <div class="col-xl-6" class="form-group">
                                    <input type="file" id="btn_file" name="btn_file" class="form-control">
                                </div>
                                <div class="col-xl-6" class="form-group">
                                    <input type="button" id="btn_upload" name="btn_upload" value="Upload" class="btn btn-danger">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 form-group">
                            <label for="message">Massage:</label>
                            <textarea name="message" id="message" class="form-control" cols="30" rows="20"></textarea>
                        </div>
                        <div class="col-xl-12">
                            <input type="submit" value="SEND" name="sendmail" class="btn btn-success">
                        </div>
                    </div>

                    <p id="results"></p>
                </form>


            </div>
        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <!-- <footer class="sticky-footer">
      <div class="container my-auto fl">
        <div class="copyright text-center my-auto">
          <span>Copyright © Your Website 2019</span>
        </div>
      </div>
    </footer> -->

    </div>
    <!-- /.content-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="logout">Logout</a>
            </div>
        </div>
    </div>
</div>
<script src="js/tinymce/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector: "textarea#message",
            theme: "modern",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        content_css: "css/content.css",
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons fullscreen | autosave ",
                style_formats: [{
                    title: 'Bold text',                 inline: 'b'
                },
            {
                title: 'Red text',
                inline: 'span',
                styles: {
                    color: '#ff0000'
                }             },
            {
                title: 'Red header',
                block: 'h1',
                styles: {
                color: '#ff0000'
            }
                },
            {
                title: 'Example 1',
                inline: 'span',
            classes: 'example1'
                },
            {
            title: 'Example 2',
                inline: 'span',
                classes: 'example2'
            },
                {
            title: 'Table styles'
    },
    {
        title: 'Table row 1',
                selector: 'tr',
                classes: 'tablerow1'
            }
        ]
    });


    function handleFileSelect()
    {
        if (!window.File || !window.FileReader || !window.FileList || !window.Blob) {
            alert('The File APIs are not fully supported in this browser.');
            return;
        }

            input = document.getElementById('fileinput');
        if (!input) {
        alert("Um, couldn't find the fileinput element.");
        }
            else if (!input.files) {
            alert("This browser doesn't seem to support the `files` property of file inputs.");
        }
            else if (!input.files[0]) {
            alert("Please select a file before clicking 'Load'");
        }
            else {
        file = input.files[0];
    fr = new FileReader();
        fr.onload = receivedText;
            //fr.readAsText(file);
    fr.readAsDataURL(file);
        }
    }

    function receivedText() {
        document.getElementById('editor').appendChild(document.createTextNode(fr.result));
            }
</script>
<?php include 'inc/footer.php'; ?>

<script>
    $(document).ready(function () {
            $('#btn_upload').on('click', function () {
            if (!window.FileReader) {
            return alert('FileReader API is not supported by your browser.');
                }             var $i = $('#btn_file'), // Put file input ID here
                input = $i[0]; // Getting the element from jQuery
                if (input.files && input.files[0]) {
                    file = input.files[0]; // The file
                fr = new FileReader(); // FileReader instance
                    fr.onload = function () {
                        // Do stuff on onload, use fr.result for contents of file
//                    $('#recipients').text(fr.result);
                        var fileText = fr.result;
                    if (fileText != '') {
                        var emailList = fileText.split(',');
                            var resultEmail = [];
                            //                        alert(emailList);
                                $.each(emailList, function (key, email) {
                            email = email.trim();
                           if (emailCheck(email) && email != '') {
                                resultEmail.push(email);
                            }
                        //                            else {
                        //                                alert("Wrong email : " + email);
                    //                                return false;
                //                            }
                        });
                $('#recipients').text(resultEmail.join(",\n"));
                    }

                };
        fr.readAsText(file);
    } else {
        // Handle errors here                 alert("File not selected or browser incompatible.")
        }
        });
    });

            function emailCheck(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!regex.test(email)) {
            return false;
        } else {
            return true;
        }
    }

</script>

