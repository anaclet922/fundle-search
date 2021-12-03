<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// echo '<pre>';print_r($this->session->user != null);
?>
<div class="container h-100">
    <div class="row">
      <div class="col-md-12 signin-me text-center">
         <br>
        <?php if(null == $this->session->user){ ?>
          <a class="" href="<?= base_url('dashboard') ?>"><i class="fas fa-user"></i> Sign in</a>
          <a class="" href="#"><i class="fas fa-user-plus"></i> Sign up</a>
        <?php }else{ ?>
          <?= $this->session->user[0]['full_names'] ?> 
          <a class="" href="<?= base_url('welcome/sign_out') ?>"><i class="fas fa-user-plus"></i> Sign out</a>
        <?php } ?>

         <br>
         <br>
      </div>
    </div>
    <div class="row align-items-center" style="height: 85%">
        <div class="col-8 mx-auto">
            <h1 class="text-center"><span style="color: #FC930A; font-weight: bold;">F</span>undle search</h1>
            <h6 class="text-center" style="" id="search-title">
              <!-- WHAT ARE YOU LOOKING FOR? -->
              <b>What are you looking for?</b>
            </h6>
            <br>
            
            <div class="searchbar">
              <input class="search_input" type="text" name="" placeholder="Type to search...." id="search-input" />
              <a href="javascript:void(0)" id="search-btn" class="search_icon" id=""><i class="fas fa-search"></i></a>
            </div>


            <p style="padding: 10px" class="history-words">

                <?php foreach ($history as $key) { ?>
                  <span class="suggests shadow-sm">
                    <?= $key['word'] ?>
                </span>
                <?php } ?>
            </p>

            <p id="search-result-summary" style="font-size: 13px"></p>

            <p id="loader" class="text-center">
              Fetching results
              <br>
              <img src="<?= base_url('assets/images/loader.gif') ?>">
            </p>

            <div id="results-container">
              
            </div>
            

        </div>
    </div>
</div>

<style type="text/css">
  .result-item .link-text{
    font-size: 12px;
  }
  .result-item .result-link{
    font-size: 20px;
    color: #c7750a;
  }
  .result-item .description-text{
    font-size: 14px;
  }
  .result-item .bank-info{
    font-size: 14px;
  }
  .result-item .bank-info{
    font-size: 12px;
    color: #0056b3;
  }
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

  .searchbar{
    margin-bottom: auto;
    margin-top: auto;
    height: 60px;
    background-color: #fff;
    border-radius: 30px;
    padding: 10px;
  }

  .search_input{
    color: #303841;
    border: 0;
    outline: 0;
    /*caret-color:transparent;*/
    line-height: 40px;
    transition: width 0.4s linear;
    padding-left: 20px;
    font-size: 20px;
    width: 85%;
  }

  .search_icon{
    height: 40px;
    width: 40px;
    float: right;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    color:#FC930A;
    text-decoration:none;
  }


  .suggests{
    background-color: #FC930A;
    padding: 3px;
    padding-left: 10px;
    padding-right: 10px;
    border-radius: 15px;
    margin-left: 5px;
    margin-right: 5px;
    font-size: 14px;
    color: white;
  }
  .signin-me{
    font-size: 12px;
  }
  .signin-me a{
    margin: 10px;
    color: #303841;
    font-weight: bold;
    font-size: 12px;
  }

  #loader{    
    font-size: 12px;
    display: none;
  }
  #loader img{
    height: 45px;
  }
</style>


<script type="text/javascript">
  
  

  $(document).ready(function(){

      $('#search-btn').click(function(){
          if($('#search-input').val().trim() != ''){
            FetchResults();
          }
      });


      $(document).on('keypress',function(e) {
        if(e.which == 13) {
            if($('#search-input').val().trim() != ''){
              FetchResults();            }
        }
      });

  });
  function DisplayResult(result){
    $('#loader').hide(900);
    $('#search-title').hide(500);
    if(result.results.length){
      $('#search-result-summary').html('Search result for <b>'+ $('#search-input').val() +'</b> - '+ result.meta.page.total_results +' results');
      var output = '';
      var json = result.results;
      for (var i = 0; i < json.length; i++) {
         var inst = '';
         if(json[i].url.raw.includes('bk')){
           inst = 'Bank of Kigali';
         }else if(json[i].url.raw.includes('https://equitygroupholdings.com/')){
           inst = 'Equity Group Holdings';
         }else{
           inst = 'Cogebanque';
         }

         var descr = '';
         for (var j = 1; j < json[i].headings.raw.length - 1; j++) {
           descr += json[i].headings.raw[j] + ', ';
         }

         var utl_text = json[i].headings.raw[0];

         if ('title' in json[i]){
           utl_text = json[i].title.raw;
         }
          output += '<div class="card shadow result-item">' +
                      '<div class="card-body">' +
                          '<span class="link-text"><i class="fas fa-link"></i> ' + json[i].url.raw + '</span>' +
                          '<br>' +
                          '<a href="' + json[i].url.raw + '" class="result-link">' + utl_text +  '</a>' +
                          '<br>' +
                          '<span class="description-text">' + (descr.substring(0, descr.length - 2)).substring(0, 255) + '...</span>' +
                          '<br>' +
                          '<span class="bank-info">' + inst + '</span>' +
                      '</div>' +
                    '</div><br/>';
      }
      $('#results-container').html(output);
      SaveHistory();
    }else{
      $('#search-result-summary').html('Oops no search result for <b>'+ $('#search-input').val() +'</b> - '+ result.meta.page.total_results +' results');
    }
  }

  async function FetchResults(){
    $('#loader').show(800);
    const rawResponse = await fetch('https://fundle-90b183.ent.us-central1.gcp.cloud.es.io/api/as/v1/engines/fundle-search-engine/search', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': 'Bearer search-ny4ftjj341fpcvp1y758sgfx'
      },
      body: JSON.stringify({"query": $('#search-input').val()})
    });
    const content = await rawResponse.json();

    DisplayResult(content);

  }

  async function SaveHistory(){
    const rawResponse = await fetch('<?= base_url() ?>welcome/save_search', {
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({"query": $('#search-input').val()})
    });
    const content = await rawResponse;

    console.log('search saved');
  }

</script>