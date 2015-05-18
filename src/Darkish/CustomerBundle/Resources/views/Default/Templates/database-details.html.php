<div class="details-header" id="details-header" ng-class="{'fixed': isXSmall()}">
	<button ng-disabled="state.current.name == 'database'" class="return-button" 
		ui-sref="database">
		<div class="dk icon-arrow-right"></div>
	</button>
	مشخصات پایگاه داده
	<button ui-sref="database.edit" class="details-header-button btn btn-sm btn-primary">
		<div class="dk icon-edit"></div>ویرایش 
	</button>
</div>
<div class="well database-details details-inner">
	<h5><label>توضیحات</label></h5>

	<span class="database-description" ng-bind="databaseData.dbase_description"></span>
	<hr/>
	<h5><label>بنر پایگاه داده</label></h5>
	<img width="100%" src="<?php echo $view['assets']->getUrl('bundles/darkishcustomer/images/default_banner.jpg') ?>" ng-src="{{databaseData.dbase_banner.mobile_absolute_path}}" class="banner-image">
</div>