<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
	<button ng-disabled="state.current.name == 'store'" class="return-button" 
		ui-sref="store.details">
		<div class="dk icon-arrow-right"></div>
	</button>
	<span class="details-header-title">ویرایش مشخصات فروشگاه</span>
	<!-- <button class="details-header-button btn btn-sm btn-primary">
		مشخصات فروشگاه
	</button> -->
</div>
<div class="store-edit details-inner well">
	<form>
		<label for="store-description">توضیحات</label>
		<textarea id="store-description" ng-model="store.market_description" 
				  class="form-control"> </textarea>

		<hr/>
		<label for="store-banner">بنر</label>
		<div class="store-banner">
			<div class="text-center">
			  <label class="file-select btn">
			      <input  type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
			      <img src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_banner.jpg') ?>" ng-src="{{store.market_banner.mobile_absolute_path}}" class="banner-image">
			      <span class="image-upload-tip">برای بارگزاری کلیک کنید</span>
			  </label>
			  
			</div>
			<div class="row file-upload-row">
			    <div ng-show="uploader.isUploading" class="col col-md-8 col-md-offset-2">
			        <div class="progress" style="">
			            <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
			        </div>
			    </div>
			    <div ng-show="uploader.isUploading" class="col col-md-8 col-md-offset-2 upload-cancel">
			        <button  ng-disabled="!RecordService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
			            X
			        </button>
			    </div>
			    <div class="col col-md-8 col-md-offset-2 message-box">
			        <span class="uploader-msg" ng-bind="uploader.msg">

			        </span>
			    </div>


			</div>
		</div>
		<hr/>
		<label for="store-template">قالب</label>
	    <select id="store-template" class="form-control" ng-model="store.market_template" ng-options="template.title for template in templates"></select>
	    <hr/>
		<label for="store-groups">گروه ها</label>
		<span class="store-group-hint">برای افزودن گروه در فضای خالی باکس زیر کلیک کنید.</span>
		<div class="store-groups">
			<tags model="store.market_groups"></tags>
		</div>




	    <button ng-click="saveStoreDetails()" class="btn btn-default btn-sm">ذخیره</button>
    </form>
</div>