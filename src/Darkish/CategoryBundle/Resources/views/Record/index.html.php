<?php $view->extend('::panel_layout.html.php') ?>



<?php $view['slots']->start('stylesheets') ?>
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control-attribute.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-ui-grid/ui-grid.min.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/xeditable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/record-admin-page.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-modal/modal.css') ?>" type="text/css" rel="stylesheet" />

<?php $view['slots']->stop() ?>


<?php $view['slots']->start('ngapp') ?>RecordApp<?php $view['slots']->stop() ?>

<?php $view['slots']->start('controller') ?>
RecordIndexCtrl<?php $view['slots']->stop() ?>

<?php $view['slots']->start('formname') ?>recordform<?php $view['slots']->stop() ?>

<?php $view['slots']->start('body') ?>

    <div class="container-fluid main-wrapper">
        <div class="row main">
            <div class="col col-md-2 main-right main-cols">
                <div class="main-tree-block">
                    <h3 class="block-title">
                        شاخه بندی رکورد ها
                    </h3>
                    <ul class="filter-links">
                        <li>
                            <a>
                                تایید نشده ها
                            </a>
                        </li>
                        <li>
                            <a>
                                بدون شاخه
                            </a>
                        </li>
                        <li>
                            <a>
                                غیرفعال
                            </a>
                        </li>
                    </ul>
                    <div class="record-tree">
                        <treecontrol class="tree-classic"
                                     tree-model="tree()"
                                     options="treeOptions()"
                                     on-selection="TreeService.selectTree(node)"
                                     selected-node="TreeService.currentTreeNode">
                            {{node.title}}
                        </treecontrol>
                    </div>
                </div>
                <div class="main-search-block">
                    <h3 class="block-title">
جستجو
                    </h3>
                    <div class="search-box">
                        <input id="search-by-title" type="radio" name="search-based-on" />
                        <label for="search-by-title">
                            عنوان
                        </label>
                        <input id="search-by-number" type="radio" name="search-based-on" />
                        <label for="search-by-number">
                            شماره
                        </label>
                        <input id="search-by-all" type="radio" name="search-based-on" />
                        <label for="search-by-all">
                            همه
                        </label>

                        <button class="btn">
                            بیاب
                        </button>
                        <input type="text" class="keyword" />
                    </div>
                </div>
                <div class="sort-block">
                    <span>
                        ترتیب نمایش
                    </span>
                    <input id="sort-by-date-desc" type="radio" name="sord-based-on" />
                    <label for="sort-by-date-desc">
                        تاریخ نزولی
                    </label>
                    <input id="sort-by-date-asc" type="radio" name="sord-based-on" />
                    <label for="sort-by-date-asc">
تاریخ صعودی
                    </label>
                    <input id="sort-by-number-desc" type="radio" name="sord-based-on" />
                    <label for="sort-by-number-desc">
شماره نزولی
                    </label>
                    <input id="sort-by-number-asc" type="radio" name="sord-based-on" />
                    <label for="sort-by-number-asc">
شماره صعودی
                    </label>
                </div>
            </div>
            <div class="col col-md-6 main-center main-cols">
                <div class="basic-info col col-md-12">
                    <div class="col-md-9 titles-box">

                    </div>
                    <div class="col-md-3 number-box">
unvar
                    </div>
                </div>
            </div>
            <div class="col col-md-4 main-left main-cols">

            </div>
        </div>
        <div class="row list">
            <div class="col col-lg-12">
                <div class="grid-block">
                    <table st-table="recordList()" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره پرونده</th>
                            <th>عنوان</th>
                            <th>عنوان فرعی</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr st-select-row="row" ng-class="{selected: RecordService.isSelected(row)}" data-ng-click="RecordService.selectRecord(row)" st-select-mode="single" ng-repeat="row in recordList()">
                            <td>{{row.id}}</td>
                            <td>{{row.record_number}}</td>
                            <td>{{row.title}}</td>
                            <td>{{row.sub_title}}</td>
                        </tr>
                        </tbody>
                    </table>



                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid">

        <div class="row">
            <div class="col-md-3">
                <div class="row crud-buttons">
                    <button class="btn btn-primary new-btn">
                        جدید
                    </button>
                    <button class="btn btn-danger delete-btn">
                        حذف
                    </button>
                    <button class="btn btn-info edit-btn">
                        ویرایش
                    </button>
                    <button class="btn btn-warning attachements-btn">
                        ضمیمه ها
                    </button>

                </div>
                <div class="row search-block">
                    <button class="btn hide-main-tree">^</button>
                    <input type="text" class="search-box"/>
                    <button class="search-btn btn">
                        جستجو
                    </button>
                    <div class="filter-chechboxes">
                        <span class="all-branches">
                            <input type="radio" id="all-branches" />
                            <label for="all-branches">همه زیرشاخه ها</label>
                        </span>
                        <span class="without-branch">
                            <input type="radio" id="without-branch" />
                            <label for="without-branch">
                                بدون شاخه
                            </label>
                        </span>
                        <span class="this-branch">
                            <input type="radio" id="this-branch" />
                            <label for="this-branch">
                                این شاخه
                            </label>
                        </span>
                        <span class="unapproved">
                            <input type="radio" id="unapproved" />
                            <label for="unapproved">
                                تایید نشده
                            </label>
                        </span>

                    </div>


                </div>

                <div class="branch-id-block">
                    <span class="branch-id-label">
                    کد شاخه
                    </span>
                    <h3 data-ng-show="TreeService.currentTreeNode.treeIndex" class="branch-id">
                        R{{TreeService.currentTreeNode.treeIndex}}
                    </h3>
                </div>


                <div dir="ltr">

                </div>

            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3 record-number-block-wrapper">
                        <div class="record-number-block">
                            <span>
                                شماره پرونده
                            </span>
                            <div class="record-number-preview">
                                {{RecordService.currentRecord.record_number}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 record-teaser-preview-block-wrapper">
                        <div class="record-teaser-preview-block">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="approved-block">
                            <div class="approved">
                                <input type="checkbox" ng-model="RecordService.currentRecord.verify">
                                <label>
                                    تایید شده
                                </label>
                            </div>
                        </div>
                        <div class="record-basic-info-wrapper">
                            <div class="record-basic-info">
                                <label for="record-title">
عنوان
                                </label>
                                <input ng-model="RecordService.currentRecord.title" type="text" id="record-title" />

                                <label for="record-subtitle">
زیرعنوان
                                </label>
                                <input ng-model="RecordService.currentRecord.sub_title" type="text" id="record-subtitle" />

                                <label for="record-keywords">
کلید واژه جستجو
                                </label>
                                <textarea ng-model="RecordService.currentRecord.search_keywords" id="record-keywords"></textarea>

                                <label for="record-owner">
مالک
                                </label>
                                <input ng-model="RecordService.currentRecord.owner" type="text" id="record-owner" />

                                <label for="record-legal-name">
نام حقوقی
                                </label>
                                <input ng-model="RecordService.currentRecord.legal_name" type="text" id="record-legal-name" />


                            </div>
                        </div>
                        <div class="record-select-tree-block-wrapper">
                            <div class="record-select-tree-block">
                                <div class="add-remove">
                                    <button ng-click="showModal()" class="btn">+</button>
                                    <button class="btn">-</button>
                                    <span>
                                        شاخه ها
                                    </span>
                                </div>
                                <div class="tree-list">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
            <div class="col-md-3">se</div>

        </div>





    </div>


    <script type="text/ng-template" id="tree-modal.html">
        <div class="modal-bg">
            <div class="btf-modal">
                <div class="tree-modal-header">
                    <a href ng-click="closeMe()">X</a>
                    <button class="btn" data-ng-click="">اضافه</button>
                </div>
            </div>
        </div>
    </script>

<?php $view['slots']->stop() ?>


<?php $view['slots']->start('top-menu');?>
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="{{ path('admin_newstree') }}" class="dropdown-toggle" data-toggle="dropdown">اخبار و سرگرمی<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?php print $view['router']->generate("offer"); ?>">پیشنهاد ویژه</a></li>
                <li><a href="<?php print $view['router']->generate("classified"); ?>">نیازمندی ها</a></li>

            </ul>
        </li>
    </ul>
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('top-actions');?>
    <div  class="news-top row show-grid ">

        <div class="col-md-4">
            <button ng-disabled="editing" type="button" class="btn btn-primary" ng-click="newNewsAction()">
                جدید
            </button>

            <button ng-disabled="editing" type="button" class="btn btn-info" ng-click="editNewsAction()">
                ویرایش
            </button>
            <script type="text/ng-template" id="deleteModalContent.html">
                <div class="modal-header">
                    <h3 class="modal-title">
                         حذف خبر
                    </h3>
                </div>
                <div class="modal-body">
                    آیا از حذف خبر فعلی اطمینان دارید؟
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" ng-click="okDeleteModal()">
                        بله
                    </button>
                    <button class="btn btn-warning" ng-click="cancelDeleteModal()">
                        خیر
                    </button>
                </div>
            </script>
            <button ng-disabled="editing"  type="button" class="btn btn-danger" ng-click="openDeleteModal()" ng-disabled="editing || !news.id">
                حذف
            </button>
            <button ng-disabled="!editing || newsform.$invalid" type="button" class="btn btn-success" ng-click="saveCurrentNews()">
                ذخیره
            </button>
            <button ng-disabled="editing == false" type="button" class="btn btn-warning" ng-click="cancelNewsAction(); newsform.$setPristine();">
                انصراف
            </button>





        </div>
        <div class="col-md-3">
            <button type="button" ng-disabled="newsGridOptions.page <= 1" class="btn btn-primary" ng-click="newsGridOptions.previousPage()">
                قبلی
            </button>

                صفحه
                {{newsGridOptions.page}}
                از
                {{newsGridOptions.totalPages}}

            <button type="button" ng-disabled="newsGridOptions.page >= newsGridOptions.totalPages" class="btn btn-primary" ng-click="newsGridOptions.nextPage()">
                بعدی
            </button>
            <button type="button" class="btn btn-success" ng-click="approveCurrentNews()" ng-disabled="editing || !news.id" >
                تایید
            </button>
        </div>

        <div class="col-md-1 left" style="float: left">
            Username
        </div>
    </div>
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('javascripts') ?>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular-tree-control.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/pdfmake.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/vfs_fonts.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-ui-grid/ui-grid.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-smart-table/dist/smart-table.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular-sanitize.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/xeditable.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ui-bootstrap.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ng-flow-standalone.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/libs/ckeditor/ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-modal/modal.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ui-bootstrap-tpls-0.11.2.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Controllers/recordIndexCtrl.js') ?>"></script>
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/recordService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/recordtreeService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/recordIndex.js') ?><!--"></script>-->

<?php $view['slots']->stop() ?>