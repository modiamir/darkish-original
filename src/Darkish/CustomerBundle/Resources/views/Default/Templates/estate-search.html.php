<form>
	<div class="row">
		<div class="col col-xs-12 form-group">
		  <select class="form-control" id="estate-contract-type" ng-model="searchCriteria.estate_contract_type"
		  			ng-options="contractType.id as contractType.value for contractType in contractTypes">
		  			<option value="" disabled selected>نوع واگذاری</option>
	      </select>
		</div>
		<div class="col col-xs-12 form-group">
		  	<select  class="form-control" id="estate-type" ng-model="searchCriteria.estate_type"
		  			ng-options="estateType.id as estateType.value for estateType in estateTypes">
            	<option value="" disabled selected>نوع ملک</option>
          	</select>
		</div>
		<div class="col col-xs-12 form-group">
		  	<select class="form-control" id="estate-num-rooms" ng-model="searchCriteria.estate_num_rooms">
		  		<option value="" disabled selected>تعداد اتاق</option>
		  		<option ng-repeat="key in [1,2,3,4,5,6,7,8,9,10]" value="{{key}}">{{key}}</option>
          	</select>
		</div>
		<div class="col col-xs-12 input-group dimension-search">
      		<span class="input-group-addon">متراژ</span>
	      	<input class="form-control" type="number"
	      		 ng-model="searchCriteria.estate_dimension"
	      		 maxlength="10">
  		  	<span class="input-group-addon">متر مربع</span>
	  	</div>
      	<div ng-hide="searchCriteria.estate_contract_type == 2"  class="col col-xs-12 input-group">
      		<span class="input-group-addon">قیمت</span>
	      	<input class="form-control" type="number"
	      		 ng-model="searchCriteria.estate_price"
	      		 maxlength="10">
  		  	<span class="input-group-addon">تومان</span>
	  	</div>
	  	<div class="alert alert-info" role="alert">
	  		توضیح: قیمت و متراژ با اختلاف <b>۱۰</b> درصد محاسبه میشود.
	  	</div>
	  	<div class="col col-xs-12">
	  		<div class="btn-group">
	  			<button ng-click="search()" class="btn btn-info search-btn">جستجو</button>
	  			<button ng-click="clearSearchCriteria(); search()" class="btn btn-danger search-btn clear-search-btn"><div class="dk icon-cancel"></div></button>
	  		</div>
			
		</div>

	</div>
</form>