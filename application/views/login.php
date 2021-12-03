<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container h-100">
    <div class="row align-items-center h-100">
        <div class="col-4 mx-auto">
            
            <div class="card">
              <div class="card-body">
                  
                  <form method="post" action="<?= base_url('dashboard/post_login') ?>">
                      
                      <h2 class="text-center" style="font-weight: bold;">
                        <!-- WHAT ARE YOU LOOKING FOR? -->
                        Login
                      </h2>
                      
                      <br>

                      <?php 
                        if(null != $this->session->flashdata('error')){
                      ?>
                      <p class="alert alert-danger">
                        <?= $this->session->flashdata('error') ?>
                      </p>
                      <?php } ?>

                      <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control">
                      </div>

                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control">
                      </div>

                      <button class="btn btn-secondary" type="submit">Submit</button>

                  </form>


              </div>
            </div>

        </div>
    </div>
</div>

<style type="text/css">

  body,html{
    height: 100%;
    width: 100%;
    margin: 0;
    padding: 0;
    background: url("<?= base_url() ?>assets/images/Searchs_004.jpg");
    background-size: cover;
    background-position: center center;
    color: #303841;
  }


</style>


