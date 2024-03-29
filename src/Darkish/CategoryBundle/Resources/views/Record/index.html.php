<?php $view->extend('::panel_layout.html.php') ?>



<?php $view['slots']->start('stylesheets') ?>
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/tree-control-attribute.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-ui-grid/ui-grid.min.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/angular/xeditable.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/css/record-admin-page.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-modal/modal.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-hotkeys/build/hotkeys.min.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angucomplete-alt/angucomplete-alt.css') ?>" type="text/css" rel="stylesheet" />
<link href="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular-themes-default/videogular.min.css') ?>" type="text/css" rel="stylesheet" />


<?php $view['slots']->stop() ?>

<?php $view['slots']->start('pagetitle') ?>مدیریت رکوردها<?php $view['slots']->stop() ?>
<?php $view['slots']->start('ngapp') ?>RecordApp<?php $view['slots']->stop() ?>

<?php $view['slots']->start('controller') ?>RecordIndexCtrl<?php $view['slots']->stop() ?>

<?php $view['slots']->start('formname') ?>recordform<?php $view['slots']->stop() ?>

<?php $view['slots']->start('body') ?>

    <div class="container-fluid main-wrapper">
        <div class="row main">
            <div class="col col-xs-2 main-right main-cols">
                <div class="main-tree-block">
                    
                    <h3 class="block-title">
                        شاخه بندی رکورد ها
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
                        <li>
                            <a data-ng-click="TreeService.currentTreeNode = {id: -4};TreeService.selectTree(TreeService.currentTreeNode)" ng-class="{'selected': TreeService.currentTreeNode.id == -4}">
                                فروشندگان بلیط
                            </a>
                        </li>
                        <li>
                            <a data-ng-click="TreeService.currentTreeNode = {id: -5};TreeService.selectTree(TreeService.currentTreeNode)" ng-class="{'selected': TreeService.currentTreeNode.id == -5}">
                                خدمات دهندگان بلیط
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
                        <div data-ng-show="RecordService.isEditing()" id="tree-selectable-inactivator"></div>
                    </div>
                </div>
                <div class="main-search-block">
                    <h3 class="block-title">
جستجو
                    </h3>
                    <div class="search-box">
                        <input tabindex="-1" id="search-by-title" type="radio" name="search-based-on" ng-model="RecordService.recordSearchCriteria.searchBy" value="1" />
                        <label for="search-by-title">
                            عنوان
                        </label>
                        <input tabindex="-1" id="search-by-number" type="radio" name="search-based-on" ng-model="RecordService.recordSearchCriteria.searchBy" value="2" />
                        <label for="search-by-number">
                            شماره
                        </label>
                        <input tabindex="-1" id="search-by-all" type="radio" name="search-based-on" ng-model="RecordService.recordSearchCriteria.searchBy" value="3" />
                        <label for="search-by-all">
                            همه
                        </label>

                        <button tabindex="-1" class="btn" data-ng-click="RecordService.recordSearchCriteria.cid = null; RecordService.searchRecords()">
                            بیاب
                        </button>
                        <input type="text" class="keyword" ng-model="RecordService.recordSearchCriteria.searchKeyword" tabindex="-1" />
                    </div>
                </div>
                <div class="sort-block">
                    <span>
                        ترتیب نمایش
                    </span>
                    <input tabindex="-1" id="sort-by-date-desc" type="radio" name="sort-based-on"
                           ng-model="RecordService.recordSearchCriteria.sortBy" value="1" />
                    <label for="sort-by-date-desc">
                        تاریخ نزولی
                    </label>
                    <input tabindex="-1" id="sort-by-date-asc" type="radio" name="sort-based-on"
                           ng-model="RecordService.recordSearchCriteria.sortBy" value="2" />
                    <label for="sort-by-date-asc">
تاریخ صعودی
                    </label>
                    <input tabindex="-1" id="sort-by-number-desc" type="radio" name="sort-based-on"
                           ng-model="RecordService.recordSearchCriteria.sortBy" value="3" />
                    <label for="sort-by-number-desc">
شماره نزولی
                    </label>
                    <input tabindex="-1" id="sort-by-number-asc" type="radio" name="sort-based-on"
                           ng-model="RecordService.recordSearchCriteria.sortBy" value="4" />
                    <label for="sort-by-number-asc">
شماره صعودی
                    </label>
                </div>
            </div>
            <div class="col col-xs-6 main-center main-cols">
                <div class="basic-info col col-xs-12">
                    <div class="basic-info-left-col">
                        
<!--                        <div class="archive-wrapper">
                            <label for="archive-checkbox" class="archive-label">
                                آرشیو
                            </label>
                            <input ng-disabled="!RecordService.isEditing()" type="checkbox" id="archive-checkbox" ng-model="RecordService.currentRecord.archive" />
                        </div>-->
                        <div class="record-number-wrapper">
                          <span class="record-number-title">شماره پرونده</span>
                          <span class="record-number" dir="ltr">
                              {{RecordService.currentRecord.record_number.substring(0,3)}},
                              {{RecordService.currentRecord.record_number.substring(3,6)}}
                          </span>
                          
                        </div>
                        <button ng-disabled="!RecordService.currentRecord.id" class="btn btn-default btn-xs" ng-click="RecordService.generateRgisterCodeSingle()">تولید کد ثبت نام</button>
                    </div>

                    <div class="basic-info-right-col">
                        <div class="record-title">
                            <div class="field-title record-title-title">عنوان:</div>
                            <input type="text" ng-maxlength="70" name="record-title" class="record-title-input" ng-model="RecordService.currentRecord.title" ng-disabled="!RecordService.isEditing()" required>
                            <button data-ng-click="openTitlesModal()" class="record-title-lan" ng-disabled="!RecordService.isEditing()" >Lan</button>
                        </div>

                        <div class="record-subtitle">
                            <div class="field-title record-title-title">زیر عنوان:</div>
                            <input  type="text" ng-maxlength="70" name="record-subtitle" class="record-subtitle-input" ng-model="RecordService.currentRecord.sub_title" ng-disabled="!RecordService.isEditing()" required>
                        </div>
                        
                        <script type="text/ng-template" id="titlesModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">عناوین</h3>
                            </div>
                            <div class="modal-body">
                                <h4 class="modal-header2">
                                    انگلیسی
                                </h4>
                                    <label for="english-title">
                                    عنوان
                                    </label>
                                    <input ng-maxlength="70" id="english-title" ng-model="RecordService.currentRecord.english_title" ng-disabled="!RecordService.isEditing()" />

                                    <label for="english-sub-title">
زیر عنوان
                                    </label>
                                    <input ng-maxlength="70" id="english-sub-title" ng-model="RecordService.currentRecord.english_sub_title" ng-disabled="!RecordService.isEditing()" />


                                <h4 class="modal-header2">
                                    عربی
                                </h4>
                                    <label for="arabic-title">
                                    عنوان
                                    </label>
                                    <input ng-maxlength="70" id="arabic-title" ng-model="RecordService.currentRecord.arabic_title" ng-disabled="!RecordService.isEditing()" />

                                    <label for="arabic-sub-title">
                                        زیر عنوان
                                    </label>
                                    <input ng-maxlength="70" id="arabic-sub-title" ng-model="RecordService.currentRecord.arabic_sub_title" ng-disabled="!RecordService.isEditing()" />


                                <h4 class="modal-header2">
                                    ترکی
                                </h4>

                                    <label for="turkish-title">
                                        عنوان
                                    </label>
                                    <input ng-maxlength="70" id="turkish-title" ng-model="RecordService.currentRecord.turkish_title" ng-disabled="!RecordService.isEditing()" />

                                    <label for="turkish-sub-title">
                                        زیر عنوان
                                    </label>
                                    <input ng-maxlength="70" id="turkish-sub-title" ng-model="RecordService.currentRecord.turkish_sub_title" ng-disabled="!RecordService.isEditing()" />

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-info pull-left" data-ng-click="close()">
                                            تایید
                                </button>
                            </div>
                        </script>
                        
                        

                    </div>
      
                </div>
                <div class="main-fields-row">





                    <div class="col main-fields-wrapper" id="main-fields-wrapper">
                        <div class="main-fields-first-section" >

                            <div class="main-fields-informations">
                                <label class="main-fields-searchkey-title first-section-fields-title" for="search-key-input">توضیحات یک:</label>
                                <textarea ng-maxlength="255" name="info-one-input" id="info-two-input" class="first-section-input" ng-model="RecordService.currentRecord.info_one" ng-disabled="!RecordService.isEditing()"></textarea>
                                <label class="main-fields-searchkey-title first-section-fields-title" for="search-key-input">توضیحات دو:</label>
                                <textarea ng-maxlength="255" name="info-two-input" id="info-one-input" class="first-section-input" ng-model="RecordService.currentRecord.info_two" ng-disabled="!RecordService.isEditing()"></textarea>
                            </div>
                            <div class="main-fields-informations">
                                <label class="main-fields-searchkey-title first-section-fields-title" for="path-input">
                                    آدرس صفحه رکورد:
                                </label>
                                <input ng-maxlength="25" name="path-input" id="path-input" class="first-section-input" ng-model="RecordService.currentRecord.path" ng-disabled="!RecordService.isEditing()"></input>

                            </div>
                            <div id="non-searchable-wrapper" style="margin: 10px 0;">
                                <label class="main-fields-non-searchable first-section-fields-title" for="non-searchable">عدم جستجو:</label>
                                <input type="checkbox" id="non-searchable" name="just-html-chk" class="" ng-model="RecordService.currentRecord.non_searchable" ng-disabled="!RecordService.isEditing()">
                            </div>
                            <div class="main-fields-search-key">
                                <label class="main-fields-searchkey-title first-section-fields-title" for="search-key-input">کلید واژه جستجو:</label>
                                <input type="text" ng-maxlength="255" name="searchkey-input" id="search-key-input" class="first-section-input" ng-model="RecordService.currentRecord.search_keywords" ng-disabled="!RecordService.isEditing()">
                            </div>
                            <br/>
                            <div class="main-fields-owner">
                                <label class="main-fields-owner-title first-section-fields-title" for="owner-input">نام مالک:</label>
                                <input type="text" ng-maxlength="255" name="owner-input" id="owner-input" class="first-section-input" ng-model="RecordService.currentRecord.owner" ng-disabled="!RecordService.isEditing()">
                            </div>
                            <div class="main-fields-owner">
                                <label class="main-fields-owner-phone first-section-fields-title" for="owner-phone-input">تلفن مالک:</label>
                                <input type="text" ng-maxlength="11" name="owner-phone-input" id="owner-phone-input" class="first-section-input" ng-model="RecordService.currentRecord.owner_phone" ng-disabled="!RecordService.isEditing()">
                            </div>
                            <div class="main-fields-owner">
                                <label class="main-fields-owner-mail first-section-fields-title" for="owner-mail-input">ایمیل مالک:</label>
                                <input type="text" ng-maxlength="50" name="owner-mail-input" id="owner-mail-input" class="first-section-input" ng-model="RecordService.currentRecord.owner_mail" ng-disabled="!RecordService.isEditing()">
                            </div>
                            <br/>
                            <div class="main-fields-owner">
                                <label class="main-fields-manager-title first-section-fields-title" for="manager-input">نام مدیر:</label>
                                <input type="text" ng-maxlength="255" name="manager-input" id="manager-input" class="first-section-input" ng-model="RecordService.currentRecord.manager" ng-disabled="!RecordService.isEditing()">
                            </div>
                            <div class="main-fields-owner">
                                <label class="main-fields-manager-phone-title first-section-fields-title" for="manager-phone-input">تلفن مدیر:</label>
                                <input type="text" ng-maxlength="11" name="manager-phone-input" id="manager-phone-input" class="first-section-input" ng-model="RecordService.currentRecord.manager_phone" ng-disabled="!RecordService.isEditing()">
                            </div>
                            <div class="main-fields-owner">
                                <label class="main-fields-manager-mail first-section-fields-title" for="manager-mail-input">ایمیل مدیر:</label>
                                <input type="text" ng-maxlength="50" name="manager-mail-input" id="manager-mail-input" class="first-section-input" ng-model="RecordService.currentRecord.manager_mail" ng-disabled="!RecordService.isEditing()">
                            </div>

                            <br/>
                            <div class="main-fields-legal-name">
                                <label class="main-fields-legal-name-title first-section-fields-title" for="legal-name-input">نام حقوقی:</label>
                                <input type="text" name="legal-name-input" id="legal-name-input" class="first-section-input" ng-model="RecordService.currentRecord.legal_name" ng-disabled="!RecordService.isEditing()">
                            </div>

                            <div class="main-fields-owner">


                            </div>
                            <div id="spec-msg-detail-wrapper">
                                <label class="trip-maker-title first-section-fields-title" for="trip-maker-combo">
                                    سطح دسترسی
                                </label>
                                <select id="trip-maker-combo" ng-model="RecordService.currentRecord.access_class" ng-disabled="!RecordService.isEditing()" class="first-section-input">
                                    <option ng-selected="class.value == RecordService.currentRecord.access_class" ng-repeat="class in ValuesService.accessClasses" value="{{class.id}}" > {{class.name}} </option>

                                </select>
                                <br/><br/>
                                <label id="expire-date-label" class="third-section-label " for="expire-date-input">
                                    تاریخ اعتبار رکورد:
                                </label>
                                <input ng-click="openExpireDate($event)" type="text" id="expire-date-input" class="third-section-input"  datepicker-popup-persian="{{format}}" ng-model="RecordService.currentRecord.expire_date" is-open="expireDateIsOpen"  datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-disabled="!RecordService.isEditing()" close-text="بستن" />

                            </div>
                            

                            <div class="main-fields-tree-list">
                                <div class="main-fields-tree-list-commands-wrapper">
                                    <label class="tree-list-trees-button-wrapper">
                                        شاخه ها:
                                    </label>
                                    <div class="tree-list-add-remove-button-wrapper">
                                        
                                        <button type="button" ng-click="openTreeModal()" id="tree-list-add-button"  ng-disabled="!RecordService.isEditing() || (RecordService.currentRecord.treeList.length >= 5)">+</button>
                                        <button type="button" ng-click="RecordService.removeFromTreeList(secondTreeSelected)" id="tree-list-remove-button" ng-disabled="!RecordService.isEditing()">-</button>
                                    </div>


                                </div>
                                <select multiple id="tree-list-input" ng-model="secondTreeSelected" ng-disabled="!RecordService.isEditing()"
                                        ng-options="(tree.tree.parent_tree_title + '-->' +tree.tree.title + '(' + tree.sort + ')' + ':' + ((tree.group_filter.filter_name)?tree.group_filter.filter_name:((tree.tree.group_filter.filter_name)?tree.tree.group_filter.filter_name:'بدون فیلتر') ) ) for tree in RecordService.currentRecord.treeList.all()">
                                        <!-- <option ng-repeat="center in ValuesService.centers" value="{{center}}" > {{center.name}} </option> -->



                                </select>
                                
                                <div class="tree-ranks">
                                    <select class="ranklist-combo" ng-repeat="tree in RecordService.currentRecord.treeList.array" ng-model="tree.sort" ng-disabled="!RecordService.isEditing()">
                                        <option ng-repeat="treeRank in ValuesService.treeRanks" value="{{treeRank.id}}" ng-selected="treeRank.id == tree.sort" > {{treeRank.name}}</option>
                                    </select>

                                </div>
                                <script type="text/ng-template" id="treeModal.html">
                                    <div class="modal-header">
                                        <h3 class="modal-title">انتخاب شاخه ها<span ng-show="message">({{message}})</span></h3>
                                    </div>
                                    <div class="modal-body">
                                        <treecontrol class="tree-classic"
                                                    tree-model="tree()"
                                                    options="tOptions"
                                                    on-selection="selectTree(node)"
                                                    selected-node="TreeService.currentSecondTreeNode">
                                           {{node.title}}
                                        </treecontrol>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-warning" ng-click="close()">بستن</button>
                                        <select class="tree-modal-tree-rank pull-left" ng-model="list_rank">
                                            <option ng-repeat="treeRank in ValuesService.treeRanks" value="{{treeRank.id}}" > {{treeRank.name}} </option>
                                        </select>
                                        <select 
                                            class="tree-modal-tree-group-filter pull-left" 
                                            ng-options="groupFilter as groupFilter.filter_name for groupFilter in groupFilters"
                                            ng-model="group_filter"></select>
                                            
                                        
                                        <button ng-disabled="RecordService.currentRecord.treeList.length >= 5 || !group_filter" class="btn btn-info pull-left" data-ng-click="message = RecordService.addToTreeList(TreeService.currentSecondTreeNode, list_rank, group_filter)">اضافه</button>
                                    </div>
                                </script>
                                
                            </div>

                        </div>
                         <div class="main-fields-second-section" >

                            <div id="just-html-chk-wrapper" class="main-fields-second-section-chk-wrapper">
                                <input type="checkbox" id="just-html-chk" name="just-html-chk" class="second-section-chk" ng-model="RecordService.currentRecord.only_html" ng-disabled="!RecordService.isEditing()">
                                <label id="just-html-chk-label" class="second-section-chk-label" for="just-html-chk"> فقط HTML</label>
                            </div>

                            <div id="html-page-chk-wrapper" class="main-fields-second-section-chk-wrapper">
                                <input type="checkbox" id="html-page-chk" name="html-page-chk" class="second-section-chk" ng-model="RecordService.currentRecord.online_enable" ng-disabled="!RecordService.isEditing()">
                                <label id="html-page-chk-label" class="second-section-chk-label" for="html-page-chk"> صفحه HTML</label>
                            </div>

                            <div id="brand-chk-wrapper" class="main-fields-second-section-chk-wrapper">
                                <input type="checkbox" id="brand-chk" name="brand-chk" class="second-section-chk" ng-model="RecordService.currentRecord.brand_enable" ng-disabled="!RecordService.isEditing()">
                                <label id="brand-chk-label" class="second-section-chk-label" for="brand-chk"> برند - نمایندگی</label>
                            </div>

                             <div id="ranklist-combo-wrapper" class="main-fields-second-section-combo-wrapper">

                                 <label id="ranklist-combo-label" class="second-section-combo-label" for="ranklist-combo">رتبه نمایش در لیست</label>
<!--
                                <select id="ranklist-combo" ng-model="RecordService.currentRecord.list_rank" ng-disabled="!RecordService.isEditing()"
                                        ng-options="rank.name for rank in ValuesService.treeRanks" >
                                </select>-->
                               
                            </div>

                            <div id="group-massage-chk-wrapper" class="main-fields-second-section-chk-wrapper">
                                <input type="checkbox" id="group-massage-chk" name="group-massage-chk" class="second-section-chk" ng-model="RecordService.currentRecord.bulk_sms_enable" ng-disabled="!RecordService.isEditing()">
                                <label id="group-massage-chk-label" class="second-section-chk-label" for="group-massage-chk">امکان ارسال پیام گروهی</label>
                            </div>

                             <div id="spec-massage-chk-wrapper" class="main-fields-second-section-chk-wrapper">
                                <input type="checkbox" id="spec-massage-chk" name="spec-massage-chk" class="second-section-chk" ng-model="RecordService.currentRecord.message_enable" ng-disabled="!RecordService.isEditing()">
                                <label id="spec-massage-chk-label" class="second-section-chk-label" for="spec-massage-chk">امکان درج پیام ویژه</label>
                            </div>

                            <div id="bazar-wrapper" class="main-fields-second-section-chk-wrapper">
                                <label class="bazar-label">مرکز/بازار</label>
                               	<label class="bazar-id" ng-bind="RecordService.currentRecord.center_index.id"></label>
                            </div>

                            <div id="central-wrapper" >
                                <label  class="central-wrapper-combo-label second-section-combo-label" for="central-wrapper-combo">انتخاب مرکز</label>	
                                <select id="central-wrapper-combo" ng-model="RecordService.currentRecord.center_index" ng-disabled="!RecordService.isEditing()"
                                    ng-options="center.name for center in ValuesService.centers">
                                    <!-- <option ng-repeat="center in ValuesService.centers" value="{{center}}" > {{center.name}} </option> -->

                                </select>


                                <label class="central-floor-title second-section-fields-title" for="central-floor-input">طبقه</label>
                                <input type="text" name="central-floor" id="central-floor-input" class="second-section-input" ng-model="RecordService.currentRecord.center_floor" ng-disabled="!RecordService.isEditing()">

                               <label class="central-unit-title second-section-fields-title" for="central-unit-input">واحد</label>
                               <input type="number" ng-maxlength="4" name="central-unit" id="central-unit-input" class="second-section-input" ng-model="RecordService.currentRecord.center_unit_number" ng-disabled="!RecordService.isEditing()">
                            </div>

                            <div id="trip-maker-wrapper" class="main-fields-second-section-chk-wrapper">
                                <div class="trip-maker-chk-wrapper">
                                    <input type="checkbox" id="trip-maker-chk" name="trip-maker-chk" ng-model="RecordService.currentRecord.safarsaz" class="second-section-chk"  ng-disabled="!RecordService.isEditing()">
                                    <label id="trip-maker-chk-label" class="second-section-chk-label" for="trip-maker-chk">سفر ساز</label>
                                </div>
                                
                                <label class="trip-maker-id" ng-bind="RecordService.currentRecord.safarsaz_type_index.id"></label>
                            </div>

                            <div id="choose-group-wrapper" >
                                <label  class="choose-group-wrapper-combo-label second-section-combo-label" for="choose-group-wrapper-combo">انتخاب گروه</label>
                                <select id="central-wrapper-combo" ng-model="RecordService.currentRecord.safarsaz_type_index" ng-disabled="!RecordService.isEditing() || !RecordService.currentRecord.safarsaz"
                                        ng-options="safarsazType.name for safarsazType in ValuesService.safarsazTypes">
                                    <!-- <option ng-repeat="center in ValuesService.centers" value="{{center}}" > {{center.name}} </option> -->

                                </select>

                                <label class="trip-maker-title second-section-fields-title" for="trip-maker-combo">رتبه در سفر ساز</label>
                                <select id="trip-maker-combo" ng-model="RecordService.currentRecord.safarsaz_rank" ng-disabled="!RecordService.isEditing() || !RecordService.currentRecord.safarsaz">
                                     <option ng-repeat="safarsazRank in ValuesService.safarsazRanks" value="{{safarsazRank.id}}" > {{safarsazRank.name}} </option>

                                </select>
                            </div>
                            <div class="sell-service-box">
                                <div class="">
                                    <input type="checkbox" id="sell-service-page" name="info-bank-chk" class="second-section-chk" ng-model="RecordService.currentRecord.sell_service_page" ng-disabled="!RecordService.isEditing()" >
                                    <label id="sell-service-page-label" class="info-bank-chk-label" for="sell-service-page">صفحه فروش/خدمات</label>
                                </div>
                                <div class="">
                                    <label id="sell-service-page-title-label" class="info-bank-chk-label" for="sell-service-page-title">عنوان صفحه خدمات/فروش</label>
                                    <input type="text" id="sell-service-page-title" name="info-bank-chk" class="second-section-chk" ng-model="RecordService.currentRecord.sell_service_page_title" ng-disabled="!RecordService.isEditing() || !RecordService.currentRecord.sell_service_page" >
                                    
                                </div>
                                
                                
                            </div>
                            <div id="info-bank-wrapper" class="main-fields-second-section-chk-wrapper">
                                <div class="info-bank-chk-wrapper">
                                    <input type="checkbox" id="info-bank-chk" name="info-bank-chk" class="second-section-chk" ng-model="RecordService.currentRecord.dbase_enable" ng-disabled="!RecordService.isEditing()" >
                                    <label id="info-bank-chk-label" class="info-bank-chk-label" for="info-bank-chk">بانک اطلاعات</label>
                                </div>
                                
                                <label class="info-bank-id" ng-bind="RecordService.currentRecord.dbase_type_index.id"></label>
                            </div>
                            <div id="info-bank-choose-group-wrapper" >
                                <label  class="info-bank-choose-group-wrapper-combo-label second-section-combo-label" for="info-bank-choose-group-wrapper-combo">انتخاب گروه</label>
                                <select id="info-bank-choose-group-wrapper-combo" ng-model="RecordService.currentRecord.dbase_type_index" ng-disabled="!RecordService.isEditing() || !RecordService.currentRecord.dbase_enable"
                                        ng-options="safarsazType.name for safarsazType in ValuesService.dbaseTypes">
                                    <!-- <option ng-repeat="center in ValuesService.centers" value="{{center}}" > {{center.name}} </option> -->

                                </select>
                            </div>

                            <div id="just-html-chk-wrapper" class="main-fields-second-section-chk-wrapper">
                                <input type="checkbox" id="commentable" name="just-html-chk"  class="second-section-chk" ng-model="RecordService.currentRecord.commentable" ng-init="RecordService.currentRecord.commentable=true" ng-disabled="!RecordService.isEditing()">
                                <label id="just-html-chk-label" class="second-section-chk-label" for="commentable"> فعال کردن نظرات </label>
                            </div>

                            <div class="main-fields-owner">
                                <label class="trip-maker-title first-section-fields-title" for="comment-default-state">
                                    وضعیت پیشفرض
                                </label>
                                <select id="comment-default-state" ng-model="RecordService.currentRecord.comment_default_state" ng-disabled="!RecordService.isEditing() || !RecordService.currentRecord.commentable" class="">
                                    <option ng-selected="state.value == RecordService.currentRecord.comment_default_state" ng-repeat="state in ValuesService.commentDefaultStates" value="{{state.value}}" > {{state.label}} </option>

                                </select>
                            </div>
                            
                         </div>

                         <div class="main-fields-third-section" >
                             <div id="spec-msg-detail-wrapper">
                                 <div id="spec-msg-text-wrapper">
                                     <label id="spec-msg-text-label" class="third-section-label " for="spec-msg-text-input">متن پیام ویژه</label>
                                     <input type="text" id="spec-msg-text-input" class="third-section-input" ng-model="RecordService.currentRecord.message_text" ng-disabled="!RecordService.isEditing()">
                                 </div>
                                 <div id="spec-msg-date-wrapper">


                                     <label id="spec-msg-credit-date-label" class="third-section-label " for="spec-msg-credit-date-input">تاریخ اعتبار</label>
                                     <input ng-click="openValidityDate($event)" type="text" id="spec-msg-credit-date-input" class=" third-section-input"  datepicker-popup-persian="{{format}}" ng-model="RecordService.currentRecord.message_validity_date" is-open="validityDateIsOpen"  datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-disabled="!RecordService.isEditing()" close-text="بستن" />

                                 </div>
                             </div>



                             <div id="ticket-wrapper">
                                 <div id="spec-msg-text-wrapper">
                                     <label id="spec-msg-text-label" class="third-section-label ">فروشنده بلیط</label>
                                     <input type="checkbox" class="" ng-model="RecordService.currentRecord.ticket_seller" ng-disabled="!RecordService.isEditing()">
                                 </div>
                                 <div id="spec-msg-date-wrapper">


                                     <label id="spec-msg-credit-date-label" class="third-section-label " >رتبه نمایش در لیست فروشنده ها</label>
                                     <select id="trip-maker-combo" ng-model="RecordService.currentRecord.ticket_seller_sort" ng-disabled="!RecordService.isEditing()"
                                            ng-options="n for n in [] | range:1:30">
                                          

                                     </select>

                                 </div>
                                 <hr style="
                                     float: right;
                                     width: 100%;
                                 ">
                                 <div style="display:inline-block" id="spec-msg-text-wrapper">
                                     <label id="spec-msg-text-label" class="third-section-label ">خدمات دهنده بلیط</label>
                                     <input type="checkbox" class="" ng-model="RecordService.currentRecord.ticket_server" ng-disabled="!RecordService.isEditing()">
                                 </div>
                                 <div id="spec-msg-date-wrapper">


                                     <label id="spec-msg-credit-date-label" class="third-section-label " >رتبه نمایش در شاخه خدمات دهندگان</label>
                                     <select id="trip-maker-combo" ng-model="RecordService.currentRecord.ticket_server_tree_sort" ng-disabled="!RecordService.isEditing()"
                                            ng-options="n for n in [] | range:1:30">
                                          

                                     </select>

                                 </div>
                                 <div id="spec-msg-date-wrapper">


                                     <button type="button" ng-click="openTicketTreeModal()" id="tree-list-add-button"  ng-disabled="!RecordService.isEditing()">انتخاب شاخه بلیط</button>
                                     <span ng-bind="(RecordService.currentRecord.ticket_server_tree)?RecordService.currentRecord.ticket_server_tree.title: 'بدون شاخه'"></span>
                                     <script type="text/ng-template" id="ticketTreeModal.html">
                                         <div class="modal-header">
                                             <h3 class="modal-title">انتخاب شاخه ها<span ng-show="message">({{message}})</span></h3>
                                         </div>
                                         <div class="modal-body">
                                             <treecontrol class="tree-classic"
                                                         tree-model="tree()"
                                                         options="tOptions"
                                                         selected-node="currentTicketTreeNode">
                                                {{node.title}}
                                             </treecontrol>
                                         </div>
                                         <div class="modal-footer">
                                             <button class="btn btn-warning" ng-click="close()">بستن</button>
                                             <button ng-disabled="RecordService.currentRecord.treeList.length >= 5" class="btn btn-info pull-left" data-ng-click="selectTicketTreeList(currentTicketTreeNode)">اضافه</button>
                                         </div>
                                     </script>
                                 </div>
                                 
                             </div>

                             <div id="opening-hours-wrapper">
                                 <label id="opening-time-label" class="third-section-label">ساعات کار</label>
                                 <div class="hostelry-box">
                                     <label class="hostelry-label" for="hostelry-input">
                                         شبانه روزی
                                     </label>
                                     <input id="hostelry-input" type="checkbox" ng-model="RecordService.currentRecord.hostelry" ng-disabled="!RecordService.isEditing()" />
                                 </div>
                                 <div id="opening-hours-time">
                                    <span class="morning">
                                    صبح
                                    </span>
                                    <label>
                                     از
                                    </label>
                                    <timepicker  mousewheel="false" ng-change="RecordService.currentRecord.m_opening_hours_from = RecordService.getTime(RecordService.currentRecord.m_opening_hours_from_date);"
                                                class="morning-one" ng-model="RecordService.currentRecord.m_opening_hours_from_date" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" ng-disabled="!RecordService.isEditing()"
                                                ng-class="{'time-disabled': !RecordService.isEditing()}"
                                    ></timepicker>
                                     <label>
                                     تا
                                     </label>
                                    <timepicker mousewheel="false" ng-change="RecordService.currentRecord.m_opening_hours_to = RecordService.getTime(RecordService.currentRecord.m_opening_hours_to_date);"
                                        class="morning-two" ng-model="RecordService.currentRecord.m_opening_hours_to_date" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" ng-disabled="!RecordService.isEditing()"
                                        ng-class="{'time-disabled': !RecordService.isEditing()}"
                                    ></timepicker>
                                    <span class="evening">
                                    عصر
                                    </span>
                                     <label>
                                         از
                                     </label>
                                    <timepicker mousewheel="false" ng-change="RecordService.currentRecord.a_opening_hours_from = RecordService.getTime(RecordService.currentRecord.a_opening_hours_from_date);"
                                        class="evening-one" ng-model="RecordService.currentRecord.a_opening_hours_from_date" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" ng-disabled="!RecordService.isEditing()"
                                        ng-class="{'time-disabled': !RecordService.isEditing()}"
                                    ></timepicker>
                                     <label>
                                         تا
                                     </label>
                                    <timepicker mousewheel="false" ng-change="RecordService.currentRecord.a_opening_hours_to = RecordService.getTime(RecordService.currentRecord.a_opening_hours_to_date);"
                                        class="evening-two" ng-model="RecordService.currentRecord.a_opening_hours_to_date" hour-step="hstep" minute-step="mstep" show-meridian="ismeridian" ng-disabled="!RecordService.isEditing()"
                                        ng-class="{'time-disabled': !RecordService.isEditing()}"
                                    ></timepicker>


                                 </div>
                                 <div style="display: inline-block; width:100%">
                                     <label class="central-floor-title second-section-fields-title" for="opening-hours-desc">
                                         توضیحات ساعات فعالیت
                                     </label>
                                     <textarea style="width:60%;" maxlength="255" id="opening-hours-desc" class="" ng-model="RecordService.currentRecord.opening_hours_desc" ng-disabled="!RecordService.isEditing()"></textarea>
                                 </div>
                                 <div class="holidays-wrapper">
                                     <span>
                                         ایام تعطیل
                                     </span>
                                     <div class="working-days" ng-bind="RecordService.currentRecord.working_days"></div>
                                     <input type="checkbox" id="holiday-shanbe"  ng-disabled="!RecordService.isEditing()"
                                            ng-change="RecordService.changeWorkingDays()"
                                            ng-model="RecordService.currentRecord.decoded_working_days.1" />
                                     <label for="holiday-shanbe">
                                         شنبه
                                     </label>

                                     <input type="checkbox" id="holiday-yekshanbe"  ng-disabled="!RecordService.isEditing()"
                                            ng-change="RecordService.changeWorkingDays()"
                                            ng-model="RecordService.currentRecord.decoded_working_days.2" />
                                     <label for="holiday-yekshanbe">
                                         یکشنبه
                                     </label>

                                     <input type="checkbox" id="holiday-doshanbe" ng-disabled="!RecordService.isEditing()"
                                            ng-change="RecordService.changeWorkingDays()"
                                            ng-model="RecordService.currentRecord.decoded_working_days.3" />
                                     <label for="holiday-doshanbe">
                                         دوشنبه
                                     </label>

                                     <input type="checkbox" id="holiday-seshanbe" ng-disabled="!RecordService.isEditing()"
                                            ng-change="RecordService.changeWorkingDays()"
                                            ng-model="RecordService.currentRecord.decoded_working_days.4" />
                                     <label for="holiday-seshanbe">
                                         سه شنبه
                                     </label>

                                     <input type="checkbox" id="holiday-charshanbe" ng-disabled="!RecordService.isEditing()"
                                            ng-change="RecordService.changeWorkingDays()"
                                            ng-model="RecordService.currentRecord.decoded_working_days.5" />
                                     <label for="holiday-charshanbe">
                                         چهارشنبه
                                     </label>

                                     <input type="checkbox" id="holiday-panjshanbe" ng-disabled="!RecordService.isEditing()"
                                            ng-change="RecordService.changeWorkingDays()"
                                            ng-model="RecordService.currentRecord.decoded_working_days.6" />
                                     <label for="holiday-panjshanbe">
                                         پنج شنبه
                                     </label>

                                     <input type="checkbox" id="holiday-jome" ng-disabled="!RecordService.isEditing()"
                                            ng-change="RecordService.changeWorkingDays()"
                                            ng-model="RecordService.currentRecord.decoded_working_days.7" />
                                     <label for="holiday-jome">
                                         جمعه
                                     </label>

                                     <input type="checkbox" id="holiday-holiday" ng-disabled="!RecordService.isEditing()"
                                            ng-change="RecordService.changeWorkingDays()"
                                            ng-model="RecordService.currentRecord.decoded_working_days.8" />
                                     <label for="holiday-holiday">
                                         تعطیل رسمی
                                     </label>



                                     <div style="display: inline-block; width:100%">
                                         <label style="width: 30%;" class="central-floor-title second-section-fields-title" for="opening-hours-desc">
                                             روزهای تعطیل
                                         </label>
                                         <textarea maxlength="255" style="width: 60%;" id="opening-hours-desc" class="" ng-model="RecordService.currentRecord.working_days_desc" ng-disabled="!RecordService.isEditing()"></textarea>
                                     </div>


                                 </div>
                             </div>
                         </div>
                        <div class="main-field-forht-half-section">
                            <label for="show-contact-on-list" >نمایش دکمه تماس روی لیست ها</label>
                            <input ng-disabled="!RecordService.isEditing()" id="show-contact-on-list" type="checkbox" ng-model="RecordService.currentRecord.show_contact_on_list" />
                            <label for="only-contact-information">فقط حاوی اطلاعات تماس</label>
                            <input ng-disabled="!RecordService.isEditing() || !RecordService.currentRecord.show_contact_on_list" id="only-contact-information" type="checkbox" ng-model="RecordService.currentRecord.only_contact_information" />
                        </div>
                         <div class="main-fields-forth-section" >
                            <span> آدرس و تلفن</span>
                            <label for="address">آدرس</label>
                            <div class="form-item-wrapper address">
                                <textarea ng-maxlength="255" id="address" ng-model="RecordService.currentRecord.address" ng-disabled="!RecordService.isEditing()">
                                    
                                </textarea>
                            </div>


                             <label for="phone-one">
                                 تلفن
                             </label>
                             <div class="form-item-wrapper ">
                                 <input type="text"  id="phone-one-label" ng-model="RecordService.currentRecord.tel_number_one_label" ng-disabled="!RecordService.isEditing()"
                                        placeholder="عنوان"
                                     />
                                 <input type="text" ng-maxlength="11" id="phone-one" ng-model="RecordService.currentRecord.tel_number_one" ng-disabled="!RecordService.isEditing()"
                                        placeholder="شماره"
                                     />
                                 <input type="text"  id="phone-two-label" ng-model="RecordService.currentRecord.tel_number_two_label" ng-disabled="!RecordService.isEditing()"
                                        placeholder="عنوان"
                                     />
                                 <input type="text" ng-maxlength="11" id="phone-two" ng-model="RecordService.currentRecord.tel_number_two" ng-disabled="!RecordService.isEditing()"
                                        placeholder="شماره"
                                     />
                                 <input type="text"  id="phone-three-label" ng-model="RecordService.currentRecord.tel_number_three_label" ng-disabled="!RecordService.isEditing()"
                                        placeholder="عنوان"
                                     />
                                 <input type="text" ng-maxlength="11" id="phone-three" ng-model="RecordService.currentRecord.tel_number_three" ng-disabled="!RecordService.isEditing()"
                                        placeholder="شماره"
                                     />

                                 <input type="text"  id="phone-four-label" ng-model="RecordService.currentRecord.tel_number_four_label" ng-disabled="!RecordService.isEditing()"
                                        placeholder="عنوان"
                                     />
                                 <input type="text" ng-maxlength="11" id="phone-four" ng-model="RecordService.currentRecord.tel_number_four" ng-disabled="!RecordService.isEditing()"
                                        placeholder="شماره"
                                     />

                                 <input type="text"  id="phone-five-label" ng-model="RecordService.currentRecord.tel_number_five_label" ng-disabled="!RecordService.isEditing()"
                                        placeholder="عنوان"
                                     />
                                 <input type="text" ng-maxlength="11" id="phone-five" ng-model="RecordService.currentRecord.tel_number_five" ng-disabled="!RecordService.isEditing()"
                                        placeholder="شماره"
                                     />

                                 <input type="text"  id="phone-six-label" ng-model="RecordService.currentRecord.tel_number_six_label" ng-disabled="!RecordService.isEditing()"
                                        placeholder="عنوان"
                                     />
                                 <input type="text" ng-maxlength="11" id="phone-six" ng-model="RecordService.currentRecord.tel_number_six" ng-disabled="!RecordService.isEditing()"
                                        placeholder="شماره"
                                     />
                                 <input type="text"  id="phone-seven-label" ng-model="RecordService.currentRecord.tel_number_seven_label" ng-disabled="!RecordService.isEditing()"
                                        placeholder="عنوان"
                                     />
                                 <input type="text" ng-maxlength="11" id="phone-seven" ng-model="RecordService.currentRecord.tel_number_seven" ng-disabled="!RecordService.isEditing()"
                                        placeholder="شماره"
                                     />

                                 <input type="text"  id="phone-eight-label" ng-model="RecordService.currentRecord.tel_number_eight_label" ng-disabled="!RecordService.isEditing()"
                                        placeholder="عنوان"
                                     />
                                 <input type="text" ng-maxlength="11" id="phone-eight" ng-model="RecordService.currentRecord.tel_number_eight" ng-disabled="!RecordService.isEditing()"
                                        placeholder="شماره"
                                     />

                             </div>


                            <label for="fax-one">فکس</label>
                            <div class="form-item-wrapper fax">
                                <input type="text" ng-maxlength="11" id="fax-one" ng-model="RecordService.currentRecord.fax_number_one" ng-disabled="!RecordService.isEditing()" />
                                <input type="text" ng-maxlength="11" id="fax-two" ng-model="RecordService.currentRecord.fax_number_two" ng-disabled="!RecordService.isEditing()" />
                            </div>

                            <label for="mobile-one">همراه</label>
                            <div class="form-item-wrapper mobile">
                                <input type="text" ng-maxlength="11" id="mobile-one" ng-model="RecordService.currentRecord.mobile_number_one" ng-disabled="!RecordService.isEditing()" />
                                <input type="text" ng-maxlength="11" id="mobile-two" ng-model="RecordService.currentRecord.mobile_number_two" ng-disabled="!RecordService.isEditing()" />
                            </div>

                            <label for="email">ایمیل</label>
                            <div class="form-item-wrapper email">
                                <input type="text" id="email" ng-model="RecordService.currentRecord.email" ng-disabled="!RecordService.isEditing()" />
                            </div>

                            <label for="website">سایت</label>
                            <div class="form-item-wrapper website">
                                <input type="text" id="website" ng-model="RecordService.currentRecord.website" ng-disabled="!RecordService.isEditing()" />
                            </div>
                            
                            <label for="sms-number">شماره پیام کوتاه</label>
                            <div class="form-item-wrapper website">
                                <input type="text" ng-maxlength="11" id="sms-number" ng-model="RecordService.currentRecord.sms_number" ng-disabled="!RecordService.isEditing()" />
                            </div>
                            
                            <label for="postal-code">کد پستی</label>
                            <div class="form-item-wrapper website">
                                <input type="text" ng-maxlength="11" id="postal-code" ng-model="RecordService.currentRecord.postal_code" ng-disabled="!RecordService.isEditing()" />
                            </div>

                            <label for="states"> محله </label>
                            <div class="form-item-wrapper state">

                                <select id="states" ng-model="RecordService.currentRecord.area_index" ng-disabled="!RecordService.isEditing()"
                                        ng-options="area.name for area in ValuesService.areas">
                                    <!-- <option ng-repeat="center in ValuesService.centers" value="{{center}}" > {{center.name}} </option> -->

                                </select>
                                <span class="state-id" ng-bind="RecordService.currentRecord.area_index.id">
                                    
                                </span>   
                            </div>


                            <div class="map-button">
                                <button ng-disabled="!RecordService.isEditing()" ng-click="showMapModal()" class="btn map">مکان نقشه</button>
                                <script type="text/ng-template" id="map-modal.html">
                                    <div class="modal-bg" data-ng-click="closeMe()">
                                        <div class="btf-modal  titles-modal" data-ng-click="$event.stopPropagation()">
                                            <h3 class="modal-header1">
                                                نقشه
                                            </h3>
                                            <div class="modal-body">

                                                <div class="google-map-selector">
                                                    <ui-gmap-google-map center='map.center' zoom='map.zoom' events='map.events'>
                                                        <ui-gmap-marker coords="map.marker.coords" options="map.marker.options" events="map.marker.events" idkey="map.marker.id">
                                                        </ui-gmap-marker>
                                                    </ui-gmap-google-map>
                                                </div>

                                            </div>
                                            <div class="modal-control-buttons-wrapper">
                                                <button class="btn" data-ng-click="closeMe()">
                                                    انصراف
                                                </button>
                                                <button class="btn" data-ng-click="apply()">
                                                    تایید
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </script>
                            </div>
                            <div class="form-item-wrapper map">
                                <input type="text" id="latitude" ng-model="RecordService.currentRecord.latitude" ng-disabled="!RecordService.isEditing()" />
                                <input type="text" id="longitude" ng-model="RecordService.currentRecord.longitude" ng-disabled="!RecordService.isEditing()" />
                                
                            </div>
                            
                            





                             
                         </div>
                    </div>
                    <div class="col capabilites">
                        <div class="capabilites-buttons-wrapper">
                            
                            قابلیط ها
                            <span data-ng-click="RecordService.toggleCapability('favorite_enable')"
                                  ng-class="{'active' : RecordService.currentRecord.favorite_enable == true, 'inactive' : RecordService.currentRecord.favorite_enable != true}"
                                  class="capabilites-buttons favorit">   </span>
                            <span data-ng-click="RecordService.toggleCapability('like_enable')"
                                  ng-class="{'active' : RecordService.currentRecord.like_enable == true, 'inactive' : RecordService.currentRecord.like_enable != true}"
                                  class="capabilites-buttons like inactive" >      </span>
                            <span data-ng-click="RecordService.toggleCapability('send_sms_enable')"
                                  ng-class="{'active' : RecordService.currentRecord.send_sms_enable == true, 'inactive' : RecordService.currentRecord.send_sms_enable != true}"
                                  class="capabilites-buttons message inactive">   </span>
                            <span ng-class="{'active' : RecordService.currentRecord.safarsaz == true, 'inactive' : RecordService.currentRecord.safarsaz != true}"
                                class="capabilites-buttons safarname inactive"> </span>
                            <span data-ng-click="RecordService.toggleCapability('online_ticket')"
                                  ng-class="{'active' : RecordService.currentRecord.online_ticket == true, 'inactive' : RecordService.currentRecord.online_ticket != true}"
                                class="capabilites-buttons ticket inactive">     </span>
                            <span ng-class="{'active' : RecordService.hasAudio() == true, 'inactive' : RecordService.hasAudio() != true}"
                                class="capabilites-buttons sound inactive">    </span>
                            <span ng-class="{'active' : RecordService.hasVideo() == true, 'inactive' : RecordService.hasVideo() != true}"
                                class="capabilites-buttons video inactive">     </span>
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
                        <button ng-show="uploader.isUploading" ng-disabled="!RecordService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
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
                                        <li ng-repeat="image in RecordService.currentRecord.images" style="float: right"  ng-class="{'selected' : RecordService.selectedImage.id == image.id}">
                                                <img ng-click="RecordService.selectedImage = image ;openImageModal('lg',image, $index)" ng-src="{{image.icon_absolute_path}}"  />
                                            <input
                                                type="checkbox"
                                                checklist-model="RecordService.selectedImages"
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
                                    
                                    <img ng-show="RecordService.currentRecord.icon.id" ng-click="openIconModal('sm',RecordService.currentRecord.icon)" ng-src="{{RecordService.currentRecord.icon.icon_absolute_path}}"  />
                                    <img ng-show="!RecordService.currentRecord.icon.id &&  RecordService.currentRecord.images.length >= 1 " ng-click="openIconModal('sm',RecordService.currentRecord.images[0])" ng-src="{{RecordService.currentRecord.images[0].icon_absolute_path}}"  />
                                    <input
                                        ng-show="RecordService.currentRecord.icon.id"
                                        type="checkbox"
                                        checklist-model="RecordService.selectedIcon"
                                        checklist-value="true"
                                    />
                                        
                                    <script type="text/ng-template" id="iconModal.html">
                                        
                                        <div class="modal-body">
                                            <img ng-src="{{icon.icon_absolute_path}}" />
                                        </div>
                                        
                                    </script>
                                    

                                </div>
                                <div ng-switch-when="video" class="video">
                                    <ul class="video-list">
                                        <li ng-repeat="video in RecordService.currentRecord.videos" style="float: right"  ng-class="{'selected' : RecordService.selectedVideo.id == video.id}">
                                            <input
                                                type="checkbox"
                                                checklist-model="RecordService.selectedVideos"
                                                checklist-value="video"
                                                />
                                            <span ng-bind="video.file_name" ng-click="RecordService.selectedVideo =video; openVideoModal('lg',video, $index)"></span>
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
                                        <li ng-repeat="audio in RecordService.currentRecord.audios" style="float: right" ng-class="{'selected' : RecordService.selectedAudio.id == audio.id}">
                                            <input
                                                type="checkbox"
                                                checklist-model="RecordService.selectedAudios"
                                                checklist-value="audio"
                                            />
                                            <span ng-bind="audio.file_name" ng-click="RecordService.selectedAudio = audio; openAudioModal('md',audio, $index)" >  </span>
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
<!--                        <button class="btn btn-info add-attachment" ng-disabled="!RecordService.isEditing()" data-ng-click="showUploadModal()">
                            اضافه
                        </button>-->
                        
                        
                        <label class="file-select" ng-class="{'disabled': !RecordService.isEditing()}">
                            انتخاب فایل
                            <input ng-disabled="!RecordService.isEditing() || !SecurityService.connected" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
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
                        <button class="btn btn-danger remove-attachment" ng-disabled="!RecordService.isEditing()"
                                data-ng-click="RecordService.removeFromAttachList()">
                            حذف
                        </button>
                        <button class="btn btn-info btn-continual-modal" ng-disabled="!RecordService.isEditing()"
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
                                        رکورد
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
                                                <td style="width: 50%; overflow-wrap: break-word;">{{RecordService.currentRecord.icon.file_name}}</td>
                                                <td style="width: 30%"><img ng-src="{{RecordService.currentRecord.icon.absolute_path}}" width="50" /></td>
                                                <td style="width: 10%">
                                                    <input type="checkbox" ng-model="RecordService.currentRecord.icon.continual" />
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
                        <div class="html-preview"  bind-html-compile="trustedBody()">

                        </div>
                        <button data-ng-show="RecordService.isEditing()" id="body-modal-button" class="btn btn-info" data-ng-click="openBodyModal('lg')">
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
                                <h3 class="modal-title">بدنه رکورد</h3>
                                <button class=" close-button btn btn-primary pull-right" ng-click="close()">بستن</button>
                                <button ng-disabled="!RecordService.isEditing() || recordform.$invalid" type="button" class="save-continue-button btn btn-success" ng-click="checkConnectionSave(true);recordform.$setPristine()">
                                    ذخیره و ادامه
                                </button>
                                <button id="body-preview-modal-button" class="btn btn-info" ng-click="openBodyPreviewModal()">
                                    پیش نمایش صفحه
                                </button>
                                <span class="body-save-continue-message" ng-show="RecordService.saved">
                                    <ul>
                                        <li ng-repeat="msg in RecordService.savingMessages" ng-bind="msg">
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
                                                                <li class = "file" ng-repeat="image in RecordService.currentRecord.body_images" style="float: right" ng-click="RecordService.selectBodyImage(image)" ng-class="{'selected' : RecordService.selectedBodyImage.id == image.id}">
                                                                    <img ng-src="{{image.absolute_path}}"  ng-click="RecordService.selectedBodyImage = image ;showImageShowModal(image)" />
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="RecordService.selectedBodyImages"
                                                                        checklist-value="image"
                                                                        />
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('video')" heading="فیلم">
                                                        <div class="video">
                                                            <ul class="video-list files-list">
                                                                <li class = "file" ng-repeat="video in RecordService.currentRecord.body_videos" style="float: right" ng-click="RecordService.selectBodyVideo(video)" ng-class="{'selected' : RecordService.selectedBodyVideo.id == video.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="RecordService.selectedBodyVideos"
                                                                        checklist-value="video"
                                                                    />
                                                                    <span ng-click="RecordService.selectedBodyVideo =video" ng-bind="video.file_name"></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('audio')" heading="صدا">
                                                        <div class="audio">
                                                            <ul class="audio-list files-list">
                                                                <li class = "file" ng-repeat="audio in RecordService.currentRecord.body_audios" style="float: right" ng-click="RecordService.selectBodyAudio(audio)" ng-class="{'selected' : RecordService.selectedBodyAudio.id == audio.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="RecordService.selectedBodyAudios"
                                                                        checklist-value="audio"
                                                                    />
                                                                    <span ng-click="RecordService.selectedBodyAudio =audio" ng-bind="audio.file_name" ></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </tab>
                                                    <tab select="selectTab('doc')" heading="دیگر">
                                                        <div class="doc">
                                                            <ul class="doc-list files-list">
                                                                <li class = "file" ng-repeat="doc in RecordService.currentRecord.body_docs" style="float: right" ng-click="RecordService.selectBodyAudio(doc)" ng-class="{'selected' : RecordService.selectedBodyDoc.id == doc.id}">
                                                                    <input
                                                                        type="checkbox"
                                                                        checklist-model="RecordService.selectedBodyDocs"
                                                                        checklist-value="doc"
                                                                    />
                                                                    <span ng-click="RecordService.selectedBodyDoc =doc" ng-bind="doc.file_name" ></span>
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
                                                                    <button ng-show="uploader.isUploading" ng-disabled="!RecordService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
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
                                                            <label class="file-select" ng-class="{'disabled': !RecordService.isEditing()}">
                                                                انتخاب فایل
                                                                <input ng-disabled="!RecordService.isEditing() || !SecurityService.connected" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
                                                            </label>
                                                            <button class="btn btn-info" data-ng-click="CkeditorInsert()" ng-disabled="!RecordService.isReadyToInsert()">
                                                                درج
                                                            </button>
                                                            <button class="btn btn-danger" data-ng-click="RecordService.removeFromBodyAttachList()">
                                                                حذف
                                                            </button>
                                                            <button ng-disabled="!RecordService.isEditing() || recordform.$invalid" type="button" class="save-continue-button-bottom btn btn-success" ng-click="checkConnectionSave(true);recordform.$setPristine()">
                                                                ذخیره و ادامه
                                                            </button>
                                                            <span class="body-save-continue-message-bottom" ng-show="RecordService.saved">
                                                                <ul>
                                                                    <li ng-repeat="msg in RecordService.savingMessages" ng-bind="msg">
                                                                    </li>
                                                                </ul>
                                                            </span>
                                                            <button class="btn insert-tree-button" ng-click="openBodyTreeModal()" >درج شاخه</button>
                                                            <button class="btn insert-record-button" ng-click="openBodyRecordModal()" >درج رکورد</button>
                                                            <button class="btn insert-record-button" ng-click="openInsertLinkModal()" >درج لینک</button>
                                                        </div>

                                                        

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-8">
                                        <div class="body-editor">
                                            <textarea ckeditor="bodyEditorOptions" ng-model="RecordService.currentRecord.body"></textarea>

                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </script>

                        <script type="text/ng-template" id="registerCodeModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">عملیات کدهای ثبت نام</h3>
                            </div>
                            <div class="modal-body">
                                <tabset>
                                    <tab select="" heading="گروهی">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col col-offset-xs-3 col-xs-6">
                                                    <br />
                                                    <button class="btn btn-md btn-info" ng-click="generateRgisterCodeGroup()">تولید کد برای رکوردهای لیست</button>
                                                    <button class="btn btn-md btn-success" ng-click="printRgisterCodeGroup()">چاپ کد برای رکوردهای لیست</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </tab>
                                    <tab select="" heading="بازه ای">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col col-offset-xs-3 col-xs-6">
                                                    <br/>
                                                    <label for="range-from">از</label> <input id="range-from" type="text" ng-model="from" class="form-control" />
                                                    <label for="range-to">تا</label> <input id="range-to" type="text" ng-model="to" class="form-control" />
                                                    <br/>
                                                    <button ng-disable="!from || !to || to<=from" class="btn btn-md btn-info" ng-click="generateRgisterCodeRange(from, to)">تولید کد برای بازه</button>
                                                    <button ng-disable="!from || !to || to<=from" class="btn btn-md btn-success" ng-click="printRgisterCodeRange(from, to)">چاپ کد برای بازه</button>
                                                </div>
                                            </div>
                                        </div>
                                    </tab>
                                    
                                </tabset>
                                
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
                        <script type="text/ng-template" id="bodyRecordModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">درج رکورد</h3>
                            </div>
                            <div class="modal-body">

                                <label class="record-insert-link-type" for="record-insert-link-type">نوع لینک</label>
                                <select ng-init="linkType = 'record'" ng-model="linkType" required>
                                    <option value="record">رکورد</option>
                                    <option value="news">خبر</option>
                                </select>
                                <input id="record-insert-text" type="text" ng-model="text" class="form-control" placeholder="عنوان لینک" />
                                <div ng-show="linkType == 'record'"  > 
                                    <angucomplete-alt  id="records"
                                              placeholder="عنوان رکورد"
                                              pause="400"
                                              selected-object="selectedEntity"
                                              remote-url="ajax/get_entity_list/record/name/"
                                              remote-url-data-field="results"
                                              title-field="record_number,title"
                                              minlength="1"
                                              input-class="form-control form-control-small autocomplete-entity-search"/>
                                </div>

                                <div ng-show="linkType == 'record'" class="autocomplete-entity-search" >
                                    <angucomplete-alt  id="records"
                                              placeholder="شماره رکورد"
                                              pause="400"
                                              selected-object="selectedEntity"
                                              remote-url="ajax/get_entity_list/record/number/"
                                              remote-url-data-field="results"
                                              title-field="record_number,title"
                                              minlength="1"
                                              input-class="form-control form-control-small autocomplete-entity-search"/>
                                </div>  

                                <div ng-show="linkType == 'news'">
                                    <angucomplete-alt  id="news"
                                              placeholder="عنوان خبر"
                                              pause="400"
                                              selected-object="selectedEntity"
                                              remote-url="ajax/get_entity_list/news/name/"
                                              remote-url-data-field="results"
                                              title-field="id,title"
                                              minlength="1"
                                              input-class="form-control form-control-small autocomplete-entity-search"/>
                                </div>

                                <div ng-show="linkType == 'news'">
                                    <angucomplete-alt  id="news"
                                              placeholder="شماره خبر"
                                              pause="400"
                                              selected-object="selectedEntity"
                                              remote-url="ajax/get_entity_list/news/number/"
                                              remote-url-data-field="results"
                                              title-field="id,title"
                                              minlength="1"
                                              input-class="form-control form-control-small autocomplete-entity-search"/>
                                </div>  

                                

                                <!--<label class="record-insert-text-label" for="record-insert-text">متن</label>
                                <input id="record-insert-text" type="text" ng-model="text" />
                                
                                <label class="record-insert-id-label" for="record-insert-id">شماره رکورد</label>
                                <input id="record-insert-id" type="text" ng-model="recordId" />-->
                                
                                
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-warning" ng-click="close()">بستن</button>
                                <button ng-show="linkType == 'record'" class="btn btn-info pull-left" data-ng-click="insertRecord(selectedEntity)">اضافه</button>
                                <button ng-show="linkType == 'news'" class="btn btn-info pull-left" data-ng-click="insertNews(selectedEntity)">اضافه</button>
                            </div>
                        </script>
                        <script type="text/ng-template" id="insertLinkModal.html">
                            <div class="modal-header">
                                <h3 class="modal-title">درج لینک</h3>
                            </div>
                            <div class="modal-body">
                                <label class="link-insert-text-label" for="record-insert-text">متن</label>
                                <input id="link-insert-text" type="text" ng-model="text" />
                                
                                <label class="link-insert-link-label" for="record-insert-id">لینک</label>
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
                                                                        <li class = "file" ng-repeat="image in RecordService.currentRecord.body_images" style="float: right" ng-click="RecordService.selectBodyImage(image)" ng-class="{'selected' : RecordService.selectedBodyImage.id == image.id}">
                                                                            <img ng-src="{{image.absolute_path}}"  ng-click="RecordService.selectedBodyImage = image ;showImageShowModal(image)" />
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="RecordService.selectedBodyImages"
                                                                                checklist-value="image"
                                                                                />
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                            <tab select="selectTab('video')" heading="فیلم">
                                                                <div class="video">
                                                                    <ul class="video-list files-list">
                                                                        <li class = "file" ng-repeat="video in RecordService.currentRecord.body_videos" style="float: right" ng-click="RecordService.selectBodyVideo(video)" ng-class="{'selected' : RecordService.selectedBodyVideo.id == video.id}">
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="RecordService.selectedBodyVideos"
                                                                                checklist-value="video"
                                                                            />
                                                                            <span ng-click="RecordService.selectedBodyVideo =video" ng-bind="video.file_name"></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                            <tab select="selectTab('audio')" heading="صدا">
                                                                <div class="audio">
                                                                    <ul class="audio-list files-list">
                                                                        <li class = "file" ng-repeat="audio in RecordService.currentRecord.body_audios" style="float: right" ng-click="RecordService.selectBodyAudio(audio)" ng-class="{'selected' : RecordService.selectedBodyAudio.id == audio.id}">
                                                                            <input
                                                                                type="checkbox"
                                                                                checklist-model="RecordService.selectedBodyAudios"
                                                                                checklist-value="audio"
                                                                            />
                                                                            <span ng-click="RecordService.selectedBodyAudio =audio" ng-bind="audio.file_name" ></span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </tab>
                                                        </tabset>
                                                        
                                                        
                                                        
                                                        
                                                        
                                                        <div class="container body-modal-container">



                                                            <div class="row">

                                                                <div class="col-xs-12">
                                                                    <button class="btn btn-danger" data-ng-click="RecordService.removeFromBodyAttachList()">
                                                                        حذف
                                                                    </button>
                                                                    <button class="btn btn-info" data-ng-click="CkeditorInsert()" ng-disabled="!RecordService.isReadyToInsert()">
                                                                        درج
                                                                    </button>
                                                                    <label class="file-select" ng-class="{'disabled': !RecordService.isEditing()}">
                                                                        انتخاب فایل
                                                                        <input ng-disabled="!RecordService.isEditing()" type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
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
                                                                                    <button ng-disabled="!RecordService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
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
                                                    <textarea ckeditor="bodyEditorOptions" ng-model="RecordService.currentRecord.body"></textarea>

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
                {{recordList().length}} از
                {{RecordService.totalRecord}}
                </h4>
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
                <div id="record-list-inactivator" data-ng-show="RecordService.isEditing()" >

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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">رکوردها<span class="caret"></span></a>
            <?php print $view['knp_menu']->render('main') ?>
        </li>
    </ul>
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('top-actions');?>
    <div  class="record-top show-grid ">

        <div class="col-xs-4">
            <button ng-show="SecurityService.buttonsAccess.newButtonAccess()" ng-disabled="RecordService.isEditing()" type="button" class="btn btn-primary" ng-click="RecordService.editingNew()">
                جدید
            </button>

            <button ng-show="SecurityService.buttonsAccess.editButtonAccess()" ng-disabled="RecordService.isNew() || RecordService.isEditing() || !SecurityService.connected" type="button" class="btn btn-info" ng-click="RecordService.editing()">
                ویرایش
            </button>
            <script type="text/ng-template" id="deleteModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">حذف رکورد</h3>
                </div>
                <div class="modal-body">
                    آیا از حذف رکورد جاری اطمینان دارید؟
                            
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning" data-ng-click="close()">
                        خیر (انصراف)
                    </button>
                    <button class="btn btn-danger" data-ng-click="deleteCurrentRecord()">
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
              <button ng-disabled="!RecordService.currentRecord.id || RecordService.isEditing() || !SecurityService.connected" class="btn btn-danger btn-xs dropdown-toggle" type="button" id="claimtypedropdowm" data-toggle="dropdown" aria-expanded="true" style="line-height: inherit">
                حذف
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" role="menu" aria-labelledby="claimtypedropdowm">
                <li><a ng-click="openDeleteModal()">حذف</a></li>
              </ul>
            </div>
            <!-- <button ng-show="SecurityService.buttonsAccess.deleteButtonAccess()" ng-disabled="!RecordService.currentRecord.id || RecordService.isEditing() || !SecurityService.connected"  type="button" class="btn btn-danger" ng-click="openDeleteModal()">
                حذف
            </button> -->
            <button ng-show="SecurityService.buttonsAccess.saveButtonAccess()" ng-disabled="!RecordService.isEditing() || recordform.$invalid" type="button" class="btn btn-success" ng-click="checkConnectionSave()">
                ذخیره
            </button>
            <button ng-show="SecurityService.buttonsAccess.saveAndContinueButtonAccess()" ng-disabled="!RecordService.isEditing() || recordform.$invalid" type="button" class="btn btn-success" ng-click="checkConnectionSave(true)">
                ذخیره و ادامه
            </button>
            <script type="text/ng-template" id="savingModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">ذخیره</h3>
                </div>
                <div class="modal-body">
                    <span ng-show="!RecordService.saved">
                        در حال ذخیره سازی...
                    </span>
                    <span ng-show="RecordService.saved && RecordService.savingMessageIsArray">
                        <p ng-repeat="msg in RecordService.savingMessages" ng-bind="msg">

                        </p>

                    </span>
                    <p ng-show="RecordService.saved && !RecordService.savingMessageIsArray" ng-bind="RecordService.savingMessages">
                    </p>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn" ng-disabled="!RecordService.saved" data-ng-click="close()">
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
            <button ng-disabled="!RecordService.isEditing()" type="button" class="btn btn-warning" ng-click="openCancelModal('lg',recordform)">
                انصراف
            </button>
            <script type="text/ng-template" id="cancelModal.html">
                <div class="modal-header">
                    <h3 class="modal-title">انصراف</h3>
                </div>
                <div class="modal-body">
                    آیا از انصراف ویرایش رکورد جاری اطمینان دارید؟
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" ng-click="cancel()">بله</button>
                    <button class="btn btn-warning" ng-click="close()">خیر</button>
                </div>
            </script>





        </div>
        <div class="col-xs-4">
            <button type="button" ng-disabled="!RecordService.currentRecord.id || RecordService.isEditing() || !RecordService.previousable()" class="btn btn-primary" ng-click="RecordService.previousSelectedRecord()">
                قبلی
            </button>


            <button type="button" ng-disabled="!RecordService.currentRecord.id || RecordService.isEditing() || !RecordService.nexable()" class="btn btn-primary" ng-click="RecordService.nextSelectedRecord()">
                بعدی
            </button>

            <button ng-disabled="!RecordService.currentRecord.record_number || !RecordService.isEditing() || !(SecurityService.buttonsAccess.activateButtonAccess() == true) || !SecurityService.connected" data-ng-click="RecordService.toggleActiveCurrentRecord()" data-ng-show="RecordService.currentRecord.record_number" class="btn active-inactive-btn" ng-class="{'is-active': RecordService.currentRecord.active == true,'is-inactive': RecordService.currentRecord.active == false }" >
                <i class="fa fa-check"></i>
                <i class="fa fa-times"></i>
                {{(RecordService.currentRecord.active)?'فعال':'غیر فعال'}}
            </button>
            
            <button ng-disabled="!RecordService.currentRecord.record_number || !RecordService.isEditing() || !(SecurityService.buttonsAccess.verifyButtonAccess() == true) || !SecurityService.connected" data-ng-click="RecordService.toggleVerifyCurrentRecord()" data-ng-show="RecordService.currentRecord.record_number" class="btn verify-notverify-btn" ng-class="{'is-verify': RecordService.currentRecord.verify == true,'is-notverify': RecordService.currentRecord.verify == false }" >
                <i class="fa fa-check"></i>
                <i class="fa fa-times"></i>
                {{(RecordService.currentRecord.verify)? 'تایید شده':'تایید نشده'}}
            </button>
            
            <button class="btn btn-default" ng-click="openRegisterCodeModal('md')">تولید کد ثبت نام</button>
            
        </div>

        <div class="col-xs-2 left user-box" ng-class="{'logged-in': (SecurityService.loggedIn && SecurityService.connected), 'logged-out': (!SecurityService.loggedIn || !SecurityService.connected)}" style="float: left"  >
            <ul class="nav navbar-nav navbar-left user-pane">



                <li class="dropdown open">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <i class="fa fa-power-off"></i>
                    <span class="username-value">
                    {{ValuesService.username}}
                    </span> <span class="caret"></span></a>
                    <ul class="dropdown-menu dropdown-menu-left" role="menu">
                        <li ng-show="SecurityService.loggedIn && SecurityService.connected">
                            <a  href="#" data-ng-click="openLogoutModal()">
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


    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/checklist-model/checklist-model.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-media-player/dist/angular-media-player.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ngInfiniteScroll/build/ng-infinite-scroll.min.js') ?>"></script>
    
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-file-upload/angular-file-upload.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-google-maps/dist/angular-google-maps.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/lodash/dist/lodash.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-scroll/angular-scroll.min.js') ?>"></script>



    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angucomplete-alt/dist/angucomplete-alt.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular/videogular.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular-controls/vg-controls.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular-overlay-play/vg-overlay-play.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular-poster/vg-poster.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/videogular-buffering/vg-buffering.js') ?>"></script>


    
<!--    <script src='//maps.googleapis.com/maps/api/js?sensor=false'></script>-->


    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-collection/angular-collection.js') ?>"></script>



    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Controllers/recordIndexCtrl.js') ?>"></script>
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/recordService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/recordtreeService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/recordIndex.js') ?><!--"></script>-->

    
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