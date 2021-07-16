<!-- catatan:
error message pada field jika invalidnya masih muncul, padahal field yg salah sudah diganti isinya,
mestinya ketika user mengganti, error messagenya langsung ilang -->

<style>
	.textarea-summernote.is-invalid+.note-editor {
		border: 1px solid #b0272b;
	}
</style>

<div class="row">
	<div class="col-9 offset-md-1">
		<?php if (isset($msg) || validation_errors() !== '') : ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="fa fa-exclamation"></i> Terjadi Kesalahan</h4>
				<?= validation_errors(); ?>
				<?= isset($msg) ? $msg : ''; ?>
			</div>
		<?php endif; ?>
		<!-- fash message yang muncul ketika proses penghapusan data berhasil dilakukan -->
		<?php if ($this->session->flashdata('msg') != '') : ?>
			<div class="alert alert-success flash-msg alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4>Sukses!</h4>
				<?= $this->session->flashdata('msg'); ?>
			</div>
		<?php endif; ?>		

			<div class="card shadow mt-3">				
				<div class="collapse show" id="collterbit">
					<div class="card-body pb-3">

					
						<?php echo form_open_multipart('admin/suratmasuk/baru'); ?>

						<div class="form-group row">
							<label class="col-md-4" for="">Nomor Surat
								<small class="form-text text-muted">Masukkan Nomor Surat.</small></label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="no_surat" id="" value="<?= (validation_errors()) ? set_value('no_surat') : ''; ?>"> 
								<span class="text-danger"><?php echo form_error('no_surat'); ?></span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4" for="">Hal
								<small class="form-text text-muted">Hal Surat.</small></label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="hal" id="" value="<?= (validation_errors()) ? set_value('hal') : ''; ?>"> 
								<span class="text-danger"><?php echo form_error('hal'); ?></span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4" for="tujuan_surat">Tujuan Surat
								<small class="form-text text-muted">Tujuan Surat.</small></label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="tujuan_surat" id="" value="<?= (validation_errors()) ? set_value('tujuan_surat') : ''; ?>"> 
								<span class="text-danger"><?php echo form_error('tujuan_surat'); ?></span>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-md-4" for="tanggal_surat">Tanggal Surat
								<small class="form-text text-muted">Tanggal Surat.</small></label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="tanggal_surat" id="" value="<?= (validation_errors()) ? set_value('tanggal_surat') : ''; ?>"> 
								<span class="text-danger"><?php echo form_error('tanggal_surat'); ?></span>
							</div>
						</div>
						
						<div class="form-group row">
							<label class="col-md-4" for="">Pengirim
								<small class="form-text text-muted">Surat dikirim oleh.</small></label>
							<div class="col-md-8">
								<input type="text" class="form-control" name="pengirim" id="" value="<?= (validation_errors()) ? set_value('pengirim') : ''; ?>"> 
								<span class="text-danger"><?php echo form_error('pengirim'); ?></span>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4" for="">Upload PDF
								<small class="form-text text-muted">Upload PDF Surat.</small></label>
							<div class="col-md-8">
								<input type="file" class="form-control" name="upload_pdf" id="" value="<?= (validation_errors()) ? set_value('upload_pdf') : ''; ?>"> 
								<span class="text-danger"><?php echo form_error('upload_pdf'); ?></span>
							</div>
						</div>

				

						<input type="submit" id="sub1" value="Simpan Surat Masuk" name="submit" class="btn btn-perak btn-md btn-block">
						<?php form_close(); ?>
					</div>
				</div>
			</div>
	</div>
</div>
<!-- /.row -->
