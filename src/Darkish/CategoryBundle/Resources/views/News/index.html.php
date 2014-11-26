<?php $view->extend('::panel_layout.html.php') ?>



<?php $view['slots']->start('stylesheets') ?>
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control-attribute.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/ui-grid-unstable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/xeditable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.css') ?>" type="text/css" rel="stylesheet" />

<?php $view['slots']->stop() ?>


<?php $view['slots']->start('ngapp') ?>newsApp<?php $view['slots']->stop() ?>

<?php $view['slots']->start('controller') ?>
NewsIndexController
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('formname') ?>newsform<?php $view['slots']->stop() ?>

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
                                        <div class="news-title-field">
                                            <label >
                                                عنوان:
                                            </label>

                                            <input type="text" ng-show="editing" ng-model="news.title" required>
                                            <span ng-hide="editing">{{news.title  || "عنوان خبر" }}</span>

                                        </div>
                                        <div class="news-subtitle-field">
                                            <label>
                                                زیر عنوان:
                                            </label>



                                <span class="news-subtitle">
                                        <input type="text" ng-show="editing" ng-model="news.subTitle">
                                        <span ng-hide="editing">{{news.subTitle  || "تیتر ثانویه" }}</span>
                                </span>
                                        </div>
                                        <div class="id-field" style="clear: both">
                                            <label style="float: right" class="id-label">
                                                شناسه:
                                            </label>
                                            <span style="float: right"  class="id-value">
                                                <span style="float: left"> N</span>{{news.id || "----"}}
                                            </span>
                                        </div>
                                        <div class="news-publish" ng-init="publishediting = 0" style="clear: both">

                                            <div class="news-publish-form" ng-show="editing">
                                                <div class="date-input">
                                                    <label class="news-publish-label">
                                                        تاریخ انتشار:
                                                    </label>
                                                    <input type="text" ng-show="editing" ng-model="news.publishDate" placeholder="139305012312" required />

                                                </div>
                                                <span style="text-decoration: underline;" class="date-display" ng-hide="editing" ng-click="publishediting = 1">{{news.publish || "تاریخ انتشار را وارد کنید"}}</span>
                                            </div>
                                            <div class="news-publish-display" ng-hide="editing">
                                                <label class="news-publish-label">
                                                    تاریخ انتشار:
                                                </label>
                                                <span>
                                                    {{news.publishDate}}
                                                </span>
                                            </div>

                                        </div>


                                        <div class="news-expire-date">
                                            <label>
                                                تاریخ انقضا:
                                            </label>

                                            <input type="number" ng-model="news.expireDate" ng-show="editing" required />

                                            <span ng-hide="editing">{{news.expireDate || "--"}}</span>
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
                                                                  tree-model="dataForTheNewsTree"
                                                                  options="treeOptions"
                                                                  on-selection="selectTreeForCurrentNews(node)"
                                                                  selected-node="news.categoryObj"
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
                                                    {{news.categoryObj.title}}
                                                </span>

                                            </div>

                                            <button ng-show="editing" class="btn btn-default btn-sm" ng-click="open()">
                                                انتخاب شاخه
                                            </button>


                                            <div style="clear: both; padding: 5px 10px; border: 1px solid #d3d3d3" class="competition">

                                                <label class="competition-label">
                                                    مسابقه
                                                </label>
                                                <input ng-disabled="!editing" type="checkbox" ng-change="news.trueAnswer =(!news.isCompetition) ? news.isCompetition : null; news.rate =(!news.isCompetition) ? news.isCompetition : null " ng-model="news.isCompetition">
                                                <br/>
                                                <input ng-required="news.isCompetition == true" id="competition-1" ng-model="news.trueAnswer" ng-disabled="!news.isCompetition" type="radio" value="1"><label for="competition-1">  گزینه یک </label><br/>
                                                <input id="competition-2" ng-model="news.trueAnswer" ng-disabled="!news.isCompetition" type="radio" value="2"><label for="competition-2"> گزینه دو </label><br/>
                                                <input id="competition-3" ng-model="news.trueAnswer" ng-disabled="!news.isCompetition" type="radio" value="3"><label for="competition-3">  گزینه سه </label><br/>
                                                <input id="competition-4" ng-model="news.trueAnswer" ng-disabled="!news.isCompetition" type="radio" value="4"><label for="competition-4">  گزینه چهار </label><br/>
                                                <div class="rate">
                                                    <label for="rate">
                                                        امتیاز
                                                    </label>
                                                    <input ng-required="news.isCompetition == true" id="rate" ng-model="news.rate" type="number" ng-disabled="!news.isCompetition" />

                                                </div>
                                            </div>

                                            <div ng-hide="editing && !news.id" class="news-status">
                                                <span data-ng-show="news.status">
                                                    تایید شده
                                                </span>
                                                <span data-ng-hide="news.status">
                                                    تایید نشده
                                                </span>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-6 right">
                                    <div class="jumbotron" style="padding: 5px;">
                                        <div class="body-editor" ng-show="editing" ng-init="bodyediting = 0">

                                            <div dynamic="html"></div>
                                        </div>
                                        <div class="body-display" ng-hide="editing">
                                            <div class="panel" style="height: 280px; overflow-y: scroll" ng-bind-html="news.body">

                                            </div>

                                        </div>


                                        <div dynamic="ImageInputFile"></div>
                                        <button data-ng-show="editing" data-ng-click="upload()">Upload</button>
                                        <ul class="">
                                        <li ng-repeat="file in news.files">
                                            <img ng-src="{{file.absolutePath}}" width="100px" />
                                            <button data-ng-show="editing" data-ng-click='CkeditorInsertImage(file.absolutePath)'>
                                            افزودن به HTML
                                            </button>
                                        </li>

                                        </ul>

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
                <div ng-hide="newsGridHide" style="width: 100%" dir="rtl" ui-grid="newsGridOptions" ui-grid-edit ui-grid-row-edit ui-grid-cellNav  ui-grid-selection class="grid"></div>
                <button data-ng-click="testFunction()">test</button>


            </div>

        </div>
    </div>
    <?php /* @var $slots Symfony\Component\Templating\Helper\SlotsHelper */ $slots = $view['slots']; ?>


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
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ui-grid-unstable.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular-sanitize.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/xeditable.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ui-bootstrap.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ng-flow-standalone.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/libs/ckeditor/ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ui-bootstrap-tpls-0.11.2.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Controllers/newsIndexCtrl.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Services/newsService.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Services/treeService.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/newsIndex.js') ?>"></script>

<?php $view['slots']->stop() ?>