<?php $settings = $this->Adminmodel->get('settings', true, 'settingId', '1'); ?>
<div data-simplebar class="sidebar-menu-scroll">
    <div id="sidebar-menu">
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title">Menu</li>
            <li class="<?= (!empty($page) && $page == 'dashboard') ? 'mm-active' : ''; ?>"><a href="<?= base_url('admin/dashboard') ?>" class="waves-effect"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="<?= (!empty($subpage) && $subpage == 'category') ? 'mm-active' : ''; ?>">
                <a href="javascript: void(0);" class="has-arrow waves-effect <?= (!empty($page) && $page == 'category') ? 'mm-active' : ''; ?>">
                    <i class="fa fa-bookmark"></i>
                    <span>Management des cultures</span>
                </a>
                <ul class="sub-menu" aria-expanded="true">
                    <li class="<?= (!empty($page) && $page == 'Category List') ? 'mm-active' : ''; ?>">
                        <a href="<?= base_url('admin/category') ?>" class="<?= (!empty($subpage) && $subpage == 'category') ? 'active' : ''; ?>">
                            <span class="hide-menu">Liste des Bio Agresseurs</span>
                        </a>
                    </li>
                    <li class="<?= (!empty($page) && $page == 'Product List') ? 'mm-active' : ''; ?>">
                        <a href="<?= base_url('admin/product') ?>" class="<?= (!empty($subpage) && $subpage == 'product') ? 'active' : ''; ?>">
                            <span class="hide-menu">List des Cultures</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
</div>