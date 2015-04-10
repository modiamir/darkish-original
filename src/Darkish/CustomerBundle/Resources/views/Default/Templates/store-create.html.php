<div class="details-header" id="details-header">
	<button ng-disabled="state.current.name == 'store'" class="return-button" 
		ui-sref="store">
		<div class="icon icon-arrow-right"></div>
	</button>
	<span class="details-header-title">ایجاد محصول</span>
	<!-- <button class="details-header-button btn btn-sm btn-primary">
		مشخصات فروشگاه
	</button> -->
</div>
<div class="store-create-product details-inner well">
	<form>
		<div layout="row" layout-sm="column">
			<md-input-container flex>
			      <label>کد آیتم</label>
			      <input ng-model="product.code">
			    </md-input-container>

			<md-input-container flex>
			      <label>قیمت</label>
			      <input ng-model="product.price">
			    </md-input-container>		    

		    <md-input-container flex>
			      <label>درصد تخفیف</label>
			      <input ng-model="product.discount_percent">
			    </md-input-container>
		    
		</div>
		<div layout="row">
			<md-input-container flex>
			      <label>عنوان محصول</label>
			      <input ng-model="product.title">
			    </md-input-container>
		</div>
		<div layout="row">
			<md-select flex ng-model="product.group">
		          <md-select-label>گروه {{ product.group.id ? ' : '+product.group.name : '' }}</md-select-label>
		          <md-option ng-value="group" ng-repeat="group in storeData.market_groups">{{group.name}}</md-option>
		        </md-select>
		</div>

		
	<form>

</div>