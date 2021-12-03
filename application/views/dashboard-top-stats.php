
<div class="row">
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-warning shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">query_stats</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Total Queries</p>
                <h4 class="mb-0">
                  <?php
                    $t = 0;
                    foreach($counts['results'] as $c){
                      $t += $c['queries'];
                    }
                    echo $t;

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
                </h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0"><span class="text-success text-sm font-weight-bolder"><?= $d ?>% </span>than yesterday</p>
            </div>
          </div>
        </div>
        <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">ads_click</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Clicks</p>
                <h4 class="mb-0"><?php
                    $c = 0;
                  if(count($clicks['results']) > 0){

                    foreach($clicks['results'] as $cli){
                      $c += $cli['clicks'];
                    }
                    
                  } 
                  echo $c;

                   ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-3">
              <p class="mb-0">This count when user click on result</p>
            </div>
          </div>
        </div>

        
        
      </div>