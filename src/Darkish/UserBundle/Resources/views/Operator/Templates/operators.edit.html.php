<a ui-sref="operators" class="btn btn-default btn-xs">بازگشت</a>
<h1>ویرایش
{{operator.username}}</h1>
<hr/>
<form name="operator-edit">
    <div class="form-group">
        <label for="operatorEmail">پست الکترونیک</label>
        <input ng-model="operator.email" type="email" class="form-control" id="operatorEmail" placeholder="پست الکترونیک">
    </div>
    <div class="form-group">
        <label for="operatorUsername">نام کاربری</label>
        <input ng-model="operator.username" ng-disabled="true" type="text" class="form-control" id="operatorUsername" placeholder="نام کاربری">
    </div>
    <div class="form-group">
        <label for="operatorPassword">رمز عبور</label>
        <input ng-model="operator.password" type="text" class="form-control" id="operatorPassword" placeholder="رمز عبور">
    </div>
    <div class="form-group">
        <label for="operatorPasswordConfirm">تکرار رمز عبور</label>
        <input ng-model="operator.passwordConfirm" type="text" class="form-control" id="operatorPasswordConfirm" placeholder="تکرار رمز عبور">
    </div>
    <div class="form-group">
        <label for="exampleInputFile">File input</label>
        <input type="file" id="exampleInputFile">
        <p class="help-block">Example block-level help text here.</p>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox"> Check me out
        </label>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>