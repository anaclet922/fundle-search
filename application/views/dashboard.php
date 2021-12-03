<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    Fundle dashboard
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="<?= base_url() ?>assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="<?= base_url() ?>assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-200">


  <?php $this->load->view('dashboard-menu') ?>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    
    <?php $this->load->view('dashboard-nav'); ?>

    <div class="container-fluid py-4">

      <?php $this->load->view('dashboard-top-stats') ?>


      <div class="row mt-4">
        <div class="col-lg-12 col-md-12 mt-4 mb-4">
          <div class="card z-index-2  ">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
              <div class="bg-gradient-success shadow-success border-radius-lg py-3 pe-1">
                <div class="chart">
                  <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
            </div>
            <div class="card-body">
              <h6 class="mb-0 "> Weekly searches</h6>
              <?php
                    $today = $counts['results'][count($counts['results'])-1]['queries'];
                    $yesterday = $counts['results'][count($counts['results'])-2]['queries'];
                    $d = '';
                    $yesterday = $yesterday == 0 ? 1 : $yesterday;
                    if($today > $yesterday){
                      $d = '+' . ($today * 100) / $yesterday;
                    }else{
                      $d = '-' . ($today * 100) / $yesterday;
                    }
              ?>
              <p class="text-sm "> (<span class="font-weight-bolder"><?= $d ?>%</span>) increase in today searches. </p>
              <hr class="dark horizontal">
              <div class="d-flex ">
                <i class="material-icons text-sm my-auto me-1">schedule</i>
                <p class="mb-0 text-sm"> Refresh to see update</p>
              </div>
            </div>
          </div>
        </div>

      </div>


      <div class="row mb-4">

        <div class="col-lg-12 col-md-12">
          <div class="card my-4">
            <div class="card-header pb-0">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-warning shadow-primary border-radius-lg pt-4 pb-3">
                  <h6 class="text-white text-capitalize ps-3">Top queries</h6>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Search term</th>
                      <th style="width: 7%" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Queries</th>
                      <th style="width: 7%" class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Clicks</th>
                    </tr>
                  </thead>
                  <tbody>
                        
                      <?php foreach ($queries['results'] as $q) { ?>
                          <tr>
                            <td style="padding-left: 22px;"><p class="text-sm font-weight-bold mb-0"><?= $q['term'] ?></p></td>
                            <td style="text-align: center;"><?= $q['queries'] ?></td>
                            <td style="text-align: center;"><?= $q['clicks'] ?></td>
                          </tr>
                      <?php } ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
      <footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="https://anaclet.online" class="font-weight-bold" target="_blank">Anaclet Ahishakiye</a>
              </div>
            </div>
            <div class="col-lg-6">
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>

  <!--   Core JS Files   -->
  <script src="<?= base_url() ?>assets/js/core/popper.min.js"></script>
  <script src="<?= base_url() ?>assets/js/core/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="<?= base_url() ?>assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="<?= base_url() ?>assets/js/plugins/chartjs.min.js"></script>


  <?php
      $days = '';
      $d = '';
      foreach($counts['results'] as $cou){
        $days .= '"'. date('m/d', strtotime($cou['from'])) .'", ';
        $d .= $cou['queries'] . ', ';
      }
      $days = chop($days, ', ');
      $d = chop($d, ', ');
   ?>
  <script>

    var ctx2 = document.getElementById("chart-line").getContext("2d");

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: [<?= $days ?>],
        datasets: [{
          label: "Queries",
          tension: 0,
          borderWidth: 0,
          pointRadius: 5,
          pointBackgroundColor: "rgba(255, 255, 255, .8)",
          pointBorderColor: "transparent",
          borderColor: "rgba(255, 255, 255, .8)",
          borderColor: "rgba(255, 255, 255, .8)",
          borderWidth: 4,
          backgroundColor: "transparent",
          fill: true,
          data: [<?= $d ?>],
          maxBarThickness: 6

        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: 'rgba(255, 255, 255, .2)'
            },
            ticks: {
              display: true,
              color: '#f8f9fa',
              padding: 10,
              font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#f8f9fa',
              padding: 10,
              font: {
                size: 14,
                weight: 300,
                family: "Roboto",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });

   
  </script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?= base_url() ?>assets/js/material-dashboard.min.js?v=3.0.0"></script>
</body>

</html>

<style type="text/css">
  body,html{
    height: 100%;
    width: 100%;
    margin: 0;
    padding: 0;
    /*background: url("<?= base_url() ?>assets/images/Searchs_004.jpg");*/
    background-size: cover;
    background-position: center center;
    color: #303841;
  }

</style>
