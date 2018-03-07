<form name="add-RSS" action="" method="post">
	<div class="col-md-12">
		<!-- RSS Name -->
		<div class="form-group">
			<label for="inputName">{c2r-name}</label>
			<input name="name" type="text" class="form-control" id="inputName" placeholder="" value="">
		</div>
		<!-- END RSS Name -->

		<!-- RSS url -->
		<div class="form-group">
			<label for="inputUrl">{c2r-url}</label>
			<input name="url" type="text" class="form-control" id="inputUrl" placeholder="" value="">
		</div>
		<!-- END RSS Url -->

		<!-- RSS Date -->
		<div class="form-group">
			<label for="inputDate">{c2r-date}</label>
			<input name="date" type="text" class="form-control" id="inputDate" placeholder="" value="{c2r-date-value}">
		</div>
		<!-- END RSS Date -->

		<!-- RSS Published -->
		<div class="checkbox sm-taright">
			<label><input type="checkbox" name="status" value="1"/> {c2r-published}</label>
		</div>
		<!-- END RSS Published -->

	</div>
	<div class="col-md-12 md-taright xs-tacenter">
		<button type="submit" class="btn btn-success" name="save">{c2r-but-submit}</button>
	</div>
</form>
