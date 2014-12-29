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
            <div class="col col-md-6 main-center main-cols">
                <div class="basic-info col col-md-12">
                    <div class="basic-info-left-col">
                        
                       
                        <div class="record-number-wrapper">
                          <span class="record-number-title">شماره پرونده</span>
                          <span class="record-number" dir="ltr">
                              {{RecordService.currentRecord.record_number.substring(0,3)}},
                              {{RecordService.currentRecord.record_number.substring(3,6)}}
                          </span>
                          
                        </div>
                        
                    </div>

                    <div class="basic-info-right-col">
                        <div class="record-title">
                            <button data-ng-click="showTitlesModal()" class="record-title-lan" ng-disabled="!RecordService.isEditing()" >Lan</button>
                            <div class="field-title record-title-title">عنوان:</div>
                            <input type="text" name="record-title" class="record-title-input" ng-model="RecordService.currentRecord.title" ng-disabled="!RecordService.isEditing()" required>
                        </div>

                        <div class="record-subtitle">
                            <div class="field-title record-title-title">زیر عنوان:</div>
                            <input  type="text" name="record-subtitle" class="record-subtitle-input" ng-model="RecordService.currentRecord.sub_title" ng-disabled="!RecordService.isEditing()" required>
                        </div>

                        <script type="text/ng-template" id="titles-modal.html">
                            <div class="modal-bg" data-ng-click="closeMe()">
                                <div class="btf-modal  titles-modal" data-ng-click="$event.stopPropagation()">
                                    <h3 class="modal-header1">
                                        عناوین
                                    </h3>
                                    <div class="modal-body">

                                        <h4 class="modal-header2">
                                            انگلیسی
                                        </h4>
                                            <label for="english-title">
                                            عنوان
                                            </label>
                                            <input id="english-title" ng-model="RecordService.currentRecord.english_title" ng-disabled="!RecordService.isEditing()" />

                                            <label for="english-sub-title">
    زیر عنوان
                                            </label>
                                            <input id="english-sub-title" ng-model="RecordService.currentRecord.english_sub_title" ng-disabled="!RecordService.isEditing()" />


                                        <h4 class="modal-header2">
                                            عربی
                                        </h4>
                                            <label for="arabic-title">
                                            عنوان
                                            </label>
                                            <input id="arabic-title" ng-model="RecordService.currentRecord.arabic_title" ng-disabled="!RecordService.isEditing()" />

                                            <label for="arabic-sub-title">
                                                زیر عنوان
                                            </label>
                                            <input id="arabic-sub-title" ng-model="RecordService.currentRecord.arabic_sub_title" ng-disabled="!RecordService.isEditing()" />


                                        <h4 class="modal-header2">
                                            ترکی
                                        </h4>

                                            <label for="turkish-title">
                                                عنوان
                                            </label>
                                            <input id="turkish-title" ng-model="RecordService.currentRecord.turkish_title" ng-disabled="!RecordService.isEditing()" />

                                            <label for="turkish-sub-title">
                                                زیر عنوان
                                            </label>
                                            <input id="turkish-sub-title" ng-model="RecordService.currentRecord.turkish_sub_title" ng-disabled="!RecordService.isEditing()" />

                                    </div>
                                    <div class="modal-control-buttons-wrapper">
                                        <button class="btn" data-ng-click="closeMe()">
                                            تایید
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </script>

                    </div>
      
                </div>
                <div class="main-fields-row">





                    <div class="col main-fields-wrapper">
                        <div class="main-fields-first-section" >

                            <div class="main-fields-search-key">
                                <label class="main-fields-searchkey-title first-section-fields-title" for="search-key-input">کلید واژه جستجو:</label>
                                <input type="text" name="searchkey-input" id="search-key-input" class="first-section-input" ng-model="RecordService.currentRecord.search_keywords" ng-disabled="!RecordService.isEditing()">
                            </div>

                            <div class="main-fields-owner">
                                <label class="main-fields-owner-title first-section-fields-title" for="owner-input">مالک/مدیر:</label>
                                <input type="text" name="owner-input" id="owner-input" class="first-section-input" ng-model="RecordService.currentRecord.owner" ng-disabled="!RecordService.isEditing()">
                            </div>

                            <div class="main-fields-legal-name">
                                <label class="main-fields-legal-name-title first-section-fields-title" for="legal-name-input">نام حقوقی:</label>
                                <input type="text" name="legal-name-input" id="legal-name-input" class="first-section-input" ng-model="RecordService.currentRecord.legal_name" ng-disabled="!RecordService.isEditing()">
                            </div>

                            <div class="main-fields-tree-list">
                                <div class="main-fields-tree-list-commands-wrapper">
                                    <label class="tree-list-trees-button-wrapper">
                                        شاخه ها:
                                    </label>
                                    <div class="tree-list-add-remove-button-wrapper">
                                        <button type="button" ng-click="showModal()" id="tree-list-add-button"  ng-disabled="!RecordService.isEditing()">+</button>
                                        <button type="button" ng-click="RecordService.removeFromTreeList(secondTreeSelected)" id="tree-list-remove-button" ng-disabled="!RecordService.isEditing()">-</button>
                                    </div>


                                </div>
                                <select multiple id="tree-list-input" ng-model="secondTreeSelected" ng-disabled="!RecordService.isEditing()"
                                            ng-options="tree.title for tree in RecordService.currentRecord.treeList.all()">
                                        <!-- <option ng-repeat="center in ValuesService.centers" value="{{center}}" > {{center.name}} </option> -->



                                </select>
                                <script type="text/ng-template" id="tree-modal.html">
                                    <div class="modal-bg">
                                        <div class="btf-modal tree-modal">
                                            <h3 class="modal-header1">
                                                انتخاب شاخه ها
                                            </h3>
                                            <div class="tree-modal-header">
                                                <a href ng-click="closeMe()">X</a>
                                                <button class="btn" data-ng-click="RecordService.addToTreeList(TreeService.currentSecondTreeNode)">اضافه</button>
                                            </div>
                                            <div class="tree-modal-content">
                                                <treecontrol class="tree-classic"
                                                             tree-model="tree()"
                                                             options="treeOptions()"
                                                             selected-node="TreeService.currentSecondTreeNode">
                                                    {{node.title}}
                                                </treecontrol>
                                            </div>

                                        </div>
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

                                <select id="ranklist-combo" ng-model="RecordService.currentRecord.list_rank" ng-disabled="!RecordService.isEditing()">
                                    <option value=1> 1 </option>
                                    <option value=2> 2 </option>
                                    <option value=3> 3 </option>
                                    <option value=4> 4 </option>
                                    <option value=5> 5 </option>
                                    <option value=6> 6 </option>
                                    <option value=7> 7 </option>
                                    <option value=8> 8 </option>
                                    <option value=9> 9 </option>
                                    <option value=10> 10 </option>
                                </select>
                               
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
                               <input type="text" name="central-unit" id="central-unit-input" class="second-section-input" ng-model="RecordService.currentRecord.center_unit_number" ng-disabled="!RecordService.isEditing()">
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
                         </div>

                         <div class="main-fields-third-section" >
                             <div id="spec-msg-detail-wrapper">
                                 <div id="spec-msg-text-wrapper">
                                     <label id="spec-msg-text-label" class="third-section-label " for="spec-msg-text-input">متن پیام ویژه</label>
                                     <input type="text" id="spec-msg-text-input" class="third-section-input" ng-model="RecordService.currentRecord.message_text" ng-disabled="!RecordService.isEditing()">
                                 </div>
                                 <div id="spec-msg-date-wrapper">

                                     
                                     <label id="spec-msg-credit-date-label" class="third-section-label " for="spec-msg-credit-date-input">تاریخ اعتبار</label>
                                     <input ng-click="openValidityDate($event)" type="text" id="spec-msg-credit-date-input" class=" third-section-input"  datepicker-popup-persian="{{format}}" ng-model="RecordService.currentRecord.message_validity_date" is-open="validityDateIsOpen"  datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-disabled="!RecordService.isEditing()" close-text="بسته" />

                                 </div>
                             </div>

                             <div id="opening-hours-wrapper">
                                 <label id="opening-time-label" class="third-section-label">ساعات کار</label>
                                 <div id="opening-hours-time">
                                    <span class="morning">
                                    صبح
                                    </span>
                                    <input class="morning-one"  type="time" ng-model="RecordService.currentRecord.m_opening_hours_from"  ng-disabled="!RecordService.isEditing()" />
                                    <input class="morning-two"  type="time" ng-model="RecordService.currentRecord.m_opening_hours_to"  ng-disabled="!RecordService.isEditing()" />
                                    <span class="evening">
                                    عصر
                                    </span>
                                    <input class="evening-one"  type="time" ng-model="RecordService.currentRecord.a_opening_hours_from"  ng-disabled="!RecordService.isEditing()" />
                                    <input class="evening-two"  type="time" ng-model="RecordService.currentRecord.a_opening_hours_to"  ng-disabled="!RecordService.isEditing()" />
                                     
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






                                 </div>
                             </div>
                         </div>
                         <div class="main-fields-forth-section" >
                            <span> آدرس و تلفن</span>
                            <label for="address">آدرس</label>
                            <div class="form-item-wrapper address">
                                <textarea id="address" ng-model="RecordService.currentRecord.address" ng-disabled="!RecordService.isEditing()">
                                    
                                </textarea>
                            </div>

                            <label for="phone-one">تلفن</label>
                            <div class="form-item-wrapper phone">
                                <input type="text" id="phone-one" ng-model="RecordService.currentRecord.tel_number_one" ng-disabled="!RecordService.isEditing()" />
                                <input type="text" id="phone-two" ng-model="RecordService.currentRecord.tel_number_two" ng-disabled="!RecordService.isEditing()" />
                                <input type="text" id="phone-three" ng-model="RecordService.currentRecord.tel_number_three" ng-disabled="!RecordService.isEditing()" />
                                <input type="text" id="phone-four" ng-model="RecordService.currentRecord.tel_number_four" ng-disabled="!RecordService.isEditing()"/>
                            </div>

                            <label for="fax-one">فکس</label>
                            <div class="form-item-wrapper fax">
                                <input type="text" id="fax-one" ng-model="RecordService.currentRecord.fax_number_one" ng-disabled="!RecordService.isEditing()" />
                                <input type="text" id="fax-two" ng-model="RecordService.currentRecord.fax_number_two" ng-disabled="!RecordService.isEditing()" />
                            </div>

                            <label for="mobile-one">همراه</label>
                            <div class="form-item-wrapper mobile">
                                <input type="text" id="mobile-one" ng-model="RecordService.currentRecord.mobile_number_one" ng-disabled="!RecordService.isEditing()" />
                                <input type="text" id="mobile-two" ng-model="RecordService.currentRecord.mobile_number_two" ng-disabled="!RecordService.isEditing()" />
                            </div>

                            <label for="email">ایمیل</label>
                            <div class="form-item-wrapper email">
                                <input type="text" id="email" ng-model="RecordService.currentRecord.email" ng-disabled="!RecordService.isEditing()" />
                            </div>

                            <label for="website">سایت</label>
                            <div class="form-item-wrapper website">
                                <input type="text" id="website" ng-model="RecordService.currentRecord.website" ng-disabled="!RecordService.isEditing()" />
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
                                <button class="btn map">مکان نقشه</button>
                            </div>
                            <div class="form-item-wrapper map">
                                <input type="text" id="latitude" ng-model="RecordService.currentRecord.latitude" ng-disabled="!RecordService.isEditing()" />
                                <input type="text" id="longitude" ng-model="RecordService.currentRecord.longitude" ng-disabled="!RecordService.isEditing()" />
                            </div>
                            





                             
                         </div>
                    </div>
                    <div class="col capabilites">
                        <div class="capabilites-buttons-wrapper">
                            
                            قابلیت ها
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
                            <span data-ng-click="RecordService.toggleCapability('audio')"
                                  ng-class="{'active' : RecordService.currentRecord.audio == true, 'inactive' : RecordService.currentRecord.audio != true}"
                                class="capabilites-buttons sound inactive">    </span>
                            <span data-ng-click="RecordService.toggleCapability('video')"
                                  ng-class="{'active' : RecordService.currentRecord.video == true, 'inactive' : RecordService.currentRecord.video != true}"
                                class="capabilites-buttons video inactive">     </span>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="col col-md-4 main-left main-cols">
                <div class="row attachements-wrapper">
                    <div class="col-md-2 right">
                        <ul class="tab-list" ng-init="ValuesService.activeTab = 'image'">
                            <li class="pure-button"
                                ng-class="{'tab-active': ValuesService.activeTab === 'image'}"
                                ng-click="ValuesService.activeTab = 'image'">
                                عکس
                            </li>
                            <li class="pure-button"
                                ng-class="{'tab-active': ValuesService.activeTab === 'video'}"
                                ng-click="ValuesService.activeTab = 'video'">
                                فیلم
                            </li>
                            <li class="pure-button"
                                ng-class="{'tab-active': ValuesService.activeTab === 'audio'}"
                                ng-click="ValuesService.activeTab = 'audio'">
                                صدا
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-8 center">
                        <div class="tab-content">
                            <div ng-switch="ValuesService.activeTab">
                                <div ng-switch-when="image" class="image">
                                    <ul class="image-list">
                                        <li ng-repeat="image in RecordService.currentRecord.images" style="float: right"  ng-class="{'selected' : RecordService.selectedImage.id == image.id}">
                                            <img ng-click="RecordService.selectedImage = image ;showImageShowModal(image)" ng-src="{{image.absolute_path}}"  />
                                            <input
                                                type="checkbox"
                                                checklist-model="RecordService.selectedImages"
                                                checklist-value="image"
                                            />
                                        </li>
                                    </ul>
                                    <script type="text/ng-template" id="image-modal.html">
                                        <div class="modal-bg" data-ng-click="closeMe()">
                                            <div class="btf-modal  image-modal" data-ng-click="$event.stopPropagation()">
                                                <div class="modal-body">
                                                    <img width="100%" ng-src="{{ValuesService.currentImageModal.absolute_path}}" />  
                                                </div>
                                                <div class="modal-control-buttons">
                                                    <button class="btn close" data-ng-click="closeMe()">
                                                        بستن
                                                    </button>
                                                </div>
                                            </div>
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
                                            <span ng-bind="video.file_name" ng-click="RecordService.selectedVideo =video; showVideoShowModal(video)"></span>
                                        </li>
                                    </ul>
                                </div>
                                <div ng-switch-when="audio" class="audio">
                                    <ul class="audio-list">
                                        <li ng-repeat="audio in RecordService.currentRecord.audios" style="float: right" ng-class="{'selected' : RecordService.selectedAudio.id == audio.id}">
                                            <input
                                                type="checkbox"
                                                checklist-model="RecordService.selectedAudios"
                                                checklist-value="audio"
                                            />
                                            <span ng-bind="audio.file_name" ng-click="RecordService.selectedAudio = audio" >  </span>
                                        </li>
                                    </ul>
                                    <script type="text/ng-template" id="video-modal.html">
                                        <div class="modal-bg" data-ng-click="closeMe()">
                                            <div class="btf-modal  image-modal" data-ng-click="$event.stopPropagation()">
                                                <div class="modal-body">
                                                    <img width="100%" ng-src="{{ValuesService.currentImageModal.absolute_path}}" />
                                                    <div>
                                                        <video width="300" media-player="videoPlayer" data-playlist="videoPlaylist" ng-init="">

                                                        </video>
                                                        <span ng-show="videoPlayer.playing">Player status: Playing</span>
                                                        <span ng-show="!videoPlayer.playing">Player status: Paused</span>
                                                        <button  class="btn" data-ng-click="videoPlayer.playPause()">
                                                            قطع/وصل
                                                        </button>
                                                        <button class="btn" data-ng-click="videoPlayer.next()">
بعدی
                                                        </button>
                                                        <button class="btn" data-ng-click="videoPlayer.prev()">
                                                            قبلی
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="modal-control-buttons">
                                                    <button class="btn close" data-ng-click="closeMe()">
                                                        بستن
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 left">
                        <button class="btn btn-info add-attachment" ng-disabled="!RecordService.isEditing()" data-ng-click="showUploadModal()">
                            اضافه
                        </button>
                        <script type="text/ng-template" id="upload-modal.html">

                            <div class="modal-bg" data-ng-click="closeMe()">
                                <div class="btf-modal" data-ng-click="$event.stopPropagation()">
                                    <h3 class="modal-header1">
                                        آپلود فایل
                                    </h3>
                                    <div class="modal-body">
                                    <input name='imageupload' type='file' ng-model='files' onchange='angular.element(this).scope().filesChanged(this)' />
                                    <p ng-hide="!uploading">
در حال بارگذاری...
                                    </p>
                                    <span ng-show="RecordService.saved">
        رکورد مورد نظر ذخیره شد.
                                    </span>
                                    <button ng-disabled="!uploadable" class="btn btn-info" data-ng-click="upload()">Upload</button>

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
                    </div>
                </div>

                <div class="row html-wrapper">
                    <div class="col-md-12">
                        <div class="html-preview" ng-bind-html="RecordService.currentRecord.body">

                        </div>
                        <button data-ng-show="RecordService.isEditing()" id="body-modal-button" class="btn btn-info" data-ng-click="showBodyModal()">
                            ویرایش صفحه
                        </button>
                        <script type="text/ng-template" id="body-modal.html" >
                            <div id="body-modal-bg " class="modal-bg html-editor-modal" data-ng-click="closeMe()">
                                <div id="body-modal-btf" class="btf-modal"  data-ng-click="$event.stopPropagation()">
                                    <h3 class="modal-header1">
                                        بدنه رکورد
                                        <div class="modal-header-control-buttons-wrapper">
                                            <a href ng-click="closeMe()">X</a>
                                        </div>
                                    </h3>
                                    
                                    <div class="body-modal-content">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="body-attachments">
                                                    <div class="body-attachments-inner">

                                                        <ul class="tab-list" ng-init="ValuesService.bodyAttachmentActiveTab = 'image'">
                                                            <li class="pure-button "
                                                                ng-class="{'tab-active': ValuesService.bodyAttachmentActiveTab === 'image'}"
                                                                ng-click="ValuesService.bodyAttachmentActiveTab = 'image'">
                                                                عکس
                                                            </li>
                                                            <li class="pure-button "
                                                                ng-class="{'tab-active': ValuesService.bodyAttachmentActiveTab === 'video'}"
                                                                ng-click="ValuesService.bodyAttachmentActiveTab = 'video'">
                                                                فیلم
                                                            </li>
                                                            <li class="pure-button "
                                                                ng-class="{'tab-active': ValuesService.bodyAttachmentActiveTab === 'audio'}"
                                                                ng-click="ValuesService.bodyAttachmentActiveTab = 'audio'">
                                                                صدا
                                                            </li>
                                                        </ul>
                                                        <p ng-hide="!uploading">
                                                            در حال بارگذاری...
                                                        </p>
                                                        <button class="btn upload-btn" data-ng-click="upload()" ng-disabled="!uploadable">
                                                            بارگذاری
                                                        </button>
                                                        <button class="btn btn-danger" data-ng-click="RecordService.removeFromBodyAttachList()">
                                                            حذف
                                                        </button>
                                                        <button class="btn btn-info" data-ng-click="CkeditorInsert()" ng-disabled="!RecordService.isReadyToInsert()">
                                                            درج
                                                        </button>
                                                        <input class="html-upload" name='imageupload' type='file' ng-model='files' onchange='angular.element(this).scope().filesChanged(this)' />
                                                        <div ng-switch="ValuesService.bodyAttachmentActiveTab">
                                                            <div ng-switch-when="image" class="image">
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
                                                            <div ng-switch-when="video" class="video">
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
                                                            <div ng-switch-when="audio" class="audio">
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
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-10">
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
            <div class="col col-lg-12">
                <div class="grid-block">
                    <table st-table="recordList()" class="table table-striped" infinite-scroll="RecordService.searchRecords(RecordService.recordList().length)">
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
            <a href="{{ path('admin_newstree') }}" class="dropdown-toggle" data-toggle="dropdown">اخبار و سرگرمی<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="<?php print $view['router']->generate("offer"); ?>">پیشنهاد ویژه</a></li>
                <li><a href="<?php print $view['router']->generate("classified"); ?>">نیازمندی ها</a></li>

            </ul>
        </li>
    </ul>
<?php $view['slots']->stop() ?>

<?php $view['slots']->start('top-actions');?>
    <div  class="news-top show-grid ">

        <div class="col-md-4">
            <button ng-disabled="RecordService.isEditing()" type="button" class="btn btn-primary" ng-click="RecordService.editingNew()">
                جدید
            </button>

            <button ng-disabled="RecordService.isNew() || RecordService.isEditing()" type="button" class="btn btn-info" ng-click="RecordService.editing()">
                ویرایش
            </button>
            <script type="text/ng-template" id="delete-modal.html">

                <div class="modal-bg" data-ng-click="closeMe()">
                    <div class="btf-modal  titles-modal" data-ng-click="$event.stopPropagation()">
                        <h3 class="modal-header">
                            حذف رکورد
                        </h3>
                        <div class="modal-body">
                            آیا از حذف رکورد جاری اطمینان دارید؟
                            <button class="btn btn-warning" data-ng-click="closeMe()">
                                خیر (انصراف)
                            </button>
                            <button class="btn btn-danger" data-ng-click="deleteCurrentRecord()">
                                بله (حذف)
                            </button>
                        </div>
                    </div>
                </div>
            </script>
            <button ng-disabled="!RecordService.currentRecord.id || RecordService.isEditing()"  type="button" class="btn btn-danger" ng-click="showDeleteModal()" ng-disabled="editing || !news.id">
                حذف
            </button>
            <button ng-disabled="!RecordService.isEditing() || recordform.$invalid" type="button" class="btn btn-success" ng-click="showSavingModal();RecordService.saveCurrentRecord();recordform.$setPristine()">
                ذخیره
            </button>
            <script type="text/ng-template" id="saving-modal.html">

                <div class="modal-bg">
                    <div class="btf-modal">
                        <h3 class="modal-header">
                            ذخیره
                        </h3>

                        <div class="modal-body">
                            <span ng-show="!RecordService.saved">
                                در حال ذخیره سازی...
                            </span>
                            <span ng-show="RecordService.saved">
                                <p ng-repeat="msg in RecordService.savingMessages" ng-bind="msg">

                                </p>

                            </span>
                            <button class="btn" ng-disabled="!RecordService.saved" data-ng-click="closeMe()">
                                بستن
                            </button>
                        </div>
                    </div>
                </div>
            </script>
            <button ng-disabled="!RecordService.isEditing()" type="button" class="btn btn-warning" ng-click="RecordService.cancelEditing(); recordform.$setPristine()">
                انصراف
            </button>





        </div>
        <div class="col-md-5">
            <button type="button" ng-disabled="!RecordService.currentRecord.id || RecordService.isEditing() || !RecordService.previousable()" class="btn btn-primary" ng-click="RecordService.previousSelectedRecord()">
                قبلی
            </button>


            <button type="button" ng-disabled="!RecordService.currentRecord.id || RecordService.isEditing() || !RecordService.nexable()" class="btn btn-primary" ng-click="RecordService.nextSelectedRecord()">
                بعدی
            </button>

            <button ng-disabled="!RecordService.currentRecord.id || !RecordService.isEditing()" data-ng-click="RecordService.toggleActiveCurrentRecord()" data-ng-show="RecordService.currentRecord.id" class="btn active-inactive-btn" ng-class="{'is-active': RecordService.currentRecord.active == true,'is-inactive': RecordService.currentRecord.active == false }" >
                <i class="fa fa-check"></i>
                <i class="fa fa-times"></i>
                {{(RecordService.currentRecord.active)?'فعال':'غیر فعال'}}
            </button>

            <button ng-disabled="!RecordService.currentRecord.id || !RecordService.isEditing()" data-ng-click="RecordService.toggleVerifyCurrentRecord()" data-ng-show="RecordService.currentRecord.id" class="btn verify-notverify-btn" ng-class="{'is-verify': RecordService.currentRecord.verify == true,'is-notverify': RecordService.currentRecord.verify == false }" >
                <i class="fa fa-check"></i>
                <i class="fa fa-times"></i>
                {{(RecordService.currentRecord.verify)? 'تایید شده':'تایید نشده'}}
            </button>

        </div>

        <div class="col-md-1 left" style="float: left"  >
            نام کاربری:
            {{ValuesService.username}}
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
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ng-flow-standalone.min.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/libs/ckeditor/ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ng-ckeditor/ng-ckeditor.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-modal/modal.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/ui-bootstrap-tpls-0.11.2.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/dateparser.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/position.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/datepicker-tpls.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/persiandate.js') ?>"></script>
    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/persian-datepicker-tpls.js') ?>"></script>


    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/checklist-model/checklist-model.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-media-player/dist/angular-media-player.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/ngInfiniteScroll/build/ng-infinite-scroll.min.js') ?>"></script>

    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-hotkeys/build/hotkeys.min.js') ?>"></script>




    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/bower_components/angular-collection/angular-collection.js') ?>"></script>



    <script src="<?php echo $view['assets']->getUrl('assets/js/angular/Controllers/recordIndexCtrl.js') ?>"></script>
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/recordService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/Services/recordtreeService.js') ?><!--"></script>-->
<!--    <script src="--><?php //echo $view['assets']->getUrl('assets/js/angular/recordIndex.js') ?><!--"></script>-->

<?php $view['slots']->stop() ?>