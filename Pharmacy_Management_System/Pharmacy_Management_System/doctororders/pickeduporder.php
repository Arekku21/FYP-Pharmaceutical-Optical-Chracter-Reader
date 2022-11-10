<head>
<style>

.menu-list{
  border-radius: 2px;
  width: 100%;
  display: block;
  padding: 10px;
  }
  .btn{
    width: 100%;
    color:hsl(0, 0%, 21%);
    background-color: hsl(0, 0%, 88%);
    border-radius: 3px;
  }
  .newclass :hover{
    background-color: hsl(0, 0%, 21%);
    color: hsl(0, 0%, 88%);
  }

</style>
</head>
<?php
      include "../menu/menu.php";
      ?>
        <div style="margin-top: 0%; width:85vw;">
            <div>
              <div style="margin-top: 0.8%; height:900px;">
                <section class="section columns">
                  <div class="column is-full-desktop is-full-mobile" style="margin-left: 18.5%; margin-top: 4%">
                    <!-- <app-search-supplier-window></app-search-supplier-window> -->
                    <div class="tabs is-toggle is-fullwidth">
                      <ul>
                        <li>
                          <a href="doctororders.php">
                            <!-- <span class="icon is-small"><i class="fas fa-music" aria-hidden="true"></i></span> -->
                            <span>New Orders</span>
                          </a>
                        </li>
                        <li >
                        <a href="verifyorder.php">
                            <!-- <span class="icon is-small"><i class="fas fa-image" aria-hidden="true"></i></span> -->
                            <span>Verified Orders</span>
                          </a>
                        </li>
                        <li class="is-active ">
                          <a href="pickeduporder.php">
                            <!-- <span class="icon is-small"><i class="fas fa-music" aria-hidden="true"></i></span> -->
                            <span>Picked Up Orders</span>
                          </a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </section>
              <section class="panel" style="margin: 3px;margin-top: -30px; width: 82vw; margin-left: 20%;">
                <p class="panel-heading" style="background-color:hsl(0, 0%, 88%) ;color:hsl(0, 0%, 21%)">
                  Picked Up Orders
                </p>
                <div class="panel-block ">
                  <div  style="height: 610px; width:100%;">
                  <div style="overflow:auto; height: 610px;">
                    <table class="table is-full menu-list" style=" margin:0px; width:100%;" >
                      <tbody >
                          <tr *ngFor="let docOrder of doctorOrderService.docOrders | async">
                            <!-- <div class="div columns  is-full btn r" style="margin: 0;"> -->
                                <!-- <div class="div column"> -->
                                  <table class="table is-full" style=" width:100%;">
                                    <thead style="font-weight: bold;">
                                      <td>Patient Name</td>
                                      <td>Patient DOB</td>
                                      <td>Doctor Name</td>
                                      <td>Doctor Contact </td>
                                      <td >Doctor ID </td>
                                      <td >Doctor Email </td>
                                      <td >Drug Names </td>
                                      <td>Drug Prices</td>
                                      <td>Quantities</td>
                                      <td >Total</td>
                                      <td >Pickup Date</td>
                                      <td> Case Number </td>
                                      <td> Dispense Status </td>
                                      <td ><a class="button is-small is-primary" (click)="onOrderVerify(docOrder.id)" >Order Verify</a></td>
                                    </thead>
                                    <tbody>
                                      <td>{{docOrder.patientName}}</td>
                                      <td>{{docOrder.patientDOB}}</td>
                                      <td>{{docOrder.doctorName}}</td>
                                      <td>{{docOrder.doctorContact}} </td>
                                      <td >{{docOrder.doctorId}} </td>
                                      <td >{{docOrder.doctorEmail}}</td>
                                      <td >{{docOrder.drugName[0]}}<br>{{docOrder.drugName[1]}}<br>{{docOrder.drugName[2]}}<br>{{docOrder.drugName[3]}}<br>{{docOrder.drugName[4]}}<br>{{docOrder.drugName[5]}}</td>
                                      <td>{{docOrder.drugPrice[0]}}<br>{{docOrder.drugPrice[1]}}<br>{{docOrder.drugPrice[2]}}<br>{{docOrder.drugPrice[3]}}<br>{{docOrder.drugPrice[4]}}<br>{{docOrder.drugPrice[5]}}</td>
                                      <td>{{docOrder.drugQuantity[0]}}<br>{{docOrder.drugQuantity[1]}}<br>{{docOrder.drugQuantity[2]}}<br>{{docOrder.drugQuantity[3]}}<br>{{docOrder.drugQuantity[4]}}<br>{{docOrder.drugQuantity[5]}}  </td>
                                      <td >{{docOrder.totalAmount}} </td>
                                      <td >{{docOrder.pickupDate}} </td>
                                      <td> {{docOrder.caseNumber}} </td>
                                      <td>{{docOrder.dispenseStatus}}</td>
                                      <td ><a class="button is-small is-primary" style="font-weight: bold;" (click)="onViewOrder(docOrder)">View Order</a></td>
                                    </tbody>
                                  </table>
                                <!-- </div> -->
                            <!-- </div> -->
                            <br>
                          </tr>
                    <br>
                      </tbody>
                    </table>
                    </div>
                  </div>
                </div>
                <div class="panel-block">
                </div>
              </section>
              </div>
            </div>
            </div>          




            