<div class="row">
	<div class="col-md-12">



	</div>

	<div class="col-md-12">
		<?php if(isset($msg) || validation_errors() !== ''): ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="fa fa-exclamation"></i> Terjadi Kesalahan</h4>
				<?= validation_errors();?>
				<?= isset($msg)? $msg: ''; ?>
			</div>
			<?php endif; ?>


		<div class="card card-success card-outline">

			<div class="card-body box-profile">

				<?php echo form_open(base_url('admin/kategorisurat/simpan_kategori_surat'), array('id' => 'tambah_kategori_surat', 'class' => 'form-horizontal'));  ?>
				<div class="form-group row">
					<label for="kategori_surat" class="col-md-3 control-label">Kategori Surat *</label>
					<div class="col-md-9">
						<input type="text" value="" name="kategori_surat" class="form-control <?= (form_error('kategori_surat')) ? 'is-invalid' : ''; ?>" id="kategori_surat">
					
						<span class="invalid-feedback"><?php echo form_error('kategori_surat'); ?></span>
					</div>
				</div>


				<div class="form-group row">
					<label for="kode" class="col-md-3 control-label"></label>
					<div class="col-md-9">
						<input type="submit" name="submit" value="Tambah Kategori Surat" class="btn btn-perak btn-block">
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
