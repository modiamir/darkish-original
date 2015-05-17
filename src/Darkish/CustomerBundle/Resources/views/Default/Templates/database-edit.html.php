<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
	<button ng-disabled="state.current.name == 'database'" class="return-button" 
		ui-sref="store.details">
		<div class="dk icon-arrow-right"></div>
	</button>
	ویرایش مشخصات پایگاه داده
	<button ng-click="saveDatabaseDetails()" class="details-header-button btn btn-sm btn-primary">
		<div class="dk icon-verify-small"></div>ذخیره
	</button>
</div>
<div class="database-edit details-inner well">
	<form>
		<label for="database-description">توضیحات</label>
		<textarea id="database-description" ng-model="database.dbase_description" 
				  class="form-control"> </textarea>

		<hr/>
		<h3>
			<label for="database-banner">بنر</label>
			<label class="file-select btn btn-info btn-sm">
		    	<input  type="file" nv-file-select="" uploader="uploader" multiple="true" style="visibility: hidden;display: none"/>
		    	<span class="image-upload-tip">بنر جدید</span>
			</label>
			<button ng-show="database.dbase_banner" class="btn btn-danger btn-sm banner-remove" ng-click="removeBanner();"><div class="dk icon-trash"></div>حذف بنر</button>
		</h3>
		<div class="row file-upload-row">
		    <div ng-show="uploader.isUploading" class="col col-xs-12 col-sm-8">
		        <div class="progress" style="">
		            <div class="progress-bar" role="progressbar" ng-style="{ 'width': uploader.progress + '%' }"></div>
		        </div>
		    </div>
		    <div ng-show="uploader.isUploading" class="col col-xs-12  col-sm-4 upload-cancel">
		        <button  ng-disabled="!RecordService.isEditing()" class="btn btn-danger" ng-click="uploader.cancelAll()">
		            X
		        </button>
		    </div>
		    <!-- <div class="col col-md-8 col-md-offset-2 message-box">
		        <span class="uploader-msg" ng-bind="uploader.msg">

		        </span>
		    </div> -->


		</div>
		<div class="database-banner">
			<div class="text-center">
			  <img width="100%" ng-src="{{database.dbase_banner.mobile_absolute_path ? database.dbase_banner.mobile_absolute_path : '<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_banner.jpg') ?>'}}" class="banner-image">
			</div>
			
		</div>
		


	    
    </form>
</div>