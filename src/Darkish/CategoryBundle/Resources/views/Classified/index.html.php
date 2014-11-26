<?php $view->extend('::panel_layout.html.php') ?>



<?php $view['slots']->start('stylesheets') ?>
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control-attribute.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/ui-grid-unstable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/xeditable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.css') ?>" type="text/css" rel="stylesheet" />

<?php $view['slots']->stop() ?>


<?php $view['slots']->start('ngapp') ?>classifiedApp<?php $view['slots']->stop() ?>

<?php $view['slots']->start('controller') ?>
ClassifiedIndexController
<?php $view['slots']->stop() ?>
<?php $view['slots']->start('formname') ?>classifiedform<?php $view['slots']->stop() ?>

<?php $view['slots']->start('body') ?>


    <div class="container-fluid"  style="margin: 50px;">

        <div ng-disabled="editing == false" class="row show-grid main-panel">
            <div class="col-md-2 " height="100%">
                <div class="jumbotron tree-wrapper">

                    <treecontrol class="tree-classic"
                                 tree-model="dataForTheTree"
                                 options="treeOptions"
                                 on-selection="showSelected(node)"
                                 selected-node="selected"
                                 expanded-nodes="expanded_nodes"
                                ng-hide="mainTreeHide">
                        {{node.title}}
                    </treecontrol>


                </div>
            </div>
            <div class="col-md-10">
                <div class="row show-grid main-record-wrapper">

                    <div class="panel main-record-panel panel-default" flow-init
                         flow-file-added="!!{png:1,gif:1,jpg:1,jpeg:1}[$file.getExtension()]"
                         flow-files-submitted="$flow.upload()">


                        <div class="panel-body">



                            <div class="row">

                                <div class="col-md-6 right-section">
                                    <div class="panel">
                                        <div class="classified-title-field">
                                            <label >
                                                عنوان:
                                            </label>

                                            <input type="text" ng-show="editing" ng-model="classified.title" required>
                                            <span ng-hide="editing">{{classified.title  || "عنوان خبر" }}</span>

                                        </div>

                                        <div class="id-field" style="clear: both">
                                            <label style="float: right" class="id-label">
                                                شناسه:
                                            </label>
                                            <span style="float: right"  class="id-value">
                                                <span style="float: left"> C</span>{{classified.id || "----"}}
                                            </span>
                                        </div>
                                        <div class="classified-publish" ng-init="publishediting = 0" style="clear: both">

                                            <div class="classified-publish-form" ng-show="editing">
                                                <div class="date-input">
                                                    <label class="classified-publish-label">
                                                        تاریخ انتشار:
                                                    </label>
                                                    <input type="text" ng-show="editing" ng-model="classified.publishDate" placeholder="139305012312" required />

                                                </div>
                                                <span style="text-decoration: underline;" class="date-display" ng-hide="editing" ng-click="publishediting = 1">{{classified.publish || "تاریخ انتشار را وارد کنید"}}</span>
                                            </div>
                                            <div class="classified-publish-display" ng-hide="editing">
                                                <label class="classified-publish-label">
                                                    تاریخ انتشار:
                                                </label>
                                                <span>
                                                    {{classified.publishDate}}
                                                </span>
                                            </div>

                                        </div>


                                        <div class="classified-expire-date">
                                            <label>
                                                تاریخ انقضا:
                                            </label>

                                            <input type="number" ng-model="classified.expireDate" ng-show="editing" required />

                                            <span ng-hide="editing">{{classified.expireDate || "--"}}</span>
                                            روز
                                        </div>

                                        <div class="tree-selection" ng-init="treeediting = 0">
                                            <label style="float: right">
                                                شاخه:
                                            </label>
                                            <script type="text/ng-template" id="myModalContent.html">
                                                <div class="modal-header">
                                                    <h3 class="modal-title">
                                                        انتخاب شاخه
                                                    </h3>
                                                </div>
                                                <div class="modal-body">
                                                    <treecontrol  class="tree-classic"
                                                                  tree-model="dataForTheClassifiedTree"
                                                                  options="treeOptions"
                                                                  on-selection="selectTreeForCurrentClassified(node)"
                                                                  selected-node="classified.categoryObj"
                                                        >
                                                        {{node.title}}
                                                    </treecontrol>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" ng-click="ok()">OK</button>
                                                    <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
                                                </div>
                                            </script>

                                            <div class="tree-display" style="float: right">
                                                <span>
                                                    {{classified.categoryObj.title}}
                                                </span>

                                            </div>

                                            <button ng-show="editing" class="btn btn-default btn-sm" ng-click="open()">
                                                انتخاب شاخه
                                            </button>

                                            <div class="classified-first-phone-field" style="clear: both">
                                                <label>
                                                    شماره تلفن اول:
                                                </label>



                                            <span class="classified-first-phone">
                                                    <input type="text" ng-show="editing" ng-model="classified.firstPhone">
                                                    <span ng-hide="editing">{{classified.firstPhone  || "شماره تلفن اول" }}</span>
                                            </span>
                                            </div>

                                            <div class="classified-first-phone-field" style="clear: both">
                                                <label>
                                                    شماره تلفن دوم:
                                                </label>



                                            <span class="classified-second-phone">
                                                    <input type="text" ng-show="editing" ng-model="classified.secondPhone">
                                                    <span ng-hide="editing">{{classified.secondPhone  || "شماره تلفن دوم" }}</span>
                                            </span>
                                            </div>

                                            <div class="classified-email-field" style="clear: both">
                                                <label>
                                                    ایمیل:
                                                </label>



                                            <span class="classified-email">
                                                    <input type="text" ng-show="editing" ng-model="classified.email">
                                                    <span ng-hide="editing">{{classified.email  || "ایمیل" }}</span>
                                            </span>
                                            </div>

                                            <div class="classified-unit-number" style="clear: both">
                                                <label>
                                                    شماره پرونده واحد:
                                                </label>



                                            <span class="classified-unit-number">
                                                    <input type="text" ng-show="editing" ng-model="classified.unitNumber">
                                                    <span ng-hide="editing">{{classified.unitNumber  || "شماره پرونده واحد" }}</span>
                                            </span>
                                            </div>


                                            <div ng-hide="editing && !classified.id" class="classified-status">
                                                <span data-ng-show="classified.status">
                                                    تایید شده
                                                </span>
                                                <span data-ng-hide="classified.status">
                                                    تایید نشده
                                                </span>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-6 right">
                                    <div class="jumbotron" style="padding: 5px;">
                                        <div class="body-editor" ng-show="editing" ng-init="bodyediting = 0">
                                            <textarea required height="400px" ckeditor="editorOptions" ng-model="classified.body"></textarea>
                                        </div>
                                        <div class="body-display" ng-hide="editing">
                                            <div class="panel" style="height: 280px; overflow-y: scroll" ng-bind-html="classified.body">

                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>





                    </div>


                </div>

            </div>
        </div>
        <div class="row">
            <div class="jumbotron">
                <div ng-hide="classifiedGridHide" style="width: 100%" dir="rtl" ui-grid="classifiedGridOptions" ui-grid-edit ui-grid-row-edit ui-grid-cellNav  ui-grid-selection class="grid"></div>
                <button data-ng-click="testFunction()">test</button>

            </div>

        </div>
    </div>
    <?php /* @var $slots Symfony\Component\Templating\Helper\SlotsHelper */ $slots = $view['slots']; ?>


<?php $view['slots']->stop() ?>


<?php $view['slots']->start('top-menu');?>
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="{{ path('admin_newstree') }}" class="dropdown-toggle" data-toggle="dropdown">
                نیازمندی ها
                <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?php print $view['router']->generate("news"); ?>">
                        اخبار و سرگرمی
                </a></li>
                <li><a href="<?php print $view['router']->generate("offer"); ?>">
                        پیشنهاد ویژه
                </a></li>

            </ul>
        </li>
    </ul>
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('top-actions');?>
    <div  class="classified-top row show-grid ">

        <div class="col-md-4">
            <button ng-disabled="editing" type="button" class="btn btn-primary" ng-click="newClassifiedAction()">
                جدید
            </button>

            <button ng-disabled="editing" type="button" class="btn btn-info" ng-click="editClassifiedAction()">
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
            <button ng-disabled="editing"  type="button" class="btn btn-danger" ng-click="openDeleteModal()" ng-disabled="editing || !classified.id">
                حذف
            </button>
            <button ng-disabled="!editing || classifiedform.$invalid" type="button" class="btn btn-success" ng-click="saveCurrentClassified()">
                ذخیره
            </button>
            <button ng-disabled="editing == false" type="button" class="btn btn-warning" ng-click="cancelClassifiedAction(); classifiedform.$setPristine();">
                انصراف
            </button>





        </div>
        <div class="col-md-3">
            <button type="button" ng-disabled="classifiedGridOptions.page <= 1" class="btn btn-primary" ng-click="classifiedGridOptions.previousPage()">
                قبلی
            </button>

                صفحه
                {{classifiedGridOptions.page}}
                از
                {{classifiedGridOptions.totalPages}}

            <button type="button" ng-disabled="classifiedGridOptions.page >= classifiedGridOptions.totalPages" class="btn btn-primary" ng-click="classifiedGridOptions.nextPage()">
                بعدی
            </button>
            <button type="button" class="btn btn-success" ng-click="approveCurrentClassified()" ng-disabled="editing || !classified.id" >
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
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ui-grid-unstable.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular-sanitize.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/xeditable.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ui-bootstrap.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ng-flow-standalone.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/libs/ckeditor/ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ui-bootstrap-tpls-0.11.2.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Controllers/classifiedIndexCtrl.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Services/classifiedService.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Services/classifiedtreeService.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/classifiedIndex.js') ?>"></script>

<?php $view['slots']->stop() ?>