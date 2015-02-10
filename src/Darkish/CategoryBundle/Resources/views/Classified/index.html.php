<?php $view->extend('::panel_layout.html.php') ?>



<?php $view['slots']->start('stylesheets') ?>
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control-attribute.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-ui-grid/ui-grid.min.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/xeditable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/classified-admin-page.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-modal/modal.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-hotkeys/build/hotkeys.min.css') ?>" type="text/css" rel="stylesheet" />

<?php $view['slots']->stop() ?>

<?php $view['slots']->start('pagetitle') ?>مدیریت نیازمندیها<?php $view['slots']->stop() ?>
<?php $view['slots']->start('ngapp') ?>ClassifiedApp<?php $view['slots']->stop() ?>

<?php $view['slots']->start('controller') ?>ClassifiedIndexCtrl<?php $view['slots']->stop() ?>

<?php $view['slots']->start('formname') ?>classifiedform<?php $view['slots']->stop() ?>

<?php $view['slots']->start('body') ?>

    <div class="container-fluid main-wrapper">
        <div class="row main">
            <div class="col col-xs-2 main-right main-cols">
                <div class="main-tree-block">
                    
                    <h3 class="block-title">
                        شاخه بندی نیازمندیها ها
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
                    <div class="classified-tree">
                        <treecontrol class="tree-classic"
                                     tree-model="tree()"
                                     options="treeOptions()"
                                     on-selection="TreeService.selectTree(node)"
                                     selected-node="TreeService.currentTreeNode">
                            {{node.title}}
                        </treecontrol>
                        <div data-ng-show="ClassifiedService.isEditing()" id="tree-selectable-inactivator"></div>
                    </div>
                </div>
                <div class="main-search-block">
                    <h3 class="block-title">
جستجو
                    </h3>
                    <div class="search-box">
                        <input tabindex="-1" id="search-by-title" type="radio" name="search-based-on" ng-model="ClassifiedService.classifiedSearchCriteria.searchBy" value="1" />
                        <label for="search-by-title">
                            عنوان
                        </label>
                        <input tabindex="-1" id="search-by-number" type="radio" name="search-based-on" ng-model="ClassifiedService.classifiedSearchCriteria.searchBy" value="2" />
                        <label for="search-by-number">
                            شماره
                        </label>
                        <input tabindex="-1" id="search-by-all" type="radio" name="search-based-on" ng-model="ClassifiedService.classifiedSearchCriteria.searchBy" value="3" />
                        <label for="search-by-all">
                            همه
                        </label>

                        <button tabindex="-1" class="btn" data-ng-click="ClassifiedService.classifiedSearchCriteria.cid = null; ClassifiedService.searchClassified()">
                            بیاب
                        </button>
                        <input type="text" class="keyword" ng-model="ClassifiedService.classifiedSearchCriteria.searchKeyword" tabindex="-1" />
                    </div>
                </div>
                <div class="sort-block">
                    <span>
                        ترتیب نمایش
                    </span>
                    <input tabindex="-1" id="sort-by-date-desc" type="radio" name="sort-based-on"
                           ng-model="ClassifiedService.classifiedSearchCriteria.sortBy" value="1" />
                    <label for="sort-by-date-desc">
                        تاریخ نزولی
                    </label>
                    <input tabindex="-1" id="sort-by-date-asc" type="radio" name="sort-based-on"
                           ng-model="ClassifiedService.classifiedSearchCriteria.sortBy" value="2" />
                    <label for="sort-by-date-asc">
تاریخ صعودی
                    </label>
                    <input tabindex="-1" id="sort-by-number-desc" type="radio" name="sort-based-on"
                           ng-model="ClassifiedService.classifiedSearchCriteria.sortBy" value="3" />
                    <label for="sort-by-number-desc">
شماره نزولی
                    </label>
                    <input tabindex="-1" id="sort-by-number-asc" type="radio" name="sort-based-on"
                           ng-model="ClassifiedService.classifiedSearchCriteria.sortBy" value="4" />
                    <label for="sort-by-number-asc">
شماره صعودی
                    </label>
                </div>
            </div>
            <div class="col col-xs-6 main-center main-cols">
                <div class="basic-info col col-xs-12">
                    

                    <div class="basic-info-left-col">
                        
                        <div class="classified-number-wrapper">
                          <span class="classified-number" dir="ltr">
                              O{{ClassifiedService.currentClassified.id}}
                          </span>
                          
                        </div>
                        
                    </div>
                    
                    
                    <div class="basic-info-right-col">
                        <div class="classified-title">
                            <div class="field-title classified-title-title">عنوان:</div>
                            <input type="text" ng-maxlength="70" name="classified-title" class="classified-title-input" ng-model="ClassifiedService.currentClassified.title" ng-disabled="!ClassifiedService.isEditing()" required>
                            
                        </div>

                        <div class="classified-subtitle">
                            <div class="field-title classified-title-title">زیر عنوان:</div>
                            <input  type="text" ng-maxlength="70" name="classified-subtitle" class="classified-subtitle-input" ng-model="ClassifiedService.currentClassified.sub_title" ng-disabled="!ClassifiedService.isEditing()" required>
                        </div>
                        
                        
                        
                        

                    </div>
                    
      
                </div>
                <div class="main-fields-row">





                    <div class="col main-fields-wrapper" id="main-fields-wrapper">
                        <div class="main-fields-first-section" >



                            <div class="main-fields-tree-list">
                                <div class="main-fields-tree-list-commands-wrapper">
                                    <div class="tree-list-add-remove-button-wrapper">
                                        <button type="button" ng-click="openTreeModal()" id="tree-list-add-button"  ng-disabled="!ClassifiedService.isEditing() || (ClassifiedService.currentClassified.treeList.length >= 5)">شاخه</button>                                        
                                        <button type="button" ng-click="ClassifiedService.removeFromTreeList(secondTreeSelected)" id="tree-list-remove-button" ng-disabled="!ClassifiedService.isEditing()">حذف</button>
                                    </div>


                                </div>
                                <select multiple id="tree-list-input" ng-model="secondTreeSelected" ng-disabled="!ClassifiedService.isEditing()"
                                            ng-options="(tree.parent_tree_title + '-->' + tree.title ) for tree in ClassifiedService.currentClassified.treeList.all()">
                                        

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
                                        <button ng-disabled="ClassifiedService.currentClassified.treeList.length >= 5" class="btn btn-info pull-left" data-ng-click="ClassifiedService.addToTreeList(TreeService.currentSecondTreeNode)">اضافه</button>
                                    </div>
                                </script>
                                
                            </div>
                            
                            <div class="main-fields-dates-competition row">
                                <div class="dates col col-xs-6">
                                    <div class="publish-date-box">
                                        <label id="publish-date-label" class="third-section-label " for="publish-date-picker">تاریخ انتشار</label>
                                        <input ng-click="openPublishDate($event)" type="text" id="publish-date-picker" class=" third-section-input"  datepicker-popup-persian="{{format}}" ng-model="ClassifiedService.currentClassified.publish_date" is-open="publishDateIsOpen"  datepicker-options="publishDateOptions" date-disabled="disabled(date, mode)" ng-disabled="!ClassifiedService.isEditing()" close-text="بستن" />
                                    </div>

                                    
                                    <div class="expire-date-box">
                                        <div class="continual-box">
                                            <label for="continual-checkbox" class="continual-label">
                                                دائمی
                                            </label>
                                            <input type="checkbox" id="continual-checkbox" ng-model="ClassifiedService.currentClassified.continual" ng-disabled="!ClassifiedService.isEditing()"  />
                                        </div>
                                        <label id="expire-date-label" class="third-section-label " for="expire-date-picker">پایان اعتبار</label>
                                        <input  ng-click="openExpireDate($event)" type="text" id="expire-date-picker" class=" third-section-input"  datepicker-popup-persian="{{format}}" ng-model="ClassifiedService.currentClassified.expire_date" is-open="expireDateIsOpen"  datepicker-options="expireDateOptions" date-disabled="disabled(date, mode)" ng-disabled="!ClassifiedService.isEditing() || ClassifiedService.currentClassified.continual" close-text="بستن" />
                                    </div>
                                </div>
                                
                                <div class="immediate-rank-box col col-xs-6">
                                    <div class="listrank-box">
                                        <label for="listrank-select" class="listrank-label">
                                            رتبه در لیست
                                        </label>
                                        <select id="listrank-select" ng-model="ClassifiedService.currentClassified.list_rank" ng-disabled="!ClassifiedService.isEditing()">
                                            <option ng-repeat="treeRank in ValuesService.treeRanks" value="{{treeRank.id}}" > {{treeRank.name}} </option>
                                        </select>
                                    </select>
                                    </div>
                                    
                                </div>

                                
                            </div>
                            
                            
                            
                            <div class="classified-submiter-box">
                                <input type="text" ng-disabled="!ClassifiedService.isEditing()" id="classified-submitter-input" ng-model="ClassifiedService.currentClassified.submitter" />
                                <label for="classified-submitter-input">
                                    شماره رکورد آگهی کننده
                                </label>
                                
                            </div>
                            
                            
                            
                            

                        </div>
                        <div class="main-fields-forth-section">
                            <span> آدرس و تلفن</span>
                            <label for="address">آدرس</label>
                            <div class="form-item-wrapper address">
                                <textarea ng-maxlength="255" id="address" ng-model="ClassifiedService.currentClassified.address" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid ng-valid-maxlength" disabled="disabled">                                    
                                </textarea>
                            </div>

                            <label for="phone-one">تلفن</label>
                            <div class="form-item-wrapper phone">
                                <input type="number" ng-maxlength="11" id="phone-one" ng-model="ClassifiedService.currentClassified.tel_number_one" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                                <input type="number" ng-maxlength="11" id="phone-two" ng-model="ClassifiedService.currentClassified.tel_number_two" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                                <input type="number" ng-maxlength="11" id="phone-three" ng-model="ClassifiedService.currentClassified.tel_number_three" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                                <input type="number" ng-maxlength="11" id="phone-four" ng-model="ClassifiedService.currentClassified.tel_number_four" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                            </div>

                            <label for="fax-one">فکس</label>
                            <div class="form-item-wrapper fax">
                                <input type="number" ng-maxlength="11" id="fax-one" ng-model="ClassifiedService.currentClassified.fax_number_one" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                                <input type="number" ng-maxlength="11" id="fax-two" ng-model="ClassifiedService.currentClassified.fax_number_two" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                            </div>

                            <label for="mobile-one">همراه</label>
                            <div class="form-item-wrapper mobile">
                                <input type="number" ng-maxlength="11" id="mobile-one" ng-model="ClassifiedService.currentClassified.mobile_number_one" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                                <input type="number" ng-maxlength="11" id="mobile-two" ng-model="ClassifiedService.currentClassified.mobile_number_two" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                            </div>

                            <label for="email">ایمیل</label>
                            <div class="form-item-wrapper email">
                                <input type="text" id="email" ng-model="ClassifiedService.currentClassified.email" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid" disabled="disabled">
                            </div>

                            <label for="website">سایت</label>
                            <div class="form-item-wrapper website">
                                <input type="text" id="website" ng-model="ClassifiedService.currentClassified.website" ng-disabled="!ClassifiedService.isEditing()" class="ng-pristine ng-valid" disabled="disabled">
                            </div>

                            


                        </div>

                    </div>
                    
                </div>
                
            </div>

            <div class="col col-xs-4 main-left main-cols">
                <div class="row file-upload-row">
                    <div class="col col-xs-6 message-box">
                        <span class="uploader-msg" ng-bind="uploader.msg">
                            
                        </span>
                    </div>
                    <div class="col col-xs-4">
                        <div class="progress" style="">
                            <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                        </div>
                    </div>
                    <div class="col col-xs-2 upload-cancel">
                        <button ng-show="uploader.isUploading" ng-disabled="!ClassifiedService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
                            X
                        </button>
                    </div>
                    
                    
                </div>
                <div class="row attachements-wrapper">
                    <div class="col-xs-2 right">
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
                    <div class="col-xs-8 center">
                        <div class="tab-content">
                            <div ng-switch="ValuesService.activeTab">
                                <div ng-switch-when="image" class="image">
                                    <ul class="image-list">
                                        <li ng-repeat="image in ClassifiedService.currentClassified.images" style="float: right"  ng-class="{'selected' : ClassifiedService.selectedImage.id == image.id}">
                                            <img ng-click="ClassifiedService.selectedImage = image ;openImageModal('lg',image, $index)" ng-src="{{image.absolute_path}}"  />
                                            <input
                                                type="checkbox"
                                                checklist-model="ClassifiedService.selectedImages"
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
                                    
                                    <img ng-show="ClassifiedService.currentClassified.icon.id" ng-click="openIconModal('lg',icon)" ng-src="{{ClassifiedService.currentClassified.icon.absolute_path}}"  />
                                    <input
                                        ng-show="ClassifiedService.currentClassified.icon.id"
                                        type="checkbox"
                                        checklist-model="ClassifiedService.selectedIcon"
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
                                        <li ng-repeat="video in ClassifiedService.currentClassified.videos" style="float: right"  ng-class="{'selected' : ClassifiedService.selectedVideo.id == video.id}">
                                            <input
                                                type="checkbox"
                                                checklist-model="ClassifiedService.selectedVideos"
                                                checklist-value="video"
                                                />
                                            <span ng-bind="video.file_name" ng-click="ClassifiedService.selectedVideo =video; openVideoModal('lg',video, $index)"></span>
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
                                        <li ng-repeat="audio in ClassifiedService.currentClassified.audios" style="float: right" ng-class="{'selected' : ClassifiedService.selectedAudio.id == audio.id}">
                                            <input
                                                type="checkbox"
                                                checklist-model="ClassifiedService.selectedAudios"
                                                checklist-value="audio"
                                            />
                                            <span ng-bind="audio.file_name" ng-click="ClassifiedService.selectedAudio = audio" >  </span>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2 left">
<!--                        <button class="btn btn-info add-attachment" ng-disabled="!ClassifiedService.isEditing()" data-ng-click="showUploadModal()">
                            اضافه
                        </button>-->
                        
                        
                        <label class="file-select" ng-class="{'disabled': !ClassifiedService.isEditing()}">
                            انتخاب فایل
                            <input ng-disabled="!ClassifiedService.isEditing()  || !SecurityService.connected" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
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

                                                <div class="col-xs-12">

                                                    <input type="file" nv-file-select="" uploader="uploader" multiple="true"  /><br/>

                                                </div>

                                                <div class="col-xs-12" style="margin-bottom: 40px">
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
                        <button class="btn btn-danger remove-attachment" ng-disabled="!ClassifiedService.isEditing()"
                                data-ng-click="ClassifiedService.removeFromAttachList()">
                            حذف
                        </button>
                        <button class="btn btn-info btn-continual-modal" ng-disabled="!ClassifiedService.isEditing()"
                                data-ng-click="openContinualModal()">
                            تنظیمات
                        </button>
                        <script type="text/ng-template" id="continualModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">تنظیمات فایل ها</h3>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col col-xs-7 center" style="text-align: center;
                                                                            border-bottom: 1px solid rgb(110, 181, 95);
                                                                            padding-bottom: 5px;">
                                        نیازمندیها
                                    </div>
                                    <div class="col col-xs-5 center" style="text-align: center;
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
                                                <td style="width: 50%; overflow-wrap: break-word;">{{ClassifiedService.currentClassified.icon.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{ClassifiedService.currentClassified.icon.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="ClassifiedService.currentClassified.icon.continual" />
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
                    <div class="col-xs-12">
                        <textarea ng-model="ClassifiedService.currentClassified.body" ng-disabled="!ClassifiedService.isEditing()" ></textarea>
                        <div ng-hide="true" class="html-preview" ng-bind-html="trustedBody()">

                        </div>
                        <button  
                            data-ng-show="false"
                                 id="body-modal-button" class="btn btn-info" data-ng-click="openBodyModal('lg')">
                            ویرایش صفحه
                        </button>
                        <button ng-hide="true" id="body-preview-modal-button" class="btn btn-info" ng-click="openBodyPreviewModal()">
                            پیش نمایش صفحه
                        </button>
                        <script type="text/ng-template" id="bodyPreviewModal.html">
                            <div class="modal-body">
                                <i ng-click="close()" class="fa fa-close"></i>
                                <button ng-click="goToTop()" class="go-to-top" ng-click="">
                                بالای صفحه<i class="fa fa-arrow-up"></i>
                                </button>
                                <button ng-disabled="!hasBack()" ng-click="back()" class="return" ng-click="">
                                بازگشت<i class="fa fa-arrow-left"></i>
                                </button>
                                <span class="rt-title" ng-disabled="true" ng-bind-html="rtTitle"> </span>
                                <div class="body-preview-box">
                                    <div ng-show="innerLink" class="body-preview-content" ng-bind-html="trustedBody">
                                    </div>
                                    <div ng-show="externalLink" class="body-preview-content external-link">
                                        <iframe ng-src="{{trustedUrl}}" width="362" height="588" />
                                    </div>
                                </div>
                            </div>
                            
                        </script>
                        <script type="text/ng-template" id="bodyModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">بدنه نیازمندیها</h3>
                                <button class=" close-button btn btn-primary pull-right" ng-click="close()">بستن</button>
                                <button ng-disabled="!ClassifiedService.isEditing() || classifiedform.$invalid" type="button" class="save-continue-button btn btn-success" ng-click="checkConnectionSave(true);classifiedform.$setPristine()">
                                    ذخیره و ادامه
                                </button>
                                <span class="body-save-continue-message" ng-show="ClassifiedService.saved">
                                    <ul>
                                        <li ng-repeat="msg in ClassifiedService.savingMessages" ng-bind="msg">
                                        </li>
                                    </ul>
                                </span>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xs-4 body-modal-right">
                                        <div class="body-attachments">
                                            <div class="body-attachments-inner">

                                                <tabset ng-init="selectTab('image')">
                                                    <tab select="selectTab('image')" heading="عکس">
                                                        <div class="image">
                                                            <ul class="image-list files-list">
                                                                <li class = "file" ng-repeat="image in ClassifiedService.currentClassified.body_images" style="float: right" ng-click="ClassifiedService.selectBodyImage(image)" ng-class="{'selected' : ClassifiedService.selectedBodyImage.id == image.id}">
                                                                    <img ng-src="{{image.absolute_path}}"  ng-click="ClassifiedService.selectedBodyImage = image ;showImageShowModal(image)" />
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="ClassifiedService.selectedBodyImages"
                                                                        checklist-value="image"
                                                                        />
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('video')" heading="فیلم">
                                                        <div class="video">
                                                            <ul class="video-list files-list">
                                                                <li class = "file" ng-repeat="video in ClassifiedService.currentClassified.body_videos" style="float: right" ng-click="ClassifiedService.selectBodyVideo(video)" ng-class="{'selected' : ClassifiedService.selectedBodyVideo.id == video.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="ClassifiedService.selectedBodyVideos"
                                                                        checklist-value="video"
                                                                    />
                                                                    <span ng-click="ClassifiedService.selectedBodyVideo =video" ng-bind="video.file_name"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('audio')" heading="صدا">
                                                        <div class="audio">
                                                            <ul class="audio-list files-list">
                                                                <li class = "file" ng-repeat="audio in ClassifiedService.currentClassified.body_audios" style="float: right" ng-click="ClassifiedService.selectBodyAudio(audio)" ng-class="{'selected' : ClassifiedService.selectedBodyAudio.id == audio.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="ClassifiedService.selectedBodyAudios"
                                                                        checklist-value="audio"
                                                                    />
                                                                    <span ng-click="ClassifiedService.selectedBodyAudio =audio" ng-bind="audio.file_name" ></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('doc')" heading="دیگر">
                                                        <div class="doc">
                                                            <ul class="doc-list files-list">
                                                                <li class = "file" ng-repeat="doc in ClassifiedService.currentClassified.body_docs" style="float: right" ng-click="ClassifiedService.selectBodyAudio(doc)" ng-class="{'selected' : ClassifiedService.selectedBodyDoc.id == doc.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="ClassifiedService.selectedBodyDocs"
                                                                        checklist-value="doc"
                                                                    />
                                                                    <span ng-click="ClassifiedService.selectedBodyDoc =doc" ng-bind="doc.file_name" ></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                </tabset>





                                                <div class="container body-modal-container">



                                                    <div class="row">

                                                        <div class="col-xs-12" >

                                                            <div class="row file-upload-row">
                                                                <div class="col col-xs-8">
                                                                    <div class="progress" style="">
                                                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="col col-xs-4">
                                                                    <button ng-show="uploader.isUploading" ng-disabled="!ClassifiedService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
                                                                        انصراف
                                                                    </button>
                                                                </div>


                                                            </div>




                                                        </div>
                                                        <div class="col col-xs-12 message-box">
                                                            <span class="uploader-msg" ng-bind="uploader.msg">

                                                            </span>
                                                        </div>
                                                        <div class="col-xs-12 body-upload-buttons" >
                                                            <label class="file-select" ng-class="{'disabled': !ClassifiedService.isEditing()}">
                                                                انتخاب فایل
                                                                <input ng-disabled="!ClassifiedService.isEditing() || !SecurityService.connected" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
                                                            </label>
                                                            <button class="btn btn-info" data-ng-click="CkeditorInsert()" ng-disabled="!ClassifiedService.isReadyToInsert()">
                                                                درج
                                                            </button>
                                                            <button class="btn btn-danger" data-ng-click="ClassifiedService.removeFromBodyAttachList()">
                                                                حذف
                                                            </button>
                                                            <button ng-disabled="!ClassifiedService.isEditing() || classifiedform.$invalid" type="button" class="save-continue-button-bottom btn btn-success" ng-click="checkConnectionSave(true);classifiedform.$setPristine()">
                                                                ذخیره و ادامه
                                                            </button>
                                                            <span class="body-save-continue-message-bottom" ng-show="ClassifiedService.saved">
                                                                <ul>
                                                                    <li ng-repeat="msg in ClassifiedService.savingMessages" ng-bind="msg">
                                                                    </li>
                                                                </ul>
                                                            </span>
                                                            <button class="btn insert-tree-button" ng-click="openBodyTreeModal()" >درج شاخه</button>
                                                            <button class="btn insert-classified-button" ng-click="openBodyClassifiedModal()" >درج نیازمندیها</button>
                                                            <button class="btn insert-classified-button" ng-click="openInsertLinkModal()" >درج لینک</button>
                                                        </div>

                                                        

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-8">
                                        <div class="body-editor">
                                            <textarea ckeditor="bodyEditorOptions" ng-model="ClassifiedService.currentClassified.body"></textarea>

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
                        <script type="text/ng-template" id="bodyClassifiedModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">درج نیازمندیها</h3>
                            </div>
                            <div class="modal-body">
                                <label class="classified-insert-text-label" for="classified-insert-text">متن</label>
                                <input id="classified-insert-text" type="text" ng-model="text" />
                                
                                <label class="classified-insert-id-label" for="classified-insert-id">شماره نیازمندیها</label>
                                <input id="classified-insert-id" type="text" ng-model="classifiedId" />
                                
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" ng-click="close()">بستن</button>
                                <button class="btn btn-info pull-left" data-ng-click="insertClassified()">اضافه</button>
                            </div>
                        </script>
                        <script type="text/ng-template" id="insertLinkModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">درج لینک</h3>
                            </div>
                            <div class="modal-body">
                                <label class="link-insert-text-label" for="classified-insert-text">متن</label>
                                <input id="link-insert-text" type="text" ng-model="text" />
                                
                                <label class="link-insert-link-label" for="classified-insert-id">لینک</label>
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
                                            <div class="col-xs-4 body-modal-right">
                                                <div class="body-attachments">
                                                    <div class="body-attachments-inner">
                                                        
                                                        <tabset ng-init="selectTab('image')">
                                                            <tab select="selectTab('image')" heading="عکس">
                                                                <div class="image">
                                                                    <ul class="image-list files-list">
                                                                        <li class = "file" ng-repeat="image in ClassifiedService.currentClassified.body_images" style="float: right" ng-click="ClassifiedService.selectBodyImage(image)" ng-class="{'selected' : ClassifiedService.selectedBodyImage.id == image.id}">
                                                                            <img ng-src="{{image.absolute_path}}"  ng-click="ClassifiedService.selectedBodyImage = image ;showImageShowModal(image)" />
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="ClassifiedService.selectedBodyImages"
                                                                                checklist-value="image"
                                                                                />
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                            <tab select="selectTab('video')" heading="فیلم">
                                                                <div class="video">
                                                                    <ul class="video-list files-list">
                                                                        <li class = "file" ng-repeat="video in ClassifiedService.currentClassified.body_videos" style="float: right" ng-click="ClassifiedService.selectBodyVideo(video)" ng-class="{'selected' : ClassifiedService.selectedBodyVideo.id == video.id}">
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="ClassifiedService.selectedBodyVideos"
                                                                                checklist-value="video"
                                                                            />
                                                                            <span ng-click="ClassifiedService.selectedBodyVideo =video" ng-bind="video.file_name"></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                            <tab select="selectTab('audio')" heading="صدا">
                                                                <div class="audio">
                                                                    <ul class="audio-list files-list">
                                                                        <li class = "file" ng-repeat="audio in ClassifiedService.currentClassified.body_audios" style="float: right" ng-click="ClassifiedService.selectBodyAudio(audio)" ng-class="{'selected' : ClassifiedService.selectedBodyAudio.id == audio.id}">
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="ClassifiedService.selectedBodyAudios"
                                                                                checklist-value="audio"
                                                                            />
                                                                            <span ng-click="ClassifiedService.selectedBodyAudio =audio" ng-bind="audio.file_name" ></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                        </tabset>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <div class="container body-modal-container">



                                                            <div class="row">

                                                                <div class="col-xs-12">
                                                                    <button class="btn btn-danger" data-ng-click="ClassifiedService.removeFromBodyAttachList()">
                                                                        حذف
                                                                    </button>
                                                                    <button class="btn btn-info" data-ng-click="CkeditorInsert()" ng-disabled="!ClassifiedService.isReadyToInsert()">
                                                                        درج
                                                                    </button>
                                                                    <label class="file-select" ng-class="{'disabled': !ClassifiedService.isEditing()}">
                                                                        انتخاب فایل
                                                                        <input ng-disabled="!ClassifiedService.isEditing()" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
                                                                    </label>

                                                                </div>

                                                                <div class="col-xs-12">
                                                                    
                                                                            <div class="row file-upload-row">
                                                                                <div class="col col-xs-4">
                                                                                    <div class="progress" style="">
                                                                                        <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col col-xs-2">
                                                                                    <button ng-disabled="!ClassifiedService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
                                                                                        انصراف
                                                                                    </button>
                                                                                </div>
                                                                                <div class="col col-xs-6 message-box">
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
                                            <div class="col-xs-8">
                                                <div class="body-editor">
                                                    <textarea ckeditor="bodyEditorOptions" ng-model="ClassifiedService.currentClassified.body"></textarea>

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
                    <table st-table="classifiedList()" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>عنوان فرعی</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr st-select-row="row" ng-class="{selected: ClassifiedService.isSelected(row)}" data-ng-click="ClassifiedService.selectClassified(row)" st-select-mode="single" ng-repeat="row in classifiedList()">
                            <td>{{row.id}}</td>
                            <td>{{row.title}}</td>
                            <td>{{row.sub_title}}</td>
                        </tr>
                        </tbody>
                    </table>



                </div>
                <div id="classified-list-inactivator" data-ng-show="ClassifiedService.isEditing()" >

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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">نیازمندیها<span class="caret"></span></a>
            <?php print $view['knp_menu']->render('main') ?>
        </li>
    </ul>
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('top-actions');?>
    <div  class="classified-top show-grid ">

        <div class="col-xs-5">
            <button ng-show="SecurityService.buttonsAccess.newButtonAccess()" ng-disabled="ClassifiedService.isEditing()" type="button" class="btn btn-primary" ng-click="ClassifiedService.editingNew()">
                جدید
            </button>

            <button ng-show="SecurityService.buttonsAccess.editButtonAccess()" ng-disabled="ClassifiedService.isNew() || ClassifiedService.isEditing() || !SecurityService.connected" type="button" class="btn btn-info" ng-click="ClassifiedService.editing()">
                ویرایش
            </button>
            <script type="text/ng-template" id="deleteModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">حذف نیازمندیها</h3>
                </div>
                <div class="modal-body">
                    آیا از حذف نیازمندیها جاری اطمینان دارید؟
                            
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" data-ng-click="close()">
                        خیر (انصراف)
                    </button>
                    <button class="btn btn-danger" data-ng-click="deleteCurrentClassified()">
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
            <button ng-show="SecurityService.buttonsAccess.deleteButtonAccess()" ng-disabled="!ClassifiedService.currentClassified.id || ClassifiedService.isEditing() || !SecurityService.connected"  type="button" class="btn btn-danger" ng-click="openDeleteModal()">
                حذف
            </button>
            <button ng-show="SecurityService.buttonsAccess.saveButtonAccess()" ng-disabled="!ClassifiedService.isEditing() || classifiedform.$invalid" type="button" class="btn btn-success" ng-click="checkConnectionSave()">
                ذخیره
            </button>
            <button ng-show="SecurityService.buttonsAccess.saveAndContinueButtonAccess()" ng-disabled="!ClassifiedService.isEditing() || classifiedform.$invalid" type="button" class="btn btn-success" ng-click="checkConnectionSave(true)">
                ذخیره و ادامه
            </button>
            <script type="text/ng-template" id="savingModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">ذخیره</h3>
                </div>
                <div class="modal-body">
                    <span ng-show="!ClassifiedService.saved">
                        در حال ذخیره سازی...
                    </span>
                    <span ng-show="ClassifiedService.saved && ClassifiedService.savingMessageIsArray">
                        <p ng-repeat="msg in ClassifiedService.savingMessages" ng-bind="msg">

                        </p>

                    </span>
                    <p ng-show="ClassifiedService.saved && !ClassifiedService.savingMessageIsArray" ng-bind="ClassifiedService.savingMessages">
                    </p>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn" ng-disabled="!ClassifiedService.saved" data-ng-click="close()">
                        بستن
                    </button>
                </div>
            </script>
            <script type="text/ng-template" id="disconnectModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">قطع اتصال</h3>
                </div>
                <div class="modal-body">
                    <span>
                            كاربر گرامي، ارتباط شما با سرور قطع شده است. پس از برقراري ارتباط، دوباره سعي كنيد.
                    </span>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn" data-ng-click="close()">
                        بستن
                    </button>
                </div>
            </script>
            <button ng-disabled="!ClassifiedService.isEditing()" type="button" class="btn btn-warning" ng-click="openCancelModal('lg',classifiedform)">
                انصراف
            </button>
            <script type="text/ng-template" id="cancelModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">انصراف</h3>
                </div>
                <div class="modal-body">
                    آیا از انصراف ویرایش نیازمندیها جاری اطمینان دارید؟
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" ng-click="cancel()">بله</button>
                    <button class="btn btn-warning" ng-click="close()">خیر</button>
                </div>
            </script>





        </div>
        <div class="col-xs-4">
            <button type="button" ng-disabled="!ClassifiedService.currentClassified.id || ClassifiedService.isEditing() || !ClassifiedService.previousable()" class="btn btn-primary" ng-click="ClassifiedService.previousSelectedClassified()">
                قبلی
            </button>


            <button type="button" ng-disabled="!ClassifiedService.currentClassified.id || ClassifiedService.isEditing() || !ClassifiedService.nexable()" class="btn btn-primary" ng-click="ClassifiedService.nextSelectedClassified()">
                بعدی
            </button>

            <button ng-disabled="!ClassifiedService.isEditing() || !(SecurityService.buttonsAccess.activateButtonAccess() == true) || !SecurityService.connected" data-ng-click="ClassifiedService.toggleActiveCurrentClassified()"  class="btn active-inactive-btn" ng-class="{'is-active': ClassifiedService.currentClassified.active == true,'is-inactive': ClassifiedService.currentClassified.active == false }" >
                <i class="fa fa-check"></i>
                <i class="fa fa-times"></i>
                {{(ClassifiedService.currentClassified.active)?'فعال':'غیر فعال'}}
            </button>
            
            <button ng-disabled="!ClassifiedService.isEditing() || !(SecurityService.buttonsAccess.verifyButtonAccess() == true) || !SecurityService.connected" data-ng-click="ClassifiedService.toggleVerifyCurrentClassified()"  class="btn verify-notverify-btn" ng-class="{'is-verify': ClassifiedService.currentClassified.verify == true,'is-notverify': ClassifiedService.currentClassified.verify == false }" >
                <i class="fa fa-check"></i>
                <i class="fa fa-times"></i>
                {{(ClassifiedService.currentClassified.verify)? 'تایید شده':'تایید نشده'}}
            </button>
            
            
        </div>

        <div class="col-xs-3 left user-box" ng-class="{'logged-in': (SecurityService.loggedIn  && SecurityService.connected), 'logged-out': (!SecurityService.loggedIn  && !SecurityService.connected)}" style="float: left"  >
            <label class="username-label">
            نام کاربری:
            </label>
            <i class="fa fa-power-off"></i>
            <span class="username-value">
            {{ValuesService.username}}
            </span>
            <button ng-show="SecurityService.loggedIn && SecurityService.connected" class="btn btn-warning logout-btn" data-ng-click="logout()">
                خروج
            </button>
            <button ng-hide="SecurityService.loggedIn  || !SecurityService.connected" class="btn btn-warning logout-btn" data-ng-click="openLoginModal()">
                ورود مجدد
            </button>
            <script type="text/ng-template" id="loginModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">ورود مجدد</h3>
                </div>
                <div class="modal-body">
                    <label class="username" for="login-username" >نام کاربری</label>
                    <input id="login-username" type="text" ng-model="username">
                    <label class="password" for="login-password" >رمز عبور</label>
                    <input id="login-password" type="text" ng-model="password">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" ng-click="login()">ورود</button>
                    <button class="btn btn-warning" ng-click="close()">بستن</button>
                </div>
            </script>

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



    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Controllers/classifiedIndexCtrl.js') ?>"></script>
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/classifiedService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/classifiedtreeService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/classifiedIndex.js') ?><!--"></script>-->

    
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
CKEDITOR.on('instanceReady', function(evt){
    setTimeout( function(){
        evt.editor.resetUndo();
    }, 500 );

});
    </script>
<?php $view['slots']->stop() ?>