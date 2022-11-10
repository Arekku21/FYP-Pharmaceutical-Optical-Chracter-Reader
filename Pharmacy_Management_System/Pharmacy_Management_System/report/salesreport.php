<?php
include "../menu/menu.php";
?>
<div >
  <div style="margin-top: 0%; width:85vw;">
    <div style="margin-top: 0.8%; height:900px;">
      <section class="section columns">
        <div class="column is-full-desktop is-full-mobile" style="margin-left: 18.5%; margin-top: 4%">
          <!-- <app-search-supplier-window></app-search-supplier-window> -->
          <div class="tabs is-toggle is-fullwidth">
            <ul>
              <li class="is-active ">
                <a href="salesreport.php">
                  <!-- <span class="icon is-small"><i class="fas fa-music" aria-hidden="true"></i></span> -->
                  <span>Sales Chart</span>
                </a>
              </li>

              <li>
                <a routerLink="/salesreport/report">
                  <!-- <span class="icon is-small"><i class="fas fa-music" aria-hidden="true"></i></span> -->
                  <span>Sales Report</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </section>

    <section class="panel" style="margin-left: 18%;margin-top: -30px; width: 87.5vw;">

      <div >
        <div  style="height: 610px; width: 100%;">

        <section class="panel section level-item" style="margin: 3px;margin-top: -50px; width: 99%;">

<div class="column panel is-half level-right" style="width: 50%;">

  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Sales per Month
  </p>

  <div class="panel-block ">

    <div  style="height: 850px; width: 100%;">
      <div class="column">
      <div class="box">

<iframe style="background: #21313C;border: none;height: 550px;;border-radius: 10px;box-shadow: 0 2px 10px 0 rgba(70, 76, 79, .2);" width="640" height="480" src="https://charts.mongodb.com/charts-project-0-logtf/embed/charts?id=ac8943d9-7c82-465b-8727-547d42389e8b&autoRefresh=10&theme=dark"></iframe>


       </div>

      </div>
    </div>

  </div>
</div>


<div class="column panel is-half level-left" style="width: 50%;">

  <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
    Sales per Drug
  </p>

  <div class="panel-block ">

    <div  style="height: 850px; width: 100%;">
      <div class="column">
      <div class="box">
<iframe style="background: #21313C;border: none;height: 550px;width: 100%;border-radius: 10px;box-shadow: 0 2px 40px 0 rgba(70, 76, 79, .2);" width="640" height="780" src="https://charts.mongodb.com/charts-project-0-logtf/embed/charts?id=542b4874-f7d6-4088-9041-d8c7c886f8bb&autoRefresh=10&theme=dark"></iframe>


       </div>

      </div>
    </div>

  </div>
</div>


<div class="panel-block">

</div>
</section>
        </div>
      </div>
      <div class="panel-block">

      </div>
    </section>
    </div>

    </div>
</div>

