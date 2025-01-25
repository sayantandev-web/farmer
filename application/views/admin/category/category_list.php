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
                                    <h4 class="card-title mb-4">Bio Agressor List</h4>
                                </div>

                                <div class="col-sm-2 text-end" style="padding-left: 54px;">
                                    <a href="<?= base_url('admin/category/add_category') ?>" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>&nbsp;Add Bio Agressor</a>
                                </div>
                            </div>
                            <div class="">
                                <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead class="thead-light text-center">
                                        <tr>
                                            <th>#</th>
                                            <th>Bio Agressor Name</th>
                                            <th>Bio Agressor Description</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        <?php if (is_array($category) || is_object($category)) { ?>
                                            <?php foreach ($category as $key => $v): ?>
                                                <tr>
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= strip_tags(@$v->category_name); ?></td>
                                                    <td><?= strip_tags(@$v->category_description); ?></td>
                                                    <td>
                                                        <div class="form-check mb-3 mt-3">
                                                            <input type="checkbox" class="form-check-input small" id="statusChange_<?= $key ?>" switch="bool" value="<?= @$v->status ?>" <?= (@$v->status == 1) ? 'checked' : '' ?> onchange="changeCategoryStatus(<?= @$v->id ?>, $(this))">
                                                            <label class="form-check-label" for="statusChange_<?= $key ?>"></label>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url('admin/category/edit_category/' . $v->id) ?>" class="btn btn-outline-success btn-sm" data-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <a href="javascript:void(0)" class="btn btn-outline-warning btn-sm" data-toggle="tooltip" title="Delete" onclick="deleteCategory(<?= @$v->id ?>)">
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
var adminUrl = ""
function myfunc() {
    var element = document.getElementById("savethedeal");
    html2canvas(element, {
        allowTaint: true,
        useCORS: true
    }).then(function (canvas) {
        canvas.toBlob(function (blob) {
            window.saveAs(blob, "Deal.png");
        });
    });
}
;

function deleteCategory(dealId) {
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
            window.location.href = '<?= base_url('admin/category/delete_category/') ?>' + dealId
        }
    });
}

function changeCategoryStatus(id, thisSwitch) {
    var newStatus;
    if (thisSwitch.val() == 1) {
        thisSwitch.val('0');
        newStatus = '0';
    } else {
        thisSwitch.val('1');
        newStatus = '1';
    }
    $.ajax({
        url: '<?php echo base_url('admin/category/change_category_status'); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            catId: String(id),
            status: String(newStatus)
        },
    })
            .done(function (data) {
                if (newStatus == 1) {
                    swal({title: "Sucess!", text: "<strong>Bio Agressor status is Activate</strong>", type: "success", showConfirmButton: true, html: true}, function () {
                        window.location.href = " "
                    });
                } else if (newStatus == 0) {
                    swal({title: "Sucess!", text: "<strong>Bio Agressor status is Inctivate</strong>", type: "success", showConfirmButton: true, html: true}, function () {
                        window.location.href = " "
                    });
                }
            })
            .fail(function (data) {
                console.log(data);
            });
}
</script>