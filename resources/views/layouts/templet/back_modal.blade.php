<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="profileModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Informasi Profil</h4>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <div class="row">
                <div class="container-fluid px-2 px-md-4">
                    <div class="page-header min-height-150 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1920&amp;q=80');">
                        <span class="mask  bg-gradient-primary  opacity-6"></span>
                    </div>
                    <div class="card card-body mx-3 mx-md-4 mt-n6">
                        <div class="row gx-4 mb-2">
                            <div class="col-auto">
                                <div class="avatar avatar-xl position-relative">
                                <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-2.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm" id="fotoprofil"><span id="fotomasknya" class="">Resigned</span>
                                </div>
                            </div>
                            <div class="col-auto my-auto">
                                <div class="h-100">
                                    <h5 class="mb-1" id="namaprofil">
                                        Eddo Ertino
                                    </h5>
                                    <p class="mb-0 font-weight-normal text-sm">
                                        Programmer
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                                <!-- for tabular -->
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Detail</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Histori</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-file-tab" data-bs-toggle="pill" href="#pills-file" role="tab" aria-controls="pills-file" aria-selected="false">Overview</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                    <!--start -->
                                    <div class="row">
                                        <div class="card card-plain h-100">
                                            <div class="card-header pb-0 p-3">
                                            <div class="row">
                                                <div class="col-md-8 d-flex align-items-center">
                                                <h6 class="mb-0">Profile Information</h6>
                                                </div>
                                                <div class="col-md-4 text-end">
                                                <a href="javascript:;">
                                                    <i class="fas fa-envelope-square text-secondary text-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="" aria-hidden="true" data-bs-original-title="Kirim Pesan" aria-label="Kirim Pesan"></i><span class="sr-only">Kirim Pesan</span>
                                                </a>
                                                </div>
                                            </div>
                                            </div>
                                            <div class="card-body p-3">
                                            <p class="text-sm" id="sapaanprofil">
                                                Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).
                                            </p>
                                            <hr class="horizontal gray-light my-4">
                                            <ul class="list-group">
                                                <li class="list-group-item border-0 ps-0 pb-0">
                                                <strong class="text-dark text-sm">Social:</strong> &nbsp;
                                                <a class="btn btn-facebook btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                                    <i class="fab fa-facebook fa-lg" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-twitter btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                                    <i class="fab fa-twitter fa-lg" aria-hidden="true"></i>
                                                </a>
                                                <a class="btn btn-instagram btn-simple mb-0 ps-1 pe-2 py-0" href="javascript:;">
                                                    <i class="fab fa-instagram fa-lg" aria-hidden="true"></i>
                                                </a>
                                                </li>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!--ends -->
                                    <hr />
                                    <div class="row mb-4">
                                        <div class="card card-plain h-100">
                                            <div class="card-header pb-0 p-3">
                                        
                                            <div class="row">
                                                <div class="col-lg-6 col-7">
                                                    <h6>Projects</h6>
                                                    <p class="text-sm mb-0">
                                                    <i class="fa fa-check text-info" aria-hidden="true"></i>
                                                    <span class="font-weight-bold ms-1">30 done</span> this month
                                                    </p>
                                                </div>
                                                <div class="col-lg-6 col-5 my-auto text-end">
                                                    <div class="dropdown float-lg-end pe-4">
                                                        <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v text-secondary" aria-hidden="true"></i>
                                                        </a>
                                                        <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                                                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a></li>
                                                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else here</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="card-body px-0 pb-2">
                                            <div class="table-responsive">
                                                <table class="table align-items-center mb-0">
                                                <thead>
                                                    <tr>
                                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Companies</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Budget</th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Completion</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="https://surat.cilacapkab.go.id/assets/assets_login/img/icon/logoasoka.png" class="avatar avatar-sm me-3" alt="xd">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Material XD Version</h6>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> $14,000 </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="progress-wrapper w-75 mx-auto">
                                                        <div class="progress-info">
                                                            <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold">60%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-info w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/logos/small-logos/logo-invision.svg" class="avatar avatar-sm me-3" alt="atlassian">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Add Progress Track</h6>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> $3,000 </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="progress-wrapper w-75 mx-auto">
                                                        <div class="progress-info">
                                                            <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold">10%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-info w-10" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/logos/small-logos/logo-jira.svg" class="avatar avatar-sm me-3" alt="team7">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Fix Platform Errors</h6>
                                                        </div>
                                                        </div>
                                                    </td>
                                    
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> Not set </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="progress-wrapper w-75 mx-auto">
                                                        <div class="progress-info">
                                                            <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold">100%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-success w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                    <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                        <div>
                                                            <img src="https://demos.creative-tim.com/soft-ui-design-system-pro/assets/img/logos/small-logos/logo-slack.svg" class="avatar avatar-sm me-3" alt="spotify">
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">Launch our Mobile App</h6>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <td class="align-middle text-center text-sm">
                                                        <span class="text-xs font-weight-bold"> $20,500 </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="progress-wrapper w-75 mx-auto">
                                                        <div class="progress-info">
                                                            <div class="progress-percentage">
                                                            <span class="text-xs font-weight-bold">100%</span>
                                                            </div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-gradient-success w-100" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        </div>
                                                    </td>
                                                    </tr>
                                                    
                                                </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!--ends here-->
                                </div>

                                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                    <div class="row mt-4">
                                        <!-- start-->
                                        <div class="col-lg-12 col-md-12">
                                            <div class="card card-plain h-100">
                                                <div class="card-header pb-0">
                                                <h6>Aktifitas Terakhir</h6>
                                                <p class="text-sm">
                                                    <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                                                    <span class="font-weight-bold">21-Nov-2021</span> Terakhir Login
                                                </p>
                                                </div>
                                                <div class="card-body p-3">
                                                <div class="timeline timeline-one-side">
                                                    <div class="timeline-block mb-3">
                                                    <span class="timeline-step">
                                                        <i class="material-icons text-success text-gradient">notifications</i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h6 class="text-dark text-sm font-weight-bold mb-0">$2400, Design changes</h6>
                                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                                                    </div>
                                                    </div>
                                                    <div class="timeline-block mb-3">
                                                    <span class="timeline-step">
                                                        <i class="material-icons text-danger text-gradient">code</i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h6 class="text-dark text-sm font-weight-bold mb-0">New order #1832412</h6>
                                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 11 PM</p>
                                                    </div>
                                                    </div>
                                                    <div class="timeline-block mb-3">
                                                    <span class="timeline-step">
                                                        <i class="material-icons text-info text-gradient">shopping_cart</i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Server payments for April</h6>
                                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">21 DEC 9:34 PM</p>
                                                    </div>
                                                    </div>
                                                    <div class="timeline-block mb-3">
                                                    <span class="timeline-step">
                                                        <i class="material-icons text-warning text-gradient">credit_card</i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h6 class="text-dark text-sm font-weight-bold mb-0">New card added for order #4395133</h6>
                                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">20 DEC 2:20 AM</p>
                                                    </div>
                                                    </div>
                                                    <div class="timeline-block mb-3">
                                                    <span class="timeline-step">
                                                        <i class="material-icons text-primary text-gradient">key</i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h6 class="text-dark text-sm font-weight-bold mb-0">Unlock packages for development</h6>
                                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">18 DEC 4:54 AM</p>
                                                    </div>
                                                    </div>
                                                    <div class="timeline-block">
                                                    <span class="timeline-step">
                                                        <i class="material-icons text-dark text-gradient">payments</i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h6 class="text-dark text-sm font-weight-bold mb-0">New order #9583120</h6>
                                                        <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">17 DEC</p>
                                                    </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- ends -->
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-file" role="tabpanel" aria-labelledby="pills-file-tab">
                                    <div class="row mt-4">
                                        <div class="col-lg-6 col-md-6 mt-4 mb-4">
                                            <div class="card z-index-2 ">
                                                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                                    <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                                        <div class="chart">
                                                            <canvas id="chart-bars" class="chart-canvas" height="340" width="631" style="display: block; box-sizing: border-box; height: 170px; width: 315.7px;"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="mb-0 ">Website Views</h6>
                                                    <p class="text-sm ">Last Campaign Performance</p>
                                                    <hr class="dark horizontal">
                                                    <div class="d-flex ">
                                                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                                                        <p class="mb-0 text-sm"> campaign sent 2 days ago </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 mt-4 mb-4">
                                            <div class="card z-index-2  ">
                                                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                                                    <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                                                        <div class="chart">
                                                            <canvas id="chart-line" class="chart-canvas" height="340" width="631" style="display: block; box-sizing: border-box; height: 170px; width: 315.7px;"></canvas>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                     <h6 class="mb-0 "> Daily Sales </h6>
                                                    <p class="text-sm "> (<span class="font-weight-bolder">+15%</span>) increase in today sales. </p>
                                                    <hr class="dark horizontal">
                                                    <div class="d-flex ">
                                                        <i class="material-icons text-sm my-auto me-1">schedule</i>
                                                        <p class="mb-0 text-sm"> updated 4 min ago </p>
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
            </div>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="appModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Informasi Aplikasi</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
      <!-- Modal body -->
        <div class="modal-body">
            <!-- starts here for detail -->
            <div class="row">
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-0">ASOKA</h6>
                                </div>
                            </div>
                            </div>
                            <div class="card-body p-3">
                            <p class="text-sm">
                                Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).
                            </p>
                            <hr class="horizontal gray-light my-4">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Versi:</strong> 1.1</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Update Terakhir:</strong> 15 Nov 2021 +7 GMT</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Error / Bug Dilaporkan:</strong> 15 / 12 (Diselesaikan)</li>
                            </ul>
                            <div class="d-flex align-items-center justify-content-between">
                                <strong class="text-dark">Tech in use:</strong>
                                <div class="avatar-group mt-2">
                                <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="CodeIgniter">
                                    <img alt="Image placeholder" src="https://www.studentstutorial.com/codeigniter/images/codeigniter-tutorial.png?ezimgfmt=ng%3Awebp%2Fngcb2%2Frs%3Adevice%2Frscb2-2">
                                </a>
                                <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="MySQL">
                                    <img alt="Image placeholder" src="https://www.nesabamedia.com/wp-content/uploads/2019/09/MySQL-Logo-1.png">
                                </a>
                                <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Flask">
                                    <img alt="Image placeholder" src="https://miro.medium.com/max/800/1*Q5EUk28Xc3iCDoMSkrd1_w.png">
                                </a>
                                <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Express JS">
                                    <img alt="Image placeholder" src="https://raw.githubusercontent.com/aleksandryackovlev/openapi-mock-express-middleware/master/assets/express-logo.png">
                                </a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                            <h6 class="mb-0">PIC</h6>
                            </div>
                            <div class="card-body p-3">
                            <ul class="list-group">
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                                <div class="avatar me-3">
                                    <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-3.jpg" alt="kal" class="border-radius-lg shadow">
                                </div>
                                <div class="d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">Eddo Ertino</h6>
                                    <p class="mb-0 text-xs">Programmer</p>
                                </div>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="avatar me-3">
                                    <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-1.jpg" alt="kal" class="border-radius-lg shadow">
                                </div>
                                <div class="d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">Ridwan Arifin</h6>
                                    <p class="mb-0 text-xs">DevOps</p>
                                </div>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="avatar me-3">
                                    <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-2.jpg" alt="kal" class="border-radius-lg shadow">
                                </div>
                                <div class="d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">Brianna</h6>
                                    <p class="mb-0 text-xs">Ruslana</p>
                                </div>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <!-- end here for detail -->
            <!--- start here -->
            <div class="row">
                <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                        <h6 class="text-white text-capitalize ps-3">Integrasi</h6>
                    </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center justify-content-center mb-0">
                        <thead>
                            <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aplikasi</th>
                            
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Modul Integrasi</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Host / Client</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis Integrasi</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center opacity-7 ps-2">Completion</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <td>
                                <div class="d-flex px-2">
                                <div>
                                    <img src="http://esign.cilacapkab.go.id/images/bse-white-logo.png" class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                </div>
                                <div class="my-auto">
                                    <h6 class="mb-0 text-sm">eSign BrsE</h6>
                                </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">Tanda Tangan Elektronik</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">Client</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">API</p>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                <span class="me-2 text-xs font-weight-bold">60%</span>
                                <div>
                                    <div class="progress">
                                    <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                    </div>
                                </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <button class="btn btn-link text-secondary mb-0">
                                <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                                </button>
                            </td>
                            </tr>

                            <tr>
                            <td>
                                <div class="d-flex px-2">
                                <div>
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/Application-default-icon.svg/1024px-Application-default-icon.svg.png" class="avatar avatar-sm rounded-circle me-2" alt="spotify">
                                </div>
                                <div class="my-auto">
                                    <h6 class="mb-0 text-sm">Reksobahu</h6>
                                </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">Pengecheckan Proposal</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">Host</p>
                            </td>
                            <td>
                                <p class="text-sm font-weight-bold mb-0">API</p>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                <span class="me-2 text-xs font-weight-bold">100%</span>
                                <div>
                                    <div class="progress">
                                    <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                                    </div>
                                </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <button class="btn btn-link text-secondary mb-0">
                                <i class="fa fa-ellipsis-v text-xs" aria-hidden="true"></i>
                                </button>
                            </td>
                            </tr>
                            
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <!-- end here -->
            <!--start calendar -->
            
        
            <!-- end calendar -->
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

    </div>
  </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="integrationModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Informasi Integrasi</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
      <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                <div class="col-6 col-md-6 col-xs-6">
                    <img src="http://dev1.cilacapkab.go.id/assets/assets_login/img/icon/logoasoka.png" style="width:100px; float:right;" class="border-radius-lg">
                </div>
                <div class="col-6 col-md-6 col-xs-6">
                    <img src="https://pbs.twimg.com/profile_images/910343339949600768/MxS2t2xb_400x400.jpg" style="width:100px; float:left;" class="border-radius-lg">
                </div>
            </div>

            <div class="row">
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                            <div class="row">
                                <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-0">Detail Integrasi</h6>
                                </div>
                            </div>
                            </div>
                            <div class="card-body p-3">
                            <p class="text-sm">
                                Hi, I’m Alec Thompson, Decisions: If you can’t decide, the answer is no. If two equally difficult paths, choose the one more painful in the short term (pain avoidance is creating an illusion of equality).
                            </p>
                            <hr class="horizontal gray-light my-4">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Versi :</strong> 1.1</li>
                                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Jenis :</strong> API</li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Update Terakhir :</strong> 15 Nov 2021 +7 GMT</li>
                            </ul>
                            <div class="d-flex align-items-center justify-content-between">
                                <strong class="text-dark">Tech in use:</strong>
                                <div class="avatar-group mt-2">
                                <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="CodeIgniter">
                                    <img alt="Image placeholder" src="https://www.studentstutorial.com/codeigniter/images/codeigniter-tutorial.png?ezimgfmt=ng%3Awebp%2Fngcb2%2Frs%3Adevice%2Frscb2-2">
                                </a>
                                <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="MySQL">
                                    <img alt="Image placeholder" src="https://www.nesabamedia.com/wp-content/uploads/2019/09/MySQL-Logo-1.png">
                                </a>
                                <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Flask">
                                    <img alt="Image placeholder" src="https://miro.medium.com/max/800/1*Q5EUk28Xc3iCDoMSkrd1_w.png">
                                </a>
                                <a href="javascript:;" class="avatar avatar-xs rounded-circle" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Express JS">
                                    <img alt="Image placeholder" src="https://raw.githubusercontent.com/aleksandryackovlev/openapi-mock-express-middleware/master/assets/express-logo.png">
                                </a>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="card card-plain h-100">
                            <div class="card-header pb-0 p-3">
                            <h6 class="mb-0">PIC</h6>
                            </div>
                            <div class="card-body p-3">
                            <ul class="list-group">
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                                <div class="avatar me-3">
                                    <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-3.jpg" alt="kal" class="border-radius-lg shadow">
                                </div>
                                <div class="d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">Eddo Ertino</h6>
                                    <p class="mb-0 text-xs">Programmer</p>
                                </div>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="avatar me-3">
                                    <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-1.jpg" alt="kal" class="border-radius-lg shadow">
                                </div>
                                <div class="d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">Ridwan Arifin</h6>
                                    <p class="mb-0 text-xs">DevOps</p>
                                </div>
                                </li>
                                <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                                <div class="avatar me-3">
                                    <img src="https://demos.creative-tim.com/test/material-dashboard-pro/assets/img/team-2.jpg" alt="kal" class="border-radius-lg shadow">
                                </div>
                                <div class="d-flex align-items-start flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">Brianna</h6>
                                    <p class="mb-0 text-xs">Ruslana</p>
                                </div>
                                </li>
                            </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>

    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="agendaModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Informasi Agenda</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
      <!-- Modal body -->
        <div class="modal-body">
            <div class="row mb-4">
                <form>     
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="exampleFormControlSelect1" class="ms-0">Aplikasi</label>
                                <input type="text" id="dapp_name" name="dapp_name" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="exampleFormControlSelect1" class="ms-0">Jenis Servis</label>
                                <input type="text" id="djenis_servis" name="djenis_servis" class="form-control" readonly>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="exampleFormControlSelect1" class="ms-0">OPD</label>
                                <input type="text" id="dOPD" name="dOPD" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="exampleFormControlSelect1" class="ms-0">Tanggal</label>
                                <input type="text" id="dtgl_permohonan" name="dtgl_permohonan" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label class="ms-0">Keterangan</label>
                                <input type="text" id="dketerangan" name="dketerangan" class="form-control" onchange="checkAll(this.value,'ket')">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label for="exampleFormControlSelect1" class="ms-0">Lokasi</label>
                                <input type="text" id="dlokasi" name="dlokasi" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label class="ms-0">email pemohon</label>
                                <input type="email" id="demail" name="demail" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label class="ms-0">no telp / nama pemohon</label>
                                <input type="text" id="dcontact_person" name="dcontact_person" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label class="ms-0">Status Permohonan</label>
                                <input type="email" id="dstatus_permohonan" name="dstatus_permohonan" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-static mb-4">
                                <label class="ms-0">Jadwal Terubah</label>
                                <input type="text" id="djadwal_rev" name="djadwal_rev" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" data-id="" id="isAllDay" checked>
                                <label class="form-check-label" for="flexSwitchCheckDefault">All Day</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>            
        </div>
        

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="approvepermohonan" data-status="1" class="btn btn-success jenit">Approve</button>
            <button type="button" id="rejectmohonan" data-status="3" class="btn btn-danger jenit">Tolak</button>
        </div>

    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="tambahModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Task / Improvement</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
                <div class="row mb-4">
                    <form enctype="multipart/form-data" id="formTask" action="{{ route('tambah.task')}}" method="post" class="form-horizontal">
                    @csrf     
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0">Aplikasi</label>
                                    <select class="form-control" name="taplikasi" id="taplikasi">
                                        @foreach($listApp as $row)
                                            <option value="{{$row->id}}">{{$row->app_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0">Jenis</label>
                                    
                                    <select class="form-control" name="tJenis" id="tJenis">
                                        @foreach($listServis as $row)
                                            <option value="{{$row->id}}">{{$row->service_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0">Integrasi</label>
                                    
                                    <select class="form-control" name="tIntegrasi" id="tIntegrasi">
                                        <option value="0" selected disabled>-- Pilih Integrasi (Jika Ada)</option>
                                        @foreach($listIntegrasi as $row)
                                            <option value="{{$row->id}}">{{$row->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0">Modul</label>
                                    <input type="text" id="tModul" name="tModul" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display:none">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0">Tanggal Mulai</label>
                                    <input type="text" id="etgl" name="etgl" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0">status</label>
                                    <input type="text" id="tStatus" name="tStatus" class="form-control" value="0" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0">Target Selesai</label>
                                    <input type="date" id="etgl_end" name="etgl_end" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label class="ms-0">Keterangan</label>
                                    <textarea class="form-control" id="tKeterangan" name="tKeterangan"></textarea>
                                </div>
                            </div>
                            
                        </div>

                        <div class="row toevent">
                            <div class="col-md-6">
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0">Lampiran</label>
                                    <input type="file" id="tFileTask" name="tFileTask" class="form-control" accept=".pdf">
                                </div>
                            </div>
                            <div class="col-md-6" style="display:none">
                                <div class="input-group input-group-static mb-4">
                                    <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                    <input type="text" id="tUser_id" name="tUser_id" value="{{$user_id}}" class="form-control">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>            
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="submitTask" data-user="{{$user_id}}" class="btn btn-success submitTask">Submit</button>
            </div>

        </div>
    </div>
</div>