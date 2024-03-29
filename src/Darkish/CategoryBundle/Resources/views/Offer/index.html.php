<?php $view->extend('::panel_layout.html.php') ?>



<?php $view['slots']->start('stylesheets') ?>
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control-attribute.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-ui-grid/ui-grid.min.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/xeditable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/offer-admin-page.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-modal/modal.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-hotkeys/build/hotkeys.min.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angucomplete-alt/angucomplete-alt.css') ?>" type="text/css" rel="stylesheet" />
    <link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular-themes-default/videogular.min.css') ?>" type="text/css" rel="stylesheet" />
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('pagetitle') ?>مدیریت پیشنهاد ویژه<?php $view['slots']->stop() ?>
<?php $view['slots']->start('ngapp') ?>OfferApp<?php $view['slots']->stop() ?>

<?php $view['slots']->start('controller') ?>OfferIndexCtrl<?php $view['slots']->stop() ?>

<?php $view['slots']->start('formname') ?>offerform<?php $view['slots']->stop() ?>

<?php $view['slots']->start('body') ?>

    <div class="container-fluid main-wrapper">
        <div class="row main">
            <div class="col col-xs-2 main-right main-cols">
                <div class="main-tree-block">
                    
                    <h3 class="block-title">
                        شاخه بندی پیشنهاد ویژه ها
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
                    <div class="offer-tree">
                        <treecontrol class="tree-classic"
                                     tree-model="tree()"
                                     options="treeOptions()"
                                     on-selection="TreeService.selectTree(node)"
                                     selected-node="TreeService.currentTreeNode">
                            {{node.title}}
                        </treecontrol>
                        <div data-ng-show="OfferService.isEditing()" id="tree-selectable-inactivator"></div>
                    </div>
                </div>
                <div class="main-search-block">
                    <h3 class="block-title">
جستجو
                    </h3>
                    <div class="search-box">
                        <input tabindex="-1" id="search-by-title" type="radio" name="search-based-on" ng-model="OfferService.offerSearchCriteria.searchBy" value="1" />
                        <label for="search-by-title">
                            عنوان
                        </label>
                        <input tabindex="-1" id="search-by-number" type="radio" name="search-based-on" ng-model="OfferService.offerSearchCriteria.searchBy" value="2" />
                        <label for="search-by-number">
                            شماره
                        </label>
                        <input tabindex="-1" id="search-by-all" type="radio" name="search-based-on" ng-model="OfferService.offerSearchCriteria.searchBy" value="3" />
                        <label for="search-by-all">
                            همه
                        </label>

                        <button tabindex="-1" class="btn" data-ng-click="OfferService.offerSearchCriteria.cid = null; OfferService.searchOffer()">
                            بیاب
                        </button>
                        <input type="text" class="keyword" ng-model="OfferService.offerSearchCriteria.searchKeyword" tabindex="-1" />
                    </div>
                </div>
                <div class="sort-block">
                    <span>
                        ترتیب نمایش
                    </span>
                    <input tabindex="-1" id="sort-by-date-desc" type="radio" name="sort-based-on"
                           ng-model="OfferService.offerSearchCriteria.sortBy" value="1" />
                    <label for="sort-by-date-desc">
                        تاریخ نزولی
                    </label>
                    <input tabindex="-1" id="sort-by-date-asc" type="radio" name="sort-based-on"
                           ng-model="OfferService.offerSearchCriteria.sortBy" value="2" />
                    <label for="sort-by-date-asc">
تاریخ صعودی
                    </label>
                    <input tabindex="-1" id="sort-by-number-desc" type="radio" name="sort-based-on"
                           ng-model="OfferService.offerSearchCriteria.sortBy" value="3" />
                    <label for="sort-by-number-desc">
شماره نزولی
                    </label>
                    <input tabindex="-1" id="sort-by-number-asc" type="radio" name="sort-based-on"
                           ng-model="OfferService.offerSearchCriteria.sortBy" value="4" />
                    <label for="sort-by-number-asc">
شماره صعودی
                    </label>
                </div>
            </div>
            <div class="col col-xs-6 main-center main-cols">
                <div class="basic-info col col-xs-12">
                    

                    <div class="basic-info-left-col">
                        
                        <div class="offer-number-wrapper">
                          <span class="offer-number" dir="ltr">
                              O{{OfferService.currentOffer.id}}
                          </span>
                          
                        </div>
                        
                    </div>
                    
                    
                    <div class="basic-info-right-col">
                        <div class="offer-title">
                            <div class="field-title offer-title-title">عنوان:</div>
                            <input type="text" ng-maxlength="70" name="offer-title" class="offer-title-input" ng-model="OfferService.currentOffer.title" ng-disabled="!OfferService.isEditing()" required>
                            
                        </div>

                        <div class="offer-subtitle">
                            <div class="field-title offer-title-title">زیر عنوان:</div>
                            <input  type="text" ng-maxlength="70" name="offer-subtitle" class="offer-subtitle-input" ng-model="OfferService.currentOffer.sub_title" ng-disabled="!OfferService.isEditing()">
                        </div>
                        
                        
                        
                        

                    </div>
                    
      
                </div>
                <div class="main-fields-row">





                    <div class="col main-fields-wrapper" id="main-fields-wrapper">
                        <div class="main-fields-first-section" >



                            <div class="main-fields-tree-list">
                                <div class="main-fields-tree-list-commands-wrapper">
                                    <div class="tree-list-add-remove-button-wrapper">
                                        <button type="button" ng-click="openTreeModal()" id="tree-list-add-button"  ng-disabled="!OfferService.isEditing() || (OfferService.currentOffer.treeList.length >= 5)">شاخه</button>                                        
                                        <button type="button" ng-click="OfferService.removeFromTreeList(secondTreeSelected)" id="tree-list-remove-button" ng-disabled="!OfferService.isEditing()">حذف</button>
                                    </div>


                                </div>
                                <div class="tree-ranks">
                                    <select class="ranklist-combo" ng-repeat="tree in OfferService.currentOffer.treeList.array" ng-model="tree.sort" ng-disabled="!OfferService.isEditing()">
                                        <option ng-repeat="treeRank in ValuesService.treeRanks" value="{{treeRank.id}}" ng-selected="treeRank.id == tree.sort" > {{treeRank.name}}</option>
                                    </select>
                                </div>
                                <select multiple id="tree-list-input" ng-model="secondTreeSelected" ng-disabled="!OfferService.isEditing()"
                                            ng-options="(tree.tree.parent_tree_title + '-->' + tree.tree.title  + '(' + tree.sort + ')') for tree in OfferService.currentOffer.treeList.all()">
                                        

                                </select>
                                
                                <script type="text/ng-template" id="treeModal.html">
                                    <div class="modal-header">
                                        <h3 class="modal-title">انتخاب شاخه ها<span ng-show="message">({{message}})</span></h3>
                                    </div>
                                    <div class="modal-body">
                                        <treecontrol class="tree-classic"
                                                    tree-model="tree()"
                                                    options="tOptions"
                                                    selected-node="TreeService.currentSecondTreeNode">
                                           {{node.title}}
                                        </treecontrol>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-warning" ng-click="close()">بستن</button>
                                        <button ng-disabled="OfferService.currentOffer.treeList.length >= 1" class="btn btn-info pull-left" data-ng-click="message = OfferService.addToTreeList(TreeService.currentSecondTreeNode)">اضافه</button>
                                    </div>
                                </script>
                                
                            </div>
                            
                            <div class="main-fields-dates-competition row">
                                <div class="dates col col-xs-6">
                                    <div class="publish-date-box">
                                        <label id="publish-date-label" class="third-section-label " for="publish-date-picker">تاریخ انتشار</label>
                                        <input ng-click="openPublishDate($event)" type="text" id="publish-date-picker" class=" third-section-input"  datepicker-popup-persian="{{format}}" ng-model="OfferService.currentOffer.publish_date" is-open="publishDateIsOpen"  datepicker-options="publishDateOptions" date-disabled="disabled(date, mode)" ng-disabled="!OfferService.isEditing()" close-text="بستن" required />
                                    </div>
                                </div>
                                <div class="dates col col-xs-6">
                                    <div class="expire-date-box">
                                        <label id="expire-date-label" class="third-section-label " for="expire-date-picker">پایان اعتبار</label>
                                        <input required ng-click="openExpireDate($event)" type="text" id="expire-date-picker" class=" third-section-input"  datepicker-popup-persian="{{format}}" ng-model="OfferService.currentOffer.expire_date" is-open="expireDateIsOpen"  datepicker-options="expireDateOptions" date-disabled="disabled(date, mode)" ng-disabled="!OfferService.isEditing()" close-text="بستن" />
                                    </div>
                                </div>

                                
                            </div>
                            
                            <div class="banner-box">
                                <div class="banner-head">
                                    <span class="banner-title">
تابلوی اپ
                                    </span>
                                    <button ng-click="OfferService.removeBanner()" ng-disabled="!OfferService.isEditing()" class="banner-delete btn-danger btn">
                                        حذف
                                    </button>
                                    <label class="banner-file-select btn btn-info" ng-class="{'disabled': !OfferService.isEditing()}">
                                        انتخاب فایل
                                        <input ng-disabled="!OfferService.isEditing()  || !SecurityService.connected" type="file" nv-file-select="" uploader="bannerUploader" multiple="true" style="visibility: hidden;display: none"/>
                                    </label>

                                </div>
                                <div class="banner-body">
                                    <img ng-show="OfferService.currentOffer.banner.id" width="80%" ng-src="{{OfferService.currentOffer.banner.absolute_path}}" />
                                </div>

                            </div>

                            <div class="banner-box">
                                <div class="banner-head">
                                    <span class="banner-title">
تابلوی وب
                                    </span>
                                    <button ng-click="OfferService.removeVerticalBanner()" ng-disabled="!OfferService.isEditing()" class="banner-delete btn-danger btn">
                                        حذف
                                    </button>
                                    <label class="banner-file-select btn btn-info" ng-class="{'disabled': !OfferService.isEditing()}">
                                        انتخاب فایل
                                        <input ng-disabled="!OfferService.isEditing()  || !SecurityService.connected" type="file" nv-file-select="" uploader="verticalBannerUploader" multiple="true" style="visibility: hidden;display: none"/>
                                    </label>

                                </div>
                                <div class="banner-body">
                                    <img ng-show="OfferService.currentOffer.vertical_banner.id" width="80%" ng-src="{{OfferService.currentOffer.vertical_banner.absolute_path}}" />
                                </div>

                            </div>
                            
                            <div class="offer-submiter-box">
                                <label style="float: right" for="offer-submitter-input">
                                    شماره رکورد آگهی کننده
                                </label>
                                <input style="float: right" type="text" ng-disabled="!OfferService.isEditing()" id="offer-submitter-input" ng-model="OfferService.currentOffer.submitter_number" />
                                <hr  style="float: right; width: 100%;margin:5px;"/>
                                <label style="float: right" for="offer-submitter-input-title">
                                    نام رکورد آگهی کننده
                                </label>
                                <input style="float: right" type="text" ng-disabled="!OfferService.isEditing()" id="offer-submitter-input-title" ng-model="OfferService.currentOffer.submitter_title" />
                                <hr  style="float: right; width: 100%; margin:5px;"/>
                                <button style="clear: both;display: block;" ng-click="openSelectRecordModal()">انتخاب رکورد</button>
                            </div>
                            
                            <script type="text/ng-template" id="selectRecordModal.html">
                                <div class="modal-header">
                                    <h3 class="modal-title">درج رکورد</h3>
                                </div>

                                <div class="modal-body">

                                    <div> 
                                        <angucomplete-alt  id="records"
                                                  placeholder="عنوان رکورد"
                                                  pause="400"
                                                  selected-object="selectedEntity"
                                                  remote-url="../record/ajax/get_entity_list/record/name/"
                                                  remote-url-data-field="results"
                                                  title-field="record_number,title"
                                                  minlength="1"
                                                  input-class="form-control form-control-small autocomplete-entity-search"/>
                                    </div>

                                    <div class="autocomplete-entity-search" >
                                        <angucomplete-alt  id="records"
                                                  placeholder="شماره رکورد"
                                                  pause="400"
                                                  selected-object="selectedEntity"
                                                  remote-url="../record/ajax/get_entity_list/record/number/"
                                                  remote-url-data-field="results"
                                                  title-field="record_number,title"
                                                  minlength="1"
                                                  input-class="form-control form-control-small autocomplete-entity-search"/>
                                    </div>  

                                    
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-warning" ng-click="close()">بستن</button>
                                    <button class="btn btn-info pull-left" data-ng-click="insertRecord(selectedEntity)">اضافه</button>
                                </div>
                            </script>
                            
                            

                        </div>
                        <div class="main-fields-forth-section">
                            <span> آدرس و تلفن</span>
                            <label for="address">آدرس</label>
                            <div class="form-item-wrapper address">
                                <textarea ng-maxlength="255" id="address" ng-model="OfferService.currentOffer.address" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid ng-valid-maxlength" disabled="disabled">                                    
                                </textarea>
                            </div>

                            <label for="phone-one">تلفن</label>
                            <div class="form-item-wrapper phone">
                                <input type="number" ng-maxlength="11" id="phone-one" ng-model="OfferService.currentOffer.tel_number_one" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                                <input type="number" ng-maxlength="11" id="phone-two" ng-model="OfferService.currentOffer.tel_number_two" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                                <input type="number" ng-maxlength="11" id="phone-three" ng-model="OfferService.currentOffer.tel_number_three" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                                <input type="number" ng-maxlength="11" id="phone-four" ng-model="OfferService.currentOffer.tel_number_four" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                            </div>

                            <label for="fax-one">فکس</label>
                            <div class="form-item-wrapper fax">
                                <input type="number" ng-maxlength="11" id="fax-one" ng-model="OfferService.currentOffer.fax_number_one" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                                <input type="number" ng-maxlength="11" id="fax-two" ng-model="OfferService.currentOffer.fax_number_two" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                            </div>

                            <label for="mobile-one">همراه</label>
                            <div class="form-item-wrapper mobile">
                                <input type="number" ng-maxlength="11" id="mobile-one" ng-model="OfferService.currentOffer.mobile_number_one" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                                <input type="number" ng-maxlength="11" id="mobile-two" ng-model="OfferService.currentOffer.mobile_number_two" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid ng-valid-number ng-valid-maxlength" disabled="disabled">
                            </div>

                            <label for="email">ایمیل</label>
                            <div class="form-item-wrapper email">
                                <input maxlength="100" type="text" id="email" ng-model="OfferService.currentOffer.email" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid" disabled="disabled">
                            </div>

                            <label for="website">سایت</label>
                            <div class="form-item-wrapper website">
                                <input maxlength="100" type="text" id="website" ng-model="OfferService.currentOffer.website" ng-disabled="!OfferService.isEditing()" class="ng-pristine ng-valid" disabled="disabled">
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
                        <button ng-show="uploader.isUploading" ng-disabled="!OfferService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
                            X
                        </button>
                    </div>
                    
                    
                </div>
                <div class="row attachements-wrapper" ng-init="selectTab('icon')">
                    <div class="col-xs-2 right">
                        <ul class="tab-list" ng-init="ValuesService.activeTab = 'icon'">
                            <li class="pure-button"
                                ng-class="{'tab-active': ValuesService.activeTab === 'icon'}"
                                ng-click="selectTab('icon')">
                                آیکون
                            </li>
                            <li class="pure-button"
                                ng-class="{'tab-active': ValuesService.activeTab === 'image'}"
                                ng-click="selectTab('image')">
                                عکس
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
                                        <li ng-repeat="image in OfferService.currentOffer.images" style="float: right"  ng-class="{'selected' : OfferService.selectedImage.id == image.id}">
                                            <img ng-click="OfferService.selectedImage = image ;openImageModal('lg',image, $index)" ng-src="{{image.icon_absolute_path}}"  />
                                            <input
                                                type="checkbox"
                                                checklist-model="OfferService.selectedImages"
                                                checklist-value="image"
                                            />
                                        </li>
                                    </ul>
                                    <script type="text/ng-template" id="imageModal.html">
                                        
                                        <div class="modal-body">
                                            <img width="100%" ng-src="{{currentImage.web_absolute_path}}" />
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
                                    
                                    <img ng-show="OfferService.currentOffer.icon.id" ng-click="openIconModal('sm',OfferService.currentOffer.icon)" ng-src="{{OfferService.currentOffer.icon.absolute_path}}"  />
                                    <img ng-show="!OfferService.currentOffer.icon.id &&  OfferService.currentOffer.images.length >= 1 " ng-click="openIconModal('sm',OfferService.currentOffer.images[0])" ng-src="{{OfferService.currentOffer.images[0].absolute_path}}"  />
                                    <input
                                        ng-show="OfferService.currentOffer.icon.id"
                                        type="checkbox"
                                        checklist-model="OfferService.selectedIcon"
                                        checklist-value="true"
                                    />
                                        
                                    <script type="text/ng-template" id="iconModal.html">
                                        
                                        <div class="modal-body">
                                            <img  ng-src="{{icon.icon_absolute_path}}" />
                                        </div>
                                        
                                    </script>
                                    

                                </div>
                                <div ng-switch-when="video" class="video">
                                    <ul class="video-list">
                                        <li ng-repeat="video in OfferService.currentOffer.videos" style="float: right"  ng-class="{'selected' : OfferService.selectedVideo.id == video.id}">
                                            <input
                                                type="checkbox"
                                                checklist-model="OfferService.selectedVideos"
                                                checklist-value="video"
                                                />
                                            <span ng-bind="video.file_name" ng-click="OfferService.selectedVideo =video; openVideoModal('lg',video, $index)"></span>
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
                                        <li ng-repeat="audio in OfferService.currentOffer.audios" style="float: right" ng-class="{'selected' : OfferService.selectedAudio.id == audio.id}">
                                            <input
                                                type="checkbox"
                                                checklist-model="OfferService.selectedAudios"
                                                checklist-value="audio"
                                            />
                                            <span ng-bind="audio.file_name" ng-click="OfferService.selectedAudio = audio; openAudioModal('md',audio, $index)" >  </span>
                                        </li>
                                    </ul>
                                    <script type="text/ng-template" id="audioModal.html">
                                        
                                        <div class="modal-body">
                                            <audio id="modal-audio-player" controls="" autoplay=""  width="320" height="240" name="media"><source ng-src="{{currentAudio.absolute_path}}" type="{{currentAudio.filemime}}"></audio>
                                        </div>
                                        <div class="modal-footer">
                                            <button data-ng-click="prev()" class="btn btn-info pull-left" ng-disabled="currentIndex <= 1">
                                                قبلی
                                            </button>
                                            <button data-ng-click="next()" class="btn btn-info pull-left" ng-disabled="currentIndex >= totalAudio">
                                                بعدی
                                            </button>
                                            <button class="btn btn-warning" data-ng-click="close()">
                                                بستن
                                            </button>
                                        </div>
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2 left">
<!--                        <button class="btn btn-info add-attachment" ng-disabled="!OfferService.isEditing()" data-ng-click="showUploadModal()">
                            اضافه
                        </button>-->
                        
                        
                        <label class="file-select" ng-class="{'disabled': !OfferService.isEditing()}">
                            انتخاب فایل
                            <input ng-disabled="!OfferService.isEditing()  || !SecurityService.connected" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
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
                        <button class="btn btn-danger remove-attachment" ng-disabled="!OfferService.isEditing()"
                                data-ng-click="OfferService.removeFromAttachList()">
                            حذف
                        </button>
                        <button class="btn btn-info btn-continual-modal" ng-disabled="!OfferService.isEditing()"
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
                                        پیشنهاد ویژه
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
                                                <td style="width: 50%; overflow-wrap: break-word;">{{OfferService.currentOffer.icon.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{OfferService.currentOffer.icon.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="OfferService.currentOffer.icon.continual" />
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
                        <div class="html-preview" bind-html-compile="trustedBody()">

                        </div>
                        <button data-ng-show="OfferService.isEditing()" id="body-modal-button" class="btn btn-info" data-ng-click="openBodyModal('lg')">
                            ویرایش صفحه
                        </button>
                        <button id="body-preview-modal-button" class="btn btn-info" ng-click="openBodyPreviewModal()">
                            پیش نمایش صفحه
                        </button>
                        <script type="text/ng-template" id="bodyVideoModal.html">
                            <div dir="ltr" class="modal-body">
                                <videogular vg-theme="controller.config.theme">
                                    <vg-media vg-src="controller.config.sources"
                                              vg-tracks="controller.config.tracks">
                                    </vg-media>

                                    <vg-controls>
                                        <vg-play-pause-button></vg-play-pause-button>
                                        <vg-time-display>{{ currentTime | date:'mm:ss' }}</vg-time-display>
                                        <vg-scrub-bar>
                                            <vg-scrub-bar-current-time></vg-scrub-bar-current-time>
                                        </vg-scrub-bar>
                                        <vg-time-display>{{ timeLeft | date:'mm:ss' }}</vg-time-display>
                                        <vg-volume>
                                            <vg-mute-button></vg-mute-button>
                                            <vg-volume-bar></vg-volume-bar>
                                        </vg-volume>
                                        <vg-fullscreen-button></vg-fullscreen-button>
                                    </vg-controls>

                                    <vg-overlay-play></vg-overlay-play>
                                    <vg-poster vg-url='controller.config.plugins.poster'></vg-poster>
                                </videogular>
                            </div>

                        </script>
                        <script type="text/ng-template" id="bodyAudioModal.html">
                            <div dir="ltr" class="modal-body">
                                <videogular vg-theme="controller.config.theme.url" class="videogular-container audio">
                                    <vg-media vg-src="controller.config.sources" vg-type="audio"></vg-media>

                                    <vg-controls>
                                        <vg-play-pause-button></vg-play-pause-button>
                                        <vg-time-display>{{ currentTime | date:'mm:ss' }}</vg-time-display>
                                        <vg-scrub-bar>
                                            <vg-scrub-bar-current-time></vg-scrub-bar-current-time>
                                        </vg-scrub-bar>
                                        <vg-time-display>{{ timeLeft | date:'mm:ss' }}</vg-time-display>
                                        <vg-volume>
                                            <vg-mute-button></vg-mute-button>
                                        </vg-volume>
                                    </vg-controls>
                                </videogular>
                            </div>

                        </script>
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
                                    <div ng-show="innerLink" class="body-preview-content" bind-html-compile="trustedBody">
                                    </div>
                                    <div ng-show="externalLink" class="body-preview-content external-link">
                                        <iframe ng-src="{{trustedUrl}}" width="362" height="588" />
                                    </div>
                                </div>
                            </div>
                            
                        </script>
                        <script type="text/ng-template" id="bodyModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">بدنه پیشنهاد ویژه</h3>
                                <button class=" close-button btn btn-primary pull-right" ng-click="close()">بستن</button>
                                <button ng-disabled="!OfferService.isEditing() || offerform.$invalid" type="button" class="save-continue-button btn btn-success" ng-click="checkConnectionSave(true);offerform.$setPristine()">
                                    ذخیره و ادامه
                                </button>
                                <span class="body-save-continue-message" ng-show="OfferService.saved">
                                    <ul>
                                        <li ng-repeat="msg in OfferService.savingMessages" ng-bind="msg">
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
                                                                <li class = "file" ng-repeat="image in OfferService.currentOffer.body_images" style="float: right" ng-click="OfferService.selectBodyImage(image)" ng-class="{'selected' : OfferService.selectedBodyImage.id == image.id}">
                                                                    <img ng-src="{{image.absolute_path}}"  ng-click="OfferService.selectedBodyImage = image ;showImageShowModal(image)" />
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="OfferService.selectedBodyImages"
                                                                        checklist-value="image"
                                                                        />
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('video')" heading="فیلم">
                                                        <div class="video">
                                                            <ul class="video-list files-list">
                                                                <li class = "file" ng-repeat="video in OfferService.currentOffer.body_videos" style="float: right" ng-click="OfferService.selectBodyVideo(video)" ng-class="{'selected' : OfferService.selectedBodyVideo.id == video.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="OfferService.selectedBodyVideos"
                                                                        checklist-value="video"
                                                                    />
                                                                    <span ng-click="OfferService.selectedBodyVideo =video" ng-bind="video.file_name"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('audio')" heading="صدا">
                                                        <div class="audio">
                                                            <ul class="audio-list files-list">
                                                                <li class = "file" ng-repeat="audio in OfferService.currentOffer.body_audios" style="float: right" ng-click="OfferService.selectBodyAudio(audio)" ng-class="{'selected' : OfferService.selectedBodyAudio.id == audio.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="OfferService.selectedBodyAudios"
                                                                        checklist-value="audio"
                                                                    />
                                                                    <span ng-click="OfferService.selectedBodyAudio =audio" ng-bind="audio.file_name" ></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('doc')" heading="دیگر">
                                                        <div class="doc">
                                                            <ul class="doc-list files-list">
                                                                <li class = "file" ng-repeat="doc in OfferService.currentOffer.body_docs" style="float: right" ng-click="OfferService.selectBodyAudio(doc)" ng-class="{'selected' : OfferService.selectedBodyDoc.id == doc.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="OfferService.selectedBodyDocs"
                                                                        checklist-value="doc"
                                                                    />
                                                                    <span ng-click="OfferService.selectedBodyDoc =doc" ng-bind="doc.file_name" ></span>
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
                                                                    <button ng-show="uploader.isUploading" ng-disabled="!OfferService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
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
                                                            <label class="file-select" ng-class="{'disabled': !OfferService.isEditing()}">
                                                                انتخاب فایل
                                                                <input ng-disabled="!OfferService.isEditing() || !SecurityService.connected" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
                                                            </label>
                                                            <button class="btn btn-info" data-ng-click="CkeditorInsert()" ng-disabled="!OfferService.isReadyToInsert()">
                                                                درج
                                                            </button>
                                                            <button class="btn btn-danger" data-ng-click="OfferService.removeFromBodyAttachList()">
                                                                حذف
                                                            </button>
                                                            <button ng-disabled="!OfferService.isEditing() || offerform.$invalid" type="button" class="save-continue-button-bottom btn btn-success" ng-click="checkConnectionSave(true);offerform.$setPristine()">
                                                                ذخیره و ادامه
                                                            </button>
                                                            <span class="body-save-continue-message-bottom" ng-show="OfferService.saved">
                                                                <ul>
                                                                    <li ng-repeat="msg in OfferService.savingMessages" ng-bind="msg">
                                                                    </li>
                                                                </ul>
                                                            </span>
                                                            <button class="btn insert-tree-button" ng-click="openBodyTreeModal()" >درج شاخه</button>
                                                            <button class="btn insert-offer-button" ng-click="openBodyOfferModal()" >درج پیشنهاد ویژه</button>
                                                            <button class="btn insert-offer-button" ng-click="openInsertLinkModal()" >درج لینک</button>
                                                        </div>

                                                        

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-8">
                                        <div class="body-editor">
                                            <textarea ckeditor="bodyEditorOptions" ng-model="OfferService.currentOffer.body"></textarea>

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
                        <script type="text/ng-template" id="bodyOfferModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">درج پیشنهاد ویژه</h3>
                            </div>
                            <div class="modal-body">
                                <label class="offer-insert-text-label" for="offer-insert-text">متن</label>
                                <input id="offer-insert-text" type="text" ng-model="text" />
                                
                                <label class="offer-insert-id-label" for="offer-insert-id">شماره پیشنهاد ویژه</label>
                                <input id="offer-insert-id" type="text" ng-model="offerId" />
                                
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" ng-click="close()">بستن</button>
                                <button class="btn btn-info pull-left" data-ng-click="insertOffer()">اضافه</button>
                            </div>
                        </script>
                        <script type="text/ng-template" id="insertLinkModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">درج لینک</h3>
                            </div>
                            <div class="modal-body">
                                <label class="link-insert-text-label" for="offer-insert-text">متن</label>
                                <input id="link-insert-text" type="text" ng-model="text" />
                                
                                <label class="link-insert-link-label" for="offer-insert-id">لینک</label>
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
                                                                        <li class = "file" ng-repeat="image in OfferService.currentOffer.body_images" style="float: right" ng-click="OfferService.selectBodyImage(image)" ng-class="{'selected' : OfferService.selectedBodyImage.id == image.id}">
                                                                            <img ng-src="{{image.absolute_path}}"  ng-click="OfferService.selectedBodyImage = image ;showImageShowModal(image)" />
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="OfferService.selectedBodyImages"
                                                                                checklist-value="image"
                                                                                />
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                            <tab select="selectTab('video')" heading="فیلم">
                                                                <div class="video">
                                                                    <ul class="video-list files-list">
                                                                        <li class = "file" ng-repeat="video in OfferService.currentOffer.body_videos" style="float: right" ng-click="OfferService.selectBodyVideo(video)" ng-class="{'selected' : OfferService.selectedBodyVideo.id == video.id}">
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="OfferService.selectedBodyVideos"
                                                                                checklist-value="video"
                                                                            />
                                                                            <span ng-click="OfferService.selectedBodyVideo =video" ng-bind="video.file_name"></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                            <tab select="selectTab('audio')" heading="صدا">
                                                                <div class="audio">
                                                                    <ul class="audio-list files-list">
                                                                        <li class = "file" ng-repeat="audio in OfferService.currentOffer.body_audios" style="float: right" ng-click="OfferService.selectBodyAudio(audio)" ng-class="{'selected' : OfferService.selectedBodyAudio.id == audio.id}">
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="OfferService.selectedBodyAudios"
                                                                                checklist-value="audio"
                                                                            />
                                                                            <span ng-click="OfferService.selectedBodyAudio =audio" ng-bind="audio.file_name" ></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                        </tabset>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <div class="container body-modal-container">



                                                            <div class="row">

                                                                <div class="col-xs-12">
                                                                    <button class="btn btn-danger" data-ng-click="OfferService.removeFromBodyAttachList()">
                                                                        حذف
                                                                    </button>
                                                                    <button class="btn btn-info" data-ng-click="CkeditorInsert()" ng-disabled="!OfferService.isReadyToInsert()">
                                                                        درج
                                                                    </button>
                                                                    <label class="file-select" ng-class="{'disabled': !OfferService.isEditing()}">
                                                                        انتخاب فایل
                                                                        <input ng-disabled="!OfferService.isEditing()" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
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
                                                                                    <button ng-disabled="!OfferService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
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
                                                    <textarea ckeditor="bodyEditorOptions" ng-model="OfferService.currentOffer.body"></textarea>

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
                
                <h4 class="text-center">
                {{offerList().length}} از
                {{OfferService.totalOffer}}
                </h4>
                <div class="grid-block">
                    <table st-table="offerList()" class="table table-striped">
                        <thead>
                        <tr>
                            <th>ردیف</th>
                            <th>عنوان</th>
                            <th>عنوان فرعی</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr st-select-row="row" ng-class="{selected: OfferService.isSelected(row)}" data-ng-click="OfferService.selectOffer(row)" st-select-mode="single" ng-repeat="row in offerList()">
                            <td>{{row.id}}</td>
                            <td>{{row.title}}</td>
                            <td>{{row.sub_title}}</td>
                        </tr>
                        </tbody>
                    </table>



                </div>
                <div id="offer-list-inactivator" data-ng-show="OfferService.isEditing()" >

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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">پیشنهاد ویژه<span class="caret"></span></a>
            <?php print $view['knp_menu']->render('main') ?>
        </li>
    </ul>
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('top-actions');?>
    <div  class="offer-top show-grid ">

        <div class="col-xs-4">
            <button ng-show="SecurityService.buttonsAccess.newButtonAccess()" ng-disabled="OfferService.isEditing()" type="button" class="btn btn-primary" ng-click="OfferService.editingNew()">
                جدید
            </button>

            <button ng-show="SecurityService.buttonsAccess.editButtonAccess()" ng-disabled="OfferService.isNew() || OfferService.isEditing() || !SecurityService.connected" type="button" class="btn btn-info" ng-click="OfferService.editing()">
                ویرایش
            </button>
            <script type="text/ng-template" id="deleteModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">حذف پیشنهاد ویژه</h3>
                </div>
                <div class="modal-body">
                    آیا از حذف پیشنهاد ویژه جاری اطمینان دارید؟
                            
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" data-ng-click="close()">
                        خیر (انصراف)
                    </button>
                    <button class="btn btn-danger" data-ng-click="deleteCurrentOffer()">
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
            <div ng-show="SecurityService.buttonsAccess.deleteButtonAccess()" style="display: inline-block; margin: 0" class="dropdown">
              <button ng-disabled="!OfferService.currentOffer.id || OfferService.isEditing() || !SecurityService.connected" class="btn btn-danger btn-xs dropdown-toggle" type="button" id="claimtypedropdowm" data-toggle="dropdown" aria-expanded="true" style="line-height: inherit">
                حذف
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu" aria-labelledby="claimtypedropdowm">
                <li><a ng-click="openDeleteModal()">حذف</a></li>
              </ul>
            </div>
            <!-- <button ng-show="SecurityService.buttonsAccess.deleteButtonAccess()" ng-disabled="!OfferService.currentOffer.id || OfferService.isEditing() || !SecurityService.connected"  type="button" class="btn btn-danger" ng-click="openDeleteModal()">
                حذف
            </button> -->
            <button ng-show="SecurityService.buttonsAccess.saveButtonAccess()" ng-disabled="!OfferService.isEditing() || offerform.$invalid" type="button" class="btn btn-success" ng-click="checkConnectionSave()">
                ذخیره
            </button>
            <button ng-show="SecurityService.buttonsAccess.saveAndContinueButtonAccess()" ng-disabled="!OfferService.isEditing() || offerform.$invalid" type="button" class="btn btn-success" ng-click="checkConnectionSave(true)">
                ذخیره و ادامه
            </button>
            <script type="text/ng-template" id="savingModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">ذخیره</h3>
                </div>
                <div class="modal-body">
                    <span ng-show="!OfferService.saved">
                        در حال ذخیره سازی...
                    </span>
                    <span ng-show="OfferService.saved && OfferService.savingMessageIsArray">
                        <p ng-repeat="msg in OfferService.savingMessages" ng-bind="msg">

                        </p>

                    </span>
                    <p ng-show="OfferService.saved && !OfferService.savingMessageIsArray" ng-bind="OfferService.savingMessages">
                    </p>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn" ng-disabled="!OfferService.saved" data-ng-click="close()">
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
            <button ng-disabled="!OfferService.isEditing()" type="button" class="btn btn-warning" ng-click="openCancelModal('lg',offerform)">
                انصراف
            </button>
            <script type="text/ng-template" id="cancelModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">انصراف</h3>
                </div>
                <div class="modal-body">
                    آیا از انصراف ویرایش پیشنهاد ویژه جاری اطمینان دارید؟
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" ng-click="cancel()">بله</button>
                    <button class="btn btn-warning" ng-click="close()">خیر</button>
                </div>
            </script>





        </div>
        <div class="col-xs-3">
            <button type="button" ng-disabled="!OfferService.currentOffer.id || OfferService.isEditing() || !OfferService.previousable()" class="btn btn-primary" ng-click="OfferService.previousSelectedOffer()">
                قبلی
            </button>


            <button type="button" ng-disabled="!OfferService.currentOffer.id || OfferService.isEditing() || !OfferService.nexable()" class="btn btn-primary" ng-click="OfferService.nextSelectedOffer()">
                بعدی
            </button>

            <button ng-disabled="!OfferService.isEditing() || !(SecurityService.buttonsAccess.activateButtonAccess() == true) || !SecurityService.connected" data-ng-click="OfferService.toggleActiveCurrentOffer()"  class="btn active-inactive-btn" ng-class="{'is-active': OfferService.currentOffer.active == true,'is-inactive': OfferService.currentOffer.active == false }" >
                <i class="fa fa-check"></i>
                <i class="fa fa-times"></i>
                {{(OfferService.currentOffer.active)?'فعال':'غیر فعال'}}
            </button>
            
            <button ng-disabled="!OfferService.isEditing() || !(SecurityService.buttonsAccess.verifyButtonAccess() == true) || !SecurityService.connected" data-ng-click="OfferService.toggleVerifyCurrentOffer()"  class="btn verify-notverify-btn" ng-class="{'is-verify': OfferService.currentOffer.verify == true,'is-notverify': OfferService.currentOffer.verify == false }" >
                <i class="fa fa-check"></i>
                <i class="fa fa-times"></i>
                {{(OfferService.currentOffer.verify)? 'تایید شده':'تایید نشده'}}
            </button>
            
            
        </div>

        <div class="col-xs-3 left user-box" ng-class="{'logged-in': (SecurityService.loggedIn  && SecurityService.connected), 'logged-out': (!SecurityService.loggedIn  && !SecurityService.connected)}" style="float: left"  >
            <ul class="nav navbar-nav navbar-left user-pane">



                <li class="dropdown open">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <i class="fa fa-power-off"></i>
                    <span class="username-value">
                    {{ValuesService.username}}
                    </span> <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left" role="menu">
                        <li ng-show="SecurityService.loggedIn && SecurityService.connected">
                            <a  href="#" data-ng-click="openLogoutModal()()">
                                خروج
                            </a>
                        </li>
                        <script type="text/ng-template" id="logoutModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">خروج</h3>
                            </div>
                            <div class="modal-body">
                                آیا از خروج اطمینان دارید؟
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary" ng-click="logout()">خروج</button>
                                <button class="btn btn-warning" ng-click="cancel()">بستن</button>
                            </div>
                        </script>
                        <li ng-hide="SecurityService.loggedIn  || !SecurityService.connected">
                            <a href="#" data-ng-click="openLoginModal()">
                                ورود مجدد
                            </a>
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
                        </li>

                    </ul>
                </li>
            </ul>

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

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angucomplete-alt/dist/angucomplete-alt.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/checklist-model/checklist-model.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-media-player/dist/angular-media-player.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ngInfiniteScroll/build/ng-infinite-scroll.min.js') ?>"></script>
    
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-file-upload/angular-file-upload.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-google-maps/dist/angular-google-maps.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/lodash/dist/lodash.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-scroll/angular-scroll.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular/videogular.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular-controls/vg-controls.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular-overlay-play/vg-overlay-play.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular-poster/vg-poster.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular-buffering/vg-buffering.js') ?>"></script>
    
<!--    <script src='//maps.googleapis.com/maps/api/js?sensor=false'></script>-->


    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-collection/angular-collection.js') ?>"></script>



    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Controllers/offerIndexCtrl.js') ?>"></script>
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/offerService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/offertreeService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/offerIndex.js') ?><!--"></script>-->

    
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