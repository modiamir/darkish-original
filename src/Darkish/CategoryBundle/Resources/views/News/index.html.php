<?php $view->extend('::panel_layout.html.php') ?>



<?php $view['slots']->start('stylesheets') ?>
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control-attribute.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-ui-grid/ui-grid.min.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/xeditable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/news-admin-page.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-modal/modal.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-hotkeys/build/hotkeys.min.css') ?>" type="text/css" rel="stylesheet" />

<?php $view['slots']->stop() ?>

<?php $view['slots']->start('pagetitle') ?>مدیریت اخبار<?php $view['slots']->stop() ?>
<?php $view['slots']->start('ngapp') ?>NewsApp<?php $view['slots']->stop() ?>

<?php $view['slots']->start('controller') ?>NewsIndexCtrl<?php $view['slots']->stop() ?>

<?php $view['slots']->start('formname') ?>newsform<?php $view['slots']->stop() ?>

<?php $view['slots']->start('body') ?>

    <div class="container-fluid main-wrapper">
        <div class="row main">
            <div class="col col-md-2 main-right main-cols">
                <div class="main-tree-block">
                    <h3 class="block-title">
                        شاخه بندی خبر ها
                    </h3>
                    <ul class="filter-links">
                        <li>
                            <a data-ng-click="TreeService.currentTreeNode = {id: -3};TreeService.selectTree(TreeService.currentTreeNode)" ng-class="{'selected': TreeService.currentTreeNode.id == -3}">
                                همه
                            </a>
                        </li>
                        <li>
                            <a data-ng-click="TreeService.currentTreeNode = {id: -1};TreeService.selectTree(TreeService.currentTreeNode)" ng-class="{'selected': TreeService.currentTreeNode.id == -1}">
                                تایید نشده ها
                            </a>
                        </li>
                        <li>
                            <a data-ng-click="TreeService.currentTreeNode = {id: 0};TreeService.selectTree(TreeService.currentTreeNode)" ng-class="{'selected': TreeService.currentTreeNode.id == 0}">
                                بدون شاخه
                            </a>
                        </li>
                        <li>
                            <a data-ng-click="TreeService.currentTreeNode = {id: -2};TreeService.selectTree(TreeService.currentTreeNode)" ng-class="{'selected': TreeService.currentTreeNode.id == -2}">
                                غیرفعال
                            </a>
                        </li>
                    </ul>
                    <div class="news-tree">
                        <treecontrol class="tree-classic"
                                     tree-model="tree()"
                                     options="treeOptions()"
                                     on-selection="TreeService.selectTree(node)"
                                     selected-node="TreeService.currentTreeNode">
                            {{node.title}}
                        </treecontrol>
                        <div data-ng-show="NewsService.isEditing()" id="tree-selectable-inactivator"></div>
                    </div>
                </div>
                <div class="main-search-block">
                    <h3 class="block-title">
جستجو
                    </h3>
                    <div class="search-box">
                        <input tabindex="-1" id="search-by-title" type="radio" name="search-based-on" ng-model="NewsService.newsSearchCriteria.searchBy" value="1" />
                        <label for="search-by-title">
                            عنوان
                        </label>
                        <input tabindex="-1" id="search-by-number" type="radio" name="search-based-on" ng-model="NewsService.newsSearchCriteria.searchBy" value="2" />
                        <label for="search-by-number">
                            شماره
                        </label>
                        <input tabindex="-1" id="search-by-all" type="radio" name="search-based-on" ng-model="NewsService.newsSearchCriteria.searchBy" value="3" />
                        <label for="search-by-all">
                            همه
                        </label>

                        <button tabindex="-1" class="btn" data-ng-click="NewsService.newsSearchCriteria.cid = null; NewsService.searchNews()">
                            بیاب
                        </button>
                        <input type="text" class="keyword" ng-model="NewsService.newsSearchCriteria.searchKeyword" tabindex="-1" />
                    </div>
                </div>
                <div class="sort-block">
                    <span>
                        ترتیب نمایش
                    </span>
                    <input tabindex="-1" id="sort-by-date-desc" type="radio" name="sort-based-on"
                           ng-model="NewsService.newsSearchCriteria.sortBy" value="1" />
                    <label for="sort-by-date-desc">
                        تاریخ نزولی
                    </label>
                    <input tabindex="-1" id="sort-by-date-asc" type="radio" name="sort-based-on"
                           ng-model="NewsService.newsSearchCriteria.sortBy" value="2" />
                    <label for="sort-by-date-asc">
تاریخ صعودی
                    </label>
                    <input tabindex="-1" id="sort-by-number-desc" type="radio" name="sort-based-on"
                           ng-model="NewsService.newsSearchCriteria.sortBy" value="3" />
                    <label for="sort-by-number-desc">
شماره نزولی
                    </label>
                    <input tabindex="-1" id="sort-by-number-asc" type="radio" name="sort-based-on"
                           ng-model="NewsService.newsSearchCriteria.sortBy" value="4" />
                    <label for="sort-by-number-asc">
شماره صعودی
                    </label>
                </div>
            </div>
            <div class="col col-md-6 main-center main-cols">
                <div class="basic-info col col-md-12">
                    

                    <div class="basic-info-right-col">
                        <div class="news-title">
                            <div class="field-title news-title-title">عنوان:</div>
                            <input type="text" ng-maxlength="70" name="news-title" class="news-title-input" ng-model="NewsService.currentNews.title" ng-disabled="!NewsService.isEditing()" required>
                            
                        </div>

                        <div class="news-subtitle">
                            <div class="field-title news-title-title">زیر عنوان:</div>
                            <input  type="text" ng-maxlength="70" name="news-subtitle" class="news-subtitle-input" ng-model="NewsService.currentNews.sub_title" ng-disabled="!NewsService.isEditing()" required>
                        </div>
                        
                        
                        
                        

                    </div>
      
                </div>
                <div class="main-fields-row">





                    <div class="col main-fields-wrapper" id="main-fields-wrapper">
                        <div class="main-fields-first-section" >



                            <div class="main-fields-tree-list">
                                <div class="main-fields-tree-list-commands-wrapper">
                                    <label class="tree-list-trees-button-wrapper">
                                        شاخه ها:
                                    </label>
                                    <div class="tree-list-add-remove-button-wrapper">
                                        
                                        <button type="button" ng-click="openTreeModal()" id="tree-list-add-button"  ng-disabled="!NewsService.isEditing()">+</button>
                                        <button type="button" ng-click="NewsService.removeFromTreeList(secondTreeSelected)" id="tree-list-remove-button" ng-disabled="!NewsService.isEditing()">-</button>
                                    </div>


                                </div>
                                <select multiple id="tree-list-input" ng-model="secondTreeSelected" ng-disabled="!NewsService.isEditing()"
                                            ng-options="tree.title for tree in NewsService.currentNews.treeList.all()">
                                        

                                </select>
                                <script type="text/ng-template" id="treeModal.html">
                                    <div class="modal-header">
                                        <h3 class="modal-title">انتخاب شاخه ها</h3>
                                    </div>
                                    <div class="modal-body">
                                        <treecontrol class="tree-classic"
                                                    tree-model="tree()"
                                                    options="treeOptions()"
                                                    selected-node="TreeService.currentSecondTreeNode">
                                           {{node.title}}
                                        </treecontrol>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-warning" ng-click="close()">بستن</button>
                                        <button class="btn btn-info pull-left" data-ng-click="NewsService.addToTreeList(TreeService.currentSecondTreeNode)">اضافه</button>
                                    </div>
                                </script>
                                
                            </div>
                            <div class="dates">
                                <div class="publish-date-box">
                                    <label id="publish-date-label" class="third-section-label " for="publish-date-picker">تاریخ اعتبار</label>
                                    <input ng-click="openPublishDate($event)" type="text" id="publish-date-picker" class=" third-section-input"  datepicker-popup-persian="{{format}}" ng-model="NewsService.currentNews.publish_date" is-open="publishDateIsOpen"  datepicker-options="publishDateOptions" date-disabled="disabled(date, mode)" ng-disabled="!NewsService.isEditing()" close-text="بستن" />
                                </div>

                                <div class="expire-date-box">
                                    <label id="expire-date-label" class="third-section-label " for="expire-date-picker">تاریخ اعتبار</label>
                                    <input ng-click="openExpireDate($event)" type="text" id="expire-date-picker" class=" third-section-input"  datepicker-popup-persian="{{format}}" ng-model="NewsService.currentNews.expire_date" is-open="expireDateIsOpen"  datepicker-options="expireDateOptions" date-disabled="disabled(date, mode)" ng-disabled="!NewsService.isEditing()" close-text="بستن" />
                                </div>
                            </div>
                            
                            <div class="competition-box">
                                <label class="is-competition-label" for="is-competition-input">
                                    مسابقه
                                </label>
                                <input id="is-competition-input" ng-model="NewsService.currentNews.is_competition" type="checkbox" ng-disabled="!NewsService.isEditing()" />
                                <label class="true-answer-label">
                                    پاسخ درست
                                </label>
                                <label class="answer-label" for="answer-1">1</label> <input type="radio" id="answer-1" ng-model="NewsService.currentNews.true_answer" value="1" name="trueanswer" ng-disabled="!NewsService.isEditing() || !NewsService.currentNews.is_competition"/>
                                <label class="answer-label" for="answer-2">2</label> <input type="radio" id="answer-2" ng-model="NewsService.currentNews.true_answer" value="2" name="trueanswer" ng-disabled="!NewsService.isEditing() || !NewsService.currentNews.is_competition"/>
                                <label class="answer-label" for="answer-3">3</label> <input type="radio" id="answer-3" ng-model="NewsService.currentNews.true_answer" value="3" name="trueanswer" ng-disabled="!NewsService.isEditing() || !NewsService.currentNews.is_competition"/>
                                <label class="answer-label" for="answer-4">4</label> <input type="radio" id="answer-4" ng-model="NewsService.currentNews.true_answer" value="4" name="trueanswer" ng-disabled="!NewsService.isEditing() || !NewsService.currentNews.is_competition"/>                                
                                
                                <label class="competition-rate-label" for="competition-rate-input">
                                    امتیاز
                                </label>
                                <input id="competition-rate-input" ng-model="NewsService.currentNews.rate" ng-disabled="!NewsService.isEditing() || !NewsService.currentNews.is_competition"/>
                            </div>

                        </div>

                    </div>
                    
                </div>
                
            </div>

            <div class="col col-md-4 main-left main-cols">
                <div class="row file-upload-row">
                    <div class="col col-md-6 message-box">
                        <span class="uploader-msg" ng-bind="uploader.msg">
                            
                        </span>
                    </div>
                    <div class="col col-md-4">
                        <div class="progress" style="">
                            <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                        </div>
                    </div>
                    <div class="col col-md-2 upload-cancel">
                        <button ng-show="uploader.isUploading" ng-disabled="!NewsService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
                            X
                        </button>
                    </div>
                    
                    
                </div>
                <div class="row attachements-wrapper">
                    <div class="col-md-2 right">
                        <ul class="tab-list" ng-init="ValuesService.activeTab = 'image'">
                            <li class="pure-button"
                                ng-class="{'tab-active': ValuesService.activeTab === 'image'}"
                                ng-click="selectTab('image')">
                                عکس
                            </li>
                            <li class="pure-button"
                                ng-class="{'tab-active': ValuesService.activeTab === 'icon'}"
                                ng-click="selectTab('icon')">
                                آیکون
                            </li>
                            <li class="pure-button"
                                ng-class="{'tab-active': ValuesService.activeTab === 'video'}"
                                ng-click="selectTab('video')">
                                فیلم
                            </li>
                            <li class="pure-button"
                                ng-class="{'tab-active': ValuesService.activeTab === 'audio'}"
                                ng-click="selectTab('audio')">
                                صدا
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8 center">
                        <div class="tab-content">
                            <div ng-switch="ValuesService.activeTab">
                                <div ng-switch-when="image" class="image">
                                    <ul class="image-list">
                                        <li ng-repeat="image in NewsService.currentNews.images" style="float: right"  ng-class="{'selected' : NewsService.selectedImage.id == image.id}">
                                            <img ng-click="NewsService.selectedImage = image ;openImageModal('lg',image, $index)" ng-src="{{image.absolute_path}}"  />
                                            <input
                                                type="checkbox"
                                                checklist-model="NewsService.selectedImages"
                                                checklist-value="image"
                                            />
                                        </li>
                                    </ul>
                                    <script type="text/ng-template" id="imageModal.html">
                                        
                                        <div class="modal-body">
                                            <img width="100%" ng-src="{{currentImage.absolute_path}}" />
                                        </div>
                                        <div class="modal-footer">
                                            <button data-ng-click="prev()" class="btn btn-info pull-left" ng-disabled="currentIndex <= 1">
                                                قبلی
                                            </button>
                                            <button data-ng-click="next()" class="btn btn-info pull-left" ng-disabled="currentIndex >= totalImage">
                                                بعدی
                                            </button>
                                            <button class="btn btn-warning" data-ng-click="close()">
                                                بستن
                                            </button>
                                        </div>
                                    </script>
                                    

                                </div>
                                <div ng-switch-when="icon" class="icon">
                                    
                                    <img ng-show="NewsService.currentNews.icon.id" ng-click="openIconModal('lg',icon)" ng-src="{{NewsService.currentNews.icon.absolute_path}}"  />
                                    <input
                                        ng-show="NewsService.currentNews.icon.id"
                                        type="checkbox"
                                        checklist-model="NewsService.selectedIcon"
                                        checklist-value="true"
                                    />
                                        
                                    <script type="text/ng-template" id="iconModal.html">
                                        
                                        <div class="modal-body">
                                            <img width="100%" ng-src="{{icon.absolute_path}}" />
                                        </div>
                                        
                                    </script>
                                    

                                </div>
                                <div ng-switch-when="video" class="video">
                                    <ul class="video-list">
                                        <li ng-repeat="video in NewsService.currentNews.videos" style="float: right"  ng-class="{'selected' : NewsService.selectedVideo.id == video.id}">
                                            <input
                                                type="checkbox"
                                                checklist-model="NewsService.selectedVideos"
                                                checklist-value="video"
                                                />
                                            <span ng-bind="video.file_name" ng-click="NewsService.selectedVideo =video; openVideoModal('lg',video, $index)"></span>
                                        </li>
                                    </ul>
                                    <script type="text/ng-template" id="videoModal.html">
                                        
                                        <div class="modal-body">
                                            <video id="modal-video-player" controls="" autoplay=""  width="320" height="240" name="media"><source ng-src="{{currentVideo.absolute_path}}" type="{{currentVideo.filemime}}"></video>
                                        </div>
                                        <div class="modal-footer">
                                            <button data-ng-click="prev()" class="btn btn-info pull-left" ng-disabled="currentIndex <= 1">
                                                قبلی
                                            </button>
                                            <button data-ng-click="next()" class="btn btn-info pull-left" ng-disabled="currentIndex >= totalVideo">
                                                بعدی
                                            </button>
                                            <button class="btn btn-warning" data-ng-click="close()">
                                                بستن
                                            </button>
                                        </div>
                                    </script>
                                </div>
                                <div ng-switch-when="audio" class="audio">
                                    <ul class="audio-list">
                                        <li ng-repeat="audio in NewsService.currentNews.audios" style="float: right" ng-class="{'selected' : NewsService.selectedAudio.id == audio.id}">
                                            <input
                                                type="checkbox"
                                                checklist-model="NewsService.selectedAudios"
                                                checklist-value="audio"
                                            />
                                            <span ng-bind="audio.file_name" ng-click="NewsService.selectedAudio = audio" >  </span>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 left">
<!--                        <button class="btn btn-info add-attachment" ng-disabled="!NewsService.isEditing()" data-ng-click="showUploadModal()">
                            اضافه
                        </button>-->
                        
                        
                        <label class="file-select" ng-class="{'disabled': !NewsService.isEditing()}">
                            انتخاب فایل
                            <input ng-disabled="!NewsService.isEditing()" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
                        </label>
                        
                        <script type="text/ng-template" id="upload-modal.html">

                            <div class="modal-bg upload-file" data-ng-click="closeMe()">
                                <div class="btf-modal" data-ng-click="$event.stopPropagation()">
                                    <h3 class="modal-header1">
                                        آپلود فایل
                                    </h3>
                                    <div class="modal-body">
                                    
                                        <div class="container upload-modal-container">



                                            <div class="row">

                                                <div class="col-md-12">

                                                    <input type="file" nv-file-select="" uploader="uploader" multiple="true"  /><br/>

                                                </div>

                                                <div class="col-md-12" style="margin-bottom: 40px">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th width="50%">Name</th>
                                                                <th ng-show="uploader.isHTML5">Size</th>
                                                                <th ng-show="uploader.isHTML5">Progress</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr ng-repeat="item in uploader.queue">
                                                                <td>
                                                                    <strong>{{ item.file.name }}</strong>
                                                                    <!-- Image preview -->
                                                                    <!--auto height-->
                                                                    <!--<div ng-thumb="{ file: item.file, width: 100 }"></div>-->
                                                                    <!--auto width-->

                                                                    <!--fixed width and height -->
                                                                    <!--<div ng-thumb="{ file: item.file, width: 100, height: 100 }"></div>-->
                                                                </td>
                                                                <td ng-show="uploader.isHTML5" nowrap>{{ item.file.size/1024/1024|number:2 }} MB</td>
                                                                <td ng-show="uploader.isHTML5">
                                                                    <div class="progress" style="margin-bottom: 0;">
                                                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
                                                                    </div>
                                                                </td>
                                                                <td class="text-center">
                                                                    <span ng-show="item.isSuccess"><i class="glyphicon glyphicon-ok"></i></span>
                                                                    <span ng-show="item.isCancel"><i class="glyphicon glyphicon-ban-circle"></i></span>
                                                                    <span ng-show="item.isError"><i class="glyphicon glyphicon-remove"></i></span>
                                                                </td>
                                                                <td nowrap>
                                                                    <button type="button" class="btn btn-success btn-xs" ng-click="item.upload()" ng-disabled="item.isReady || item.isUploading || item.isSuccess">
                                                                        <span class="glyphicon glyphicon-upload"></span> Upload
                                                                    </button>
                                                                    <button type="button" class="btn btn-warning btn-xs" ng-click="item.cancel()" ng-disabled="!item.isUploading">
                                                                        <span class="glyphicon glyphicon-ban-circle"></span> Cancel
                                                                    </button>
                                                                    <button type="button" class="btn btn-danger btn-xs" ng-click="item.remove()">
                                                                        <span class="glyphicon glyphicon-trash"></span> Remove
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <div>
                                                        <div>
                                                            Queue progress:
                                                            <div class="progress" style="">
                                                                <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <div class="modal-control-buttons-wrapper">
                                        <button class="btn"  data-ng-click="closeMe()">
                                            بستن
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </script>
                        <button class="btn btn-danger remove-attachment" ng-disabled="!NewsService.isEditing()"
                                data-ng-click="NewsService.removeFromAttachList()">
                            حذف
                        </button>
                        <button class="btn btn-info btn-continual-modal" ng-disabled="!NewsService.isEditing()"
                                data-ng-click="openContinualModal()">
                            تنظیمات
                        </button>
                        <script type="text/ng-template" id="continualModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">تنظیمات فایل ها</h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col col-md-7 center" style="text-align: center;
                                                                            border-bottom: 1px solid rgb(110, 181, 95);
                                                                            padding-bottom: 5px;">
                                        خبر
                                    </div>
                                    <div class="col col-md-5 center" style="text-align: center;
                                                                            border-bottom: 1px solid rgb(117, 95, 181);
                                                                            padding-bottom: 5px;">
                                        صفحه HTML
                                    </div>
                                </div>
                                <tabset justified="true">
                                    <tab heading="تصاویر">
                                        <table class="table table-striped" 
                                            style="height: 300px;overflow-y: scroll;display: inline-block;">
                                            <tr>
                                                <th style="width: 50%">
                                                    نام فایل
                                                </th>
                                                <th style="width: 30%">
                                                    پیش نمایش
                                                </th>
                                                <th style="width: 10%">
                                                    دائمی
                                                </th>

                                            </tr>
                                            <tr ng-repeat="image in images">
                                                <td style="width: 50%; overflow-wrap: break-word;">{{image.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{image.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="image.continual" />
                                                </td>
                                            </tr>
                                        </table>
                                    </tab>
                                    <tab heading="آیکن">
                                        <table class="table table-striped" 
                                            style="height: 300px;overflow-y: scroll;display: inline-block;">
                                            <tr>
                                                <th style="width: 50%">
                                                    نام فایل
                                                </th>
                                                <th style="width: 30%">
                                                    پیش نمایش
                                                </th>
                                                <th style="width: 10%">
                                                    دائمی
                                                </th>

                                            </tr>
                                            <tr>
                                                <td style="width: 50%; overflow-wrap: break-word;">{{NewsService.currentNews.icon.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{NewsService.currentNews.icon.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="NewsService.currentNews.icon.continual" />
                                                </td>
                                            </tr>
                                        </table>
                                    </tab>
                                    <tab heading="ویدئو ها">
                                        <table class="table table-striped" 
                                            style="height: 300px;overflow-y: scroll;display: inline-block;">
                                            <tr>
                                                <th style="width: 50%">
                                                    نام فایل
                                                </th>
                                                <th style="width: 30%">
                                                    پیش نمایش
                                                </th>
                                                <th style="width: 10%">
                                                    دائمی
                                                </th>
                                            </tr>
                                            <tr ng-repeat="video in videos">
                                                <td style="width: 50%; overflow-wrap: break-word;">{{video.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{video.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="video.continual" />
                                                </td>
                                            </tr>
                                        </table>
                                    </tab>
                                    <tab heading="صدا ">
                                        <table class="table table-striped" 
                                            style="height: 300px;overflow-y: scroll;display: inline-block;">
                                            <tr>
                                                <th style="width: 50%">
                                                    نام فایل
                                                </th>
                                                <th style="width: 30%">
                                                    پیش نمایش
                                                </th>
                                                <th style="width: 10%">
                                                    دائمی
                                                </th>
                                            </tr>
                                            <tr ng-repeat="audio in audios">
                                                <td style="width: 50%; overflow-wrap: break-word;">{{audio.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{audio.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="audio.continual" />
                                                </td>
                                            </tr>
                                        </table>
                                    </tab>
                                    <tab heading="تصاویر ">
                                        <table class="table table-striped" 
                                            style="height: 300px;overflow-y: scroll;display: inline-block;">
                                            <tr>
                                                <th style="width: 50%">
                                                    نام فایل
                                                </th>
                                                <th style="width: 30%">
                                                    پیش نمایش
                                                </th>
                                                <th style="width: 10%">
                                                    دائمی
                                                </th>
                                            </tr>
                                            <tr ng-repeat="bodyImage in bodyImages">
                                                <td style="width: 50%; overflow-wrap: break-word;">{{bodyImage.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{bodyImage.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="bodyImage.continual" />
                                                </td>
                                            </tr>
                                        </table>
                                    </tab>

                                    <tab heading="ویدئو ها ">
                                        <table class="table table-striped" 
                                            style="height: 300px;overflow-y: scroll;display: inline-block;">
                                            <tr>
                                                <th style="width: 50%">
                                                    نام فایل
                                                </th>
                                                <th style="width: 30%">
                                                    پیش نمایش
                                                </th>
                                                <th style="width: 10%">
                                                    دائمی
                                                </th>
                                            </tr>
                                            <tr ng-repeat="bodyVideo in bodyVideos">
                                                <td style="width: 50%; overflow-wrap: break-word;">{{bodyVideo.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{bodyVideo.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="bodyVideo.continual" />
                                                </td>
                                            </tr>
                                        </table>
                                    </tab>

                                    <tab heading="صدا">
                                        <table class="table table-striped" 
                                            style="height: 300px;overflow-y: scroll;display: inline-block;">
                                            <tr>
                                                <th style="width: 50%">
                                                    نام فایل
                                                </th>
                                                <th style="width: 30%">
                                                    پیش نمایش
                                                </th>
                                                <th style="width: 10%">
                                                    دائمی
                                                </th>
                                            </tr>
                                            <tr ng-repeat="bodyAudio in bodyAudios">
                                                <td style="width: 50%; overflow-wrap: break-word;">{{bodyAudio.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{bodyAudio.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="bodyAudio.continual" />
                                                </td>
                                            </tr>
                                        </table>
                                    </tab>
                            
                                    <tab heading="دیگر">
                                        <table class="table table-striped" 
                                            style="height: 300px;overflow-y: scroll;display: inline-block;">
                                            <tr>
                                                <th style="width: 50%">
                                                    نام فایل
                                                </th>
                                                <th style="width: 30%">
                                                    پیش نمایش
                                                </th>
                                                <th style="width: 10%">
                                                    دائمی
                                                </th>
                                            </tr>
                                            <tr ng-repeat="bodyDoc in bodyDocs">
                                                <td style="width: 50%; overflow-wrap: break-word;">{{bodyDoc.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{bodyDoc.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="bodyDoc.continual" />
                                                </td>
                                            </tr>
                                        </table>
                                    </tab>
                                </tabset>
                            </div>
                            <div class="modal-footer">
                                <button class="btn"  data-ng-click="close()">
                                    بستن
                                </button>
                                <button class="btn btn-info" data-ng-click="save()">
                                    ذخیره
                                </button>
                            </div>
                        </script>
                        <script type="text/ng-template" id="continual-modal.html">

                            <div class="modal-bg continual-file" data-ng-click="closeMe()">
                                <div class="btf-modal" data-ng-click="$event.stopPropagation()">
                                    <h3 class="modal-header1">
                                        
                                    </h3>
                                    <div class="modal-body">
                                        

                                    </div>
                                    <div class="modal-control-buttons-wrapper">
                                        
                                    </div>
                                </div>
                            </div>
                        </script>
                        
                    </div>
                </div>

                <div class="row html-wrapper">
                    <div class="col-md-12">
                        <div class="html-preview" ng-bind-html="trustedBody()">

                        </div>
                        <button data-ng-show="NewsService.isEditing()" id="body-modal-button" class="btn btn-info" data-ng-click="openBodyModal('lg')">
                            ویرایش صفحه
                        </button>
                        <script type="text/ng-template" id="bodyModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">بدنه خبر</h3>
                                <button class=" close-button btn btn-primary pull-right" ng-click="close()">بستن</button>
                                <button ng-disabled="!NewsService.isEditing() || newsform.$invalid" type="button" class="save-continue-button btn btn-success" ng-click="openSavingModal();NewsService.saveCurrentNews(true);newsform.$setPristine()">
                                    ذخیره و ادامه
                                </button>
                                <span class="body-save-continue-message" ng-show="NewsService.saved">
                                    <ul>
                                        <li ng-repeat="msg in NewsService.savingMessages" ng-bind="msg">
                                        </li>
                                    </ul>
                                </span>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 body-modal-right">
                                        <div class="body-attachments">
                                            <div class="body-attachments-inner">

                                                <tabset ng-init="selectTab('image')">
                                                    <tab select="selectTab('image')" heading="عکس">
                                                        <div class="image">
                                                            <ul class="image-list files-list">
                                                                <li class = "file" ng-repeat="image in NewsService.currentNews.body_images" style="float: right" ng-click="NewsService.selectBodyImage(image)" ng-class="{'selected' : NewsService.selectedBodyImage.id == image.id}">
                                                                    <img ng-src="{{image.absolute_path}}"  ng-click="NewsService.selectedBodyImage = image ;showImageShowModal(image)" />
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="NewsService.selectedBodyImages"
                                                                        checklist-value="image"
                                                                        />
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('video')" heading="فیلم">
                                                        <div class="video">
                                                            <ul class="video-list files-list">
                                                                <li class = "file" ng-repeat="video in NewsService.currentNews.body_videos" style="float: right" ng-click="NewsService.selectBodyVideo(video)" ng-class="{'selected' : NewsService.selectedBodyVideo.id == video.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="NewsService.selectedBodyVideos"
                                                                        checklist-value="video"
                                                                    />
                                                                    <span ng-click="NewsService.selectedBodyVideo =video" ng-bind="video.file_name"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('audio')" heading="صدا">
                                                        <div class="audio">
                                                            <ul class="audio-list files-list">
                                                                <li class = "file" ng-repeat="audio in NewsService.currentNews.body_audios" style="float: right" ng-click="NewsService.selectBodyAudio(audio)" ng-class="{'selected' : NewsService.selectedBodyAudio.id == audio.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="NewsService.selectedBodyAudios"
                                                                        checklist-value="audio"
                                                                    />
                                                                    <span ng-click="NewsService.selectedBodyAudio =audio" ng-bind="audio.file_name" ></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('doc')" heading="دیگر">
                                                        <div class="doc">
                                                            <ul class="doc-list files-list">
                                                                <li class = "file" ng-repeat="doc in NewsService.currentNews.body_docs" style="float: right" ng-click="NewsService.selectBodyAudio(doc)" ng-class="{'selected' : NewsService.selectedBodyDoc.id == doc.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="NewsService.selectedBodyDocs"
                                                                        checklist-value="doc"
                                                                    />
                                                                    <span ng-click="NewsService.selectedBodyDoc =doc" ng-bind="doc.file_name" ></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                </tabset>





                                                <div class="container body-modal-container">



                                                    <div class="row">

                                                        <div class="col-md-12" >

                                                            <div class="row file-upload-row">
                                                                <div class="col col-md-8">
                                                                    <div class="progress" style="">
                                                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col col-md-4">
                                                                    <button ng-show="uploader.isUploading" ng-disabled="!NewsService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
                                                                        انصراف
                                                                    </button>
                                                                </div>


                                                            </div>




                                                        </div>
                                                        <div class="col col-md-12 message-box">
                                                            <span class="uploader-msg" ng-bind="uploader.msg">

                                                            </span>
                                                        </div>
                                                        <div class="col-md-12 body-upload-buttons" >
                                                            <label class="file-select" ng-class="{'disabled': !NewsService.isEditing()}">
                                                                انتخاب فایل
                                                                <input ng-disabled="!NewsService.isEditing()" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
                                                            </label>
                                                            <button class="btn btn-info" data-ng-click="CkeditorInsert()" ng-disabled="!NewsService.isReadyToInsert()">
                                                                درج
                                                            </button>
                                                            <button class="btn btn-danger" data-ng-click="NewsService.removeFromBodyAttachList()">
                                                                حذف
                                                            </button>
                                                            <button ng-disabled="!NewsService.isEditing() || newsform.$invalid" type="button" class="save-continue-button-bottom btn btn-success" ng-click="openSavingModal();NewsService.saveCurrentNews(true);newsform.$setPristine()">
                                                                ذخیره و ادامه
                                                            </button>
                                                            <span class="body-save-continue-message-bottom" ng-show="NewsService.saved">
                                                                <ul>
                                                                    <li ng-repeat="msg in NewsService.savingMessages" ng-bind="msg">
                                                                    </li>
                                                                </ul>
                                                            </span>
                                                            <button class="btn insert-tree-button" ng-click="openBodyTreeModal()" >درج شاخه</button>
                                                            <button class="btn insert-news-button" ng-click="openBodyNewsModal()" >درج خبر</button>
                                                            <button class="btn insert-news-button" ng-click="openInsertLinkModal()" >درج لینک</button>
                                                        </div>

                                                        

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="body-editor">
                                            <textarea ckeditor="bodyEditorOptions" ng-model="NewsService.currentNews.body"></textarea>

                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </script>
                        <script type="text/ng-template" id="bodyTreeModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">درج شاخه</h3>
                            </div>
                            <div class="modal-body">
                                <treecontrol class="tree-classic"
                                            tree-model="tree()"
                                            options="treeOptions"
                                            selected-node="currentBodyTreeNode">
                                   {{node.title}}
                                </treecontrol>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" ng-click="close()">بستن</button>
                                <button class="btn btn-info pull-left" data-ng-click="insertTree()">اضافه</button>
                            </div>
                        </script>
                        <script type="text/ng-template" id="bodyNewsModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">درج خبر</h3>
                            </div>
                            <div class="modal-body">
                                <label class="news-insert-text-label" for="news-insert-text">متن</label>
                                <input id="news-insert-text" type="text" ng-model="text" />
                                
                                <label class="news-insert-id-label" for="news-insert-id">شماره خبر</label>
                                <input id="news-insert-id" type="text" ng-model="newsId" />
                                
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" ng-click="close()">بستن</button>
                                <button class="btn btn-info pull-left" data-ng-click="insertNews()">اضافه</button>
                            </div>
                        </script>
                        <script type="text/ng-template" id="insertLinkModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">درج لینک</h3>
                            </div>
                            <div class="modal-body">
                                <label class="link-insert-text-label" for="news-insert-text">متن</label>
                                <input id="link-insert-text" type="text" ng-model="text" />
                                
                                <label class="link-insert-link-label" for="news-insert-id">لینک</label>
                                <input dir="ltr" id="link-insert-link" type="text" ng-model="link" /><span dir="ltr"> http:// </span>
                                
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" ng-click="close()">بستن</button>
                                <button class="btn btn-info pull-left" data-ng-click="insertLink()">اضافه</button>
                            </div>
                        </script>
                        <script type="text/ng-template" id="body-modal.html" >
                            <div id="body-modal-bg " class="modal-bg html-editor-modal" data-ng-click="closeMe()">
                                <div id="body-modal-btf" class="btf-modal"  data-ng-click="$event.stopPropagation()">
                                    <h3 class="modal-header1">
                                        
                                        <div class="modal-header-control-buttons-wrapper">
                                            <a ng-click="closeMe()">X</a>
                                        </div>
                                    </h3>
                                    
                                    <div class="body-modal-content">
                                        <div class="row">
                                            <div class="col-md-4 body-modal-right">
                                                <div class="body-attachments">
                                                    <div class="body-attachments-inner">
                                                        
                                                        <tabset ng-init="selectTab('image')">
                                                            <tab select="selectTab('image')" heading="عکس">
                                                                <div class="image">
                                                                    <ul class="image-list files-list">
                                                                        <li class = "file" ng-repeat="image in NewsService.currentNews.body_images" style="float: right" ng-click="NewsService.selectBodyImage(image)" ng-class="{'selected' : NewsService.selectedBodyImage.id == image.id}">
                                                                            <img ng-src="{{image.absolute_path}}"  ng-click="NewsService.selectedBodyImage = image ;showImageShowModal(image)" />
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="NewsService.selectedBodyImages"
                                                                                checklist-value="image"
                                                                                />
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                            <tab select="selectTab('video')" heading="فیلم">
                                                                <div class="video">
                                                                    <ul class="video-list files-list">
                                                                        <li class = "file" ng-repeat="video in NewsService.currentNews.body_videos" style="float: right" ng-click="NewsService.selectBodyVideo(video)" ng-class="{'selected' : NewsService.selectedBodyVideo.id == video.id}">
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="NewsService.selectedBodyVideos"
                                                                                checklist-value="video"
                                                                            />
                                                                            <span ng-click="NewsService.selectedBodyVideo =video" ng-bind="video.file_name"></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                            <tab select="selectTab('audio')" heading="صدا">
                                                                <div class="audio">
                                                                    <ul class="audio-list files-list">
                                                                        <li class = "file" ng-repeat="audio in NewsService.currentNews.body_audios" style="float: right" ng-click="NewsService.selectBodyAudio(audio)" ng-class="{'selected' : NewsService.selectedBodyAudio.id == audio.id}">
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="NewsService.selectedBodyAudios"
                                                                                checklist-value="audio"
                                                                            />
                                                                            <span ng-click="NewsService.selectedBodyAudio =audio" ng-bind="audio.file_name" ></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                        </tabset>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <div class="container body-modal-container">



                                                            <div class="row">

                                                                <div class="col-md-12">
                                                                    <button class="btn btn-danger" data-ng-click="NewsService.removeFromBodyAttachList()">
                                                                        حذف
                                                                    </button>
                                                                    <button class="btn btn-info" data-ng-click="CkeditorInsert()" ng-disabled="!NewsService.isReadyToInsert()">
                                                                        درج
                                                                    </button>
                                                                    <label class="file-select" ng-class="{'disabled': !NewsService.isEditing()}">
                                                                        انتخاب فایل
                                                                        <input ng-disabled="!NewsService.isEditing()" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
                                                                    </label>

                                                                </div>

                                                                <div class="col-md-12">
                                                                    
                                                                            <div class="row file-upload-row">
                                                                                <div class="col col-md-4">
                                                                                    <div class="progress" style="">
                                                                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col col-md-2">
                                                                                    <button ng-disabled="!NewsService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
                                                                                        انصراف
                                                                                    </button>
                                                                                </div>
                                                                                <div class="col col-md-6 message-box">
                                                                                    <span class="uploader-msg" ng-bind="uploader.msg">

                                                                                    </span>
                                                                                </div>

                                                                            </div>
                                                                        

                                                                    

                                                                </div>

                                                            </div>

                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="body-editor">
                                                    <textarea ckeditor="bodyEditorOptions" ng-model="NewsService.currentNews.body"></textarea>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </script>

                    </div>

                </div>

            </div>
        </div>
        <div class="row list">
            <div class="col col-lg-12 grid-block-wrapper">
                

                <div class="grid-block">
                    <table st-table="newsList()" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>شماره پرونده</th>
                            <th>عنوان</th>
                            <th>عنوان فرعی</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr st-select-row="row" ng-class="{selected: NewsService.isSelected(row)}" data-ng-click="NewsService.selectNews(row)" st-select-mode="single" ng-repeat="row in newsList()">
                            <td>{{row.id}}</td>
                            <td>{{row.news_number}}</td>
                            <td>{{row.title}}</td>
                            <td>{{row.sub_title}}</td>
                        </tr>
                        </tbody>
                    </table>



                </div>
                <div id="news-list-inactivator" data-ng-show="NewsService.isEditing()" >

                </div>
            </div>

        </div>
    </div>




    <div class="container-fluid">







    </div>






<?php $view['slots']->stop() ?>


<?php $view['slots']->start('top-menu');?>
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">اخبار و سرگرمی<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?php print $view['router']->generate("offer"); ?>">پیشنهاد ویژه</a></li>
                <li><a href="<?php print $view['router']->generate("classified"); ?>">نیازمندی ها</a></li>
                <li><a href="<?php print $view['router']->generate("record"); ?>" >مدیریت رکورد ها</a></li>

            </ul>
        </li>
    </ul>
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('top-actions');?>
    <div  class="news-top show-grid ">

        <div class="col-md-4">
            <button ng-show="SecurityService.buttonsAccess.newButtonAccess()" ng-disabled="NewsService.isEditing()" type="button" class="btn btn-primary" ng-click="NewsService.editingNew()">
                جدید
            </button>

            <button ng-show="SecurityService.buttonsAccess.editButtonAccess()" ng-disabled="NewsService.isNew() || NewsService.isEditing()" type="button" class="btn btn-info" ng-click="NewsService.editing()">
                ویرایش
            </button>
            <script type="text/ng-template" id="deleteModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">حذف خبر</h3>
                </div>
                <div class="modal-body">
                    آیا از حذف خبر جاری اطمینان دارید؟
                            
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" data-ng-click="close()">
                        خیر (انصراف)
                    </button>
                    <button class="btn btn-danger" data-ng-click="deleteCurrentNews()">
                        بله (حذف)
                    </button>
                </div>
            </script>
            <script type="text/ng-template" id="delete-modal.html">

                <div class="modal-bg" data-ng-click="closeMe()">
                    <div class="btf-modal  titles-modal" data-ng-click="$event.stopPropagation()">
                        <h3 class="modal-header">
                            
                        </h3>
                        <div class="modal-body">
                            
                        </div>
                    </div>
                </div>
            </script>
            <button ng-show="SecurityService.buttonsAccess.deleteButtonAccess()" ng-disabled="!NewsService.currentNews.id || NewsService.isEditing()"  type="button" class="btn btn-danger" ng-click="openDeleteModal()" ng-disabled="editing || !news.id">
                حذف
            </button>
            <button ng-show="SecurityService.buttonsAccess.saveButtonAccess()" ng-disabled="!NewsService.isEditing() || newsform.$invalid" type="button" class="btn btn-success" ng-click="openSavingModal();NewsService.saveCurrentNews();newsform.$setPristine()">
                ذخیره
            </button>
            <button ng-show="SecurityService.buttonsAccess.saveAndContinueButtonAccess()" ng-disabled="!NewsService.isEditing() || newsform.$invalid" type="button" class="btn btn-success" ng-click="openSavingModal();NewsService.saveCurrentNews(true);newsform.$setPristine()">
                ذخیره و ادامه
            </button>
            <script type="text/ng-template" id="savingModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">ذخیره</h3>
                </div>
                <div class="modal-body">
                    <span ng-show="!NewsService.saved">
                        در حال ذخیره سازی...
                    </span>
                    <span ng-show="NewsService.saved && NewsService.savingMessageIsArray">
                        <p ng-repeat="msg in NewsService.savingMessages" ng-bind="msg">

                        </p>

                    </span>
                    <p ng-show="NewsService.saved && !NewsService.savingMessageIsArray" ng-bind="NewsService.savingMessages">
                    </p>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn" ng-disabled="!NewsService.saved" data-ng-click="close()">
                        بستن
                    </button>
                </div>
            </script>
            <button ng-disabled="!NewsService.isEditing()" type="button" class="btn btn-warning" ng-click="openCancelModal('lg',newsform)">
                انصراف
            </button>
            <script type="text/ng-template" id="cancelModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">انصراف</h3>
                </div>
                <div class="modal-body">
                    آیا از انصراف ویرایش خبر جاری اطمینان دارید؟
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" ng-click="cancel()">بله</button>
                    <button class="btn btn-warning" ng-click="close()">خیر</button>
                </div>
            </script>





        </div>
        <div class="col-md-3">
            <button type="button" ng-disabled="!NewsService.currentNews.id || NewsService.isEditing() || !NewsService.previousable()" class="btn btn-primary" ng-click="NewsService.previousSelectedNews()">
                قبلی
            </button>


            <button type="button" ng-disabled="!NewsService.currentNews.id || NewsService.isEditing() || !NewsService.nexable()" class="btn btn-primary" ng-click="NewsService.nextSelectedNews()">
                بعدی
            </button>

            <button ng-disabled="!NewsService.currentNews.news_number || !NewsService.isEditing() || !(SecurityService.buttonsAccess.activateButtonAccess() == true)" data-ng-click="NewsService.toggleActiveCurrentNews()" data-ng-show="NewsService.currentNews.news_number" class="btn active-inactive-btn" ng-class="{'is-active': NewsService.currentNews.active == true,'is-inactive': NewsService.currentNews.active == false }" >
                <i class="fa fa-check"></i>
                <i class="fa fa-times"></i>
                {{(NewsService.currentNews.active)?'فعال':'غیر فعال'}}
            </button>
            
            <button ng-disabled="!NewsService.currentNews.news_number || !NewsService.isEditing() || !(SecurityService.buttonsAccess.verifyButtonAccess() == true)" data-ng-click="NewsService.toggleVerifyCurrentNews()" data-ng-show="NewsService.currentNews.news_number" class="btn verify-notverify-btn" ng-class="{'is-verify': NewsService.currentNews.verify == true,'is-notverify': NewsService.currentNews.verify == false }" >
                <i class="fa fa-check"></i>
                <i class="fa fa-times"></i>
                {{(NewsService.currentNews.verify)? 'تایید شده':'تایید نشده'}}
            </button>
            
            
        </div>

        <div class="col-md-3 left" style="float: left"  >
            نام کاربری:
            {{ValuesService.username}}
            <button class="btn btn-warning logout-btn" data-ng-click="logout()">
                خروج
            </button>

        </div>
    </div>
<?php $view['slots']->stop() ?>


<?php $view['slots']->start('javascripts') ?>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular-tree-control.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/pdfmake.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/vfs_fonts.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-ui-grid/ui-grid.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-smart-table/dist/smart-table.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/angular-sanitize.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/xeditable.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ng-flow-standalone.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/libs/ckeditor/ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-modal/modal.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ui-bootstrap-tpls-0.11.2.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/bootstrap/src/timepicker/timepicker.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/dateparser.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/position.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/datepicker-tpls.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/persiandate.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/persian-datepicker-tpls.js') ?>"></script>


    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/checklist-model/checklist-model.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-media-player/dist/angular-media-player.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ngInfiniteScroll/build/ng-infinite-scroll.min.js') ?>"></script>
    
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-file-upload/angular-file-upload.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-google-maps/dist/angular-google-maps.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/lodash/dist/lodash.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-scroll/angular-scroll.min.js') ?>"></script>
    
<!--    <script src='//maps.googleapis.com/maps/api/js?sensor=false'></script>-->


    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-collection/angular-collection.js') ?>"></script>



    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Controllers/newsIndexCtrl.js') ?>"></script>
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/newsService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/newstreeService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/newsIndex.js') ?><!--"></script>-->

    
    <script>
    document.onkeydown = function (event) {
	
	if (!event) { /* This will happen in IE */
		event = window.event;
	}
		
	var keyCode = event.keyCode;
	
	if (keyCode == 8 &&
		((event.target || event.srcElement).tagName != "TEXTAREA") && 
		((event.target || event.srcElement).tagName != "INPUT")) { 
		
		if (navigator.userAgent.toLowerCase().indexOf("msie") == -1) {
			event.stopPropagation();
		} else {
			alert("prevented");
			event.returnValue = false;
		}
		
		return false;
	}
};	
    </script>
<?php $view['slots']->stop() ?>