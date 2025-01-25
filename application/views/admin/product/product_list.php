<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><?= $title ?></h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active"><?= $title ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- end row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card custom-shadow rounded-lg border">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-10">
                                    <h4 class="card-title mb-4">List of Auxillaire Potentiels</h4>
                                </div>

                                <div class="col-sm-2 text-end" style="padding-left: 54px;">
                                    <a href="<?= base_url('admin/product/add_product') ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Ajouter une culture</a>
                                </div>
                            </div>
                            <div class="">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100" style=" width: 100% !important; overflow-y: scroll; display: inline-block; ">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th>#</th>
                                            <th>Liste des cultures</th>
                                            <th>Description</th>
                                            <th>Liste de bio-agresseur</th>
                                            <th>Début de période de plantation</th>
                                            <th>Fin de période de plantation</th>
                                            <th>Nombre de jours de recolte</th>
                                            <th>Nombre de jours fin recolte</th>
                                            <th>Durée /nombre de récole</th>
                                            <!-- <th>Created Date</th> -->
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php 
                                        $month_data = $this->db->query("SELECT * FROM month_data")->result();
                                        $month_map = [];
                                        foreach ($month_data as $month) {
                                            $month_map[$month->id] = $month->month_name;
                                        }

                                        $cat_data = $this->db->query("SELECT * FROM category WHERE status = '1'")->result();
                                        $cat_map = [];
                                        foreach ($cat_data as $cat) {
                                            $cat_map[$cat->id] = $cat->category_name;
                                        }

                                        if (is_array($product) || is_object($product)) { ?>
                                            <?php foreach ($product as $key => $v): 
                                                if(!empty($v->start_period)){
                                                    $period_ids = explode(',', $v->start_period);
                                                    $month_names = array_map(function($id) use ($month_map) {
                                                        return isset($month_map[trim($id)]) ? $month_map[trim($id)] : null;
                                                    }, $period_ids);
                                                    $month_names = array_filter($month_names);
                                                    $month_names_display = implode(', ', $month_names);
                                                } else {
                                                    $month_names_display = '';
                                                }
                                                
                                                if(!empty($v->end_period)){
                                                    $period_ids1 = explode(',', $v->end_period);
                                                    $month_names1 = array_map(function($id) use ($month_map) {
                                                        return isset($month_map[trim($id)]) ? $month_map[trim($id)] : null;
                                                    }, $period_ids1);
                                                    $month_names1 = array_filter($month_names1);
                                                    $month_names_display1 = implode(', ', $month_names1);
                                                } else {
                                                    $month_names_display1 = '';
                                                }

                                                if(!empty($v->category_id)){
                                                    $cat_ids = explode(',', $v->category_id);
                                                    $cat_names = array_map(function($id) use ($cat_map) {
                                                        return isset($cat_map[trim($id)]) ? $cat_map[trim($id)] : null;
                                                    }, $cat_ids);
                                                    $cat_names = array_filter($cat_names);
                                                    $cat_names_display = implode(', ', $cat_names);
                                                } else {
                                                    $cat_names_display = '';
                                                }
                                            ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= strip_tags(@$v->prod_name); ?></td>
                                                    <td><?= @$v->prod_description; ?></td>
                                                    <td><?= htmlspecialchars($cat_names_display); ?></td>
                                                    <td><?= htmlspecialchars($month_names_display); ?></td>
                                                    <td><?= htmlspecialchars($month_names_display1); ?></td>
                                                    <td><?= @$v->harvest_days; ?></td>
                                                    <td><?= @$v->harvest_end; ?></td>
                                                    <td><?= @$v->number_harvest; ?></td>
                                                    <!-- <td><?= strip_tags(@$v->created_at); ?></td> -->
                                                    <td>
                                                        <div class="form-check mb-3 mt-3">
                                                            <input type="checkbox" class="form-check-input small" id="statusChange_<?= $key ?>" switch="bool" value="<?= @$v->status ?>" <?= (@$v->status == 1) ? 'checked' : '' ?> onchange="changeProductStatus(<?= @$v->id ?>, $(this))">
                                                            <label class="form-check-label" for="statusChange_<?= $key ?>"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('admin/product/edit_product/' . $v->id) ?>" class="btn btn-outline-success btn-sm" data-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm" data-toggle="tooltip" title="Delete" onclick="deleteProduct(<?= @$v->id ?>)">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.0/FileSaver.min.js"></script>
<script type="text/javascript">
function deleteProduct(dealId) {
    swal({
        title: 'Are You sure want to delete this?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#A5DC86',
        cancelButtonColor: '#DD6B55',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        closeOnConfirm: true,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            window.location.href = '<?= base_url('admin/product/delete_product/') ?>' + dealId
        }
    });
}

function changeProductStatus(id, thisSwitch) {
    var newStatus;
    if (thisSwitch.val() == 1) {
        thisSwitch.val('0');
        newStatus = '0';
    } else {
        thisSwitch.val('1');
        newStatus = '1';
    }
    $.ajax({
        url: '<?php echo base_url('admin/product/change_product_status'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            prodId: String(id),
            status: String(newStatus)
        },
    })
    .done(function (data) {
        if (newStatus == 1) {
            swal({title: "Success!", text: "<strong>Product status is Activate</strong>", type: "success", showConfirmButton: true, html: true}, function () {
                window.location.href = " "
            });
        } else if (newStatus == 0) {
            swal({title: "Success!", text: "<strong>Product status is Inctivate</strong>", type: "success", showConfirmButton: true, html: true}, function () {
                window.location.href = " "
            });
        }
    })
    .fail(function (data) {
        console.log(data);
    });
}
</script>