<div class="main-content">
   <div class="page-content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="page-title-box d-flex align-items-center justify-content-between">
                  <h4 class="mb-0"><?=$title?></h4>
                  <div class="page-title-right">
                     <ol class="breadcrumb m-0">
                        <!--<li class="breadcrumb-item"><a href="">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>-->
                     </ol>
                  </div>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xl-12">
               <div class="row h-100">
                  <div class="col-md-6 col-xl-4">
                     <div class="card overflow-hidden card-h-100 custom-shadow rounded-lg border">
                        <a href="<?= base_url('admin/category') ?>">
                           <?php $category = $this->Adminmodel->count('category', '');?>
                           <div class="card-body">
                              <div class="d-flex justify-content-between">
                                 <h5 class="font-size-15 text-uppercase mb-0">Liste des Bio Agresseurs</h5>
                                 <div class="avatar-xs">
                                    <span class="avatar-title rounded bg-soft-primary font-size-20 mini-stat-icon">
                                    <i class="fa fa-users text-primary"></i>
                                    </span>
                                 </div>
                              </div>
                              <h3 class="font-size-24"><?=@$category?></h3>
                           </div>
                        </a>
                        <div id="project-chart"></div>
                     </div>
                  </div>
                  <div class="col-xl-4">
                     <a href="<?= base_url('admin/product') ?>">
   			            <?php $product = $this->Adminmodel->count('product', '');?>
                        <div class="card overflow-hidden card-h-100 custom-shadow rounded-lg border">
                           <div class="card-body">
                              <div class="d-flex justify-content-between">
                                 <h5 class="font-size-15 text-uppercase mb-0">List des Cultures</h5>
                                 <div class="avatar-xs">
                                    <span class="avatar-title rounded bg-soft-primary font-size-20 mini-stat-icon">
                                    <i class="fa fa-link text-primary"></i>
                                    </span>
                                 </div>
                              </div>
                              <h3 class="font-size-24"><?=@$product?></h3>
                           </div>
                           <div id="completed-chart"></div>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
