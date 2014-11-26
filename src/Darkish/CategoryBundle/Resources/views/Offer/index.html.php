<?php $view->extend('::panel_layout.html.php') ?>



<?php $view['slots']->start('stylesheets') ?>
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control-attribute.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/ui-grid-unstable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/xeditable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.css') ?>" type="text/css" rel="stylesheet" />

<?php $view['slots']->stop() ?>


<?php $view['slots']->start('ngapp') ?>offerApp<?php $view['slots']->stop() ?>

<?php $view['slots']->start('controller') ?>
OfferIndexController
<?php $view['slots']->stop() ?>
<?php $view['slots']->start('formname') ?>offerform<?php $view['slots']->stop() ?>

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
                                        <div class="offer-title-field">
                                            <label >
                                                عنوان:
                                            </label>

                                            <input type="text" ng-show="editing" ng-model="offer.title" required>
                                            <span ng-hide="editing">{{offer.title  || "عنوان خبر" }}</span>

                                        </div>

                                        <div class="id-field" style="clear: both">
                                            <label style="float: right" class="id-label">
                                                شناسه:
                                            </label>
                                            <span style="float: right"  class="id-value">
                                                <span style="float: left"> O</span>{{offer.id || "----"}}
                                            </span>
                                        </div>
                                        <div class="offer-publish" ng-init="publishediting = 0" style="clear: both">

                                            <div class="offer-publish-form" ng-show="editing">
                                                <div class="date-input">
                                                    <label class="offer-publish-label">
                                                        تاریخ انتشار:
                                                    </label>
                                                    <input type="text" ng-show="editing" ng-model="offer.publishDate" placeholder="139305012312" required />

                                                </div>
                                                <span style="text-decoration: underline;" class="date-display" ng-hide="editing" ng-click="publishediting = 1">{{offer.publish || "تاریخ انتشار را وارد کنید"}}</span>
                                            </div>
                                            <div class="offer-publish-display" ng-hide="editing">
                                                <label class="offer-publish-label">
                                                    تاریخ انتشار:
                                                </label>
                                                <span>
                                                    {{offer.publishDate}}
                                                </span>
                                            </div>

                                        </div>


                                        <div class="offer-expire-date">
                                            <label>
                                                تاریخ انقضا:
                                            </label>

                                            <input type="number" ng-model="offer.expireDate" ng-show="editing" required />

                                            <span ng-hide="editing">{{offer.expireDate || "--"}}</span>
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
                                                                  tree-model="dataForTheOfferTree"
                                                                  options="treeOptions"
                                                                  on-selection="selectTreeForCurrentOffer(node)"
                                                                  selected-node="offer.categoryObj"
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
                                                    {{offer.categoryObj.title}}
                                                </span>

                                            </div>

                                            <button ng-show="editing" class="btn btn-default btn-sm" ng-click="open()">
                                                انتخاب شاخه
                                            </button>

                                            <div class="offer-first-phone-field" style="clear: both">
                                                <label>
                                                    شماره تلفن اول:
                                                </label>



                                            <span class="offer-first-phone">
                                                    <input type="text" ng-show="editing" ng-model="offer.firstPhone">
                                                    <span ng-hide="editing">{{offer.firstPhone  || "شماره تلفن اول" }}</span>
                                            </span>
                                            </div>

                                            <div class="offer-first-phone-field" style="clear: both">
                                                <label>
                                                    شماره تلفن دوم:
                                                </label>



                                            <span class="offer-second-phone">
                                                    <input type="text" ng-show="editing" ng-model="offer.secondPhone">
                                                    <span ng-hide="editing">{{offer.secondPhone  || "شماره تلفن دوم" }}</span>
                                            </span>
                                            </div>

                                            <div class="offer-email-field" style="clear: both">
                                                <label>
                                                    ایمیل:
                                                </label>



                                            <span class="offer-email">
                                                    <input type="text" ng-show="editing" ng-model="offer.email">
                                                    <span ng-hide="editing">{{offer.email  || "ایمیل" }}</span>
                                            </span>
                                            </div>

                                            <div class="offer-unit-number" style="clear: both">
                                                <label>
                                                    شماره پرونده واحد:
                                                </label>



                                            <span class="offer-unit-number">
                                                    <input type="text" ng-show="editing" ng-model="offer.unitNumber">
                                                    <span ng-hide="editing">{{offer.unitNumber  || "شماره پرونده واحد" }}</span>
                                            </span>
                                            </div>


                                            <div ng-hide="editing && !offer.id" class="offer-status">
                                                <span data-ng-show="offer.status">
                                                    تایید شده
                                                </span>
                                                <span data-ng-hide="offer.status">
                                                    تایید نشده
                                                </span>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-6 right">
                                    <div class="jumbotron" style="padding: 5px;">
                                        <div class="body-editor" ng-show="editing" ng-init="bodyediting = 0">
                                            <textarea required height="400px" ckeditor="editorOptions" ng-model="offer.body"></textarea>
                                        </div>
                                        <div class="body-display" ng-hide="editing">
                                            <div class="panel" style="height: 280px; overflow-y: scroll" ng-bind-html="offer.body">

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
                <div ng-hide="offerGridHide" style="width: 100%" dir="rtl" ui-grid="offerGridOptions" ui-grid-edit ui-grid-row-edit ui-grid-cellNav  ui-grid-selection class="grid"></div>
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
                پیشنهاد ویژه
                <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?php print $view['router']->generate("news"); ?>">
                        اخبار و سرگرمی
                </a></li>
                <li><a href="<?php print $view['router']->generate("classified"); ?>">
                        نیازمندی ها
                </a></li>

            </ul>
        </li>
    </ul>
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('top-actions');?>
    <div  class="offer-top row show-grid ">

        <div class="col-md-4">
            <button ng-disabled="editing" type="button" class="btn btn-primary" ng-click="newOfferAction()">
                جدید
            </button>

            <button ng-disabled="editing" type="button" class="btn btn-info" ng-click="editOfferAction()">
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
            <button ng-disabled="editing"  type="button" class="btn btn-danger" ng-click="openDeleteModal()" ng-disabled="editing || !offer.id">
                حذف
            </button>
            <button ng-disabled="!editing || offerform.$invalid" type="button" class="btn btn-success" ng-click="saveCurrentOffer()">
                ذخیره
            </button>
            <button ng-disabled="editing == false" type="button" class="btn btn-warning" ng-click="cancelOfferAction(); offerform.$setPristine();">
                انصراف
            </button>





        </div>
        <div class="col-md-3">
            <button type="button" ng-disabled="offerGridOptions.page <= 1" class="btn btn-primary" ng-click="offerGridOptions.previousPage()">
                قبلی
            </button>

                صفحه
                {{offerGridOptions.page}}
                از
                {{offerGridOptions.totalPages}}

            <button type="button" ng-disabled="offerGridOptions.page >= offerGridOptions.totalPages" class="btn btn-primary" ng-click="offerGridOptions.nextPage()">
                بعدی
            </button>
            <button type="button" class="btn btn-success" ng-click="approveCurrentOffer()" ng-disabled="editing || !offer.id" >
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

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Controllers/offerIndexCtrl.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Services/offerService.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Services/offertreeService.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/offerIndex.js') ?>"></script>

<?php $view['slots']->stop() ?>