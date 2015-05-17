<form>
	<div class="row">
		<div class="col col-xs-12 form-group">
		  <select class="form-control" id="automobile-brand" ng-model="searchCriteria.automobile_brand"
		  			ng-options="automobileBrand.id as automobileBrand.value for automobileBrand in automobileBrands">
		  			<option value="" disabled selected>برند</option>
	      </select>
		</div>
		<div class="col col-xs-12 form-group">
		  	<select ng-disabled="!searchCriteria.automobile_brand" class="form-control" id="automobile-type" ng-model="searchCriteria.automobile_type"
		  			ng-options="automobileType.id as automobileType.value for automobileType in automobileTypes | filter: {parent_id: searchCriteria.automobile_brand}:true">
            	<option value="" disabled selected>نوع</option>
          	</select>
		</div>
		<div class="col col-xs-12 form-group">
		  	<select class="form-control" id="automobile-age" ng-model="searchCriteria.automobile_created_year">
		  	<option value="" disabled selected>سال ساخت</option>
		  		<option ng-repeat="age in ages" value="{{age}}"> {{age}}</option>
          	</select>
		</div>
      	<div class="col col-xs-12 input-group">
      		<span class="input-group-addon">قیمت</span>
	      	<input class="form-control" type="number"
	      		 ng-model="searchCriteria.automobile_price"
	      		 maxlength="10">
  		  	<span class="input-group-addon">تومان</span>
	  	</div>
	  	<div dir="ltr">
	  	</div>
	  	<div class="alert alert-info" role="alert">
	  		توضیح: قیمت با اختلاف <b>۱۰</b> درصد محاسبه میشود.
	  	</div>
	  	<div class="col col-xs-12">
	  		<div class="btn-group">
	  			<button ng-click="search()" class="btn btn-info search-btn">جستجو</button>
	  			<button ng-click="clearSearchCriteria(); search()" class="btn btn-danger search-btn clear-search-btn"><div class="dk icon-cancel"></div></button>
	  		</div>
		</div>

	</div>
</form>